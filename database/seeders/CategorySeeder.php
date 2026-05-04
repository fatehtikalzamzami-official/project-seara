<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Sayuran',
            'Buah',
            'Rempah',
            'Perkebunan',
            'Umbi-umbian',
            'Biji-bijian',
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
        }

        $this->command->info('✅ CategorySeeder selesai — ' . count($categories) . ' kategori dibuat.');
    }
}
