<?php

namespace App\Filament\Admin\Resources\Incomes\Pages;

use App\Filament\Admin\Resources\Incomes\IncomeResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncomeExport;

class ListIncomes extends ListRecords
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [

            // 🔹 tombol create
            Actions\CreateAction::make(),

            // 🔥 tombol export
            Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function ($livewire) {
                    return Excel::download(
                        new IncomeExport($livewire->getFilteredTableQuery()),
                        'income.xlsx'
                    );
                })
        ];
    }
}
