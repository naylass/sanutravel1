<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DriverCashReceivedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        $mail = $this->subject(
            'Cash Diterima Driver - ' .
            $this->payment->booking->booking_code
        )
        ->view('emails.driver-cash-admin');

        if ($this->payment->driver_proof) {

            $mail->attach(
                storage_path(
                    'app/public/' .
                    $this->payment->driver_proof
                )
            );
        }

        return $mail;
    }
}