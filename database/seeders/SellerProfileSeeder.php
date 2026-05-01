<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SellerApplication;
use App\Models\SellerProfile;

class SellerProfileSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('email', 'seller@seara.id')->first();
        $application = SellerApplication::where('user_id', $seller?->id)
            ->where('status', 'approved')
            ->first();

        if (!$seller || !$application) {
            $this->command->warn('⚠️  Jalankan UserSeeder & SellerApplicationSeeder dulu.');
            return;
        }

        SellerProfile::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'user_id' => $seller->id,
                'application_id' => $application->id,
                'nama_toko' => 'Surya Farm',
                'slug_toko' => 'surya-farm',
                'deskripsi_toko' => 'Sayuran organik segar langsung dari kebun Lembang, tanpa pestisida berlebih.',
                'kategori_utama' => 'Sayuran',
                'foto_toko' => null,
                'rating' => 4.92,
                'total_ulasan' => 128,
                'total_produk' => 24,
                'total_transaksi' => 312,
                'provinsi' => 'Jawa Barat',
                'kota_kabupaten' => 'Bandung Barat',
                'alamat_toko' => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
                'jam_operasional' => json_encode([
                    'senin' => '07:00-17:00',
                    'selasa' => '07:00-17:00',
                    'rabu' => '07:00-17:00',
                    'kamis' => '07:00-17:00',
                    'jumat' => '07:00-17:00',
                    'sabtu' => '07:00-15:00',
                    'minggu' => 'Tutup',
                ]),
                'metode_pengiriman' => json_encode(['J&T', 'JNE', 'Sicepat', 'GoSend']),
                'no_rekening' => '1234567890',
                'nama_bank' => 'BRI',
                'atas_nama_rekening' => 'Surya Darmawan',
                'is_open' => true,
                'is_verified' => true,
                'verified_at' => now()->subDays(3),
            ]
        );

        $this->command->info('✅ SellerProfileSeeder selesai.');
    }
}