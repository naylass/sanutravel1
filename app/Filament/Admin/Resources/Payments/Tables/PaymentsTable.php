<?php

namespace App\Filament\Admin\Resources\Payments\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ActionGroup;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 📦 BOOKING (kode + customer)
                TextColumn::make('booking')
                    ->label('Kode Booking')
                    ->formatStateUsing(fn ($record) =>
                        ($record->booking?->booking_code ?? '-') .
                        ' - ' . ($record->booking?->user?->name ?? '-')
                    )
                    ->searchable()
                    ->sortable(),

                // 💳 PAYMENT METHOD
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'transfer' => 'primary',
                        'cash' => 'success',
                        'ewallet' => 'warning',
                        default => 'gray',
                    }),

                // 📅 PAYMENT DATE
                TextColumn::make('payment_date')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),

                // 💰 AMOUNT
                TextColumn::make('amount')
                    ->label('Total')
                    ->money('IDR'),

                // 🧾 PROOF IMAGE
                ImageColumn::make('proof_image')
                    ->label('Bukti'),

                // 📊 STATUS (CLICKABLE ACTION DI SINI)
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'waiting' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })

                    ->action(function ($record) {
                        $record->update([
                            'status' => match ($record->status) {
                                'waiting' => 'verified',
                                'verified' => 'rejected',
                                'rejected' => 'waiting',
                                default => 'waiting',
                            }
                        ]);
                    })
                    ->tooltip('Klik untuk ubah status'),

                // 🕒 CREATED
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                // 🕒 UPDATED
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            // 🎯 ROW ACTIONS (TANPA STATUS ACTION)
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ]);
    }
}