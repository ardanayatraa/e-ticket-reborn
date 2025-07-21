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
            // Check if foreign key exists before dropping
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'transaksis' 
                AND COLUMN_NAME = 'pemesan_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['pemesan_id']);
            }
            
            $table->renameColumn('pemesan_id', 'pelanggan_id');
            
            // Add foreign key constraint
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['pelanggan_id']);
            
            // Rename back
            $table->renameColumn('pelanggan_id', 'pemesan_id');
            
            // Add back original foreign key if needed
            $table->foreign('pemesan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
        });
    }
}; 