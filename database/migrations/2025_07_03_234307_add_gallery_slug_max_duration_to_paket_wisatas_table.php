<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paket_wisatas', function (Blueprint $table) {
            $table->json('gallery')->nullable(); // untuk menyimpan multiple foto
            $table->string('slug')->unique()->nullable();
            $table->integer('max_duration')->default(9); // maksimal 9 jam
        });
    }

    public function down()
    {
        Schema::table('paket_wisatas', function (Blueprint $table) {
            $table->dropColumn(['gallery', 'slug', 'max_duration']);
        });
    }
};
