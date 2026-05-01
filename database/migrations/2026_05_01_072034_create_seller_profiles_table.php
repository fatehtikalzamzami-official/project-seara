<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique() // one-to-one dengan users
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('application_id')
                ->constrained('seller_applications')
                ->restrictOnDelete(); // tidak bisa hapus application kalau profile masih ada

            // Info toko publik
            $table->string('nama_toko');
            $table->string('slug_toko')->unique();
            $table->text('deskripsi_toko');
            $table->string('kategori_utama');
            $table->string('foto_toko')->nullable();

            // Statistik toko
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('total_ulasan')->default(0);
            $table->unsignedInteger('total_produk')->default(0);
            $table->unsignedInteger('total_transaksi')->default(0);

            // Lokasi & operasional
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->text('alamat_toko');
            $table->json('jam_operasional')->nullable();    // {"senin":"08:00-17:00",...}
            $table->json('metode_pengiriman')->nullable();  // ["JNE","J&T","GoSend"]

            // Rekening (enkripsi di production via Laravel Crypt)
            $table->string('no_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama_rekening')->nullable();

            // Status toko
            $table->boolean('is_open')->default(true);
            $table->boolean('is_verified')->default(true);
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
            $table->softDeletes(); // softDelete = suspend toko, bukan hapus permanen

            $table->index('kategori_utama');
            $table->index(['provinsi', 'kota_kabupaten']);
            $table->index('is_open');
            $table->index('is_verified');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_profiles');
    }
};