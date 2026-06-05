<?php

namespace App\Observers;

use App\Models\Payment;
use App\Models\Income;

class PaymentObserver
{
    public function updated(Payment $payment)
    {
        if (!$payment->isDirty('status')) return;

        $status = $payment->status;

        $shouldCreateIncome =
            ($status === 'verified' && $payment->payment_method !== 'cash') ||
            ($status === 'cash_received' && $payment->payment_method === 'cash');

        if ($shouldCreateIncome) {

            $exists = Income::where('payment_id', $payment->id)->exists();

            if (!$exists) {
                Income::create([
                    'payment_id'   => $payment->id,
                    'amount'       => $payment->amount,
                    'income_type'  => 'booking',
                    'income_date'  => now('Asia/Jakarta'),
                    'description'  => 'Income dari booking ' .
                                      ($payment->booking->booking_code ?? '-') .
                                      ' via ' . strtoupper($payment->payment_method),
                ]);
            }
        }
    }
}