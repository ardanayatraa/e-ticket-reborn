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
        // Remove terpesan_id from includes table
        Schema::table('includes', function (Blueprint $table) {
            if (Schema::hasColumn('includes', 'terpesan_id')) {
                // Drop foreign key constraint first
                $table->dropForeign(['terpesan_id']);
                $table->dropColumn('terpesan_id');
            }
        });

        // Remove terpesan_id from excludes table
        Schema::table('excludes', function (Blueprint $table) {
            if (Schema::hasColumn('excludes', 'terpesan_id')) {
                // Drop foreign key constraint first
                $table->dropForeign(['terpesan_id']);
                $table->dropColumn('terpesan_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add back terpesan_id to includes table
        Schema::table('includes', function (Blueprint $table) {
            if (!Schema::hasColumn('includes', 'terpesan_id')) {
                $table->unsignedBigInteger('terpesan_id')->after('include_id');
                $table->foreign('terpesan_id')->references('terpesan_id')->on('ketersediaans')->onDelete('cascade');
            }
        });

        // Add back terpesan_id to excludes table
        Schema::table('excludes', function (Blueprint $table) {
            if (!Schema::hasColumn('excludes', 'terpesan_id')) {
                $table->unsignedBigInteger('terpesan_id')->after('exclude_id');
                $table->foreign('terpesan_id')->references('terpesan_id')->on('ketersediaans')->onDelete('cascade');
            }
        });
    }
};
