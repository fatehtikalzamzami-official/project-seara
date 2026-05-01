<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $sayur = Category::where('name', 'Sayuran')->first();

    Product::create([
        'name' => 'Brokoli',
        'category_id' => $sayur->id,
        'unit' => 'kg'
    ]);

    Product::create([
        'name' => 'Cabai Merah',
        'category_id' => $sayur->id,
        'unit' => 'kg'
    ]);

    Product::create([
        'name' => 'Tomat',
        'category_id' => $sayur->id,
        'unit' => 'kg'
    ]);
}
}
