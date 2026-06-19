<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $data->reservation_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #1f2937;
            background: #f9fafb;
        }

        .page {
            max-width: 720px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        /* HEADER */
        .header {
            background: #1e3a5f;
            color: white;
            padding: 32px 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .hotel-name { font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .hotel-sub  { font-size: 12px; color: #93c5fd; margin-top: 4px; }
        .invoice-label { text-align: right; }
        .invoice-label p:first-child { font-size: 11px; color: #93c5fd; text-transform: uppercase; letter-spacing: 1px; }
        .invoice-label h2 { font-size: 20px; font-weight: 700; margin-top: 2px; }
        .invoice-label .date { font-size: 11px; color: #93c5fd; margin-top: 4px; }

        /* STATUS STRIP */
        .status-strip {
            padding: 10px 40px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-strip.confirmed    { background: #ecfdf5; color: #065f46; }
        .status-strip.checked-in   { background: #eff6ff; color: #1e40af; }
        .status-strip.checked-out  { background: #f0fdf4; color: #166534; }
        .status-strip.cancelled    { background: #fef2f2; color: #991b1b; }
        .status-strip.pending      { background: #fffbeb; color: #92400e; }
        .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .dot.green  { background: #10b981; }
        .dot.blue   { background: #3b82f6; }
        .dot.red    { background: #ef4444; }
        .dot.yellow { background: #f59e0b; }

        /* BODY */
        .body { padding: 32px 40px; }

        /* TWO COLS */
        .two-cols { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .info-row .label { color: #6b7280; }
        .info-row .value { font-weight: 500; text-align: right; }

        /* ROOMS TABLE */
        .rooms-section { margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1e3a5f; color: white; }
        thead th { padding: 10px 12px; text-align: left; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; }
        thead th:last-child { text-align: right; }
        tbody tr { border-bottom: 1px solid #f3f4f6; }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 10px 12px; font-size: 13px; }
        tbody td:last-child { text-align: right; font-weight: 600; }
        tbody tr:nth-child(even) { background: #f9fafb; }

        /* TOTAL */
        .total-section {
            background: #f9fafb;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13px; }
        .total-row.final {
            border-top: 2px solid #e5e7eb;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 15px;
            font-weight: 700;
            color: #1e3a5f;
        }

        /* FOOTER */
        .footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            color: #9ca3af;
        }

        /* PRINT BUTTON */
        .print-bar {
            max-width: 720px;
            margin: 0 auto 16px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }
        .print-bar button {
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-print  { background: #1e3a5f; color: white; }
        .btn-back   { background: #e5e7eb; color: #374151; }

        @media print {
            body { background: white; }
            .page { margin: 0; border-radius: 0; box-shadow: none; }
            .print-bar { display: none; }
        }
    </style>
</head>
<body>
@php
    $rooms      = $data->rooms_detail;
    $isMulti    = $rooms->count() > 1;
    $nights     = \Carbon\Carbon::parse($data->check_in)->diffInDays($data->check_out);
    $totalPrice = $rooms->sum('total_price');

    $statusClass = match($data->status) {
        'Confirmed'            => 'confirmed',
        'Checked In'           => 'checked-in',
        'Checked Out'          => 'checked-out',
        'Cancelled'            => 'cancelled',
        default                => 'pending',
    };
    $dotClass = match($data->status) {
        'Confirmed', 'Checked Out' => 'green',
        'Checked In'               => 'blue',
        'Cancelled'                => 'red',
        default                    => 'yellow',
    };
@endphp

<div class="print-bar">
    <button class="btn-back" onclick="window.close()">← Kembali</button>
    <button class="btn-print" onclick="window.print()">🖨 Print / Download PDF</button>
</div>

<div class="page">

    {{-- HEADER --}}
    <div class="header">
        <div>
            <div class="hotel-name">{{ config('app.name', 'Hotel') }}</div>
            <div class="hotel-sub">Reservation Invoice</div>
        </div>
        <div class="invoice-label">
            <p>Invoice</p>
            <h2>{{ $data->reservation_code }}</h2>
            <p class="date">{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
        </div>
    </div>

    {{-- STATUS STRIP --}}
    <div class="status-strip {{ $statusClass }}">
        <span class="dot {{ $dotClass }}"></span>
        Status: {{ $data->status }}
        @if($data->paid_at)
            &nbsp;·&nbsp; Dibayar: {{ \Carbon\Carbon::parse($data->paid_at)->format('d M Y, H:i') }}
        @endif
    </div>

    <div class="body">

        {{-- TAMU + JADWAL --}}
        <div class="two-cols">
            <div>
                <div class="section-title">Data Tamu</div>
                <div class="info-row"><span class="label">Nama</span><span class="value">{{ $data->name }}</span></div>
                <div class="info-row"><span class="label">Email</span><span class="value">{{ $data->email }}</span></div>
                <div class="info-row"><span class="label">Jumlah Tamu</span><span class="value">{{ $data->guest_total }} Orang</span></div>
            </div>
            <div>
                <div class="section-title">Jadwal Menginap</div>
                <div class="info-row">
                    <span class="label">Check-in</span>
                    <span class="value">{{ \Carbon\Carbon::parse($data->check_in)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Check-out</span>
                    <span class="value">{{ \Carbon\Carbon::parse($data->check_out)->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Durasi</span>
                    <span class="value">{{ $nights }} Malam</span>
                </div>
                @if($data->checked_in_at)
                <div class="info-row">
                    <span class="label">Waktu Check-in</span>
                    <span class="value">{{ \Carbon\Carbon::parse($data->checked_in_at)->format('d M Y, H:i') }}</span>
                </div>
                @endif
                @if($data->checked_out_at)
                <div class="info-row">
                    <span class="label">Waktu Check-out</span>
                    <span class="value">{{ \Carbon\Carbon::parse($data->checked_out_at)->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- TABEL KAMAR --}}
        <div class="rooms-section">
            <div class="section-title">Detail Kamar</div>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipe Kamar</th>
                        <th>Nomor Kamar</th>
                        <th>Penawaran</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $i => $room)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $room->roomType?->name ?? '—' }}</td>
                        <td>{{ $room->room_name ?? '—' }}</td>
                        <td>{{ $room->offer?->name ?? '—' }}</td>
                        <td>Rp {{ number_format($room->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- TOTAL --}}
        <div class="total-section">
            @if($isMulti)
                @foreach($rooms as $i => $room)
                <div class="total-row">
                    <span>Kamar {{ $i + 1 }} — {{ $room->roomType?->name ?? '—' }}</span>
                    <span>Rp {{ number_format($room->total_price, 0, ',', '.') }}</span>
                </div>
                @endforeach
            @else
                <div class="total-row">
                    <span>{{ $nights }} malam</span>
                    <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                </div>
            @endif

            @if($data->paid_at)
            <div class="total-row">
                <span style="color:#6b7280">Dibayar pada {{ \Carbon\Carbon::parse($data->paid_at)->format('d M Y, H:i') }}</span>
                <span style="color:#10b981; font-weight:600">✓ Lunas</span>
            </div>
            @endif

            <div class="total-row final">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- CATATAN --}}
        <p style="font-size:11px; color:#9ca3af; text-align:center; margin-top: -8px;">
            Invoice ini diterbitkan secara otomatis dan sah tanpa tanda tangan.
        </p>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <span>{{ config('app.name', 'Hotel') }} &copy; {{ date('Y') }}</span>
        <span>Dicetak: {{ now()->format('d M Y, H:i') }}</span>
    </div>

</div>
</body>
</html>