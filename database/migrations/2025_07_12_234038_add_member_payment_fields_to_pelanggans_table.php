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
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->string('order_id')->unique()->nullable();
            $table->decimal('amount', 10, 2)->default(25000)->nullable();
            $table->string('payment_status')->default('pending')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('midtrans_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'amount',
                'payment_status',
                'payment_type',
                'transaction_id',
                'midtrans_response',
            ]);
        });
    }
};
