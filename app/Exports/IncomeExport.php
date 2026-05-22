<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Support\Carbon;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomeExport implements FromCollection, WithHeadings
{
    protected $startDate;
    protected $endDate;
    protected $paymentMethod;

    public function __construct(
        $startDate = null,
        $endDate = null,
        $paymentMethod = null
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->paymentMethod = $paymentMethod;
    }

    public function collection()
    {
        $query = Income::with([
            'payment.booking'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($this->startDate && $this->endDate) {

            $query->whereBetween(
                'income_date',
                [
                    $this->startDate,
                    $this->endDate
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER PAYMENT METHOD
        |--------------------------------------------------------------------------
        */

        if ($this->paymentMethod) {

            $query->whereHas('payment', function ($q) {

                $q->where(
                    'payment_method',
                    $this->paymentMethod
                );
            });
        }

        return $query->get()->map(function ($item) {

            $payment = $item->payment;
            $booking = $payment?->booking;

            return [

                'Booking Code' =>
                $booking?->booking_code ?? '-',

                'Customer' =>
                $booking?->customer_name ?? '-',

                'Area' =>
                ucfirst($booking?->area ?? '-'),

                'Destination' =>
                $booking?->destination ?? '-',

                'Payment Method' =>
                strtoupper($payment?->payment_method ?? '-'),

                'Payment Status' =>
                strtoupper($payment?->status ?? '-'),

                'Amount' =>
                'Rp ' . number_format(
                    $item->amount,
                    0,
                    ',',
                    '.'
                ),

                'Income Type' =>
                ucfirst($item->income_type),

                'Description' =>
                $item->description ?? '-',

                'Booking Date' =>
                $booking?->pickup_date
                    ? Carbon::parse(
                        $booking->pickup_date
                    )->format('d-m-Y')
                    : '-',

                'Income Date' =>
                Carbon::parse(
                    $item->income_date
                )->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [

            'Booking Code',
            'Customer',
            'Area',
            'Destination',
            'Payment Method',
            'Payment Status',
            'Amount',
            'Income Type',
            'Description',
            'Booking Date',
            'Income Date',
        ];
    }
}
