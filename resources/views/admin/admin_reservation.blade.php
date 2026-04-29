@extends('Layouts.layout')

@section('content')

@php
// Simulasi data offers — nanti dari DB tabel offers
$offers = collect([
    (object)['id' => 1, 'name' => 'Basic Deal',     'tipe' => 'Standard', 'lantai' => 1, 'harga' => 200000, 'benefits' => ['No Breakfast', 'Free WiFi']],
    (object)['id' => 2, 'name' => 'Standard Plus',  'tipe' => 'Standard', 'lantai' => 1, 'harga' => 280000, 'benefits' => ['Breakfast', 'Free WiFi']],
    (object)['id' => 3, 'name' => 'Family Package',  'tipe' => 'Superior', 'lantai' => 2, 'harga' => 350000, 'benefits' => ['Breakfast', 'Free WiFi', 'Extra Bed']],
    (object)['id' => 4, 'name' => 'Business Stay',   'tipe' => 'Superior', 'lantai' => 2, 'harga' => 420000, 'benefits' => ['Breakfast', 'Free WiFi', 'Meeting Room']],
    (object)['id' => 5, 'name' => 'Luxury Stay',     'tipe' => 'Deluxe',   'lantai' => 3, 'harga' => 650000, 'benefits' => ['Breakfast', 'Spa', 'VIP Service']],
    (object)['id' => 6, 'name' => 'Honeymoon Suite', 'tipe' => 'Deluxe',   'lantai' => 3, 'harga' => 750000, 'benefits' => ['Breakfast', 'Spa', 'Flowers', 'Late Checkout']],
]);

$reservations = collect([
    (object)[
        'id' => 1,
        'user' => (object)['name' => 'Moonlight', 'email' => 'moon@gmail.com'],
        'offer' => (object)['name' => 'Basic Deal', 'harga' => 200000],
        'room' => (object)['nomor_kamar' => '01', 'lantai' => 1, 'tipe' => 'Standard'],
        'check_in' => '2026-04-20', 'check_out' => '2026-04-22', 'status' => 'confirmed'
    ],
    (object)[
        'id' => 2,
        'user' => (object)['name' => 'Sunshine', 'email' => 'shine@gmail.com'],
        'offer' => (object)['name' => 'Family Package', 'harga' => 350000],
        'room' => (object)['nomor_kamar' => null, 'lantai' => 2, 'tipe' => 'Superior'],
        'check_in' => '2026-04-25', 'check_out' => '2026-04-27', 'status' => 'pending'
    ],
    (object)[
        'id' => 3,
        'user' => (object)['name' => 'Facha', 'email' => 'chacha@gmail.com'],
        'offer' => (object)['name' => 'Luxury Stay', 'harga' => 650000],
        'room' => (object)['nomor_kamar' => null, 'lantai' => 3, 'tipe' => 'Deluxe'],
        'check_in' => '2026-04-28', 'check_out' => '2026-05-01', 'status' => 'canceled'
    ],
    (object)[
        'id' => 4,
        'user' => (object)['name' => 'Allysum', 'email' => 'ally@gmail.com'],
        'offer' => (object)['name' => 'Basic Deal', 'harga' => 200000],
        'room' => (object)['nomor_kamar' => '01', 'lantai' => 1, 'tipe' => 'Standard'],
        'check_in' => '2026-03-10', 'check_out' => '2026-03-13', 'status' => 'checked_out'
    ],
    (object)[
        'id' => 5,
        'user' => (object)['name' => 'Baobao', 'email' => 'baobao@gmail.com'],
        'offer' => (object)['name' => 'Business Stay', 'harga' => 420000],
        'room' => (object)['nomor_kamar' => '02', 'lantai' => 2, 'tipe' => 'Superior'],
        'check_in' => '2026-03-15', 'check_out' => '2026-03-17', 'status' => 'checked_out'
    ],
]);

$aktif   = $reservations->whereIn('status', ['pending', 'confirmed']);
$riwayat = $reservations->whereIn('status', ['checked_out', 'canceled']);

$income = $riwayat->where('status', 'checked_out')->sum(function($r) {
    $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
    return $nights * $r->offer->harga;
});
$lost = $riwayat->where('status', 'canceled')->sum(function($r) {
    $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
    return $nights * $r->offer->harga;
});
@endphp

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Reservations Management</h2>
        <p class="text-sm text-gray-400">Kelola reservasi hotel</p>
    </div>
    <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Reservasi
    </button>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Total Aktif</p>
        <p class="text-2xl font-semibold text-gray-800">{{ $aktif->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Confirmed
        </p>
        <p class="text-2xl font-semibold text-green-600">{{ $aktif->where('status','confirmed')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Pending
        </p>
        <p class="text-2xl font-semibold text-yellow-500">{{ $aktif->where('status','pending')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span> Total Riwayat
        </p>
        <p class="text-2xl font-semibold text-blue-500">{{ $riwayat->count() }}</p>
    </div>
</div>

{{-- TABS --}}
<div class="mb-4 border-b border-gray-200">
    <ul class="flex gap-1 text-sm font-medium">
        <li>
            <button onclick="switchTab('aktif')" id="tab-aktif"
                class="tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition">
                Aktif
                <span class="ml-1.5 bg-blue-100 text-blue-600 text-xs px-1.5 py-0.5 rounded-full">{{ $aktif->count() }}</span>
            </button>
        </li>
        <li>
            <button onclick="switchTab('riwayat')" id="tab-riwayat"
                class="tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition">
                Riwayat
                <span class="ml-1.5 bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">{{ $riwayat->count() }}</span>
            </button>
        </li>
    </ul>
</div>

{{-- TAB: AKTIF --}}
<div id="panel-aktif">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Offer</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">No. Kamar</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check In</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check Out</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="aktif-table-body" class="divide-y divide-gray-100">
                @forelse($aktif as $res)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-gray-400 text-xs font-medium">{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">{{ $res->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $res->user->email }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-gray-800 font-semibold">{{ $res->offer->name }}</p>
                        <p class="text-xs text-gray-400">{{ $res->room->tipe }} · Rp {{ number_format($res->offer->harga, 0, ',', '.') }}/malam</p>
                    </td>
                    <td class="px-6 py-4">
                        @if($res->room->nomor_kamar)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                Kamar {{ $res->room->nomor_kamar }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-orange-50 text-orange-600 border border-orange-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                                </svg>
                                Belum di-assign
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $res->check_in }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $res->check_out }}</td>
                    <td class="px-6 py-4">
                        @if($res->status == 'confirmed')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Confirmed
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Pending
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button
                                onclick="openEdit({{ $res->id }}, '{{ $res->user->name }}', '{{ $res->user->email }}', {{ $res->offer->id ?? 0 }}, '{{ $res->offer->name }}', 
                                '{{ $res->room->tipe }}', {{ $res->room->lantai }}, '{{ $res->room->nomor_kamar }}', '{{ $res->check_in }}', '{{ $res->check_out }}', '{{ $res->status }}')"
                                class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium">
                                Edit
                            </button>
                            <button
                                onclick="checkoutRow(this)"
                                class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition font-medium">
                                Check Out
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-10 text-center text-gray-400">Tidak ada reservasi aktif</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TAB: RIWAYAT --}}
<div id="panel-riwayat" class="hidden">
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Pemasukan Masuk
            </p>
            <p class="text-xl font-semibold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Potensi Hilang (Canceled)
            </p>
            <p class="text-xl font-semibold text-red-500">Rp {{ number_format($lost, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Offer & Kamar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check In</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check Out</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Total Bayar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $res)
                @php
                    $nights = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                    $total  = $nights * $res->offer->harga;
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 text-xs font-medium">#{{ $res->id }}</td>
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-800">{{ $res->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $res->user->email }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-gray-800 font-semibold">{{ $res->offer->name }}</p>
                        <p class="text-xs text-gray-400">Kamar {{ $res->room->nomor_kamar }} · {{ $res->room->tipe }} · Rp {{ number_format($res->offer->harga, 0, ',', '.') }}/malam</p>
                    </td>
                    <td class="px-4 py-3 text-gray-700 font-medium">{{ $res->check_in }}</td>
                    <td class="px-4 py-3">
                        <p class="text-gray-700 font-medium">{{ $res->check_out }}</p>
                        <p class="text-xs text-gray-400">{{ $nights }} malam</p>
                    </td>
                    <td class="px-4 py-3">
                        @if($res->status === 'canceled')
                            <span class="text-xs text-red-400 line-through">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @else
                            <span class="font-semibold text-green-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($res->status === 'checked_out')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Canceled
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-400">Belum ada riwayat reservasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <p class="text-xs text-gray-400 mt-3">* Pemasukan hanya dihitung dari reservasi berstatus <strong>Checked Out</strong>.</p>
</div>

{{-- MODAL TAMBAH --}}
<div id="modal-tambah" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Tambah Reservasi</h3>
                </div>
                <button type="button" data-modal-hide="modal-tambah"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">

                {{-- Data Tamu --}}
                <div class="pb-3 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Data Tamu</p>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                            <input id="f-name" type="text" placeholder="Masukkan nama tamu"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                            <input id="f-email" type="email" placeholder="email@contoh.com"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                {{-- Pilih Offer --}}
                <div class="pb-3 border-b border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Pilih Offer</p>
                    <div id="f-offer-list" class="space-y-2">
                        @foreach($offers as $offer)
                        <label class="flex items-start gap-3 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition offer-option"
                            data-offer-id="{{ $offer->id }}"
                            data-tipe="{{ $offer->tipe }}"
                            data-lantai="{{ $offer->lantai }}"
                            data-harga="{{ $offer->harga }}">
                            <input type="radio" name="f-offer" value="{{ $offer->id }}" class="mt-0.5 accent-blue-600">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-semibold text-gray-800">{{ $offer->name }}</p>
                                    <p class="text-sm font-bold text-blue-600">Rp {{ number_format($offer->harga, 0, ',', '.') }}<span class="text-xs font-normal text-gray-400">/malam</span></p>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $offer->tipe }} · Lantai {{ $offer->lantai }}</p>
                                <div class="flex flex-wrap gap-1 mt-1.5">
                                    @foreach($offer->benefits as $b)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $b }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Tanggal --}}
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tanggal Menginap</p>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check In</label>
                            <input id="f-checkin" type="date"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check Out</label>
                            <input id="f-checkout" type="date"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    {{-- Estimasi total --}}
                    <div id="f-estimasi" class="hidden mt-3 bg-blue-50 border border-blue-100 rounded-lg px-3 py-2.5">
                        <p class="text-xs text-blue-600">Estimasi total: <span id="f-estimasi-nilai" class="font-bold text-blue-700"></span></p>
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-yellow-700">Status awal: Pending</p>
                    <p class="text-xs text-yellow-600 mt-0.5">Nomor kamar akan di-assign saat konfirmasi.</p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="saveReservation()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan Reservasi
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modal-edit" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800" id="edit-modal-title">Edit Reservasi</h3>
                <button type="button" data-modal-hide="modal-edit"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <input id="e-name" type="text"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="e-email" type="email"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Offer info — readonly, tidak bisa diubah --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Offer</label>
                    <div id="e-offer-display"
                        class="w-full border border-blue-100 bg-blue-50 rounded-lg px-3 py-2 text-sm text-blue-700 font-medium">—</div>
                    <p class="text-xs text-gray-400 mt-1">Offer tidak dapat diubah setelah reservasi dibuat</p>
                </div>

                {{-- Assign nomor kamar — hanya muncul saat confirmed --}}
                <div id="e-room-assign-wrap">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Assign Nomor Kamar
                        <span class="ml-1 text-orange-500 font-normal">(wajib saat Confirmed)</span>
                    </label>
                    <select id="e-nomor-kamar"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih nomor kamar --</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Hanya kamar available sesuai tipe offer</p>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check In</label>
                        <input id="e-checkin" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check Out</label>
                        <input id="e-checkout" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-blue-700 mb-0.5">Penambahan Malam</p>
                    <p class="text-xs text-blue-500">Ubah tanggal Check Out untuk memperpanjang masa menginap tamu.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select id="e-status" onchange="toggleRoomAssign()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="saveEdit()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Simulasi kamar available per tipe — nanti dari DB
const availableRooms = {
    'Standard': ['01', '03', '05'],
    'Superior': ['02', '04'],
    'Deluxe':   ['01', '02'],
};

let currentEditId   = null;
let currentEditTipe = null;
let selectedOfferHarga = 0;

// ── TAB SWITCH ───────────────────────────────────────────
function switchTab(tab) {
    const isAktif = tab === 'aktif';
    document.getElementById('panel-aktif').classList.toggle('hidden', !isAktif);
    document.getElementById('panel-riwayat').classList.toggle('hidden', isAktif);
    document.getElementById('tab-aktif').className = isAktif
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
    document.getElementById('tab-riwayat').className = !isAktif
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
}

// ── ESTIMASI TOTAL ───────────────────────────────────────
function hitungEstimasi() {
    const checkin  = document.getElementById('f-checkin').value;
    const checkout = document.getElementById('f-checkout').value;
    const offer    = document.querySelector('input[name="f-offer"]:checked');

    if (!checkin || !checkout || !offer || checkout <= checkin) {
        document.getElementById('f-estimasi').classList.add('hidden');
        return;
    }

    const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
    const harga  = parseInt(offer.closest('label').dataset.harga);
    const total  = nights * harga;

    document.getElementById('f-estimasi-nilai').textContent =
        nights + ' malam × Rp ' + harga.toLocaleString('id-ID') + ' = Rp ' + total.toLocaleString('id-ID');
    document.getElementById('f-estimasi').classList.remove('hidden');
}

document.getElementById('f-checkin').addEventListener('change', hitungEstimasi);
document.getElementById('f-checkout').addEventListener('change', hitungEstimasi);
document.querySelectorAll('input[name="f-offer"]').forEach(r => r.addEventListener('change', hitungEstimasi));

// ── MODAL TAMBAH ─────────────────────────────────────────
function saveReservation() {
    const name     = document.getElementById('f-name').value.trim();
    const email    = document.getElementById('f-email').value.trim();
    const checkin  = document.getElementById('f-checkin').value;
    const checkout = document.getElementById('f-checkout').value;
    const offerEl  = document.querySelector('input[name="f-offer"]:checked');

    if (!name || !email || !offerEl || !checkin || !checkout) {
        alert('Harap lengkapi semua field dan pilih offer!'); return;
    }
    if (checkout <= checkin) {
        alert('Check Out harus setelah Check In!'); return;
    }

    const offerLabel = offerEl.closest('label');
    const offerName  = offerLabel.querySelector('p.font-semibold').textContent;
    const tipe       = offerLabel.dataset.tipe;
    const lantai     = offerLabel.dataset.lantai;
    const harga      = parseInt(offerLabel.dataset.harga);
    const tbody      = document.getElementById('aktif-table-body');
    const id         = tbody.querySelectorAll('tr').length + 1;

    const row = `
    <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 text-gray-400 text-xs font-medium">${String(id).padStart(3, '0')}</td>
        <td class="px-6 py-4">
            <p class="font-semibold text-gray-800">${name}</p>
            <p class="text-xs text-gray-400">${email}</p>
        </td>
        <td class="px-6 py-4">
            <p class="text-gray-800 font-semibold">${offerName}</p>
            <p class="text-xs text-gray-400">${tipe} · Rp ${harga.toLocaleString('id-ID')}/malam</p>
        </td>
        <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium bg-orange-50 text-orange-600 border border-orange-100">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/>
                </svg>
                Belum di-assign
            </span>
        </td>
        <td class="px-6 py-4 text-gray-700">${checkin}</td>
        <td class="px-6 py-4 text-gray-700">${checkout}</td>
        <td class="px-6 py-4">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Pending
            </span>
        </td>
        <td class="px-6 py-4">
            <div class="flex gap-2">
                <button onclick="openEdit(${id},'${name}','${email}',0,'${offerName}','${tipe}',${lantai},'','${checkin}','${checkout}','pending')"
                    class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium">Edit</button>
                <button onclick="checkoutRow(this)"
                    class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition font-medium">Check Out</button>
            </div>
        </td>
    </tr>`;

    tbody.insertAdjacentHTML('beforeend', row);

    document.getElementById('f-name').value  = '';
    document.getElementById('f-email').value = '';
    document.getElementById('f-checkin').value  = '';
    document.getElementById('f-checkout').value = '';
    document.querySelectorAll('input[name="f-offer"]').forEach(r => r.checked = false);
    document.getElementById('f-estimasi').classList.add('hidden');

    FlowbiteInstances.getInstance('Modal', 'modal-tambah')?.hide();
}

// ── MODAL EDIT ───────────────────────────────────────────
function openEdit(id, name, email, offerId, offerName, tipe, lantai, nomorKamar, checkin, checkout, status) {
    currentEditId   = id;
    currentEditTipe = tipe;

    document.getElementById('edit-modal-title').textContent = 'Edit Reservasi #' + id;
    document.getElementById('e-name').value     = name;
    document.getElementById('e-email').value    = email;
    document.getElementById('e-offer-display').textContent = offerName + ' (' + tipe + ' · Lt ' + lantai + ')';
    document.getElementById('e-checkin').value  = checkin;
    document.getElementById('e-checkout').value = checkout;
    document.getElementById('e-status').value   = status;

    // Populate dropdown kamar available sesuai tipe offer
    const rooms  = availableRooms[tipe] || [];
    const select = document.getElementById('e-nomor-kamar');
    select.innerHTML = '<option value="">-- Pilih nomor kamar --</option>';
    rooms.forEach(r => {
        const opt      = document.createElement('option');
        opt.value      = r;
        opt.textContent = 'Kamar ' + r + ' — Available';
        if (r === nomorKamar) opt.selected = true;
        select.appendChild(opt);
    });
    if (nomorKamar && !rooms.includes(nomorKamar)) {
        const opt      = document.createElement('option');
        opt.value      = nomorKamar;
        opt.textContent = 'Kamar ' + nomorKamar + ' — (sudah di-assign)';
        opt.selected   = true;
        select.appendChild(opt);
    }

    toggleRoomAssign();

    const modal = FlowbiteInstances.getInstance('Modal', 'modal-edit')
        ?? new Modal(document.getElementById('modal-edit'));
    modal.show();
}

function toggleRoomAssign() {
    const status = document.getElementById('e-status').value;
    document.getElementById('e-room-assign-wrap').style.display =
        status === 'confirmed' ? 'block' : 'none';
}

function saveEdit() {
    const checkin  = document.getElementById('e-checkin').value;
    const checkout = document.getElementById('e-checkout').value;
    const status   = document.getElementById('e-status').value;
    const kamar    = document.getElementById('e-nomor-kamar').value;

    if (checkout <= checkin) { alert('Check Out harus setelah Check In!'); return; }
    if (status === 'confirmed' && !kamar) {
        alert('Nomor kamar wajib di-assign saat status Confirmed!'); return;
    }

    alert('Reservasi #' + currentEditId + ' disimpan!' + (kamar ? '\nKamar: ' + kamar : ''));
    FlowbiteInstances.getInstance('Modal', 'modal-edit')?.hide();
}

// ── CHECK OUT ────────────────────────────────────────────
function checkoutRow(btn) {
    if (!confirm('Tandai tamu ini sebagai sudah Check Out?')) return;
    btn.closest('tr').remove();
}
</script>

@endsection