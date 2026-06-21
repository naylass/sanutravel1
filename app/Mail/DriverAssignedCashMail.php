<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverAssignedCashMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this
            ->subject(
                'Tugas Penjemputan Cash - ' .
                $this->booking->booking_code
            )
            ->view(
                'emails.driver-assigned-cash'
            );
    }
}