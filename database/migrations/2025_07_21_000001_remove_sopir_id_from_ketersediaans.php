<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Remove sopir_id from ketersediaans table
        if (Schema::hasColumn('ketersediaans', 'sopir_id')) {
            // Try to drop foreign key if it exists
            try {
                DB::statement('ALTER TABLE ketersediaans DROP FOREIGN KEY ketersediaans_sopir_id_foreign');
            } catch (\Exception $e) {
                // Try alternative foreign key names
                try {
                    DB::statement('ALTER TABLE ketersediaans DROP FOREIGN KEY ketersediaans_sopir_id_sopirs_sopir_id_foreign');
                } catch (\Exception $e2) {
                    // Foreign key doesn't exist, continue
                }
            }
            
            // Drop the column
            Schema::table('ketersediaans', function (Blueprint $table) {
                $table->dropColumn('sopir_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add sopir_id back to ketersediaans table if it doesn't exist
        if (!Schema::hasColumn('ketersediaans', 'sopir_id')) {
            Schema::table('ketersediaans', function (Blueprint $table) {
                $table->unsignedBigInteger('sopir_id')->after('mobil_id');
                $table->foreign('sopir_id')->references('sopir_id')->on('sopirs');
            });
        }
    }
}; 