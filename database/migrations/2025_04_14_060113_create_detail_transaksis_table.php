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
        Schema::create('detail_transaksis', function (Blueprint $table) {
            $table->id('detail_transaksi_id');
            $table->unsignedBigInteger('transaksi_id');
            $table->decimal('total_transaksi', 15, 2)->nullable();
            $table->decimal('total_owe_to_me', 15, 2)->nullable();
            $table->decimal('total_pay_to_provider', 15, 2)->nullable();
            $table->decimal('total_profit', 15, 2)->nullable();
            $table->timestamps();
            $table->foreign('transaksi_id')->references('transaksi_id')->on('transaksis');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
