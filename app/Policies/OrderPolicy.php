<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Seller boleh melihat order jika ada item miliknya di order tersebut.
     * Admin boleh lihat semua.
     * Buyer hanya bisa lihat order sendiri.
     */
    public function view(User $user, Order $order): bool
    {
        // Admin
        if ($user->role === 'admin') {
            return true;
        }

        // Buyer: cek apakah dia yang beli
        if ($user->role === 'buyer') {
            return $order->buyer_id === $user->id;
        }

        // Seller: cek apakah ada item miliknya
        return $order->items()->where('seller_user_id', $user->id)->exists();
    }
}
