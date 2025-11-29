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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('sku')->unique(); // Stock Keeping Unit
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->text('description')->nullable();

        // Harga & Stok
        $table->decimal('buy_price', 15, 2); // Harga beli
        $table->decimal('sell_price', 15, 2); // Harga jual
        $table->integer('min_stock')->default(10); // Alert limit
        $table->integer('current_stock')->default(0);
        $table->string('unit')->default('pcs'); // pcs, kg, box

        // Lokasi & Gambar
        $table->string('rack_location')->nullable();
        $table->string('image')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
