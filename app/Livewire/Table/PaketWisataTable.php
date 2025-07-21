<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PaketWisata;

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
            Column::make("ID", "paketwisata_id")
                ->sortable(),

            Column::make("Judul", "judul")
                ->sortable(),

            Column::make("Slug", "slug")
                ->sortable(),

            Column::make("Tempat", "tempat")
                ->sortable(),

            Column::make("Durasi", "durasi")
                ->sortable(),

            Column::make("Harga", "harga")
                ->sortable()
                ->format(fn($v) => 'Rp ' . number_format($v, 0, ',', '.')),

            Column::make('Actions')
                ->label(function($row) {
                    if (empty($row->slug)) {
                        return '<span class="text-red-500">No slug</span>';
                    }
                    return '<a href="' . route('paket-wisata.edit', $row->slug) . '" class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-sm transition">Edit</a>';
                })
                ->html(),
        ];
    }
}
