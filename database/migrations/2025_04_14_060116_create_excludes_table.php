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
            $table->boolean('bensin')->default(false);
            $table->boolean('parkir')->default(false);
            $table->boolean('sopir')->default(false);
            $table->boolean('makan_siang')->default(false);
            $table->boolean('makan_malam')->default(false);
            $table->boolean('tiket_masuk')->default(false);
            $table->boolean('status_ketersediaan')->default(true);
            $table->timestamps();
            
            $table->foreign('paketwisata_id')->references('paketwisata_id')->on('paket_wisatas')->onDelete('cascade');
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
