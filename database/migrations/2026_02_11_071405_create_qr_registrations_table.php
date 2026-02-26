<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qr_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qr_code_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('full_name');
            $table->string('mobile_number');
            $table->string('friend_family_1')->nullable();
            $table->string('friend_family_2')->nullable();
            $table->text('full_address')->nullable();
            $table->json('selected_tags')->nullable(); // ['car', 'bike', 'pet', 'children', 'bag']
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('mobile_number');
            $table->index('qr_code_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_registrations');
    }
};
