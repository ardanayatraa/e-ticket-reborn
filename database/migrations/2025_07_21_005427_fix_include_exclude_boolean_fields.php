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
        // Fix includes table
        Schema::table('includes', function (Blueprint $table) {
            // Drop existing string columns
            $table->dropColumn(['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk']);
        });

        Schema::table('includes', function (Blueprint $table) {
            // Add boolean columns
            $table->boolean('bensin')->default(false);
            $table->boolean('parkir')->default(false);
            $table->boolean('sopir')->default(false);
            $table->boolean('makan_siang')->default(false);
            $table->boolean('makan_malam')->default(false);
            $table->boolean('tiket_masuk')->default(false);
        });

        // Fix excludes table
        Schema::table('excludes', function (Blueprint $table) {
            // Drop existing string columns
            $table->dropColumn(['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk']);
        });

        Schema::table('excludes', function (Blueprint $table) {
            // Add boolean columns
            $table->boolean('bensin')->default(false);
            $table->boolean('parkir')->default(false);
            $table->boolean('sopir')->default(false);
            $table->boolean('makan_siang')->default(false);
            $table->boolean('makan_malam')->default(false);
            $table->boolean('tiket_masuk')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert includes table
        Schema::table('includes', function (Blueprint $table) {
            $table->dropColumn(['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk']);
        });

        Schema::table('includes', function (Blueprint $table) {
            $table->string('bensin', 225);
            $table->string('parkir', 225);
            $table->string('sopir', 225);
            $table->string('makan_siang', 225);
            $table->string('makan_malam', 225);
            $table->string('tiket_masuk', 225);
        });

        // Revert excludes table
        Schema::table('excludes', function (Blueprint $table) {
            $table->dropColumn(['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk']);
        });

        Schema::table('excludes', function (Blueprint $table) {
            $table->string('bensin', 225);
            $table->string('parkir', 225);
            $table->string('sopir', 225);
            $table->string('makan_siang', 225);
            $table->string('makan_malam', 225);
            $table->string('tiket_masuk', 225);
        });
    }
};
