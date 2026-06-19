@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
@php
    $rooms      = $data->rooms_detail;
    $isMulti    = $rooms->count() > 1;
    $nights     = \Carbon\Carbon::parse($data->check_in)->diffInDays($data->check_out);
    $totalPrice = $rooms->sum(fn($r) => ($r->offer?->price ?? 0) * \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out));

    $badgeClass = match($data->status) {
        'Confirmed'             => 'bg-green-100 text-green-700',
        'Checked In'            => 'bg-blue-100 text-blue-700',
        'Checked Out'           => 'bg-gray-100 text-gray-600',
        'Cancelled'             => 'bg-red-100 text-red-700',
        'Waiting Verification'  => 'bg-purple-100 text-purple-700',
        default                 => 'bg-yellow-100 text-yellow-700',
    };

    $bannerClass = match($data->status) {
        'Confirmed', 'Checked In' => 'bg-blue-50 border-blue-200 text-blue-700',
        'Cancelled'               => 'bg-red-50 border-red-200 text-red-700',
        'Checked Out'             => 'bg-green-50 border-green-200 text-green-700',
        default                   => 'bg-yellow-50 border-yellow-200 text-yellow-700',
    };

    $bannerMsg = match($data->status) {
        'Confirmed'            => 'Reservasi Anda telah dikonfirmasi. Silakan datang sesuai jadwal check-in.',
        'Checked In'           => 'Anda sedang menginap. Selamat beristirahat!',
        'Checked Out'          => 'Terima kasih telah menginap bersama kami. Sampai jumpa kembali!',
        'Cancelled'            => 'Reservasi Anda telah dibatalkan.',
        'Waiting Verification' => 'Pembayaran Anda sedang diverifikasi oleh tim kami.',
        default                => 'Reservasi Anda sedang diproses.',
    };
@endphp

<div class="pt-32 px-4 max-w-3xl mx-auto pb-20 space-y-5">

    {{-- HEADER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-xs text-gray-400 mb-1">Kode Booking</p>
                <h1 class="text-2xl font-bold text-gray-800 tracking-wide">{{ $data->reservation_code }}</h1>
                <p class="text-xs text-gray-400 mt-1">
                    Dibuat {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}
                </p>
            </div>
            <span class="px-3 py-1.5 text-xs font-semibold rounded-full {{ $badgeClass }}">
                {{ $data->status }}
            </span>
        </div>

        <div class="border border-dashed {{ str_replace('bg-', 'border-', explode(' ', $bannerClass)[0]) }} rounded-xl p-4 {{ $bannerClass }} text-sm">
            {{ $bannerMsg }}
        </div>
    </div>

    {{-- DATA TAMU + TANGGAL --}}
    <div class="grid md:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
                Data Tamu
            </h2>
            <div class="space-y-3 text-sm">
                <div>
                    <p class="text-xs text-gray-400">Nama</p>
                    <p class="font-medium text-gray-800">{{ $data->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Email</p>
                    <p class="font-medium text-gray-800">{{ $data->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">Jumlah Tamu</p>
                    <p class="font-medium text-gray-800">{{ $data->guest_total }} Orang</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
                Jadwal Menginap
            </h2>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400">Check-in</span>
                    <span class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($data->check_in)->format('d M Y') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Check-out</span>
                    <span class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($data->check_out)->format('d M Y') }}
                    </span>
                </div>
                <div class="flex justify-between border-t pt-3">
                    <span class="text-gray-400">Durasi</span>
                    <span class="font-semibold text-blue-600">{{ $nights }} Malam</span>
                </div>
                @if($data->checked_in_at)
                <div class="flex justify-between">
                    <span class="text-gray-400">Waktu Check-in</span>
                    <span class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($data->checked_in_at)->format('d M Y, H:i') }}
                    </span>
                </div>
                @endif
                @if($data->checked_out_at)
                <div class="flex justify-between">
                    <span class="text-gray-400">Waktu Check-out</span>
                    <span class="font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($data->checked_out_at)->format('d M Y, H:i') }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- DETAIL KAMAR --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4 flex items-center gap-2">
            <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
            Detail Kamar
            @if($isMulti)
                <span class="ml-1 text-xs font-semibold bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">
                    {{ $rooms->count() }} Kamar
                </span>
            @endif
        </h2>

        <div class="space-y-3">
            @foreach($rooms as $i => $room)
            @php
                $roomNights   = \Carbon\Carbon::parse($room->check_in)->diffInDays($room->check_out);
                $roomPrice    = $room->offer?->price ?? 0;
                $roomSubtotal = $roomPrice * $roomNights;
            @endphp
            <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-sm">
                @if($isMulti)
                <p class="text-xs font-semibold text-blue-600 mb-3">Kamar {{ $i + 1 }}</p>
                @endif
                <div class="grid grid-cols-2 gap-y-2.5">
                    <span class="text-gray-400">Tipe Kamar</span>
                    <span class="font-medium text-gray-800 text-right">{{ $room->roomType?->name ?? '—' }}</span>

                    <span class="text-gray-400">Nomor Kamar</span>
                    <span class="font-medium text-gray-800 text-right">{{ $room->room_name ?? '—' }}</span>

                    <span class="text-gray-400">Penawaran</span>
                    <span class="font-medium text-gray-800 text-right">{{ $room->offer?->name ?? '—' }}</span>

                    <span class="text-gray-400">Harga / Malam</span>
                    <span class="font-medium text-gray-800 text-right">Rp {{ number_format($roomPrice, 0, ',', '.') }}</span>

                    @if($isMulti)
                    <span class="text-gray-400 border-t pt-2">Subtotal ({{ $roomNights }} malam)</span>
                    <span class="font-semibold text-gray-800 text-right border-t pt-2">
                        Rp {{ number_format($roomSubtotal, 0, ',', '.') }}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- RINGKASAN PEMBAYARAN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-3">
        <h2 class="text-sm font-semibold text-gray-700 flex items-center gap-2">
            <span class="w-1 h-4 bg-blue-500 rounded-full inline-block"></span>
            Ringkasan Pembayaran
        </h2>

        @if($isMulti)
            @foreach($rooms as $i => $room)
            @php
                $roomNights   = \Carbon\Carbon::parse($room->check_in)->diffInDays($room->check_out);
                $roomSubtotal = ($room->offer?->price ?? 0) * $roomNights;
            @endphp
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Kamar {{ $i + 1 }} ({{ $room->roomType?->name ?? '—' }}) × {{ $roomNights }} malam</span>
                <span class="text-gray-700">Rp {{ number_format($roomSubtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach
            <div class="border-t pt-3 flex justify-between text-sm">
                <span class="text-gray-400">{{ $rooms->count() }} kamar</span>
                <span class="text-gray-700">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
        @else
            @php
                $roomNights = \Carbon\Carbon::parse($rooms->first()->check_in)->diffInDays($rooms->first()->check_out);
            @endphp
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">{{ $roomNights }} malam</span>
                <span class="text-gray-700">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
            </div>
        @endif

        @if($data->paid_at)
        <div class="flex justify-between text-sm">
            <span class="text-gray-400">Dibayar Pada</span>
            <span class="text-gray-700">{{ \Carbon\Carbon::parse($data->paid_at)->format('d M Y, H:i') }}</span>
        </div>
        @endif

        <div class="border-t pt-3 flex justify-between font-bold text-base">
            <span class="text-gray-800">Total</span>
            <span class="text-blue-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>

        <div class="pt-2 space-y-2">
            <a href="{{ route('reservation.invoice', ['code' => $data->reservation_code, 'email' => $data->email]) }}"
                target="_blank"
                class="flex items-center justify-center gap-2 w-full bg-gray-800 hover:bg-black text-white py-2.5 rounded-xl transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                Download Invoice
            </a>
        </div>
    </div>

</div>
@endsection