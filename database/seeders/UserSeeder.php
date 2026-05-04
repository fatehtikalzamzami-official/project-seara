<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ──────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@seara.id'],
            [
                'name'               => 'Super Admin',
                'nama_lengkap'       => 'Administrator SEARA',
                'email_verified_at'  => now(),
                'password'           => Hash::make('Admin@123'),
                'no_whatsapp'        => '081200000001',
                'alamat'             => 'Jl. Gatot Subroto No. 1, Senayan, Jakarta Selatan 12190',
                'role'               => 'admin',
                'is_active'          => true,
            ]
        );

        // ── SELLERS ─────────────────────────────────────────────
        $sellers = [
            [
                'name'         => 'Pak Surya',
                'nama_lengkap' => 'Surya Darmawan',
                'email'        => 'seller@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '081200000002',
                'alamat'       => 'Jl. Raya Lembang No. 45, Lembang, Bandung Barat 40391',
            ],
            [
                'name'         => 'Bu Ratna',
                'nama_lengkap' => 'Ratna Dewi Kusuma',
                'email'        => 'ratna@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '081311111001',
                'alamat'       => 'Desa Cikaret No. 12, Cianjur, Jawa Barat 43251',
            ],
            [
                'name'         => 'Pak Hendra',
                'nama_lengkap' => 'Hendra Wijaya',
                'email'        => 'hendra@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '082233334444',
                'alamat'       => 'Jl. Pertanian No. 7, Malang, Jawa Timur 65141',
            ],
            [
                'name'         => 'Bu Siti',
                'nama_lengkap' => 'Siti Aminah Putri',
                'email'        => 'siti@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '085677778888',
                'alamat'       => 'Jl. Subak No. 3, Tabanan, Bali 82121',
            ],
            [
                'name'         => 'Pak Budi',
                'nama_lengkap' => 'Budi Santoso',
                'email'        => 'budi@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '081299990000',
                'alamat'       => 'Dusun Pasar Baru No. 9, Solok, Sumatera Barat 27311',
            ],
            [
                'name'         => 'Pak Agus',
                'nama_lengkap' => 'Agus Setiawan',
                'email'        => 'agus@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '087812345678',
                'alamat'       => 'Desa Kebonagung No. 15, Demak, Jawa Tengah 59571',
            ],
            [
                'name'         => 'Bu Dewi',
                'nama_lengkap' => 'Dewi Lestari Sari',
                'email'        => 'dewi@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '083156781234',
                'alamat'       => 'Jl. Jeruk No. 22, Batu, Jawa Timur 65311',
            ],
            [
                'name'         => 'Pak Yusuf',
                'nama_lengkap' => 'Yusuf Hakim Pratama',
                'email'        => 'yusuf@seara.id',
                'password'     => 'Seller@123',
                'no_whatsapp'  => '089998887776',
                'alamat'       => 'Desa Mambal No. 5, Badung, Bali 80352',
            ],
        ];

        foreach ($sellers as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'role'              => 'seller',
                    'is_active'         => true,
                ])
            );
        }

        // ── BUYERS ──────────────────────────────────────────────
        $buyers = [
            [
                'name'         => 'Ibu Sari',
                'nama_lengkap' => 'Sari Indah Permata',
                'email'        => 'buyer@seara.id',
                'password'     => 'Buyer@123',
                'no_whatsapp'  => '081200000003',
                'alamat'       => 'Jl. Kemang Raya No. 88, Jakarta Selatan 12730',
            ],
            [
                'name'         => 'Pak Doni',
                'nama_lengkap' => 'Doni Firmansyah',
                'email'        => 'doni@seara.id',
                'password'     => 'Buyer@123',
                'no_whatsapp'  => '081355556666',
                'alamat'       => 'Jl. Merdeka No. 10, Bekasi, Jawa Barat 17111',
            ],
            [
                'name'         => 'Bu Lina',
                'nama_lengkap' => 'Lina Marlina',
                'email'        => 'lina@seara.id',
                'password'     => 'Buyer@123',
                'no_whatsapp'  => '082244445555',
                'alamat'       => 'Jl. Anggrek No. 5, Surabaya, Jawa Timur 60111',
            ],
            [
                'name'         => 'Pak Rizal',
                'nama_lengkap' => 'Rizal Maulana',
                'email'        => 'rizal@seara.id',
                'password'     => 'Buyer@123',
                'no_whatsapp'  => '085611112222',
                'alamat'       => 'Jl. Raden Patah No. 30, Semarang, Jawa Tengah 50141',
            ],
        ];

        foreach ($buyers as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make($data['password']),
                    'email_verified_at' => now(),
                    'role'              => 'buyer',
                    'is_active'         => true,
                ])
            );
        }

        $this->command->info('✅ UserSeeder selesai.');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            array_merge(
                [['Admin', 'admin@seara.id', 'Admin@123']],
                array_map(fn($s) => ['Seller', $s['email'], $s['password']], $sellers),
                array_map(fn($b) => ['Buyer',  $b['email'], $b['password']], $buyers),
            )
        );
    }
}
