<?php

namespace App\Exports;

use App\Models\Income;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncomeExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Income::with('payment.booking')->get()->map(function ($item) {
            return [
                'Booking Code' => $item->payment?->booking?->booking_code ?? '-',
                'Amount' => $item->amount,
                'Type' => $item->income_type,
                'Description' => $item->description,
                'Date' => $item->income_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Booking Code',
            'Amount',
            'Type',
            'Description',
            'Date',
        ];
    }
}