<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Pelanggan;

class PelangganTable extends DataTableComponent
{
    protected $model = Pelanggan::class;

    public function configure(): void
    {
        $this->setPrimaryKey('pelanggan_id');
    }

    public function columns(): array
    {
        return [
            Column::make("Pelanggan id", "pelanggan_id")
                ->sortable(),

            Column::make("Nama pemesan", "nama_pemesan")
                ->sortable(),

            Column::make("Alamat", "alamat")
                ->sortable(),

            Column::make("Email", "email")
                ->sortable(),

            Column::make("Nomor WhatsApp", "nomor_whatsapp")
                ->sortable(),

            Column::make("Status Member", "is_member")
                ->sortable()
                ->format(
                    fn($value, $row) => view('components.member-status', [
                        'isMember' => $row->is_member,
                        'points' => $row->points,
                        'memberSince' => $row->member_since
                    ])->render()
                )
                ->html(),

            Column::make('Actions')
                ->label(fn($row) => view('components.table-action', [
                    'rowId'     => $row->pelanggan_id,
                    'editUrl'   => route('pelanggan.edit', $row->pelanggan_id),
                    'deleteUrl' => route('pelanggan.destroy', $row->pelanggan_id),
                ])->render())
                ->html(),
        ];
    }
}
