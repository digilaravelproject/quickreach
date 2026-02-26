<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            // Section 1: Main Header (Inspiration from Image top)
            $table->string('main_title')->nullable();
            $table->text('main_description')->nullable();
            $table->string('main_image')->nullable();

            // Section 2: Mission (Inspiration from Image middle)
            $table->string('mission_title')->nullable();
            $table->text('mission_description')->nullable();
            $table->string('mission_image')->nullable();

            // Section 3: Story (Inspiration from Image bottom)
            $table->text('story_description')->nullable();
            $table->string('story_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
