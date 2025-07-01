<?php

namespace App\Livewire\Table;

use App\Models\Ketersediaan;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;

class KetersediaanTable extends DataTableComponent
{
    protected $model = Ketersediaan::class;

    public function configure(): void
    {
        $this->setPrimaryKey('terpesan_id');
    }

    public function builder(): Builder
    {
        return Ketersediaan::with(['pemesanan.pelanggan', 'mobil', 'sopir']);
    }

    public function columns(): array
    {
        return [
            Column::make("Terpesan ID", "terpesan_id")->sortable(),

            Column::make("Pemesan", "pemesanan_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->pemesanan->pelanggan)->nama_pemesan ?? '-'),

            Column::make("Mobil", "mobil_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->mobil)->nama_kendaraan ?? '-'),

            Column::make("Sopir", "sopir_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->sopir)->nama_sopir ?? '-'),

            Column::make("Tanggal Keberangkatan", "tanggal_keberangkatan")->sortable(),
            // Column::make("Status Ketersediaan", "status_ketersediaan")->sortable(),
            Column::make("Created At", "created_at")->sortable(),
            Column::make("Updated At", "updated_at")->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'      => $row->terpesan_id,
                    'deleteUrl'  => route('ketersediaan.destroy', $row->terpesan_id),
                    'downloadId' => $row->terpesan_id,
                ]))
                ->html(),
        ];
    }

    public function downloadTicket($id)
    {
        $ketersediaan = Ketersediaan::with(['transaksi', 'include', 'exclude'])->find($id);
        $pdf = Pdf::loadView('pdf.ticket-on-admin', ['ketersediaan' => $ketersediaan]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'tiket-' . $ketersediaan->terpesan_id . '.pdf');
    }
}
