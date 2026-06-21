<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class CancelRequestMail extends Mailable
{
    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('⚠️ Pengajuan Pembatalan Booking')
            ->view('emails.cancel-request');
    }
}