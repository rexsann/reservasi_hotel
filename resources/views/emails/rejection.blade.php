@component('mail::message')
# Pemberitahuan Pembatalan Pembayaran

Halo, **{{ $pembayaran->reservation->name }}**,

Kami mohon maaf, pembayaran Anda untuk reservasi berikut **tidak dapat kami terima**:

| Keterangan | Detail |
|---|---|
| Kode Reservasi | {{ $pembayaran->reservation->reservation_code }} |
| Total Pembayaran | Rp {{ number_format($pembayaran->total_amount, 0, ',', '.') }} |

@if($alasan)
**Alasan Penolakan:**
{{ $alasan }}
@else
**Alasan Penolakan:** Pembayaran tidak sesuai atau tidak valid.
@endif

Jika Anda ingin melakukan reservasi ulang atau memiliki pertanyaan, silakan hubungi kami.

Mohon maaf atas ketidaknyamanannya.

Salam,
{{ config('app.name') }}
@endcomponent