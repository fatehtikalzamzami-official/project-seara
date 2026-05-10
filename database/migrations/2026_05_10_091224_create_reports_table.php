<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Pelapor
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();

            // Terlapor (bisa user biasa atau seller)
            $table->foreignId('reported_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Objek yang dilaporkan (opsional — harvest/produk)
            $table->foreignId('harvest_id')->nullable()->constrained('harvests')->nullOnDelete();

            // Tipe laporan
            $table->enum('type', [
                'produk_palsu',
                'harga_tidak_wajar',
                'penipuan',
                'konten_tidak_pantas',
                'penjual_tidak_responsif',
                'lainnya',
            ])->default('lainnya');

            // Detail laporan
            $table->string('subject', 255);
            $table->text('description');
            $table->json('evidence_urls')->nullable(); // foto bukti (array URL)

            // Status moderasi
            $table->enum('status', ['pending', 'reviewing', 'resolved', 'dismissed'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('handled_at')->nullable();

            // Prioritas
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('priority');
            $table->index('type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};