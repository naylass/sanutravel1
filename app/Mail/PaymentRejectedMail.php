<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;
    public $booking;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->booking = $payment->booking;
    }

    public function build()
    {
        return $this->subject(
                'Pembayaran Ditolak'
            )

            ->view(
                'emails.payment-rejected'
            );
    }
}