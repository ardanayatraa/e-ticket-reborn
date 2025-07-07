<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('member_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2)->default(25000); // 25k untuk member
            $table->string('payment_status')->default('pending');
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamps();

            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('member_payments');
    }
};
