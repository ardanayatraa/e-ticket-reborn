<?php

namespace App\Livewire\Table;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class TransaksiTable extends DataTableComponent
{
    protected $model = Transaksi::class;

    protected $listeners = [
        'refreshTable' => '$refresh',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('transaksi_id');
    }

    public function builder(): Builder
    {
        return Transaksi::with(['paketWisata', 'pelanggan', 'pemesanan.mobil'])
            ->orderBy('created_at', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make('Actions')
                ->label(fn($row) => view('components.transaksi-action', [
                    'rowId'            => $row->transaksi_id,
                    'confirmUrl'       => route('transaksi.confirm', $row->transaksi_id),
                    'status'           => $row->transaksi_status,
                    'hargaPaket'       => optional($row->paketWisata)->harga ?? 0,
                    'additionalCharge' => $row->additional_charge ?? 0,
                ])->render())
                ->html(),

            Column::make('Transaksi ID', 'transaksi_id')->sortable(),

            Column::make('Paket Wisata', 'paketwisata_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->paketWisata)->judul ?? '-'),

            Column::make('Pemesan', 'pemesan_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->pelanggan)->nama_pemesan ?? '-'),

            Column::make('Mobil', 'pemesanan_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->pemesanan->mobil)->nama_kendaraan ?? '-'),

            Column::make('Jenis Transaksi', 'jenis_transaksi')->sortable(),

            Column::make('Jumlah Peserta', 'jumlah_peserta')->sortable(),

            Column::make('Owe to Me', 'owe_to_me')->sortable(),

            Column::make('Status Owe', 'owe_to_me_status')
                ->format(fn($v) => $v ?? '-'),

            Column::make('Pay to Provider', 'pay_to_provider')->sortable(),

            Column::make('Status Pay To Provider', 'pay_to_provider_status')
                ->format(fn($v) => $v ?? '-'),

            Column::make('Additional Charge', 'additional_charge')->sortable(),

            Column::make('Total Transaksi', 'total_transaksi')->sortable(),

            Column::make('Transaksi Status', 'transaksi_status')->sortable(),
        ];
    }
}
