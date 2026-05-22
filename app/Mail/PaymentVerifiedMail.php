<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentVerifiedMail extends Mailable
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
        $pdf = Pdf::loadView(
            'pdf.payment-receipt',
            [
                'payment' => $this->payment,
                'booking' => $this->booking
            ]
        );

        return $this->subject(
                'Pembayaran Berhasil Diverifikasi'
            )

            ->view(
                'emails.payment-verified'
            )

            ->attachData(
                $pdf->output(),
                'receipt-' .
                $this->booking->booking_code .
                '.pdf'
            );
    }
}