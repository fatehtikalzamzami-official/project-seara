<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Harvest;
use App\Models\Product;
use App\Models\Seller;
use Carbon\Carbon;

class HarvestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $products = Product::all();
    $sellers = Seller::all();

    foreach ($products as $product) {
        foreach ($sellers as $seller) {
Harvest::create([
    'product_id' => 1,
    'seller_id' => 1,
    'price_per_unit' => 8000,
    'remaining_stock' => 50,
    'harvest_date' => Carbon::now()->toDateString(),
    'harvest_time' => Carbon::now()->subHours(1),
]);
        }
    }
}
}
