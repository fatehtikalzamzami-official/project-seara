<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('harvest_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('nama_tanaman');
            $table->date('tanggal_tanam')->nullable();
            $table->date('estimasi_panen');
            $table->decimal('estimasi_kuantitas', 10, 2)->nullable();
            $table->string('satuan', 20)->nullable();
            $table->string('kebun_lokasi', 255)->nullable();
            $table->string('metode_tanam', 50)->nullable(); // organik | hidroponik | konvensional
            $table->enum('status', ['direncanakan', 'sedang_tumbuh', 'siap_panen', 'selesai', 'gagal'])
                ->default('direncanakan');
            $table->text('catatan')->nullable();
            $table->decimal('luas_lahan', 10, 2)->nullable(); // dalam m²
            $table->boolean('is_organic')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_schedules');
    }
};