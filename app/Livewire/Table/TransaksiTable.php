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
        return Transaksi::with([
            'paketWisata.include',
            'paketWisata.exclude',
            'pelanggan',
            'ketersediaan.mobil'
        ])->orderBy('created_at', 'desc');
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
                    'paketWisata'      => $row->paketWisata,

                    // Data transaksi yang sudah ada untuk fill form
                    'jenisPembayaran'  => $row->jenis_pembayaran,
                    'deposit'          => $row->deposit,
                    'payToProvider'    => $row->pay_to_provider,
                    'oweToMe'          => $row->owe_to_me,
                    'note'             => $row->note,

                    // Include data (jika sudah pernah di-set sebelumnya)
                    'includeData'      => $row->include_data ? json_decode($row->include_data, true) : null,
                ])->render())
                ->html(),

            Column::make('Transaksi ID', 'transaksi_id')->sortable(),

            Column::make('Paket Wisata', 'paketwisata_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->paketWisata)->judul ?? '-'),

            Column::make('Pemesan', 'pemesan_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->pelanggan)->nama_pemesan ?? '-'),

            Column::make('Mobil', 'terpesan_id')
                ->sortable()
                ->format(fn($v, $row) => optional($row->ketersediaan->mobil)->nama_kendaraan ?? '-'),

            Column::make('Jenis Transaksi', 'jenis_transaksi')->sortable(),

            Column::make('Jumlah Peserta', 'jumlah_peserta')->sortable(),

            Column::make('Owe to Me', 'owe_to_me')
                ->sortable()
                ->format(fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-'),

            Column::make('Status Owe', 'owe_to_me_status')
                ->format(fn($v) => $v ?? '-'),

            Column::make('Pay to Provider', 'pay_to_provider')
                ->sortable()
                ->format(fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-'),

            Column::make('Status Pay To Provider', 'pay_to_provider_status')
                ->format(fn($v) => $v ?? '-'),


            Column::make('Deposit', 'deposit')
                ->sortable()
                ->format(fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-'),

            Column::make('Additional Charge', 'additional_charge')
                ->sortable()
                ->format(fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-'),

            Column::make('Total Transaksi', 'total_transaksi')
                ->sortable()
                ->format(fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-'),

            Column::make('Transaksi Status', 'transaksi_status')
                ->sortable()
                ->format(function($value) {
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'paid' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                    ];

                    $colorClass = $statusColors[$value] ?? 'bg-gray-100 text-gray-800';

                    return '<span class="px-2 py-1 text-xs font-medium rounded-full ' . $colorClass . '">'
                           . ucfirst($value) . '</span>';
                })
                ->html(),

            Column::make('Tanggal Booking', 'created_at')
                ->sortable()
                ->format(fn($v) => $v ? $v->format('d M Y H:i') : '-'),
        ];
    }
}
