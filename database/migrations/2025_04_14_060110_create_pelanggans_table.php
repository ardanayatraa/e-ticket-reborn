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
        Schema::create('pelanggans', function (Blueprint $table) {
            $table->id('pelanggan_id');
            $table->string('nama_pemesan', 255);
            $table->text('alamat');
            $table->string('email', 255)->unique();
            $table->string('nomor_whatsapp', 50);
            // Kolom untuk menyimpan password (hashed)
            $table->string('password');
            // Token untuk `remember me`
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
