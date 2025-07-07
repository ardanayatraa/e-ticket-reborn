<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Mengecek apakah kolom sudah ada sebelum menambahkannya
        if (!Schema::hasColumn('pelanggans', 'is_member')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->boolean('is_member')->default(false);
            });
        }

        if (!Schema::hasColumn('pelanggans', 'points')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->integer('points')->default(0);
            });
        }

        if (!Schema::hasColumn('pelanggans', 'member_since')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->timestamp('member_since')->nullable();
            });
        }

        if (!Schema::hasColumn('pelanggans', 'password')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->string('password')->nullable(); // untuk login pelanggan
            });
        }

        if (!Schema::hasColumn('pelanggans', 'email_verified_at')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable();
            });
        }

        if (!Schema::hasColumn('pelanggans', 'remember_token')) {
            Schema::table('pelanggans', function (Blueprint $table) {
                $table->rememberToken();
            });
        }
    }

    public function down()
    {
        Schema::table('pelanggans', function (Blueprint $table) {
            // Hanya drop kolom jika ada
            if (Schema::hasColumn('pelanggans', 'is_member')) {
                $table->dropColumn('is_member');
            }

            if (Schema::hasColumn('pelanggans', 'points')) {
                $table->dropColumn('points');
            }

            if (Schema::hasColumn('pelanggans', 'member_since')) {
                $table->dropColumn('member_since');
            }

            if (Schema::hasColumn('pelanggans', 'password')) {
                $table->dropColumn('password');
            }

            if (Schema::hasColumn('pelanggans', 'email_verified_at')) {
                $table->dropColumn('email_verified_at');
            }

            if (Schema::hasColumn('pelanggans', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
