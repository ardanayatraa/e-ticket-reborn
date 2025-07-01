<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaketWisata;
use Illuminate\Support\Carbon;

class PaketWisataSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $pakets = [
            [
                'judul'      => 'Ubud surrounding',
                'tempat'     => 'Elephant cave temple, Tegalalang rice terrace, Tirta empul temple, Gunung kawi temple, Tegenungan waterfall.',
                'durasi'     => 1,
                'harga'      => 700000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Bedugul & waterfall',
                'tempat'     => 'Banyumala waterfall, Handara gate, Ulundanu bratan temple, Jatiluwih rice terrace.',
                'durasi'     => 1,
                'harga'      => 900000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Bedugul & Tanah Lot sunset',
                'tempat'     => 'Ulundanu bratan temple, Jatiluwih rice terrace, Tanah lot temple.',
                'durasi'     => 1,
                'harga'      => 900000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Uluwatu tour',
                'tempat'     => 'Garuda Wisnu Kencana statue, Padang-padang beach, Uluwatu temple.',
                'durasi'     => 1,
                'harga'      => 900000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Lempuyang tour',
                'tempat'     => 'Lempuyang temple, Tirta Gangga water palace, Taman Ujung water palace.',
                'durasi'     => 1,
                'harga'      => 950000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Besakih & waterfall tour',
                'tempat'     => 'Tukad Cepung waterfall, Kehen temple, Penglipuran village, Besakih temple.',
                'durasi'     => 1,
                'harga'      => 900000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Kintamani view tour',
                'tempat'     => 'Gunung kawi temple, Tirta empul temple, Tegalalang rice terrace, Kintamani view.',
                'durasi'     => 1,
                'harga'      => 800000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Art tour',
                'tempat'     => 'Mas village (wood carving), Celuk village (silver making), Sukawati art market.',
                'durasi'     => 1,
                'harga'      => 700000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'judul'      => 'Spiritual tour',
                'tempat'     => 'Beji Griya waterfall (purification ritual), Jatiluwih rice terrace, Tanah lot temple.',
                'durasi'     => 1,
                'harga'      => 850000,
                'foto'       => '',
                'deskripsi'  => '',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        PaketWisata::insert($pakets);
    }
}
