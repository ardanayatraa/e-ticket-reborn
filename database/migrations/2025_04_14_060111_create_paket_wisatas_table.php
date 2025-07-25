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
        Schema::create('paket_wisatas', function (Blueprint $table) {
            $table->id('paketwisata_id');
            $table->string('judul', 255);
            $table->string('foto', 255)->nullable();
            $table->string('deskripsi', 255);
            $table->string('tempat', 255);
            $table->string('durasi', 100);
            $table->decimal('harga', 15, 2);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_wisatas');
    }
};
