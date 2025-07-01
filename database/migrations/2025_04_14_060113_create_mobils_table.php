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
        Schema::create('mobils', function (Blueprint $table) {
            $table->id('mobil_id');
            $table->unsignedBigInteger('sopir_id');
            $table->string('nama_kendaraan', 255);
            $table->string('nomor_kendaraan', 20);
            $table->integer('jumlah_tempat_duduk');
            $table->string('status_ketersediaan', 200);
            $table->string('foto', 200);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};
