<?php

namespace App\Filament\Admin\Resources\Drivers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DriverInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('photo'),
                TextEntry::make('name'),
                TextEntry::make('phone'),
                TextEntry::make('birth_place'),
                TextEntry::make('birth_date')
                    ->date(),
                TextEntry::make('gender'),
                TextEntry::make('license_number'),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
