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
        // Rename pemesan_id to pelanggan_id in pemesanans table
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->renameColumn('pemesan_id', 'pelanggan_id');
        });

        // Rename pemesan_id to pelanggan_id in transaksis table
        Schema::table('transaksis', function (Blueprint $table) {
            $table->renameColumn('pemesan_id', 'pelanggan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rename pelanggan_id back to pemesan_id in transaksis table
        Schema::table('transaksis', function (Blueprint $table) {
            $table->renameColumn('pelanggan_id', 'pemesan_id');
        });

        // Rename pelanggan_id back to pemesan_id in pemesanans table
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->renameColumn('pelanggan_id', 'pemesan_id');
        });
    }
}; 