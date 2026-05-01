<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SellerApplication;

class SellerApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('email', 'seller@seara.id')->first();
        $admin = User::where('email', 'admin@seara.id')->first();

        if (!$seller || !$admin) {
            $this->command->warn('⚠️  Jalankan UserSeeder dulu sebelum SellerApplicationSeeder.');
            return;
        }

        SellerApplication::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'user_id' => $seller->id,
                'nama_toko' => 'Surya Farm',
                'slug_toko' => 'surya-farm',
                'deskripsi_toko' => 'Sayuran organik segar langsung dari kebun Lembang, tanpa pestisida berlebih.',
                'kategori_utama' => 'Sayuran',
                'provinsi' => 'Jawa Barat',
                'kota_kabupaten' => 'Bandung Barat',
                'alamat_toko' => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
                'no_ktp' => '3204000000000001',
                'foto_ktp' => 'ktp/surya_ktp.jpg',
                'foto_selfie_ktp' => 'ktp/surya_selfie.jpg',
                'no_rekening' => '1234567890',
                'nama_bank' => 'BRI',
                'atas_nama_rekening' => 'Surya Darmawan',
                'status' => 'approved',
                'catatan_penolakan' => null,
                'reviewed_by' => $admin->id,
                'reviewed_at' => now()->subDays(3),
                'submitted_at' => now()->subDays(5),
            ]
        );

        $this->command->info('✅ SellerApplicationSeeder selesai.');
    }
}