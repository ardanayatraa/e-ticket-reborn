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
        Schema::create('excludes', function (Blueprint $table) {
            $table->id('exclude_id');
            $table->unsignedBigInteger('paketwisata_id');
            $table->string('bensin', 225);
            $table->string('parkir', 225);
            $table->string('sopir', 225);
            $table->string('makan_siang', 225);
            $table->string('makan_malam', 225);
            $table->string('tiket_masuk', 225);
            $table->boolean('status_ketersediaan');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excludes');
    }
};
