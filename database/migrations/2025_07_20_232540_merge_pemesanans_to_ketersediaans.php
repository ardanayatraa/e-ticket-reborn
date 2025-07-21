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
        // Step 1: Add missing columns to ketersediaans table (if not exists)
        if (!Schema::hasColumn('ketersediaans', 'pelanggan_id')) {
            Schema::table('ketersediaans', function (Blueprint $table) {
                $table->unsignedBigInteger('pelanggan_id')->after('terpesan_id');
                $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('ketersediaans', 'paketwisata_id')) {
            Schema::table('ketersediaans', function (Blueprint $table) {
                $table->unsignedBigInteger('paketwisata_id')->after('pelanggan_id');
                $table->foreign('paketwisata_id')->references('paketwisata_id')->on('paket_wisatas')->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('ketersediaans', 'jam_mulai')) {
            Schema::table('ketersediaans', function (Blueprint $table) {
                $table->time('jam_mulai')->after('paketwisata_id');
            });
        }

        // Step 2: Copy data from pemesanans to ketersediaans
        DB::statement("
            UPDATE ketersediaans k
            INNER JOIN pemesanans p ON k.pemesanan_id = p.pemesanan_id
            SET k.pelanggan_id = p.pemesan_id,
                k.paketwisata_id = p.paketwisata_id,
                k.jam_mulai = p.jam_mulai
        ");

        // Step 3: Update foreign key references in other tables
        // Update transaksis table to reference ketersediaans instead of pemesanans
        Schema::table('transaksis', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'transaksis' 
                AND COLUMN_NAME = 'pemesanan_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['pemesanan_id']);
            }
            
            $table->renameColumn('pemesanan_id', 'terpesan_id');
            $table->foreign('terpesan_id')->references('terpesan_id')->on('ketersediaans')->onDelete('cascade');
        });

        // Step 4: Remove pemesanan_id column from ketersediaans (no longer needed)
        Schema::table('ketersediaans', function (Blueprint $table) {
            // Check if foreign key exists before dropping
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_SCHEMA = DATABASE() 
                AND TABLE_NAME = 'ketersediaans' 
                AND COLUMN_NAME = 'pemesanan_id' 
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['pemesanan_id']);
            }
            
            $table->dropColumn('pemesanan_id');
        });

        // Step 5: Drop pemesanans table
        Schema::dropIfExists('pemesanans');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate pemesanans table
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('pemesanan_id');
            $table->unsignedBigInteger('pelanggan_id');
            $table->unsignedBigInteger('paketwisata_id');
            $table->unsignedBigInteger('mobil_id');
            $table->time('jam_mulai');
            $table->date('tanggal_keberangkatan');
            $table->timestamps();
            
            $table->foreign('pelanggan_id')->references('pelanggan_id')->on('pelanggans')->onDelete('cascade');
            $table->foreign('paketwisata_id')->references('paketwisata_id')->on('paket_wisatas')->onDelete('cascade');
            $table->foreign('mobil_id')->references('mobil_id')->on('mobils')->onDelete('cascade');
        });

        // Add pemesanan_id back to ketersediaans
        Schema::table('ketersediaans', function (Blueprint $table) {
            $table->unsignedBigInteger('pemesanan_id')->after('terpesan_id');
            $table->foreign('pemesanan_id')->references('pemesanan_id')->on('pemesanans')->onDelete('cascade');
        });

        // Revert foreign key changes in other tables
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['terpesan_id']);
            $table->renameColumn('terpesan_id', 'pemesanan_id');
            $table->foreign('pemesanan_id')->references('pemesanan_id')->on('pemesanans')->onDelete('cascade');
        });

        // Remove added columns from ketersediaans
        Schema::table('ketersediaans', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropForeign(['paketwisata_id']);
            $table->dropColumn(['pelanggan_id', 'paketwisata_id', 'jam_mulai']);
        });
    }
};
