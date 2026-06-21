<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class DeliveryOrderCreatedMail extends Mailable
{
    public $deliveryOrder;

    public function __construct($deliveryOrder)
    {
        $this->deliveryOrder = $deliveryOrder;
    }

    public function build()
    {
        $pdf = app('dompdf.wrapper')
            ->loadView('pdf.delivery-order', [
                'deliveryOrder' => $this->deliveryOrder
            ]);

        return $this->subject('Delivery Order Baru')
            ->view('emails.delivery-order')
            ->attachData($pdf->output(), 'delivery-order.pdf');
    }
}