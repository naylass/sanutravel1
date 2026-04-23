<?php

namespace App\Filament\Admin\Resources\Payments\Pages;

use App\Filament\Admin\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentToAdmin;
use App\Mail\PaymentUploadedMail;
use App\Mail\PaymentInvoiceMail;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function afterCreate(): void
    {
        $payment = $this->record->load('booking.user');

        // 🔴 TRANSFER
        if ($payment->payment_method === 'transfer') {

            // ke admin
            Mail::to('nylaadjah@gmail.com')
                ->send(new PaymentToAdmin($payment));

            // ke customer
            Mail::to($payment->booking->user->email)
                ->send(new PaymentUploadedMail($payment));
        }

        // 🔵 CASH
        if ($payment->payment_method === 'cash') {

            // langsung kirim invoice ke customer
            Mail::to($payment->booking->user->email)
                ->send(new PaymentInvoiceMail($payment));
        }
    }
}
