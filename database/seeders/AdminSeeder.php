<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 1) Super‐Admin
        Admin::create([
            'nama_admin' => 'Admin',
            'email'      => 'admin@gmail.com',
            'password'   => Hash::make('12345678'),
            'type'       => 'admin',
        ]);

        // 2) Owner
        Admin::create([
            'nama_admin' => 'Owner',
            'email'      => 'owner@gmail.com',
            'password'   => Hash::make('12345678'),
            'type'       => 'owner',
        ]);
    }
}
