<?php

namespace App\Filament\Admin\Resources\Incomes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 🎫 BOOKING CODE (via payment)
                TextColumn::make('payment.booking.booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->sortable(),

                // 💰 AMOUNT
                TextColumn::make('amount')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                // 📊 TYPE INCOME
                TextColumn::make('income_type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'booking' => 'success',
                        'other' => 'warning',
                        default => 'gray',
                    }),

                // 📝 DESCRIPTION
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->placeholder('-'),

                // 📅 INCOME DATE (FIXED)
                TextColumn::make('income_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                // 📅 CREATED AT
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 📅 UPDATED AT
                TextColumn::make('updated_at')
                    ->label('Update')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()->icon('heroicon-o-eye'),
                    EditAction::make()->icon('heroicon-o-pencil'),
                    DeleteAction::make()->icon('heroicon-o-trash'),
                ])
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}