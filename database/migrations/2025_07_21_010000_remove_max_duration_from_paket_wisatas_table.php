<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('paket_wisatas', function (Blueprint $table) {
            if (Schema::hasColumn('paket_wisatas', 'max_duration')) {
                $table->dropColumn('max_duration');
            }
        });
    }

    public function down()
    {
        Schema::table('paket_wisatas', function (Blueprint $table) {
            $table->integer('max_duration')->default(9);
        });
    }
}; 