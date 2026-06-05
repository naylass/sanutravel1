<?php

namespace App\Exports;

use App\Models\Income;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class IncomeExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle,
    WithEvents,
    WithCustomStartCell
{
    protected $startDate;
    protected $endDate;
    protected $paymentMethod;
    protected int   $dataCount   = 0;
    protected float $totalAmount = 0;
    protected int   $lastDataRow = 0;
    protected int   $totalRow    = 0;

    protected int $startRow = 5;

    public function __construct(
        $startDate     = null,
        $endDate       = null,
        $paymentMethod = null
    ) {
        $this->startDate     = $startDate;
        $this->endDate       = $endDate;
        $this->paymentMethod = $paymentMethod;
    }

    public function startCell(): string
    {
        return 'A' . $this->startRow;
    }

    public function collection()
    {
        $query = Income::with(['payment.booking']);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('income_date', [
                $this->startDate,
                $this->endDate,
            ]);
        }

        if ($this->paymentMethod) {
            $query->whereHas('payment', function ($q) {
                $q->where('payment_method', $this->paymentMethod);
            });
        }

        $results = $query->orderBy('income_date', 'desc')->get();

        $this->dataCount   = $results->count();
        $this->totalAmount = $results->sum('amount');

        // +1 heading row (row startRow), data mulai startRow+1
        $this->lastDataRow = $this->startRow + $this->dataCount;
        $this->totalRow    = $this->startRow + $this->dataCount + 1;

        $no = 1;
        return $results->map(function ($item) use (&$no) {
            $payment = $item->payment;
            $booking = $payment?->booking;

            return [
                'no'             => $no++,
                'booking_code'   => $booking?->booking_code ?? '-',
                'customer'       => $booking?->customer_name ?? '-',
                'area'           => ucfirst($booking?->area ?? '-'),
                'destination'    => $booking?->destination ?? '-',
                'payment_method' => strtoupper($payment?->payment_method ?? '-'),
                'payment_status' => match ($payment?->status) {
                    'verified'      => 'Verified',
                    'settled'       => 'Settled',
                    'cash_received' => 'Cash Diterima',
                    default         => ucfirst($payment?->status ?? '-'),
                },
                'amount'         => (float) $item->amount,
                'description'    => $item->description ?? '-',
                'booking_date'   => $booking?->pickup_date
                    ? Carbon::parse($booking->pickup_date)->format('d-m-Y')
                    : '-',
                'income_date'    => Carbon::parse($item->income_date)->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Booking Code',
            'Customer',
            'Area',
            'Tujuan',
            'Metode',
            'Status',
            'Amount (IDR)',
            'Deskripsi',
            'Tgl Booking',
            'Tgl Income',
        ];
    }

    public function title(): string
    {
        return 'Laporan Income';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 18,  // Booking Code
            'C' => 24,  // Customer
            'D' => 14,  // Area
            'E' => 28,  // Tujuan
            'F' => 14,  // Metode
            'G' => 16,  // Status
            'H' => 22,  // Amount
            'I' => 40,  // Deskripsi
            'J' => 14,  // Tgl Booking
            'K' => 14,  // Tgl Income
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastData = $this->lastDataRow;
        $totalRow = $this->totalRow;
        $headRow  = $this->startRow;
        $sheet->getStyle("A{$headRow}:K{$headRow}")->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1A6B42'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getRowDimension($headRow)->setRowHeight(24);

        $dataStart = $headRow + 1;
        for ($row = $dataStart; $row <= $lastData; $row++) {
            $color = ($row % 2 === 0) ? 'EDF7F2' : 'FFFFFF';
            $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'font' => ['size' => 10],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(18);
        }

        $sheet->getStyle("A{$dataStart}:A{$lastData}")->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->getStyle("H{$dataStart}:H{$lastData}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle("H{$dataStart}:H{$lastData}")->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        $sheet->mergeCells("A{$totalRow}:G{$totalRow}");
        $sheet->setCellValue("A{$totalRow}", 'TOTAL INCOME');
        $sheet->setCellValue("H{$totalRow}", $this->totalAmount);

        $sheet->getStyle("A{$totalRow}:K{$totalRow}")->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size'  => 11,
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '1A6B42'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle("H{$totalRow}")
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        $sheet->getStyle("H{$totalRow}")->applyFromArray([
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
        ]);

        $sheet->getRowDimension($totalRow)->setRowHeight(22);

        $sheet->getStyle("A{$headRow}:K{$totalRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['rgb' => 'C5D9CE'],
                ],
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color'       => ['rgb' => '1A6B42'],
                ],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet    = $event->sheet->getDelegate();
                $totalRow = $this->totalRow;
                $infoRow  = $totalRow + 2;
                $infoRow1 = $infoRow + 1;
                $infoRow2 = $infoRow + 2;
                $infoRow3 = $infoRow + 3;

               
                $sheet->mergeCells('A1:K1');
                $sheet->setCellValue('A1', 'LAPORAN INCOME');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold'  => true,
                        'size'  => 16,
                        'color' => ['rgb' => '1A6B42'],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                $sheet->mergeCells('A2:K2');
                $sheet->setCellValue('A2', 'Sanu Travel — Sistem Manajemen Keuangan');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => [
                        'size'   => 11,
                        'italic' => true,
                        'color'  => ['rgb' => '6B7280'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(18);

                $periode = ($this->startDate && $this->endDate)
                    ? Carbon::parse($this->startDate)->format('d M Y') .
                    ' s/d ' .
                    Carbon::parse($this->endDate)->format('d M Y')
                    : 'Semua Periode';

                $metode = $this->paymentMethod
                    ? strtoupper($this->paymentMethod)
                    : 'Semua Metode';

                $sheet->mergeCells('A3:K3');
                $sheet->setCellValue(
                    'A3',
                    "Periode: {$periode}   |   Metode: {$metode}   |   " .
                        "Total Transaksi: {$this->dataCount}   |   " .
                        "Diekspor: " . Carbon::now('Asia/Jakarta')->format('d M Y, H:i') . ' WIB'
                );
                $sheet->getStyle('A3')->applyFromArray([
                    'font' => [
                        'size'   => 10,
                        'color'  => ['rgb' => '374151'],
                    ],
                    'fill' => [
                        'fillType'   => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D1FAE5'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $sheet->getRowDimension(3)->setRowHeight(18);
                $sheet->getRowDimension(4)->setRowHeight(6);
                $sheet->mergeCells("A{$infoRow}:K{$infoRow}");
                $sheet->setCellValue(
                    "A{$infoRow}",
                    "* Dokumen ini digenerate otomatis oleh sistem Sanu Travel"
                );
                $sheet->getStyle("A{$infoRow}")->applyFromArray([
                    'font' => [
                        'italic' => true,
                        'size'   => 9,
                        'color'  => ['rgb' => '9CA3AF'],
                    ],
                ]);

                $freezeRow = $this->startRow + 1;
                $sheet->freezePane("A{$freezeRow}");

                $headRow = $this->startRow;
                $sheet->setAutoFilter("A{$headRow}:K{$headRow}");
            },
        ];
    }
}
