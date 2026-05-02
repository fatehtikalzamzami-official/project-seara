<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // SEARA-2026XXXX-YYYY

            $table->foreignId('buyer_id')->constrained('users')->cascadeOnDelete();

            // Alamat pengiriman (snapshot saat checkout)
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('shipping_address');
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code', 10)->nullable();

            // Harga
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 12, 2)->default(0);

            // Status
            // pending_payment | paid | processing | shipped | delivered | cancelled | refunded
            $table->enum('status', [
                'pending_payment', 'paid', 'processing',
                'shipped', 'delivered', 'cancelled', 'refunded'
            ])->default('pending_payment');

            $table->string('payment_method')->nullable();  // transfer, cod, e-wallet
            $table->string('payment_proof')->nullable();   // path foto bukti transfer
            $table->timestamp('paid_at')->nullable();

            $table->text('buyer_notes')->nullable();
            $table->text('cancel_reason')->nullable();

            $table->timestamps();

            $table->index(['buyer_id', 'status']);
            $table->index('order_number');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('harvest_id')->constrained()->cascadeOnDelete();

            // Snapshot data produk (tidak berubah meski stok/harga berubah)
            $table->string('product_name');
            $table->string('product_unit');
            $table->string('seller_name');
            $table->foreignId('seller_user_id')->constrained('users');

            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2);   // harga final (bisa harga tawar)
            $table->decimal('subtotal', 12, 2);

            // Link ke offer jika dari harga tawar
            $table->foreignId('price_offer_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_offer_price')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
