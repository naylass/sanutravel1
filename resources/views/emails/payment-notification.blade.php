<h3>💳 Pembayaran Masuk</h3>

<p>Ada pembayaran baru dari customer:</p>

<ul>
    <li><b>Kode Booking:</b> {{ $payment->booking->booking_code }}</li>
    <li><b>Nama:</b> {{ $payment->booking->user->name ?? '-' }}</li>
    <li><b>Metode:</b> {{ $payment->payment_method }}</li>
    <li><b>Total:</b> Rp {{ number_format($payment->amount,0,',','.') }}</li>
    <li><b>Status:</b> {{ $payment->status }}</li>
</ul>

@if($payment->proof_image)
<p>
    <a href="{{ asset('storage/'.$payment->proof_image) }}" target="_blank">
        Lihat Bukti Transfer
    </a>
</p>
@endif