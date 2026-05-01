<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ─────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@seara.id'],
            [
                'name' => 'Super Admin',
                'nama_lengkap' => 'Administrator SEARA',
                'email' => 'admin@seara.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin@123'),
                'no_whatsapp' => '081200000001',
                'alamat' => 'Jl. Gatot Subroto No. 1, Senayan, Jakarta Selatan 12190',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // ── SELLER (simulasi buyer yang sudah diapprove) ───────
        User::updateOrCreate(
            ['email' => 'seller@seara.id'],
            [
                'name' => 'Pak Surya',
                'nama_lengkap' => 'Surya Darmawan',
                'email' => 'seller@seara.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Seller@123'),
                'no_whatsapp' => '081200000002',
                'alamat' => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
                'role' => 'seller',
                'is_active' => true,
            ]
        );

        // ── BUYER (simulasi user yang baru daftar) ─────────────
        User::updateOrCreate(
            ['email' => 'buyer@seara.id'],
            [
                'name' => 'Ibu Sari',
                'nama_lengkap' => 'Sari Indah Permata',
                'email' => 'buyer@seara.id',
                'email_verified_at' => now(),
                'password' => Hash::make('Buyer@123'),
                'no_whatsapp' => '081200000003',
                'alamat' => 'Jl. Kemang Raya No. 88, Jakarta Selatan 12730',
                'role' => 'buyer',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ UserSeeder selesai.');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@seara.id', 'Admin@123'],
                ['Seller', 'seller@seara.id', 'Seller@123'],
                ['Buyer', 'buyer@seara.id', 'Buyer@123'],
            ]
        );
    }
}