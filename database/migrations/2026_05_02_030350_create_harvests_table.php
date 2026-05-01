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

        $table->foreignId('seller_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('product_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->dateTime('harvest_date');
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
