<?php

namespace App\Filament\Admin\Resources\Drivers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class DriversTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                ImageColumn::make('photo')

                    ->label('Driver')

                    ->circular()

                    ->size(56)

                    ->defaultImageUrl(
                        url('/images/default-avatar.png')
                    ),

                TextColumn::make('name')

                    ->label('Nama Driver')

                    ->searchable()

                    ->sortable()

                    ->weight('bold')

                    ->icon('heroicon-m-user-circle')

                    ->description(fn ($record) => $record->email)

                    ->wrap(),

                TextColumn::make('phone')

                    ->label('Nomor HP')

                    ->searchable()

                    ->copyable()

                    ->icon('heroicon-m-phone')

                    ->color('success')

                    ->weight('medium'),

                TextColumn::make('birth_place')

                    ->label('Tempat Lahir')

                    ->icon('heroicon-m-map-pin')

                    ->searchable(),

                TextColumn::make('birth_date')

                    ->label('Tanggal Lahir')

                    ->date('d M Y')

                    ->sortable()

                    ->badge()

                    ->color('info')

                    ->icon('heroicon-m-calendar-days'),

                TextColumn::make('gender')

                    ->label('Gender')

                    ->badge()

                    ->formatStateUsing(fn ($state) => match ($state) {

                        'male' => 'Laki-laki',
                        'female' => 'Perempuan',

                        default => $state,
                    })

                    ->color(fn ($state) => match ($state) {

                        'male' => 'info',
                        'female' => 'danger',

                        default => 'gray',
                    })

                    ->icon(fn ($state) => match ($state) {

                        'male' => 'heroicon-m-user',
                        'female' => 'heroicon-m-user',

                        default => 'heroicon-m-user',
                    }),

                TextColumn::make('license_number')

                    ->label('Nomor SIM')

                    ->searchable()

                    ->badge()

                    ->color('warning')

                    ->icon('heroicon-m-identification')

                    ->copyable(),

                TextColumn::make('created_at')

                    ->label('Dibuat')

                    ->dateTime('d M Y H:i')

                    ->sortable()

                    ->since()

                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')

                    ->label('Diupdate')

                    ->dateTime('d M Y H:i')

                    ->sortable()

                    ->since()

                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([

            ])

            ->recordActions([

                ViewAction::make()
                    ->color('gray'),

                EditAction::make()
                    ->color('primary'),

                DeleteAction::make()
                    ->color('danger'),
            ])

            ->toolbarActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make(),

                ]),
            ])

            /*
            |--------------------------------------------------------------------------
            | TABLE STYLE
            |--------------------------------------------------------------------------
            */

            ->striped()

            ->defaultSort('created_at', 'desc')

            ->paginated([10, 25, 50])

            ->defaultPaginationPageOption(10)

            ->emptyStateHeading('Belum ada driver')

            ->emptyStateDescription('Data driver akan muncul di sini.')

            ->emptyStateIcon('heroicon-o-user-group');
    }
}