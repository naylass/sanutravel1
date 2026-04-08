<?php

namespace App\Filament\Admin\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('name')
                    ->required()
                    ->options([
                        'reguler' => 'Reguler',
                        'eksklusif' => 'Eksklusif',
                    ]),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
