<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class PaymentSettledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Payment $payment,
        public ?string $pdfPath = null 
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembayaran Selesai - ' .
                     $this->payment->booking->booking_code,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-settled',
        );
    }

    public function attachments(): array
    {
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            return [
                Attachment::fromPath($this->pdfPath)
                    ->as('Receipt-' . $this->payment->booking->booking_code . '.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}