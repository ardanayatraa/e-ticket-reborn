<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Mobil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class MobilTable extends DataTableComponent
{
    protected $model = Mobil::class;

    public function configure(): void
    {
        $this->setPrimaryKey('mobil_id');
    }

    public function builder(): Builder
    {
        return Mobil::with('sopir');
    }

    public function columns(): array
    {
        return [
            Column::make("Tipe Mobil ID", "mobil_id")
                ->sortable(),

            Column::make("Sopir", "sopir_id")
                ->sortable()
                ->format(fn($v, $row) => optional($row->sopir)->nama_sopir ?? '-'),

            Column::make("Nama Kendaraan", "nama_kendaraan")
                ->sortable(),

            Column::make("Nomor Kendaraan", "nomor_kendaraan")
                ->sortable(),

            Column::make("Jumlah Tempat Duduk", "jumlah_tempat_duduk")
                ->sortable(),

            Column::make("Status Ketersediaan", "status_ketersediaan")
                ->sortable(),

            Column::make("Foto", "foto")
                ->format(fn($value, $row) =>
                    '<img src="'.Storage::url($value).'" '
                  . 'alt="'.e($row->nama_kendaraan).'" '
                  . 'class="w-20 h-20 object-cover rounded-md" />'
                )
                ->html(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'     => $row->mobil_id,
                    'editUrl'   => route('mobil.edit', $row->mobil_id),
                    'deleteUrl' => route('mobil.destroy', $row->mobil_id),
                ])->render())
                ->html(),
        ];
    }
}
