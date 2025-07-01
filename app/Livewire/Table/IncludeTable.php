<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\IncludeModel;
use Illuminate\Database\Eloquent\Builder;

class IncludeTable extends DataTableComponent
{
    protected $model = IncludeModel::class;

    public function configure(): void
    {
        $this->setPrimaryKey('include_id');
    }

    public function builder():Builder
    {
        return IncludeModel::with('pemesanan.pelanggan');
    }

    public function columns(): array
    {
        return [
            Column::make("Include ID", "include_id")->sortable(),

            Column::make("Pemesan", "pemesanan_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->pemesanan->pelanggan)->nama_pemesan ?? '-'),

            Column::make("Bensin", "bensin")->sortable(),
            Column::make("Parkir", "parkir")->sortable(),
            Column::make("Sopir", "sopir")->sortable(),
            Column::make("Makan Siang", "makan_siang")->sortable(),
            Column::make("Makan Malam", "makan_malam")->sortable(),
            Column::make("Tiket Masuk", "tiket_masuk")->sortable(),
            Column::make("Status Ketersediaan", "status_ketersediaan")->sortable(),
            Column::make("Created At", "created_at")->sortable(),
            Column::make("Updated At", "updated_at")->sortable(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'     => $row->include_id,
                    'editUrl'   => route('include.edit', $row->include_id),
                    'deleteUrl' => route('include.destroy', $row->include_id),
                ])->render())
                ->html(),
        ];
    }
}
