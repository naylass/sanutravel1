<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class DeliveryStatusUpdatedMail extends Mailable
{
    public $deliveryOrder;

    public function __construct($deliveryOrder)
    {
        $this->deliveryOrder = $deliveryOrder;
    }

    public function build()
    {
        return $this->subject('Update Status Delivery')
            ->view('emails.delivery-status');
    }
}