<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('seller_applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Data toko yang diajukan
            $table->string('nama_toko');
            $table->string('slug_toko')->unique();
            $table->text('deskripsi_toko');
            $table->string('kategori_utama');
            $table->string('provinsi');
            $table->string('kota_kabupaten');
            $table->text('alamat_toko');

            // Dokumen verifikasi
            $table->string('no_ktp', 20);
            $table->string('foto_ktp');           // path file di storage
            $table->string('foto_selfie_ktp');    // path file di storage

            // Rekening pencairan
            $table->string('no_rekening')->nullable();
            $table->string('nama_bank')->nullable();
            $table->string('atas_nama_rekening')->nullable();

            // Status pengajuan
            $table->enum('status', ['pending', 'reviewing', 'approved', 'rejected'])
                ->default('pending');
            $table->text('catatan_penolakan')->nullable();

            // Audit trail
            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // admin dihapus → history tetap ada
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('submitted_at')->useCurrent();

            $table->timestamps();

            $table->index('status');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_applications');
    }
};