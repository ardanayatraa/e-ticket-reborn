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
        // Drop the old point_settings table if it exists
        Schema::dropIfExists('point_settings');

        // Create the new point_settings table with the correct structure
        Schema::create('point_settings', function (Blueprint $table) {
            $table->id('point_id');
            $table->string('nama_season_point');
            $table->integer('minimum_transaksi');
            $table->integer('jumlah_point_diperoleh');
            $table->integer('harga_satuan_point');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Insert default values
        DB::table('point_settings')->insert([
            [
                'nama_season_point' => 'Low Season',
                'minimum_transaksi' => 500000,
                'jumlah_point_diperoleh' => 5,
                'harga_satuan_point' => 10000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_season_point' => 'High Season',
                'minimum_transaksi' => 1000000,
                'jumlah_point_diperoleh' => 10,
                'harga_satuan_point' => 15000,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new point_settings table
        Schema::dropIfExists('point_settings');

        // Recreate the old point_settings table structure
        Schema::create('point_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // Insert old default values
        DB::table('point_settings')->insert([
            [
                'key' => 'points_per_transaction',
                'value' => '500000',
                'description' => 'Jumlah rupiah untuk mendapatkan poin (setiap Rp X = 5 poin)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'points_earned_per_transaction',
                'value' => '5',
                'description' => 'Jumlah poin yang didapat per transaksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'points_for_discount',
                'value' => '10',
                'description' => 'Jumlah poin untuk mendapatkan diskon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'discount_per_points',
                'value' => '10000',
                'description' => 'Jumlah diskon rupiah per poin (10 poin = Rp X)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
};
