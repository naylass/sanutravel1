<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use App\Services\DeliveryOrderService;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryStatusUpdatedMail;
use App\Mail\DeliveryOrderCreatedMail;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('booking.booking_code')
                    ->label('Kode Booking')
                    ->searchable(),

                TextColumn::make('driver.name')
                    ->label('Driver'),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan'),

                TextColumn::make('schedule.departure_date')
                    ->label('Tanggal'),

                TextColumn::make('schedule.departure_time')
                    ->label('Jam'),

                TextColumn::make('schedule.pickup_point')
                    ->label('Pickup Point'),

                TextColumn::make('destination')
                    ->label('Tujuan'),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'prepared' => 'info',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    }),
            ])

            ->actions([
                Action::make('change_status')
                    ->label('Ubah Status')
                    ->form([
                        Select::make('status')
                            ->options([
                                'prepared' => 'Prepared',
                                'ongoing' => 'Ongoing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                    ])
                    ->action(function ($record, $data) {

                        $record->update([
                            'status' => $data['status']
                        ]);

                        $record->load(['booking.user', 'driver']);

                        if ($record->booking?->user?->email) {
                            Mail::to($record->booking->user->email)
                                ->send(new DeliveryStatusUpdatedMail($record));
                        }

                        Notification::make()
                            ->title('Status berhasil diupdate & email customer terkirim')
                            ->success()
                            ->send();
                    }),

            ])

            ->headerActions([
                Action::make('generate')
                    ->label('Generate Delivery Order')
                    ->icon(Heroicon::ClipboardDocument)
                    ->form([
                        Select::make('booking_id')
                            ->label('Booking')
                            ->relationship('booking', 'booking_code')
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>
                                $record->booking_code . ' - ' . ($record->user->name ?? '-')
                            )
                            ->searchable(['booking_code', 'user.name'])
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (array $data) {

                        $delivery = app(DeliveryOrderService::class)
                            ->generate($data);

                        $delivery->load([
                            'driver',
                            'vehicle',
                            'booking.user',
                            'schedule'
                        ]);

                        if ($delivery->driver?->email) {
                            Mail::to($delivery->driver->email)
                                ->send(new DeliveryOrderCreatedMail($delivery));
                        }

                        Notification::make()
                            ->title('Delivery Order dibuat & email driver terkirim')
                            ->success()
                            ->send();
                    }),

            ])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}