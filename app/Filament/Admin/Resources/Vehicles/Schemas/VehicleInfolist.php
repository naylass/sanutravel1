<?php

namespace App\Filament\Admin\Resources\Vehicles\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VehicleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('plate_number'),
                TextEntry::make('brand'),
                TextEntry::make('type'),
                TextEntry::make('capacity')
                    ->numeric(),
                TextEntry::make('status'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
