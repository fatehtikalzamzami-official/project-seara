<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SellerApplication;

class SellerApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@seara.id')->first();

        $applications = [
            [
                'email'             => 'seller@seara.id',
                'nama_toko'         => 'Surya Farm',
                'slug_toko'         => 'surya-farm',
                'deskripsi_toko'    => 'Sayuran organik segar langsung dari kebun Lembang, tanpa pestisida berlebih.',
                'kategori_utama'    => 'Sayuran',
                'provinsi'          => 'Jawa Barat',
                'kota_kabupaten'    => 'Bandung Barat',
                'alamat_toko'       => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
                'no_ktp'            => '3204000000000001',
                'foto_ktp'          => 'ktp/surya_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/surya_selfie.jpg',
                'no_rekening'       => '1234567890',
                'nama_bank'         => 'BRI',
                'atas_nama_rekening'=> 'Surya Darmawan',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(30),
                'reviewed_at'       => now()->subDays(28),
            ],
            [
                'email'             => 'ratna@seara.id',
                'nama_toko'         => 'Kebun Ratna Cianjur',
                'slug_toko'         => 'kebun-ratna-cianjur',
                'deskripsi_toko'    => 'Buah segar pilihan dari dataran tinggi Cianjur, langsung petik dari pohon.',
                'kategori_utama'    => 'Buah',
                'provinsi'          => 'Jawa Barat',
                'kota_kabupaten'    => 'Cianjur',
                'alamat_toko'       => 'Desa Cikaret No. 12, Cianjur, Jawa Barat 43251',
                'no_ktp'            => '3204000000000002',
                'foto_ktp'          => 'ktp/ratna_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/ratna_selfie.jpg',
                'no_rekening'       => '9876543210',
                'nama_bank'         => 'BCA',
                'atas_nama_rekening'=> 'Ratna Dewi Kusuma',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(25),
                'reviewed_at'       => now()->subDays(23),
            ],
            [
                'email'             => 'hendra@seara.id',
                'nama_toko'         => 'Tani Hendra Malang',
                'slug_toko'         => 'tani-hendra-malang',
                'deskripsi_toko'    => 'Rempah-rempah dan sayuran segar hasil pertanian organik di kaki Gunung Arjuno.',
                'kategori_utama'    => 'Rempah',
                'provinsi'          => 'Jawa Timur',
                'kota_kabupaten'    => 'Malang',
                'alamat_toko'       => 'Jl. Pertanian No. 7, Malang, Jawa Timur 65141',
                'no_ktp'            => '3507000000000003',
                'foto_ktp'          => 'ktp/hendra_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/hendra_selfie.jpg',
                'no_rekening'       => '1122334455',
                'nama_bank'         => 'Mandiri',
                'atas_nama_rekening'=> 'Hendra Wijaya',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(20),
                'reviewed_at'       => now()->subDays(18),
            ],
            [
                'email'             => 'siti@seara.id',
                'nama_toko'         => 'Sari Bali Organik',
                'slug_toko'         => 'sari-bali-organik',
                'deskripsi_toko'    => 'Produk perkebunan organik Bali: kopi, cengkeh, dan rempah pilihan sistem subak.',
                'kategori_utama'    => 'Perkebunan',
                'provinsi'          => 'Bali',
                'kota_kabupaten'    => 'Tabanan',
                'alamat_toko'       => 'Jl. Subak No. 3, Tabanan, Bali 82121',
                'no_ktp'            => '5102000000000004',
                'foto_ktp'          => 'ktp/siti_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/siti_selfie.jpg',
                'no_rekening'       => '5566778899',
                'nama_bank'         => 'BNI',
                'atas_nama_rekening'=> 'Siti Aminah Putri',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(15),
                'reviewed_at'       => now()->subDays(13),
            ],
            [
                'email'             => 'budi@seara.id',
                'nama_toko'         => 'Minang Agro',
                'slug_toko'         => 'minang-agro',
                'deskripsi_toko'    => 'Buah dan sayuran segar dari tanah subur Sumatera Barat.',
                'kategori_utama'    => 'Buah',
                'provinsi'          => 'Sumatera Barat',
                'kota_kabupaten'    => 'Solok',
                'alamat_toko'       => 'Dusun Pasar Baru No. 9, Solok, Sumatera Barat 27311',
                'no_ktp'            => '1303000000000005',
                'foto_ktp'          => 'ktp/budi_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/budi_selfie.jpg',
                'no_rekening'       => '6677889900',
                'nama_bank'         => 'BRI',
                'atas_nama_rekening'=> 'Budi Santoso',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(12),
                'reviewed_at'       => now()->subDays(10),
            ],
            [
                'email'             => 'agus@seara.id',
                'nama_toko'         => 'Tani Demak Sejahtera',
                'slug_toko'         => 'tani-demak-sejahtera',
                'deskripsi_toko'    => 'Sayuran hijau berkualitas dari lahan pertanian subur pesisir Demak.',
                'kategori_utama'    => 'Sayuran',
                'provinsi'          => 'Jawa Tengah',
                'kota_kabupaten'    => 'Demak',
                'alamat_toko'       => 'Desa Kebonagung No. 15, Demak, Jawa Tengah 59571',
                'no_ktp'            => '3321000000000006',
                'foto_ktp'          => 'ktp/agus_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/agus_selfie.jpg',
                'no_rekening'       => '7788990011',
                'nama_bank'         => 'Mandiri',
                'atas_nama_rekening'=> 'Agus Setiawan',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(10),
                'reviewed_at'       => now()->subDays(8),
            ],
            [
                'email'             => 'dewi@seara.id',
                'nama_toko'         => 'Dewi Buah Batu',
                'slug_toko'         => 'dewi-buah-batu',
                'deskripsi_toko'    => 'Buah apel, jeruk, dan stroberi segar dari kota Batu yang dingin dan subur.',
                'kategori_utama'    => 'Buah',
                'provinsi'          => 'Jawa Timur',
                'kota_kabupaten'    => 'Batu',
                'alamat_toko'       => 'Jl. Jeruk No. 22, Batu, Jawa Timur 65311',
                'no_ktp'            => '3579000000000007',
                'foto_ktp'          => 'ktp/dewi_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/dewi_selfie.jpg',
                'no_rekening'       => '8899001122',
                'nama_bank'         => 'BCA',
                'atas_nama_rekening'=> 'Dewi Lestari Sari',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(8),
                'reviewed_at'       => now()->subDays(6),
            ],
            [
                'email'             => 'yusuf@seara.id',
                'nama_toko'         => 'Yusuf Rempah Bali',
                'slug_toko'         => 'yusuf-rempah-bali',
                'deskripsi_toko'    => 'Rempah pilihan asal Bali: kunyit, jahe merah, lengkuas, dan kemiri organik.',
                'kategori_utama'    => 'Rempah',
                'provinsi'          => 'Bali',
                'kota_kabupaten'    => 'Badung',
                'alamat_toko'       => 'Desa Mambal No. 5, Badung, Bali 80352',
                'no_ktp'            => '5101000000000008',
                'foto_ktp'          => 'ktp/yusuf_ktp.jpg',
                'foto_selfie_ktp'   => 'ktp/yusuf_selfie.jpg',
                'no_rekening'       => '9900112233',
                'nama_bank'         => 'BNI',
                'atas_nama_rekening'=> 'Yusuf Hakim Pratama',
                'status'            => 'approved',
                'submitted_at'      => now()->subDays(5),
                'reviewed_at'       => now()->subDays(3),
            ],
        ];

        foreach ($applications as $data) {
            $user = User::where('email', $data['email'])->first();
            if (!$user) continue;

            unset($data['email']);

            SellerApplication::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($data, [
                    'user_id'      => $user->id,
                    'reviewed_by'  => $admin->id,
                    'catatan_penolakan' => null,
                ])
            );
        }

        $this->command->info('✅ SellerApplicationSeeder selesai — ' . count($applications) . ' aplikasi dibuat.');
    }
}
