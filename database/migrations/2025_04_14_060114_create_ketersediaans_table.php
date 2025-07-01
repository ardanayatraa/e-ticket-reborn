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
        Schema::create('ketersediaans', function (Blueprint $table) {
            $table->id('terpesan_id');
            $table->unsignedBigInteger('pemesanan_id');
            $table->unsignedBigInteger('mobil_id');
            $table->unsignedBigInteger('sopir_id');
            $table->date('tanggal_keberangkatan');
            $table->string('status_ketersediaan', 20);
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ketersediaans');
    }
};
