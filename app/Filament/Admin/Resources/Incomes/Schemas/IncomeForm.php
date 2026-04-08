<?php

namespace App\Filament\Admin\Resources\Incomes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class IncomeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('payment_id')
                    ->label('Payment ID')
                    ->required(),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
                TextInput::make('income_type')
                    ->label('Income Type')
                    ->required(),
                TextInput::make('description')
                    ->label('Description')
                    ->required(),
                TextInput::make('date')
                    ->label('Date')
                    ->date()
                    ->required(),
            ]);
    }
}
