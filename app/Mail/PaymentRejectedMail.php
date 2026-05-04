<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Mail\Mailable;

class PaymentRejectedMail extends Mailable
{
    public Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject('Pembayaran Ditolak')
            ->view('emails.payment-rejected');
    }
}