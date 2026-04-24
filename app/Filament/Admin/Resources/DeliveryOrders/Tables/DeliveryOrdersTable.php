<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use App\Models\Booking;
use App\Services\DeliveryOrderService;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Select;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking.booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('driver.name')
                    ->label('Sopir')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('schedule')
                    ->label('Waktu Keberangkatan')
                    ->formatStateUsing(function ($record) {
                        if (!$record->schedule) return '-';

                        return \Carbon\Carbon::parse(
                            $record->schedule->departure_date . ' ' . $record->schedule->departure_time
                        )->format('d M Y H:i');
                    })
                    ->sortable(),

                TextColumn::make('booking.schedule.pickup_point')
                    ->label('Titik Penjemputan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        'prepared' => 'info', // tambahkan ini
                    })
                    ->action(
                        Action::make('change_status')
                            ->label('Ubah Status')
                            ->form([
                                \Filament\Forms\Components\Select::make('status')
                                    ->options([
                                        'ongoing' => 'ongoing',
                                        'completed' => 'Completed',
                                        'cancelled' => 'Cancelled',
                                        'prepared' => 'Prepared',
                                    ])
                                    ->required()
                            ])
                            ->action(function ($record, $data) {
                                $record->update([
                                    'status' => $data['status']
                                ]);
                            })
                    ),
            ])
            ->filters([])
            ->headerActions([
                Action::make('generate')
                    ->label('Generate Delivery Order')
                    ->icon(Heroicon::ClipboardDocument)
                    ->form([
                        Select::make('booking_id')
                            ->label('Booking')
                            ->relationship(
                                name: 'booking',
                                titleAttribute: 'booking_code'
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>
                                $record->booking_code . ' - ' . ($record->user->name ?? '-')
                            )
                            ->searchable(['booking_code', 'user.name'])
                            ->preload()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        try {
                            app(DeliveryOrderService::class)->generate($data);

                            Notification::make()
                                ->title('Delivery Order berhasil dibuat')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
