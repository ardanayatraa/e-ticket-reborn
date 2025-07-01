<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Exclude;
use Illuminate\Database\Eloquent\Builder;

class ExcludeTable extends DataTableComponent
{
    protected $model = Exclude::class;

    public function configure(): void
    {
        $this->setPrimaryKey('exclude_id');
    }

    public function builder():Builder
    {
        return Exclude::with('pemesanan.pelanggan');
    }

    public function columns(): array
    {
        return [
            Column::make("Exclude ID", "exclude_id")->sortable(),

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
                    'rowId'     => $row->exclude_id,
                    'editUrl'   => route('exclude.edit', $row->exclude_id),
                    'deleteUrl' => route('exclude.destroy', $row->exclude_id),
                ])->render())
                ->html(),
        ];
    }
}
