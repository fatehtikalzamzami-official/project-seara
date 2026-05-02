<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus duplicate rooms — pertahankan yang paling lama (id terkecil)
        //    per pasangan buyer_id + seller_id
        DB::statement('
            DELETE cr FROM chat_rooms cr
            INNER JOIN chat_rooms cr2
                ON cr.buyer_id  = cr2.buyer_id
               AND cr.seller_id = cr2.seller_id
               AND cr.id > cr2.id
        ');

        // 2. Update chat_messages yang orphan (roomnya sudah dihapus) — amankan
        //    (cascade harusnya handle ini, tapi eksplisit lebih aman)

        Schema::table('chat_rooms', function (Blueprint $table) {
    // 1. DROP FOREIGN KEY DULU
    $table->dropForeign(['buyer_id']);
    $table->dropForeign(['seller_id']);
    $table->dropForeign(['harvest_id']);

    // 2. DROP INDEX
    $table->dropUnique('chat_rooms_buyer_id_seller_id_harvest_id_unique');

    // 3. (OPSIONAL) BUAT ULANG SESUAI KEBUTUHAN
    $table->unique(['buyer_id', 'seller_id']); // contoh baru
});
    }

    public function down(): void
    {
        Schema::table('chat_rooms', function (Blueprint $table) {
            $table->dropUnique(['buyer_id', 'seller_id']);
            $table->unique(['buyer_id', 'seller_id', 'harvest_id']);
        });
    }
};
