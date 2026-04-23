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
                TextEntry::make('driver.name')
                    ->label('Sopir'),

                TextEntry::make('plate_number')
                    ->label('Nomor Polisi'),

                TextEntry::make('brand')
                    ->label('Merk'),

                TextEntry::make('type')
                    ->label('Tipe'),

                TextEntry::make('capacity')
                    ->label('Kapasitas')
                    ->numeric(),

                TextEntry::make('created_at')
                    ->label('Dibuat')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime(),
            ]);
    }
}
