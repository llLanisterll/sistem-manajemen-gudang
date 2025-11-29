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
        Schema::table('users', function (Blueprint $table) {
        // Role: admin, manager, staff, supplier
        $table->enum('role', ['admin', 'manager', 'staff', 'supplier'])->default('staff')->after('email');

        // Data tambahan khusus untuk Supplier
        $table->string('phone')->nullable()->after('role')  ;
        $table->text('address')->nullable()->after('phone');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
