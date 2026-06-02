<x-mail::message>
# Payment Invoice

Halo, **{{ $pembayaran->reservation->name }}**!

Pembayaran Anda telah **dikonfirmasi**. Berikut detail invoice Anda:

<x-mail::panel>
**No. Reservasi:** {{ $pembayaran->reservation->reservation_code }}
**Nama Tamu:** {{ $pembayaran->reservation->name }}
**Kamar:** {{ $pembayaran->reservation->room_name }}
**Check-in:** {{ \Carbon\Carbon::parse($pembayaran->reservation->check_in)->format('d M Y') }}
**Check-out:** {{ \Carbon\Carbon::parse($pembayaran->reservation->check_out)->format('d M Y') }}
**Metode Pembayaran:** {{ $pembayaran->payment_method }}
**Total Dibayar:** Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}
**Status:** ✅ Paid
</x-mail::panel>

Terima kasih telah melakukan reservasi. Kami menantikan kedatangan Anda!

Salam,
{{ config('app.name') }}
</x-mail::message>