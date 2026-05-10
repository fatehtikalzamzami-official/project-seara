<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Harvest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SellerProfile;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua seller user
        $sellers = User::where('role', 'seller')->get()->keyBy('email');
        // Ambil semua buyer user
        $buyers  = User::where('role', 'buyer')->get();

        if ($sellers->isEmpty() || $buyers->isEmpty()) {
            $this->command->warn('Tidak ada seller/buyer. Jalankan UserSeeder terlebih dahulu.');
            return;
        }

        $statuses = ['delivered', 'delivered', 'delivered', 'shipped', 'processing', 'paid', 'cancelled', 'pending_payment'];

        $orderCount = 0;

        // Untuk setiap seller, buat order dummy 6 bulan ke belakang
        foreach ($sellers as $email => $seller) {
            $harvests = Harvest::where('seller_id', function ($q) use ($seller) {
                $q->select('id')->from('seller_profiles')->where('user_id', $seller->id)->limit(1);
            })->with('product')->get();

            if ($harvests->isEmpty()) continue;

            $sellerProfile = SellerProfile::where('user_id', $seller->id)->first();
            $sellerName    = $sellerProfile?->nama_toko ?? $seller->nama_lengkap;

            // Buat 30–50 order per seller dalam 6 bulan terakhir
            $totalOrders = rand(30, 50);

            for ($i = 0; $i < $totalOrders; $i++) {
                $buyer  = $buyers->random();
                $status = $statuses[array_rand($statuses)];

                // Tanggal acak dalam 6 bulan terakhir
                $createdAt = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                $paidAt    = in_array($status, ['paid','processing','shipped','delivered'])
                             ? $createdAt->copy()->addHours(rand(1, 12))
                             : null;

                // Pilih 1–3 produk acak dari harvest seller ini
                $selectedHarvests = $harvests->random(min(rand(1, 3), $harvests->count()));
                if (!($selectedHarvests instanceof \Illuminate\Support\Collection)) {
                    $selectedHarvests = collect([$selectedHarvests]);
                }

                $subtotalOrder = 0;
                $itemsData = [];

                foreach ($selectedHarvests as $harvest) {
                    $qty      = rand(1, 10);
                    $price    = (float) $harvest->price_per_unit;
                    $subtotal = $qty * $price;
                    $subtotalOrder += $subtotal;

                    $itemsData[] = [
                        'harvest_id'     => $harvest->id,
                        'product_name'   => $harvest->product->name ?? 'Produk',
                        'product_unit'   => $harvest->product->unit ?? 'kg',
                        'seller_name'    => $sellerName,
                        'seller_user_id' => $seller->id,
                        'quantity'       => $qty,
                        'price_per_unit' => $price,
                        'subtotal'       => $subtotal,
                        'is_offer_price' => false,
                        'created_at'     => $createdAt,
                        'updated_at'     => $createdAt,
                    ];
                }

                $shippingCost = rand(0, 1) ? rand(10000, 25000) : 0;
                $totalAmount  = $subtotalOrder + $shippingCost;

                $order = Order::create([
                    'order_number'    => Order::generateOrderNumber() . '-' . $orderCount,
                    'buyer_id'        => $buyer->id,
                    'recipient_name'  => $buyer->nama_lengkap,
                    'recipient_phone' => $buyer->no_whatsapp ?? '08123456789',
                    'shipping_address'=> $buyer->alamat ?? 'Jl. Contoh No. 1',
                    'province'        => 'Jawa Barat',
                    'city'            => 'Bandung',
                    'postal_code'     => '40111',
                    'subtotal'        => $subtotalOrder,
                    'shipping_cost'   => $shippingCost,
                    'discount_amount' => 0,
                    'total_amount'    => $totalAmount,
                    'status'          => $status,
                    'payment_method'  => ['transfer', 'cod', 'e-wallet'][array_rand(['transfer','cod','e-wallet'])],
                    'paid_at'         => $paidAt,
                    'created_at'      => $createdAt,
                    'updated_at'      => $createdAt,
                ]);

                foreach ($itemsData as $item) {
                    $order->items()->create($item);
                }

                $orderCount++;
            }
        }

        $this->command->info("✅ Berhasil membuat {$orderCount} order dummy.");
    }
}
