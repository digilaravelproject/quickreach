<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_code_id')->constrained()->onDelete('cascade');
            $table->string('scanner_ip')->nullable();
            $table->text('scanner_user_agent')->nullable();
            $table->string('scanner_location')->nullable();
            $table->enum('action_taken', ['view', 'call', 'whatsapp', 'emergency'])->nullable();
            $table->timestamps();

            $table->index('qr_code_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_scans');
    }
};
