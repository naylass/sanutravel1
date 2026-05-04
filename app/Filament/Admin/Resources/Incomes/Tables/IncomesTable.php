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
use Filament\Tables\Columns\BadgeColumn;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 🎫 BOOKING (AMAN DARI NULL)
                TextColumn::make('payment.booking.booking_code')
                    ->label('Booking')
                    ->formatStateUsing(fn ($record) =>
                        $record->payment?->booking?->booking_code ?? '-'
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // 💰 AMOUNT
                TextColumn::make('amount')
                    ->label('Income')
                    ->money('IDR')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                BadgeColumn::make('income_type')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'booking',
                        'warning' => 'manual',
                    ])
                    ->icons([
                        'heroicon-o-banknotes' => 'booking',
                        'heroicon-o-pencil' => 'manual',
                    ]),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->wrap()
                    ->limit(40)
                    ->placeholder('-'),

                TextColumn::make('income_date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->visible(fn ($record) => $record->income_type === 'manual'),
                    DeleteAction::make()
                        ->visible(fn ($record) => $record->income_type === 'manual'),
                ])
            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->defaultSort('income_date', 'desc');
    }
}