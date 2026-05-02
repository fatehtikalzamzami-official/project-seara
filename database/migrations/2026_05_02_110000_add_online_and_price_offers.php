<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambah kolom online status ke users
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_seen_at')->nullable()->after('last_login_at');
        });

        // Tabel tawaran harga
        Schema::create('price_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('harvest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('seller_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('chat_room_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('original_price', 10, 2);   // harga asli saat tawar
            $table->decimal('offer_price', 10, 2);       // harga yang ditawar buyer
            $table->decimal('counter_price', 10, 2)->nullable(); // balik tawar seller
            $table->integer('quantity')->default(1);

            // pending | accepted | rejected | countered | cancelled
            $table->enum('status', ['pending','accepted','rejected','countered','cancelled'])
                  ->default('pending');

            $table->text('buyer_note')->nullable();
            $table->text('seller_note')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['harvest_id', 'status']);
            $table->index(['buyer_id', 'status']);
            $table->index(['seller_user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_offers');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_seen_at');
        });
    }
};
