<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fraud_detections', function (Blueprint $table) {
            $table->id();
            $table->string('from_number')->nullable();
            $table->string('to_number')->nullable();
            $table->unsignedBigInteger('qr_code_id')->nullable();
            $table->unsignedBigInteger('type')->nullable();
            $table->timestamp('call_started_at')->nullable();
            $table->timestamp('call_ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fraud_detections');
    }
};