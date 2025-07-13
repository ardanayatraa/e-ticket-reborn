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
        Schema::table('transaksis', function (Blueprint $table) {
            // Check if columns exist before dropping them
            if (Schema::hasColumn('transaksis', 'total_owe_to_me')) {
                $table->dropColumn('total_owe_to_me');
            }
            if (Schema::hasColumn('transaksis', 'total_pay_to_provider')) {
                $table->dropColumn('total_pay_to_provider');
            }
            if (Schema::hasColumn('transaksis', 'total_profit')) {
                $table->dropColumn('total_profit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->decimal('total_owe_to_me', 15, 2)->nullable();
            $table->decimal('total_pay_to_provider', 15, 2)->nullable();
            $table->decimal('total_profit', 15, 2)->nullable();
        });
    }
}; 