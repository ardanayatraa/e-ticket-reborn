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
        Schema::create('sopirs', function (Blueprint $table) {
            $table->id('sopir_id');
            $table->string('nama_sopir', 200);
            $table->string('nomor_ktp', 30);
            $table->string('sim', 50);
            $table->string('foto')->nullable();
            $table->integer('umur');
            $table->text('alamat');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sopirs');
    }
};
