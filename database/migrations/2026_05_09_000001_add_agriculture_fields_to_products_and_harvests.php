<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah kolom ke tabel products (Data Utama Produk)
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->after('unit');
            $table->string('status')->default('tersedia')->after('description'); // tersedia | habis | pre-order
            $table->string('photo')->nullable()->after('status');
        });

        // Tambah kolom ke tabel harvests (Data Khusus Pertanian)
        Schema::table('harvests', function (Blueprint $table) {
            $table->string('kebun_lokasi')->nullable()->after('is_organic');         // Lokasi kebun
            $table->string('metode_tanam')->nullable()->after('kebun_lokasi');       // organik | hidroponik | konvensional
            $table->integer('masa_simpan_hari')->nullable()->after('metode_tanam');  // Masa simpan (dalam hari)
            $table->string('kondisi_produk')->nullable()->after('masa_simpan_hari'); // fresh | grade_a | grade_b
            $table->decimal('berat_bersih', 10, 2)->nullable()->after('kondisi_produk'); // Berat bersih (kg)
            $table->integer('minimal_pembelian')->default(1)->after('berat_bersih'); // Minimal pembelian
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['description', 'status', 'photo']);
        });

        Schema::table('harvests', function (Blueprint $table) {
            $table->dropColumn([
                'kebun_lokasi',
                'metode_tanam',
                'masa_simpan_hari',
                'kondisi_produk',
                'berat_bersih',
                'minimal_pembelian',
            ]);
        });
    }
};
