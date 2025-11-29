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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('transaction_number')->unique(); // TRX-20231001-001

        // Siapa yang input (Staff)
        $table->foreignId('user_id')->constrained('users');

        // Jika barang masuk, perlu data supplier (dari users table)
        $table->foreignId('supplier_id')->nullable()->constrained('users');

        // Jika barang keluar, perlu nama customer (manual input)
        $table->string('customer_name')->nullable();

        $table->enum('type', ['in', 'out']); // Masuk / Keluar
        $table->date('date');

        // Status approval manager
        // Pending: Baru dibuat staff
        // Verified: Diverifikasi (utk barang masuk)
        // Approved: Disetujui (utk barang keluar)
        // Shipped/Completed: Selesai
        $table->string('status')->default('pending');

        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
