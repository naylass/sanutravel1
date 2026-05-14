<?php

namespace App\Filament\Admin\Resources\DeliveryOrders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

use App\Mail\DeliveryStatusUpdatedMail;
use App\Mail\DeliveryOrderCreatedMail;
use App\Services\DeliveryOrderService;
use App\Models\Booking;

class DeliveryOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('booking.booking_code')
                    ->label(' Kode Booking')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('booking.customer_name')
                    ->label('Nama Customer')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('driver.name')
                    ->label('Sopir')
                    ->sortable(),

                TextColumn::make('vehicle.brand')
                    ->label('Kendaraan')
                    ->sortable(),

                TextColumn::make('jadwal')
                    ->label('Jadwal')
                    ->state(function ($record) {

                        if (!$record->schedule) {
                            return '-';
                        }

                        return Carbon::parse(
                            $record->schedule->departure_date . ' ' .
                                $record->schedule->departure_time
                        )->format('d M Y H:i');
                    }),

                TextColumn::make('pickup_point')
                    ->label('Alamat Jemput')
                    ->limit(30)
                    ->tooltip(fn($state) => $state),

                TextColumn::make('booking.phone_number')
                    ->label('No. HP')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('destination')
                    ->label('Tujuan')
                    ->limit(25),

                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'prepared' => 'info',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

            ])

            ->actions([

                Action::make('change_status')
                    ->label('Update Status')

                    ->form([

                        \Filament\Forms\Components\Select::make('status')
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

                        Notification::make()
                            ->title('Status updated')
                            ->success()
                            ->send();
                    }),

            ])

            ->headerActions([

                Action::make('generate')
                    ->label('Generate Delivery Order')

                    ->form([

                        \Filament\Forms\Components\Select::make('booking_id')
                            ->label('Select Booking')
                            ->searchable()
                            ->preload()
                            ->required()

                            // 🔥 INI YANG PENTING
                            // booking yg SUDAH punya DO tidak muncul lagi
                            ->options(function () {

                                return Booking::query()

                                    ->whereDoesntHave('deliveryOrder')

                                    ->get()

                                    ->mapWithKeys(fn($b) => [

                                        $b->id =>

                                        $b->booking_code .
                                            ' - ' .
                                            $b->customer_name .
                                            ' - ' .
                                            $b->destination
                                    ]);
                            }),

                    ])

                    ->action(function (array $data) {

                        $delivery = app(DeliveryOrderService::class)
                            ->generate($data);

                        $delivery->load([
                            'driver',
                            'vehicle',
                            'booking',
                            'schedule'
                        ]);

                        // EMAIL DRIVER
                        if ($delivery->driver?->email) {

                            Mail::to($delivery->driver->email)
                                ->send(
                                    new DeliveryOrderCreatedMail($delivery)
                                );
                        }

                        Notification::make()
                            ->title('Delivery Order created')
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
