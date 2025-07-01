<?php

namespace App\Livewire\Table;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Admin;

class AdminTable extends DataTableComponent
{
    protected $model = Admin::class;

    public function configure(): void
    {
        $this->setPrimaryKey('admin_id');
    }

    public function columns(): array
    {
        return [
            Column::make("Admin id", "admin_id")
                ->sortable(),
            Column::make("Nama admin", "nama_admin")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make('Actions')
            ->label(fn($row) => view('components.table-action', [
                'rowId'     => $row->admin_id,
                'editUrl'   => route('admin.edit', $row->admin_id),
                'deleteUrl' => route('admin.destroy', $row->admin_id),
            ])->render())
            ->html(),

        ];
    }
}
