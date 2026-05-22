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

use Filament\Tables\Filters\SelectFilter;

class IncomesTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make('payment.booking.booking_code')

                    ->label('Booking')

                    ->formatStateUsing(
                        fn($record) =>
                        $record->payment?->booking?->booking_code ?? '-'
                    )

                    ->searchable()
                    ->sortable()

                    ->weight('bold')

                    ->badge()

                    ->color('gray'),

                TextColumn::make('payment.booking.customer_name')

                    ->label('Customer')

                    ->searchable()

                    ->sortable()

                    ->placeholder('-')

                    ->icon('heroicon-o-user'),

                BadgeColumn::make('payment.payment_method')

                    ->label('Metode')

                    ->formatStateUsing(
                        fn($state) => match ($state) {

                            'qris' => 'QRIS',
                            'cash' => 'Cash',
                            'transfer' => 'Transfer',

                            default => '-',
                        }
                    )

                    ->colors([

                        'success' => 'qris',
                        'warning' => 'cash',
                        'info' => 'transfer',
                    ])

                    ->icons([

                        'heroicon-o-qr-code' => 'qris',
                        'heroicon-o-banknotes' => 'cash',
                        'heroicon-o-building-library' => 'transfer',
                    ]),

                /*
                |--------------------------------------------------------------------------
                | BANK TRANSFER
                |--------------------------------------------------------------------------
                */

                TextColumn::make('payment.bank_name')

                    ->label('Bank')

                    ->placeholder('-')

                    ->badge()

                    ->color('info')

                    ->visible(
                        fn($record) =>
                        $record?->payment?->payment_method === 'transfer'
                    ),

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

                /*
                |--------------------------------------------------------------------------
                | STATUS PAYMENT
                |--------------------------------------------------------------------------
                */

                BadgeColumn::make('payment.status')

                    ->label('Status')

                    ->formatStateUsing(
                        fn($state) => match ($state) {

                            'verified' => 'Verified',
                            'settled' => 'Settled',
                            'cash_received' => 'Cash Diterima',

                            'default' => $state ? ucfirst($state) : '-',
                        }
                    )

                    ->colors([

                        'success' => 'verified',
                        'primary' => 'cash_received',
                        'warning' => 'settled',
                    ]),

                /*
                |--------------------------------------------------------------------------
                | DESKRIPSI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('description')

                    ->label('Deskripsi')

                    ->wrap()

                    ->limit(40)

                    ->placeholder('-'),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('income_date')

                    ->label('Tanggal')

                    ->date()

                    ->sortable()

                    ->badge()

                    ->color('info'),

                /*
                |--------------------------------------------------------------------------
                | CREATED
                |--------------------------------------------------------------------------
                */

                TextColumn::make('created_at')

                    ->label('Dibuat')

                    ->since()

                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])


            ->filters([

                SelectFilter::make('payment_method')

                    ->label('Metode Pembayaran')

                    ->relationship(
                        'payment',
                        'payment_method'
                    )

                    ->options([
                        'qris' => 'QRIS',
                        'cash' => 'Cash',
                        'transfer' => 'Transfer',
                    ]),

                SelectFilter::make('income_type')

                    ->options([
                        'booking' => 'Booking',
                        'manual' => 'Manual',
                    ]),
            ])

            ->recordActions([

                ActionGroup::make([

                    ViewAction::make(),

                    EditAction::make()

                        ->visible(
                            fn($record) =>
                            $record->income_type === 'manual'
                        ),

                    DeleteAction::make()

                        ->visible(
                            fn($record) =>
                            $record->income_type === 'manual'
                        ),
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
