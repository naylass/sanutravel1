<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Income;

class PaymentObserver
{
    public function updated(Payment $payment)
    {
        // hanya jalan saat status berubah ke verified
        if ($payment->isDirty('status') && $payment->status === 'verified') {

            // cek biar tidak double
            $exists = Income::where('payment_id', $payment->id)->exists();

            if (!$exists) {
                Income::create([
                    'payment_id' => $payment->id,
                    'amount' => $payment->amount,
                    'income_type' => 'booking',
                    'description' => 'Income dari booking ' . $payment->booking->booking_code,
                    'income_date' => now(),
                ]);
            }
        }
    }
}