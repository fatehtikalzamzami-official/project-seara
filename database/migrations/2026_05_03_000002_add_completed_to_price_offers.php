<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_offers', function (Blueprint $table) {
            // Ubah enum untuk tambah status 'completed'
            \DB::statement("ALTER TABLE price_offers MODIFY COLUMN status ENUM('pending','accepted','rejected','countered','cancelled','completed') NOT NULL DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE price_offers MODIFY COLUMN status ENUM('pending','accepted','rejected','countered','cancelled') NOT NULL DEFAULT 'pending'");
    }
};
