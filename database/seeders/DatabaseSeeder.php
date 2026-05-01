<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan WAJIB dijaga karena ada dependency antar seeder
        $this->call([
            UserSeeder::class,              // 1. users dulu
            SellerApplicationSeeder::class, // 2. butuh user_id dari UserSeeder
            SellerProfileSeeder::class,     // 3. butuh user_id + application_id
            CategorySeeder::class,
            ProductSeeder::class,
            SellerSeeder::class,
            HarvestSeeder::class,
        ]);
    }
}