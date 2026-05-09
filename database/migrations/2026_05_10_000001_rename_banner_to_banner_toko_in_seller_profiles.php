<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Rename kolom 'banner' → 'banner_toko' agar konsisten dengan
     * controller (SellerProfileController) dan view (profile-edit.blade.php).
     */
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            // Hanya rename jika kolom 'banner' masih ada (belum di-rename)
            if (Schema::hasColumn('seller_profiles', 'banner')) {
                $table->renameColumn('banner', 'banner_toko');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('seller_profiles', 'banner_toko')) {
                $table->renameColumn('banner_toko', 'banner');
            }
        });
    }
};
