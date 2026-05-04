<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Mail\Mailable;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentVerifiedMail extends Mailable
{
    public Payment $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.payment-receipt', [
            'payment' => $this->payment
        ]);

        return $this->subject('Pembayaran Berhasil Diverifikasi')
            ->view('emails.payment-verified')
            ->attachData(
                $pdf->output(),
                'bukti-pembayaran-'.$this->payment->id.'.pdf'
            );
    }
}