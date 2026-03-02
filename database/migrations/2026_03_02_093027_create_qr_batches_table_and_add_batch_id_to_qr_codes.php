<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Create Batches Table
        Schema::create('qr_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->timestamps();
        });

        // 2. Add Batch ID to QR Codes
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->foreignId('qr_batch_id')->nullable()->after('category_id')->constrained('qr_batches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('qr_batch_id');
        });
        Schema::dropIfExists('qr_batches');
    }
};
