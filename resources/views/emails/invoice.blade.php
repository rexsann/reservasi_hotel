<x-mail::message>
# Payment Invoice

Halo, **{{ $pembayaran->reservation->name }}**!

Pembayaran Anda telah **dikonfirmasi**. Berikut detail invoice Anda:

<x-mail::panel>
<br>**No. Reservasi:** {{ $pembayaran->reservation->reservation_code }}</br>
<br>**Nama Tamu:** {{ $pembayaran->reservation->name }}</br>
<br>**Kamar:** {{ $pembayaran->reservation->room_name }}</br>
<br>**Check-in:** {{ \Carbon\Carbon::parse($pembayaran->reservation->check_in)->format('d M Y') }}</br>
<br>**Check-out:** {{ \Carbon\Carbon::parse($pembayaran->reservation->check_out)->format('d M Y') }}</br>
<br>**Metode Pembayaran:** {{ $pembayaran->payment_method }}</br>
<br>**Total Dibayar:** Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</br>
<br>**Status:** ✅ Paid
</x-mail::panel>

Terima kasih telah melakukan reservasi. Kami menantikan kedatangan Anda!

Salam,
{{ config('app.name') }}
</x-mail::message>