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
    Schema::create('restock_orders', function (Blueprint $table) {
        $table->id();
        $table->string('po_number')->unique(); // PO-20231001-001

        $table->foreignId('user_id')->constrained('users'); // Manager yg buat
        $table->foreignId('supplier_id')->constrained('users'); // Supplier tujuan

        $table->date('expected_delivery_date')->nullable();

        // Status flow restock
        $table->enum('status', ['pending', 'confirmed', 'rejected', 'in_transit', 'received'])->default('pending');

        $table->text('notes')->nullable();
        $table->integer('rating')->nullable(); // Rating dari manager ke supplier
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restock_orders');
    }
};
