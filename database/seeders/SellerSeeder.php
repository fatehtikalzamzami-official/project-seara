<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seller;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $users = User::where('role', 'seller')->take(3)->get();

    foreach ($users as $user) {
        Seller::create([
            'user_id' => $user->id,
            'shop_name' => 'Toko ' . $user->name,
            'description' => 'Hasil panen segar langsung dari petani',
        ]);
    }
}
}
