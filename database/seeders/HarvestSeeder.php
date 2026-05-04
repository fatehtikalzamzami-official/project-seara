<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Harvest;
use App\Models\Product;
use App\Models\Seller;
use Carbon\Carbon;

class HarvestSeeder extends Seeder
{
    /**
     * Daftar produk yang dijual tiap toko, beserta harga & stok realistis.
     * Format: email_seller => [ [product_name, price, stock, is_organic, hari_panen], ... ]
     */
    private array $catalog = [
        'seller@seara.id' => [
            ['Brokoli',        12000,  80, true,  0],
            ['Wortel',          8000, 100, true,  0],
            ['Tomat',           7000, 150, false, 1],
            ['Cabai Merah',    22000,  60, false, 1],
            ['Cabai Rawit',    35000,  45, false, 2],
            ['Selada',         10000,  70, true,  0],
            ['Bayam',           5000,  90, true,  0],
            ['Sawi Hijau',      5500,  80, true,  1],
            ['Timun',           6000, 120, false, 0],
            ['Terong Ungu',     8500,  65, false, 2],
        ],
        'ratna@seara.id' => [
            ['Mangga Harum Manis', 18000, 200, false, 1],
            ['Alpukat Mentega',    25000, 100, false, 0],
            ['Pisang Kepok',        8000,  60, false, 0],
            ['Pisang Ambon',        9000,  50, false, 1],
            ['Manggis',            30000,  80, false, 2],
            ['Pepaya California',  12000, 120, false, 0],
            ['Jeruk Keprok',       15000,  90, false, 1],
            ['Rambutan',           18000,  75, false, 0],
        ],
        'hendra@seara.id' => [
            ['Jahe Emprit',    15000, 120, true,  0],
            ['Jahe Merah',     22000,  80, true,  1],
            ['Kunyit',         12000, 100, true,  0],
            ['Lengkuas',       10000,  90, true,  0],
            ['Kencur',         13000,  70, true,  2],
            ['Temulawak',      18000,  60, true,  1],
            ['Kemiri',         25000,  50, false, 3],
            ['Lada Hitam',     75000,  30, false, 5],
            ['Brokoli',        11000, 100, false, 0],
            ['Wortel',          7500, 130, false, 1],
        ],
        'siti@seara.id' => [
            ['Kopi Robusta',   85000,  50, true,  7],
            ['Kopi Arabika',  125000,  30, true, 10],
            ['Cengkeh',       120000,  25, true,  5],
            ['Kakao',          65000,  40, true,  7],
            ['Vanili',        350000,  10, true, 14],
            ['Teh Hijau',      45000,  35, true,  7],
            ['Kelapa Muda',    10000, 100, false, 0],
        ],
        'budi@seara.id' => [
            ['Manggis',        28000,  70, false, 2],
            ['Jeruk Baby',     18000, 100, false, 1],
            ['Mangga Harum Manis', 16000, 150, false, 0],
            ['Cabai Merah',    20000,  80, false, 1],
            ['Cabai Rawit',    32000,  50, false, 2],
            ['Bawang Merah',   30000,  60, false, 3],
        ],
        'agus@seara.id' => [
            ['Kangkung',        4000, 200, false, 0],
            ['Bayam',           4500, 180, false, 0],
            ['Sawi Hijau',      5000, 160, false, 0],
            ['Kacang Panjang',  7000, 100, false, 1],
            ['Terong Ungu',     7500,  80, false, 1],
            ['Pare',            6500,  70, false, 1],
            ['Labu Siam',       5000,  90, false, 0],
        ],
        'dewi@seara.id' => [
            ['Apel Malang',    20000, 150, false, 3],
            ['Stroberi',       40000,  50, false, 1],
            ['Jeruk Baby',     17000, 120, false, 2],
            ['Alpukat Mentega',22000,  80, false, 2],
            ['Semangka',       10000, 100, false, 0],
            ['Melon',          12000,  90, false, 0],
            ['Pisang Ambon',    8500,  60, false, 0],
        ],
        'yusuf@seara.id' => [
            ['Jahe Merah',     20000, 100, true,  1],
            ['Kunyit',         11000, 120, true,  0],
            ['Lengkuas',        9500,  90, true,  0],
            ['Kencur',         12500,  70, true,  2],
            ['Temulawak',      17000,  60, true,  3],
            ['Kemiri',         23000,  40, false, 5],
            ['Kayu Manis',     45000,  25, false, 7],
        ],
    ];

    public function run(): void
    {
        $total = 0;

        foreach ($this->catalog as $email => $items) {
            // Cari seller via user
            $seller = Seller::whereHas('user', fn($q) => $q->where('email', $email))->first();
            if (!$seller) {
                $this->command->warn("⚠️  Seller tidak ditemukan untuk: {$email}");
                continue;
            }

            foreach ($items as [$productName, $price, $stock, $isOrganic, $daysAgo]) {
                $product = Product::where('name', $productName)->first();
                if (!$product) {
                    $this->command->warn("⚠️  Produk tidak ditemukan: {$productName}");
                    continue;
                }

                // Variasi kecil harga agar data lebih hidup (±5%)
                $variance  = rand(-5, 5) / 100;
                $finalPrice = round($price * (1 + $variance), -2); // bulatkan ke ratusan

                // Stok bervariasi ±20%
                $finalStock = max(5, $stock + rand(-($stock * 0.2), $stock * 0.2));

                Harvest::create([
                    'seller_id'       => $seller->id,
                    'product_id'      => $product->id,
                    'harvest_date'    => Carbon::now()->subDays($daysAgo)->setTime(rand(4, 8), rand(0, 59)),
                    'remaining_stock' => (int) $finalStock,
                    'price_per_unit'  => $finalPrice,
                    'is_organic'      => $isOrganic,
                ]);
                $total++;
            }
        }

        $this->command->info("✅ HarvestSeeder selesai — {$total} data panen dibuat.");
    }
}
