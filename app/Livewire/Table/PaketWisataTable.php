<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PaketWisata;
use Illuminate\Support\Facades\Storage;

class PaketWisataTable extends DataTableComponent
{
    protected $model = PaketWisata::class;

    public function configure(): void
    {
        $this->setPrimaryKey('paketwisata_id');
    }

    public function columns(): array
    {
        return [
            Column::make("Paketwisata id", "paketwisata_id")
                ->sortable(),

            Column::make("Judul", "judul")
                ->sortable(),

            Column::make("Tempat", "tempat")
                ->sortable(),

            Column::make("Deskripsi", "deskripsi")
                ->sortable(),

            Column::make("Durasi", "durasi")
                ->sortable(),

            Column::make("Foto", "foto")
                ->format(fn($value, $row) =>
                    '<img src="'.Storage::url($value).'" '
                  . 'alt="'.e($row->judul).'" '
                  . 'class="w-20 h-20 object-cover rounded-md" />'
                )
                ->html(),

                Column::make("Harga", "harga")
                ->sortable()
                ->format(fn($v) => number_format($v, 0, ',', '.')),


            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'     => $row->paketwisata_id,
                    'editUrl'   => route('paket-wisata.edit', $row->paketwisata_id),
                    'deleteUrl' => route('paket-wisata.destroy', $row->paketwisata_id),
                ])->render())
                ->html(),
        ];
    }
}
