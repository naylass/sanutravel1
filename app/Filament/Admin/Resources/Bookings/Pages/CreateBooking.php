<?php

namespace App\Filament\Admin\Resources\Bookings\Pages;

use App\Filament\Admin\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCreatedMail;
use App\Mail\BookingPaymentMail;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function afterCreate(): void
    {
        $booking = $this->record->load('user');

        Mail::to('nylaadjah@gmail.com')
            ->send(new BookingCreatedMail($booking));

        if (!empty($booking->user?->email)) {

            Mail::to($booking->user->email)
                ->send(new BookingPaymentMail($booking));
        }
    }
}
