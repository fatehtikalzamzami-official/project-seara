<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Sayuran' => [
                ['name' => 'Brokoli',        'unit' => 'kg'],
                ['name' => 'Cabai Merah',    'unit' => 'kg'],
                ['name' => 'Cabai Rawit',    'unit' => 'kg'],
                ['name' => 'Tomat',          'unit' => 'kg'],
                ['name' => 'Bayam',          'unit' => 'ikat'],
                ['name' => 'Kangkung',       'unit' => 'ikat'],
                ['name' => 'Wortel',         'unit' => 'kg'],
                ['name' => 'Kentang',        'unit' => 'kg'],
                ['name' => 'Terong Ungu',    'unit' => 'kg'],
                ['name' => 'Pare',           'unit' => 'kg'],
                ['name' => 'Kacang Panjang', 'unit' => 'ikat'],
                ['name' => 'Sawi Hijau',     'unit' => 'ikat'],
                ['name' => 'Selada',         'unit' => 'kg'],
                ['name' => 'Timun',          'unit' => 'kg'],
                ['name' => 'Labu Siam',      'unit' => 'kg'],
            ],
            'Buah' => [
                ['name' => 'Mangga Harum Manis', 'unit' => 'kg'],
                ['name' => 'Alpukat Mentega',    'unit' => 'kg'],
                ['name' => 'Pisang Kepok',       'unit' => 'sisir'],
                ['name' => 'Pisang Ambon',       'unit' => 'sisir'],
                ['name' => 'Jeruk Baby',         'unit' => 'kg'],
                ['name' => 'Jeruk Keprok',       'unit' => 'kg'],
                ['name' => 'Apel Malang',        'unit' => 'kg'],
                ['name' => 'Stroberi',           'unit' => 'kg'],
                ['name' => 'Manggis',            'unit' => 'kg'],
                ['name' => 'Rambutan',           'unit' => 'kg'],
                ['name' => 'Durian Montong',     'unit' => 'kg'],
                ['name' => 'Pepaya California',  'unit' => 'kg'],
                ['name' => 'Semangka',           'unit' => 'kg'],
                ['name' => 'Melon',              'unit' => 'kg'],
            ],
            'Rempah' => [
                ['name' => 'Jahe Emprit',    'unit' => 'kg'],
                ['name' => 'Jahe Merah',     'unit' => 'kg'],
                ['name' => 'Kunyit',         'unit' => 'kg'],
                ['name' => 'Lengkuas',       'unit' => 'kg'],
                ['name' => 'Kencur',         'unit' => 'kg'],
                ['name' => 'Temulawak',      'unit' => 'kg'],
                ['name' => 'Kemiri',         'unit' => 'kg'],
                ['name' => 'Ketumbar',       'unit' => 'kg'],
                ['name' => 'Lada Hitam',     'unit' => 'kg'],
                ['name' => 'Kayu Manis',     'unit' => 'kg'],
            ],
            'Perkebunan' => [
                ['name' => 'Kopi Robusta',   'unit' => 'kg'],
                ['name' => 'Kopi Arabika',   'unit' => 'kg'],
                ['name' => 'Cengkeh',        'unit' => 'kg'],
                ['name' => 'Kakao',          'unit' => 'kg'],
                ['name' => 'Kelapa Muda',    'unit' => 'butir'],
                ['name' => 'Vanili',         'unit' => 'kg'],
                ['name' => 'Teh Hijau',      'unit' => 'kg'],
            ],
            'Umbi-umbian' => [
                ['name' => 'Singkong',       'unit' => 'kg'],
                ['name' => 'Ubi Jalar Ungu', 'unit' => 'kg'],
                ['name' => 'Ubi Cilembu',    'unit' => 'kg'],
                ['name' => 'Talas',          'unit' => 'kg'],
                ['name' => 'Bawang Merah',   'unit' => 'kg'],
                ['name' => 'Bawang Putih',   'unit' => 'kg'],
            ],
            'Biji-bijian' => [
                ['name' => 'Jagung Manis',   'unit' => 'kg'],
                ['name' => 'Kedelai',        'unit' => 'kg'],
                ['name' => 'Kacang Tanah',   'unit' => 'kg'],
                ['name' => 'Kacang Hijau',   'unit' => 'kg'],
                ['name' => 'Beras Merah',    'unit' => 'kg'],
                ['name' => 'Beras Organik',  'unit' => 'kg'],
            ],
        ];

        $total = 0;
        foreach ($data as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();
            if (!$category) continue;

            foreach ($products as $product) {
                Product::firstOrCreate(
                    ['name' => $product['name']],
                    [
                        'category_id' => $category->id,
                        'unit'        => $product['unit'],
                    ]
                );
                $total++;
            }
        }

        $this->command->info("✅ ProductSeeder selesai — {$total} produk dibuat.");
    }
}
