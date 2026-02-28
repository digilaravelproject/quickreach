<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('qr_registrations', function (Blueprint $table) {
            // Dynamic fields ke liye JSON column
            $table->json('category_data')->nullable()->after('selected_tags');
            // Emergency SOS note ke liye
            $table->text('emergency_note')->nullable()->after('category_data');
            // Pets wagerah ki photo ke liye
            $table->string('photo_path')->nullable()->after('emergency_note');
        });
    }

    public function down(): void
    {
        Schema::table('qr_registrations', function (Blueprint $table) {
            $table->dropColumn(['category_data', 'emergency_note', 'photo_path']);
        });
    }
};
