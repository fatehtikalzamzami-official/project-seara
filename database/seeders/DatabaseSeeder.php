<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan WAJIB dijaga karena ada foreign key dependency antar seeder
        $this->call([
            UserSeeder::class,              // 1. users dulu (admin, seller, buyer)
            SellerApplicationSeeder::class, // 2. butuh user_id dari UserSeeder
            SellerProfileSeeder::class,     // 3. butuh user_id + application_id
            CategorySeeder::class,          // 4. kategori produk
            ProductSeeder::class,           // 5. daftar produk per kategori
            SellerSeeder::class,            // 6. tabel sellers (FK ke users)
            HarvestSeeder::class,           // 7. data panen: FK ke sellers & products
        ]);
    }
}
