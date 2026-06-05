<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Booking;
use App\Mail\PaymentVerifiedMail;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentSettledMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    /*
    |----------------------------------------------------------
    | VERIFY — untuk QRIS & Transfer
    |----------------------------------------------------------
    */
    public static function verify(Payment $payment): void
    {
        $booking = $payment->booking;

        $payment->update([
            'status'      => 'verified',
            'verified_at' => now('Asia/Jakarta'),
        ]);

        $booking->update(['status' => 'confirmed']);

        // Generate PDF
        $pdfPath = self::generateReceipt($booking, $payment);
        $pdfPublicUrl = url('storage/receipts/receipt-' . $booking->booking_code . '.pdf');

        // Email customer + PDF
        try {
            if (!empty($booking->email)) {
                Mail::to($booking->email)
                    ->send(new PaymentVerifiedMail($payment, $pdfPath));
            }
        } catch (\Exception $e) {
            logger('EMAIL VERIFY ERROR: ' . $e->getMessage());
        }

        // WA customer — teks
        try {
            WhatsappService::send(
                $booking->phone_number,
                "✅ PEMBAYARAN BERHASIL DIVERIFIKASI\n\n" .
                "Halo {$booking->customer_name},\n\n" .
                "Pembayaran Anda telah diverifikasi oleh admin.\n\n" .
                "📌 Kode Booking: {$booking->booking_code}\n" .
                "💰 Total: Rp " . number_format($payment->amount, 0, ',', '.') . "\n" .
                "💳 Metode: " . strtoupper($payment->payment_method) . "\n" .
                "📍 Status: BOOKING DIKONFIRMASI\n\n" .
                "Terima kasih telah menggunakan Sanu Travel 🚐"
            );
        } catch (\Exception $e) {
            logger('WA VERIFY ERROR: ' . $e->getMessage());
        }

        // WA customer — PDF
        try {
            WhatsappService::sendDocument(
                $booking->phone_number,
                $pdfPublicUrl,
                "📄 RECEIPT PEMBAYARAN\n\nKode Booking: {$booking->booking_code}"
            );
        } catch (\Exception $e) {
            logger('WA PDF VERIFY ERROR: ' . $e->getMessage());
        }

        // WA admin
        try {
            WhatsappService::send(
                '6287764868369',
                "✅ PEMBAYARAN VERIFIED\n\n" .
                "Kode: {$booking->booking_code}\n" .
                "Customer: {$booking->customer_name}\n" .
                "Metode: " . strtoupper($payment->payment_method) . "\n" .
                "Total: Rp " . number_format($payment->amount, 0, ',', '.')
            );
        } catch (\Exception $e) {
            logger('WA ADMIN VERIFY ERROR: ' . $e->getMessage());
        }
    }

    /*
    |----------------------------------------------------------
    | REJECT — untuk QRIS & Transfer
    |----------------------------------------------------------
    */
    public static function reject(Payment $payment): void
    {
        $booking = $payment->booking;

        $payment->update(['status' => 'rejected']);
        $booking->update(['status' => 'pending']);

        // Email customer
        try {
            if (!empty($booking->email)) {
                Mail::to($booking->email)
                    ->send(new PaymentRejectedMail($payment));
            }
        } catch (\Exception $e) {
            logger('EMAIL REJECT ERROR: ' . $e->getMessage());
        }

        // WA customer
        try {
            WhatsappService::send(
                $booking->phone_number,
                "❌ PEMBAYARAN DITOLAK\n\n" .
                "Halo {$booking->customer_name},\n\n" .
                "Pembayaran Anda ditolak oleh admin.\n\n" .
                "📌 Kode Booking: {$booking->booking_code}\n\n" .
                "Silakan upload ulang bukti pembayaran.\n\n" .
                "Terima kasih 🚐"
            );
        } catch (\Exception $e) {
            logger('WA REJECT ERROR: ' . $e->getMessage());
        }

        // WA admin
        try {
            WhatsappService::send(
                '6287764868369',
                "❌ PEMBAYARAN DITOLAK\n\n" .
                "Kode: {$booking->booking_code}\n" .
                "Customer: {$booking->customer_name}\n" .
                "Status: REJECTED"
            );
        } catch (\Exception $e) {
            logger('WA ADMIN REJECT ERROR: ' . $e->getMessage());
        }
    }

    /*
    |----------------------------------------------------------
    | SETTLE — untuk Cash
    |----------------------------------------------------------
    */
    public static function settle(Payment $payment): void
    {
        $booking = $payment->booking;

        $payment->update([
            'status'              => 'settled',
            'verified_at'         => $payment->verified_at ?? now('Asia/Jakarta'),
            'paid_at'             => $payment->paid_at ?? now('Asia/Jakarta'),
            'settled_to_admin_at' => now('Asia/Jakarta'),
        ]);

        $booking->update(['status' => 'completed']);

        // Generate PDF (reuse jika sudah ada)
        $pdfPath      = self::generateReceipt($booking, $payment);
        $pdfPublicUrl = url('storage/receipts/receipt-' . $booking->booking_code . '.pdf');

        // Email customer + PDF
        try {
            if (!empty($booking->email)) {
                Mail::to($booking->email)
                    ->send(new PaymentSettledMail($payment, $pdfPath));
            }
        } catch (\Exception $e) {
            logger('EMAIL SETTLED ERROR: ' . $e->getMessage());
        }

        // WA customer — teks
        try {
            WhatsappService::send(
                $booking->phone_number,
                "✅ PEMBAYARAN SELESAI\n\n" .
                "Halo {$booking->customer_name},\n\n" .
                "Pembayaran cash Anda telah selesai diproses admin.\n\n" .
                "📌 Kode Booking: {$booking->booking_code}\n" .
                "💰 Total: Rp " . number_format($payment->amount, 0, ',', '.') . "\n" .
                "💳 Metode: CASH\n" .
                "📍 Status: SELESAI\n\n" .
                "Terima kasih telah menggunakan Sanu Travel 🚐"
            );
        } catch (\Exception $e) {
            logger('WA SETTLED ERROR: ' . $e->getMessage());
        }

        // WA customer — PDF receipt
        try {
            WhatsappService::sendDocument(
                $booking->phone_number,
                $pdfPublicUrl,
                "📄 RECEIPT PEMBAYARAN SELESAI\n\nKode Booking: {$booking->booking_code}"
            );
        } catch (\Exception $e) {
            logger('WA PDF SETTLED ERROR: ' . $e->getMessage());
        }

        // WA admin
        try {
            WhatsappService::send(
                '6287764868369',
                "✅ PEMBAYARAN SETTLED\n\n" .
                "Kode: {$booking->booking_code}\n" .
                "Customer: {$booking->customer_name}\n" .
                "Metode: CASH\n" .
                "Total: Rp " . number_format($payment->amount, 0, ',', '.')
            );
        } catch (\Exception $e) {
            logger('WA ADMIN SETTLED ERROR: ' . $e->getMessage());
        }
    }

    /*
    |----------------------------------------------------------
    | HELPER — Generate PDF Receipt
    |----------------------------------------------------------
    */
    private static function generateReceipt(
        Booking $booking,
        Payment $payment
    ): string {
        $pdfName = 'receipt-' . $booking->booking_code . '.pdf';
        $folder  = storage_path('app/public/receipts');
        $pdfPath = $folder . '/' . $pdfName;

        if (!file_exists($pdfPath)) {
            $pdf = Pdf::loadView(
                'pdf.payment-receipt',
                compact('booking', 'payment')
            );
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            file_put_contents($pdfPath, $pdf->output());
        }

        return $pdfPath;
    }
}