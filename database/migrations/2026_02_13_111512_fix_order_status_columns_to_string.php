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
        Schema::table('orders', function (Blueprint $table) {
            // Change columns from ENUM to STRING so they accept 'confirmed', 'completed', etc.
            // valid for MySQL/MariaDB
            $table->string('status', 191)->change();
            $table->string('payment_status', 191)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Revert logic if needed
    }
};
