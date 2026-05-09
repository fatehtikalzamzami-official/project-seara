<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * PERBAIKAN: harvests.seller_id sebelumnya merujuk ke tabel `sellers`
 * yang tidak pernah diisi saat proses approval seller.
 * Approval hanya membuat record di `seller_profiles`.
 * Migration ini memindahkan foreign key ke `seller_profiles`.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah foreign key lama masih ada sebelum mencoba drop
        // (migration ini menjadi no-op jika create_harvests_table sudah diperbaiki)
        try {
            Schema::table('harvests', function (Blueprint $table) {
                $table->dropForeignIfExists('harvests_seller_id_foreign');
            });
        } catch (\Exception $e) {
            // FK lama tidak ada, tidak perlu di-drop
        }

        // Pastikan FK sudah menunjuk ke seller_profiles
        $hasFk = collect(\DB::select("
            SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'harvests'
              AND COLUMN_NAME = 'seller_id'
              AND REFERENCED_TABLE_NAME = 'seller_profiles'
        "))->isNotEmpty();

        if (! $hasFk) {
            Schema::table('harvests', function (Blueprint $table) {
                $table->foreign('seller_id')
                      ->references('id')
                      ->on('seller_profiles')
                      ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        // No-op: create_harvests_table sudah di-rollback lebih dulu
    }
};
