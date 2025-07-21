<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ketersediaan;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class PemesananTable extends DataTableComponent
{
    protected $model = Ketersediaan::class;

    public function configure(): void
    {
        $this->setPrimaryKey('terpesan_id');
    }

    public function builder() :Builder
    {
        $today = Carbon::today()->format('Y-m-d');

        return Ketersediaan::with(['pelanggan', 'paketWisata', 'mobil'])
            ->orderByRaw("CASE
                WHEN tanggal_keberangkatan = ? THEN 0
                WHEN tanggal_keberangkatan > ? THEN 1
                ELSE 2
            END", [$today, $today])
            ->orderBy('tanggal_keberangkatan', 'asc') // setelah CASE, urutkan tanggal naik
            ->orderBy('jam_mulai', 'asc'); // urutkan jam naik
    }

    public function columns(): array
    {
        return [
            Column::make("Ketersediaan ID", "terpesan_id")->sortable(),

            Column::make("Pelanggan", "pelanggan_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->pelanggan)->nama_pemesan ?? '-'),

            Column::make("Paket Wisata", "paketwisata_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->paketWisata)->judul ?? '-'),

            Column::make("Mobil", "mobil_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->mobil)->nama_kendaraan ?? '-'),

            Column::make("Jam Mulai", "jam_mulai")->sortable(),

            Column::make("Status", "status_ketersediaan")
                ->sortable()
                ->format(fn($v, $row) => ucfirst($row->status_ketersediaan)),

            Column::make("Tanggal Keberangkatan", "tanggal_keberangkatan")
                ->sortable()
                ->format(function($v, $row) {
                    $tanggal = Carbon::parse($row->tanggal_keberangkatan)->format('Y-m-d');
                    $today = Carbon::today()->format('Y-m-d');

                    if ($tanggal === $today) {
                        return '
                            <span class="animate-pulse px-2 py-1 rounded text-white bg-green-500 text-sm">
                                Today ('.date('d M Y', strtotime($row->tanggal_keberangkatan)).')
                            </span>
                        ';
                    } else {
                        return '
                            <span class="px-2 py-1 rounded bg-gray-200 text-gray-800 text-sm">
                                '.date('d M Y', strtotime($row->tanggal_keberangkatan)).'
                            </span>
                        ';
                    }
                })
                ->html(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'     => $row->terpesan_id,
                    'editUrl'   => route('pemesanan.edit', $row->terpesan_id),
                    'deleteUrl' => route('pemesanan.destroy', $row->terpesan_id),
                ])->render())
                ->html(),
        ];
    }
}
