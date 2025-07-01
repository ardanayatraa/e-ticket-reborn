<?php

namespace App\Livewire\Table;

use App\Exports\TransaksiExport;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter as FiltersDateFilter;

class TransaksiLaporanTable extends DataTableComponent
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
            ->where('transaksi_status', 'paid');
    }

    public function columns(): array
    {
        return [
            Column::make("Transaksi ID", "transaksi_id")->sortable(),

            Column::make("Paket Wisata", "paketwisata_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->paketWisata)->judul ?? '-'),

            Column::make("Pemesan", "pemesan_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->pelanggan)->nama_pemesan ?? '-'),

            Column::make("Mobil", "pemesanan_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->pemesanan->mobil)->nama_kendaraan ?? '-'),

            Column::make("Jenis Transaksi", "jenis_transaksi")->sortable(),

            Column::make("Deposit", "deposit")
                ->sortable()
                ->format(fn($v) => number_format($v, 0, ',', '.'))
                ->footer(fn($rows) => 'Total: Rp ' . number_format($rows->sum('deposit'), 0, ',', '.')),

            Column::make("Balance", "balance")
                ->sortable()
                ->format(fn($v) => number_format($v, 0, ',', '.'))
                ->footer(fn($rows) => 'Total: Rp ' . number_format($rows->sum('balance'), 0, ',', '.')),

            Column::make("Jumlah Peserta", "jumlah_peserta")->sortable(),

            Column::make("Owe to Me", "owe_to_me")
                ->sortable()
                ->format(fn($v, $row) => $row->owe_to_me > 0 ? 'Rp ' . number_format($row->owe_to_me, 0, ',', '.') : '-'),

            Column::make("Status Owe", "owe_to_me_status")
                ->format(function ($value, $row) {
                    return $row->owe_to_me > 0
                        ? view('components.select-action', [
                            'rowId'   => $row->transaksi_id,
                            'field'   => 'owe_to_me_status',
                            'current' => $row->owe_to_me_status,
                        ])
                        : '-';
                })->html(),

            Column::make("Pay to Provider", "pay_to_provider")
                ->sortable()
                ->format(fn($v, $row) => $row->pay_to_provider > 0 ? 'Rp ' . number_format($row->pay_to_provider, 0, ',', '.') : '-'),

            Column::make("Status Pay To Provider", "pay_to_provider_status")
                ->format(function ($value, $row) {
                    return $row->pay_to_provider > 0
                        ? view('components.select-action', [
                            'rowId'   => $row->transaksi_id,
                            'field'   => 'pay_to_provider_status',
                            'current' => $row->pay_to_provider_status,
                        ])
                        : '-';
                })->html(),

            Column::make("Total Transaksi", "total_transaksi")
                ->sortable()
                ->format(fn($v) => number_format($v, 0, ',', '.'))
                ->footer(fn($rows) => 'Total: Rp ' . number_format($rows->sum('total_transaksi'), 0, ',', '.')),

            Column::make("Status", "transaksi_status")->sortable(),

            Column::make("Dibuat pada", "created_at")
                ->sortable()
                ->format(fn($v) => \Carbon\Carbon::parse($v)->format('Y-m-d H:i:s')),
        ];
    }

    public function filters(): array
    {
        return [
            FiltersDateFilter::make('Dari')
                ->filter(fn(Builder $query, string $value) => $query->whereDate('created_at', '>=', $value)),

            FiltersDateFilter::make('Sampai')
                ->filter(fn(Builder $query, string $value) => $query->whereDate('created_at', '<=', $value)),
        ];
    }

    public function bulkActions(): array
    {
        return [
            'export' => 'Export',
        ];
    }

    public function export()
    {
        $selectedIds = $this->getSelected();

        return Excel::download(
            new TransaksiExport($selectedIds),
            'laporan_transaksi_'.now()->format('Ymd_His').'.xlsx'
        );

        $this->clearSelected();
    }

    public function updateStatus(int $id, string $field, string $value)
    {
        if (!in_array($field, ['owe_to_me_status', 'pay_to_provider_status'])) {
            return;
        }

        $trx = Transaksi::find($id);
        if (!$trx) return;

        $trx->update([$field => $value]);
        $this->dispatch('refreshTable');
        session()->flash('message', ucfirst(str_replace('_', ' ', $field)) . " updated to {$value}");
    }
}
