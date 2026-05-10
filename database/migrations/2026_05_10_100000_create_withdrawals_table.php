<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();

            $table->foreignId('seller_user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Nominal
            $table->decimal('jumlah', 12, 2);         // nominal yang diajukan
            $table->decimal('biaya_admin', 10, 2)->default(2500); // biaya admin
            $table->decimal('diterima', 12, 2);        // jumlah - biaya_admin

            // Rekening tujuan (snapshot saat pengajuan)
            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();
            $table->string('atas_nama')->nullable();

            // Status: pending | approved | rejected | transferred
            $table->enum('status', ['pending', 'approved', 'rejected', 'transferred'])
                ->default('pending');

            $table->text('catatan')->nullable();       // catatan seller
            $table->text('admin_note')->nullable();    // catatan admin

            // Admin yang menangani
            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('handled_at')->nullable();
            $table->timestamp('transferred_at')->nullable();

            $table->timestamps();

            $table->index(['seller_user_id', 'status']);
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
