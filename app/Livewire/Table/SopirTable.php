<?php

namespace App\Livewire\Table;

use App\Models\Sopir;
use App\Models\Ketersediaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class SopirTable extends DataTableComponent
{
    protected $model = Sopir::class;

    public function configure(): void
    {
        $this->setPrimaryKey('sopir_id');
    }

    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        return Sopir::query();
    }

    public function columns(): array
    {
        return [
            Column::make('ID','sopir_id')->sortable(),
            Column::make('Nama','nama_sopir')->sortable(),
            Column::make('No. KTP','nomor_ktp')->sortable(),
            Column::make('SIM','sim')->sortable(),
            Column::make('Foto','foto')
                ->format(fn($v,$r)=>
                    '<img src="'.Storage::url($v).'" class="w-20 h-20 object-cover rounded-md"/>'
                )->html(),
            Column::make('Umur','umur')->sortable(),
            Column::make('Alamat','alamat')->sortable(),

            Column::make('Actions')
                ->label(fn($r)=> view('components.sopir-table-action', [
                    'rowId' => $r->sopir_id,
                ])->render())
                ->html(),
        ];
    }

    /**
     * Langsung dipanggil oleh wire:click
     */
    public function downloadTicket(int $sopirId, string $tanggal)
    {
        $k = Ketersediaan::with([
                'transaksi',
                'pemesanan.pelanggan',
                'pemesanan.mobil.sopir'
            ])
            ->where('sopir_id', $sopirId)
            ->where('tanggal_keberangkatan', $tanggal)
            ->firstOrFail();
        $pdf = Pdf::loadView('pdf.ticket-on-sopir', ['ketersediaan'=>$k]);

        return response()->streamDownload(
            fn()=>print($pdf->output()),
            "tiket-{$k->terpesan_id}-{$tanggal}.pdf"
        );
    }
}
