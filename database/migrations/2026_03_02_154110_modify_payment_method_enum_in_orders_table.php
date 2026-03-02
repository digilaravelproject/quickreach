<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("
            ALTER TABLE orders 
            CHANGE payment_method payment_method 
            ENUM('online','cod','offline') 
            CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci 
            NOT NULL DEFAULT 'online'
        ");
    }

    public function down()
    {
        DB::statement("
            ALTER TABLE orders 
            CHANGE payment_method payment_method 
            ENUM('online','cod') 
            CHARACTER SET utf8mb4 
            COLLATE utf8mb4_unicode_ci 
            NOT NULL DEFAULT 'online'
        ");
    }
};
