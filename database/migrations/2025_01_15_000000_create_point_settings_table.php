<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
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

    public function down()
    {
        Schema::dropIfExists('point_settings');
    }
}; 