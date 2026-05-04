<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seller;
use App\Models\SellerProfile;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        // Koordinat toko (lat, lng) per email penjual
        $coords = [
            'seller@seara.id' => [-6.8126,  107.6152],  // Lembang
            'ratna@seara.id'  => [-6.8309,  107.1438],  // Cianjur
            'hendra@seara.id' => [-7.9666,  112.6326],  // Malang
            'siti@seara.id'   => [-8.5381,  115.1336],  // Tabanan
            'budi@seara.id'   => [-0.7897,  100.6503],  // Solok
            'agus@seara.id'   => [-6.8945,  110.6428],  // Demak
            'dewi@seara.id'   => [-7.8688,  112.5268],  // Batu
            'yusuf@seara.id'  => [-8.5631,  115.1888],  // Badung
        ];

        $sellers = User::where('role', 'seller')->get();
        $count = 0;

        foreach ($sellers as $user) {
            $profile = SellerProfile::where('user_id', $user->id)->first();
            $shopName = $profile?->nama_toko ?? ('Toko ' . $user->name);
            $description = $profile?->deskripsi_toko ?? 'Hasil panen segar langsung dari petani kami.';
            [$lat, $lng] = $coords[$user->email] ?? [null, null];

            Seller::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'shop_name'   => $shopName,
                    'description' => $description,
                    'latitude'    => $lat,
                    'longitude'   => $lng,
                ]
            );
            $count++;
        }

        $this->command->info("✅ SellerSeeder selesai — {$count} seller dibuat.");
    }
}
