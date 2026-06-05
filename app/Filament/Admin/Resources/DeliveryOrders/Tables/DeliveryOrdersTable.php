<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use Carbon\Carbon;
use App\Models\Booking;
use Filament\Tables\Table;
use Filament\Actions\Action;
use App\Services\DeliveryOrderService;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryOrderCreatedMail;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('booking.booking_code')

                    ->label('Booking')

                    ->searchable()

                    ->sortable()

                    ->badge()

                    ->color('primary')

                    ->weight('bold')

                    ->icon('heroicon-o-ticket')

                    ->description(
                        fn($record) =>
                        $record->booking?->customer_name ?? '-'
                    ),

                TextColumn::make('driver.name')

                    ->label('Sopir')

                    ->sortable()

                    ->searchable()

                    ->badge()

                    ->color('success')

                    ->icon('heroicon-o-user')

                    ->description(
                        fn($record) =>
                        $record->driver?->phone_number ?? '-'
                    ),


                TextColumn::make('vehicle.brand')

                    ->label('Kendaraan')

                    ->sortable()

                    ->searchable()

                    ->icon('heroicon-o-truck')

                    ->weight('semiBold')

                    ->description(
                        fn($record) =>
                        'Plat: ' .
                            ($record->vehicle?->plate_number ?? '-')
                    ),

                TextColumn::make('schedule')

                    ->label('Jadwal')

                    ->badge()

                    ->color('info')

                    ->icon('heroicon-o-clock')

                    ->state(function ($record) {

                        if (!$record->schedule) {
                            return '-';
                        }

                        return Carbon::parse(
                            $record->schedule->departure_date .
                                ' ' .
                                $record->schedule->departure_time
                        )->translatedFormat('d M Y • H:i');
                    }),


                TextColumn::make('pickup_point')

                    ->label('Penjemputan')

                    ->icon('heroicon-o-map-pin')

                    ->wrap()

                    ->limit(40)

                    ->tooltip(fn($state) => $state),

                TextColumn::make('destination')

                    ->label('Tujuan')

                    ->icon('heroicon-o-map')

                    ->badge()

                    ->color('gray')

                    ->limit(30)

                    ->tooltip(fn($state) => $state),

                TextColumn::make('booking.phone_number')

                    ->label('No HP')

                    ->icon('heroicon-o-phone')

                    ->copyable()

                    ->copyMessage('Nomor berhasil disalin')

                    ->searchable()

                    ->badge()

                    ->color('warning'),

                TextColumn::make('status')

                    ->label('Status')

                    ->badge()

                    ->icon(fn($state) => match ($state) {

                        'prepared' => 'heroicon-o-clock',

                        'ongoing' => 'heroicon-o-truck',

                        'completed' => 'heroicon-o-check-circle',

                        'cancelled' => 'heroicon-o-x-circle',

                        default => 'heroicon-o-information-circle',
                    })

                    ->formatStateUsing(fn($state) => match ($state) {

                        'prepared' => 'Prepared',

                        'ongoing' => 'Perjalanan',

                        'completed' => 'Selesai',

                        'cancelled' => 'Dibatalkan',

                        default => ucfirst($state),
                    })

                    ->color(fn($state) => match ($state) {

                        'prepared' => 'info',

                        'ongoing' => 'warning',

                        'completed' => 'success',

                        'cancelled' => 'danger',

                        default => 'gray',
                    }),

                TextColumn::make('created_at')

                    ->label('Dibuat')

                    ->since()

                    ->sortable()

                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->actions([])

            ->headerActions([

                Action::make('generate')

                    ->label('Generate Delivery Order')

                    ->icon('heroicon-o-plus-circle')

                    ->color('success')

                    ->modalWidth('lg')

                    ->form([

                        \Filament\Forms\Components\Select::make('booking_id')

                            ->label('Pilih Booking')

                            ->searchable()

                            ->preload()

                            ->required()

                            ->options(function () {

                                return Booking::query()

                                    ->whereDoesntHave('deliveryOrder')

                                    ->get()

                                    ->mapWithKeys(fn($b) => [

                                        $b->id =>

                                        $b->booking_code .
                                            ' • ' .
                                            $b->customer_name .
                                            ' • ' .
                                            $b->destination
                                    ]);
                            }),

                    ])

                    ->action(function (array $data) {

                        $delivery = app(
                            DeliveryOrderService::class
                        )->generate($data);

                        $delivery->load([
                            'driver',
                            'vehicle',
                            'booking.payment',
                            'schedule',
                        ]);

                        $driver  = $delivery->driver;
                        $booking = $delivery->booking;

                        if (!empty($driver?->email)) {
                            try {
                                Mail::to($driver->email)
                                    ->send(new DeliveryOrderCreatedMail($delivery));
                            } catch (\Exception $e) {
                                logger('EMAIL DO ERROR: ' . $e->getMessage(), [
                                    'delivery_id' => $delivery->id,
                                ]);
                            }
                        }

                        if (
                            !empty($driver?->email) &&
                            $booking?->payment?->payment_method === 'cash'
                        ) {
                            try {
                                Mail::to($driver->email)
                                    ->send(new \App\Mail\DriverAssignedCashMail($booking));
                            } catch (\Exception $e) {
                                logger('EMAIL CASH REMINDER ERROR: ' . $e->getMessage(), [
                                    'delivery_id' => $delivery->id,
                                ]);
                            }
                        }

                        Notification::make()
                            ->title('Delivery Order berhasil dibuat')
                            ->success()
                            ->send();
                    }),

            ])

            ->bulkActions([

                BulkActionGroup::make([

                    DeleteBulkAction::make()
                        ->label('Hapus Data'),

                ]),
            ])

            ->striped()

            ->defaultSort('created_at', 'desc')

            ->paginated([10, 25, 50])

            ->emptyStateHeading(
                'Belum ada Delivery Order'
            )

            ->emptyStateDescription(
                'Delivery order akan muncul di sini.'
            );
    }
}
