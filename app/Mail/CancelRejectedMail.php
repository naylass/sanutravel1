<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class CancelRejectedMail extends Mailable
{
    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('❌ Pembatalan Ditolak')
            ->view('emails.cancel-rejected');
    }
}