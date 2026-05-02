<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'last_seen_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'last_seen_at'      => 'datetime',
        ];
    }

    // ── Relasi
    public function sellerApplication() { return $this->hasOne(SellerApplication::class); }
    public function sellerProfile()     { return $this->hasOne(SellerProfile::class); }
    public function seller()            { return $this->hasOne(Seller::class); }

    // ── Online status
    // Dianggap online jika last_seen_at dalam 3 menit terakhir
    public function isOnline(): bool
    {
        return $this->last_seen_at && $this->last_seen_at->gt(now()->subMinutes(3));
    }

    public function onlineLabel(): string
    {
        if ($this->isOnline()) return 'Online';
        if (!$this->last_seen_at) return 'Belum pernah online';
        return 'Terakhir ' . $this->last_seen_at->diffForHumans();
    }
}
