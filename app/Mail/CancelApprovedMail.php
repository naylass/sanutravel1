<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Mail\Mailable;

class CancelApprovedMail extends Mailable
{
    public Booking $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('✅ Pembatalan Disetujui')
            ->view('emails.cancel-approved');
    }
}