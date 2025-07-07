<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('order_id')->nullable()->unique();
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'payment_type', 'transaction_id', 'additional_charge', 'note']);
        });
    }
};
