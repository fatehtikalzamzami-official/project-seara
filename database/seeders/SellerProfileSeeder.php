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
        $profiles = [
            [
                'email'           => 'seller@seara.id',
                'nama_toko'       => 'Surya Farm',
                'slug_toko'       => 'surya-farm',
                'deskripsi_toko'  => 'Sayuran organik segar langsung dari kebun Lembang, tanpa pestisida berlebih. Sudah melayani ribuan pelanggan sejak 2018.',
                'kategori_utama'  => 'Sayuran',
                'rating'          => 4.92,
                'total_ulasan'    => 312,
                'total_produk'    => 18,
                'total_transaksi' => 820,
                'provinsi'        => 'Jawa Barat',
                'kota_kabupaten'  => 'Bandung Barat',
                'alamat_toko'     => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
                'no_rekening'     => '1234567890',
                'nama_bank'       => 'BRI',
                'atas_nama_rekening' => 'Surya Darmawan',
                'jam_operasional' => ['senin'=>'07:00-17:00','selasa'=>'07:00-17:00','rabu'=>'07:00-17:00','kamis'=>'07:00-17:00','jumat'=>'07:00-17:00','sabtu'=>'07:00-15:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['J&T', 'JNE', 'Sicepat', 'GoSend'],
                'verified_at'     => now()->subDays(28),
            ],
            [
                'email'           => 'ratna@seara.id',
                'nama_toko'       => 'Kebun Ratna Cianjur',
                'slug_toko'       => 'kebun-ratna-cianjur',
                'deskripsi_toko'  => 'Buah segar pilihan dari dataran tinggi Cianjur. Mangga, alpukat, pisang kepok, dan durian montong langsung petik.',
                'kategori_utama'  => 'Buah',
                'rating'          => 4.85,
                'total_ulasan'    => 210,
                'total_produk'    => 12,
                'total_transaksi' => 540,
                'provinsi'        => 'Jawa Barat',
                'kota_kabupaten'  => 'Cianjur',
                'alamat_toko'     => 'Desa Cikaret No. 12, Cianjur, Jawa Barat 43251',
                'no_rekening'     => '9876543210',
                'nama_bank'       => 'BCA',
                'atas_nama_rekening' => 'Ratna Dewi Kusuma',
                'jam_operasional' => ['senin'=>'06:00-16:00','selasa'=>'06:00-16:00','rabu'=>'06:00-16:00','kamis'=>'06:00-16:00','jumat'=>'06:00-16:00','sabtu'=>'06:00-14:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['JNE', 'J&T', 'Pos Indonesia'],
                'verified_at'     => now()->subDays(23),
            ],
            [
                'email'           => 'hendra@seara.id',
                'nama_toko'       => 'Tani Hendra Malang',
                'slug_toko'       => 'tani-hendra-malang',
                'deskripsi_toko'  => 'Rempah-rempah berkualitas tinggi dari kaki Gunung Arjuno. Jahe, kunyit, lengkuas, dan kencur organik bersertifikat.',
                'kategori_utama'  => 'Rempah',
                'rating'          => 4.78,
                'total_ulasan'    => 185,
                'total_produk'    => 15,
                'total_transaksi' => 430,
                'provinsi'        => 'Jawa Timur',
                'kota_kabupaten'  => 'Malang',
                'alamat_toko'     => 'Jl. Pertanian No. 7, Malang, Jawa Timur 65141',
                'no_rekening'     => '1122334455',
                'nama_bank'       => 'Mandiri',
                'atas_nama_rekening' => 'Hendra Wijaya',
                'jam_operasional' => ['senin'=>'07:00-17:00','selasa'=>'07:00-17:00','rabu'=>'07:00-17:00','kamis'=>'07:00-17:00','jumat'=>'07:00-15:00','sabtu'=>'08:00-14:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['JNE', 'Sicepat', 'AnterAja'],
                'verified_at'     => now()->subDays(18),
            ],
            [
                'email'           => 'siti@seara.id',
                'nama_toko'       => 'Sari Bali Organik',
                'slug_toko'       => 'sari-bali-organik',
                'deskripsi_toko'  => 'Produk perkebunan organik Bali yang dikelola turun-temurun. Kopi Kintamani, cengkeh, dan vanili pilihan ekspor.',
                'kategori_utama'  => 'Perkebunan',
                'rating'          => 4.95,
                'total_ulasan'    => 398,
                'total_produk'    => 20,
                'total_transaksi' => 1100,
                'provinsi'        => 'Bali',
                'kota_kabupaten'  => 'Tabanan',
                'alamat_toko'     => 'Jl. Subak No. 3, Tabanan, Bali 82121',
                'no_rekening'     => '5566778899',
                'nama_bank'       => 'BNI',
                'atas_nama_rekening' => 'Siti Aminah Putri',
                'jam_operasional' => ['senin'=>'08:00-17:00','selasa'=>'08:00-17:00','rabu'=>'08:00-17:00','kamis'=>'08:00-17:00','jumat'=>'08:00-17:00','sabtu'=>'08:00-16:00','minggu'=>'09:00-13:00'],
                'metode_pengiriman' => ['J&T', 'JNE', 'Sicepat', 'GoSend', 'Grab'],
                'verified_at'     => now()->subDays(13),
            ],
            [
                'email'           => 'budi@seara.id',
                'nama_toko'       => 'Minang Agro',
                'slug_toko'       => 'minang-agro',
                'deskripsi_toko'  => 'Buah manggis, jeruk, dan cabai segar dari tanah Minang. Jaminan kesegaran 100% atau uang kembali.',
                'kategori_utama'  => 'Buah',
                'rating'          => 4.70,
                'total_ulasan'    => 143,
                'total_produk'    => 10,
                'total_transaksi' => 310,
                'provinsi'        => 'Sumatera Barat',
                'kota_kabupaten'  => 'Solok',
                'alamat_toko'     => 'Dusun Pasar Baru No. 9, Solok, Sumatera Barat 27311',
                'no_rekening'     => '6677889900',
                'nama_bank'       => 'BRI',
                'atas_nama_rekening' => 'Budi Santoso',
                'jam_operasional' => ['senin'=>'07:00-16:00','selasa'=>'07:00-16:00','rabu'=>'07:00-16:00','kamis'=>'07:00-16:00','jumat'=>'07:00-11:30','sabtu'=>'07:00-15:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['JNE', 'J&T', 'Wahana'],
                'verified_at'     => now()->subDays(10),
            ],
            [
                'email'           => 'agus@seara.id',
                'nama_toko'       => 'Tani Demak Sejahtera',
                'slug_toko'       => 'tani-demak-sejahtera',
                'deskripsi_toko'  => 'Sayuran hijau premium dari lahan pesisir Demak. Kangkung, bayam, terong, dan pare segar tiap hari.',
                'kategori_utama'  => 'Sayuran',
                'rating'          => 4.60,
                'total_ulasan'    => 98,
                'total_produk'    => 8,
                'total_transaksi' => 220,
                'provinsi'        => 'Jawa Tengah',
                'kota_kabupaten'  => 'Demak',
                'alamat_toko'     => 'Desa Kebonagung No. 15, Demak, Jawa Tengah 59571',
                'no_rekening'     => '7788990011',
                'nama_bank'       => 'Mandiri',
                'atas_nama_rekening' => 'Agus Setiawan',
                'jam_operasional' => ['senin'=>'05:00-15:00','selasa'=>'05:00-15:00','rabu'=>'05:00-15:00','kamis'=>'05:00-15:00','jumat'=>'05:00-12:00','sabtu'=>'05:00-14:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['J&T', 'Sicepat'],
                'verified_at'     => now()->subDays(8),
            ],
            [
                'email'           => 'dewi@seara.id',
                'nama_toko'       => 'Dewi Buah Batu',
                'slug_toko'       => 'dewi-buah-batu',
                'deskripsi_toko'  => 'Apel Malang, jeruk baby, dan stroberi segar dari kebun di kota Batu yang sejuk. Pengiriman dingin tersedia.',
                'kategori_utama'  => 'Buah',
                'rating'          => 4.88,
                'total_ulasan'    => 265,
                'total_produk'    => 14,
                'total_transaksi' => 670,
                'provinsi'        => 'Jawa Timur',
                'kota_kabupaten'  => 'Batu',
                'alamat_toko'     => 'Jl. Jeruk No. 22, Batu, Jawa Timur 65311',
                'no_rekening'     => '8899001122',
                'nama_bank'       => 'BCA',
                'atas_nama_rekening' => 'Dewi Lestari Sari',
                'jam_operasional' => ['senin'=>'07:00-17:00','selasa'=>'07:00-17:00','rabu'=>'07:00-17:00','kamis'=>'07:00-17:00','jumat'=>'07:00-17:00','sabtu'=>'07:00-16:00','minggu'=>'08:00-13:00'],
                'metode_pengiriman' => ['JNE', 'J&T', 'Sicepat', 'GoSend'],
                'verified_at'     => now()->subDays(6),
            ],
            [
                'email'           => 'yusuf@seara.id',
                'nama_toko'       => 'Yusuf Rempah Bali',
                'slug_toko'       => 'yusuf-rempah-bali',
                'deskripsi_toko'  => 'Rempah tradisional Bali: kunyit, jahe merah, kemiri, dan kencur diproses secara alami tanpa bahan pengawet.',
                'kategori_utama'  => 'Rempah',
                'rating'          => 4.82,
                'total_ulasan'    => 177,
                'total_produk'    => 11,
                'total_transaksi' => 390,
                'provinsi'        => 'Bali',
                'kota_kabupaten'  => 'Badung',
                'alamat_toko'     => 'Desa Mambal No. 5, Badung, Bali 80352',
                'no_rekening'     => '9900112233',
                'nama_bank'       => 'BNI',
                'atas_nama_rekening' => 'Yusuf Hakim Pratama',
                'jam_operasional' => ['senin'=>'08:00-17:00','selasa'=>'08:00-17:00','rabu'=>'08:00-17:00','kamis'=>'08:00-17:00','jumat'=>'08:00-15:00','sabtu'=>'08:00-14:00','minggu'=>'Tutup'],
                'metode_pengiriman' => ['J&T', 'JNE', 'AnterAja'],
                'verified_at'     => now()->subDays(3),
            ],
        ];

        foreach ($profiles as $data) {
            $user = User::where('email', $data['email'])->first();
            if (!$user) continue;

            $application = SellerApplication::where('user_id', $user->id)
                ->where('status', 'approved')
                ->first();
            if (!$application) continue;

            unset($data['email']);

            SellerProfile::updateOrCreate(
                ['user_id' => $user->id],
                array_merge($data, [
                    'user_id'        => $user->id,
                    'application_id' => $application->id,
                    'foto_toko'      => null,
                    'is_open'        => true,
                    'is_verified'    => true,
                    'jam_operasional'    => json_encode($data['jam_operasional']),
                    'metode_pengiriman'  => json_encode($data['metode_pengiriman']),
                ])
            );
        }

        $this->command->info('✅ SellerProfileSeeder selesai — ' . count($profiles) . ' profil toko dibuat.');
    }
}
