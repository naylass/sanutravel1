<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;


class PaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.invoice', [
            'payment' => $this->payment
        ]);

        return $this->subject('Bukti Pembayaran (Invoice)')
            ->view('emails.invoice')
            ->attachData($pdf->output(), 'invoice.pdf');
    }
}
