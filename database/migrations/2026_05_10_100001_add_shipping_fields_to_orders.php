<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Informasi pengiriman (diisi seller saat status → shipped)
            $table->string('kurir')->nullable()->after('cancel_reason');
            $table->string('nomor_resi')->nullable()->after('kurir');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['kurir', 'nomor_resi']);
        });
    }
};
