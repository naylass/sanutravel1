<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public mixed $booking;

    public function __construct(mixed $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Baru Masuk')
            ->view('emails.booking-created');
    }
}