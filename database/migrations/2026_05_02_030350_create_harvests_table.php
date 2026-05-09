<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('harvests', function (Blueprint $table) {
            $table->id();

            // FK ke seller_profiles (bukan sellers) karena approval hanya mengisi seller_profiles
            $table->unsignedBigInteger('seller_id');
            $table->foreign('seller_id')
                  ->references('id')
                  ->on('seller_profiles')
                  ->cascadeOnDelete();

            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('harvest_date');
            $table->integer('remaining_stock');
            $table->decimal('price_per_unit', 10, 2);
            $table->boolean('is_organic')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};
