@extends('Layouts.layout')

@section('content')

@php
    // ── DATA RESERVASI (sama persis dengan reservations.blade.php) ──
    $reservations = collect([
        (object)[
            'id' => 1,
            'user' => (object)['name' => 'Moonlight', 'email' => 'moon@gmail.com'],
            'items' => [
                (object)['offer' => (object)['id'=>2,'name'=>'Breakfast Package','harga'=>350000], 'room' => (object)['nomor_kamar'=>'01','lantai'=>1,'tipe'=>'Standard']],
            ],
            'check_in'  => '2026-04-20',
            'check_out' => '2026-04-22',
            'status'    => 'confirmed',
        ],
        (object)[
            'id' => 2,
            'user' => (object)['name' => 'Sunshine', 'email' => 'shine@gmail.com'],
            'items' => [
                (object)['offer' => (object)['id'=>5,'name'=>'Family Package','harga'=>600000], 'room' => (object)['nomor_kamar'=>null,'lantai'=>2,'tipe'=>'Superior']],
                (object)['offer' => (object)['id'=>1,'name'=>'Room Only','harga'=>300000],      'room' => (object)['nomor_kamar'=>null,'lantai'=>1,'tipe'=>'Standard']],
            ],
            'check_in'  => '2026-04-25',
            'check_out' => '2026-04-27',
            'status'    => 'pending',
        ],
        (object)[
            'id' => 3,
            'user' => (object)['name' => 'Facha', 'email' => 'chacha@gmail.com'],
            'items' => [
                (object)['offer' => (object)['id'=>9,'name'=>'VIP Experience','harga'=>1100000], 'room' => (object)['nomor_kamar'=>null,'lantai'=>3,'tipe'=>'Deluxe']],
            ],
            'check_in'  => '2026-04-28',
            'check_out' => '2026-05-01',
            'status'    => 'canceled',
        ],
        (object)[
            'id' => 4,
            'user' => (object)['name' => 'Allysum', 'email' => 'ally@gmail.com'],
            'items' => [
                (object)['offer' => (object)['id'=>3,'name'=>'Staycation Deal','harga'=>400000], 'room' => (object)['nomor_kamar'=>'03','lantai'=>1,'tipe'=>'Standard']],
            ],
            'check_in'  => '2026-03-10',
            'check_out' => '2026-03-13',
            'status'    => 'checked_out',
        ],
        (object)[
            'id' => 5,
            'user' => (object)['name' => 'Baobao', 'email' => 'baobao@gmail.com'],
            'items' => [
                (object)['offer' => (object)['id'=>4,'name'=>'Business Stay','harga'=>500000], 'room' => (object)['nomor_kamar'=>'02','lantai'=>2,'tipe'=>'Superior']],
                (object)['offer' => (object)['id'=>7,'name'=>'Luxury Stay','harga'=>750000],  'room' => (object)['nomor_kamar'=>'01','lantai'=>3,'tipe'=>'Deluxe']],
            ],
            'check_in'  => '2026-03-15',
            'check_out' => '2026-03-17',
            'status'    => 'checked_out',
        ],
    ]);

    $aktif     = $reservations->whereIn('status', ['pending', 'confirmed']);
    $riwayat   = $reservations->whereIn('status', ['checked_out', 'canceled']);
    $confirmed = $reservations->where('status', 'confirmed');
    $pending   = $reservations->where('status', 'pending');

    // Total income dari checked_out
    $income = $riwayat->where('status', 'checked_out')->sum(function($r) {
        $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
        return $nights * collect($r->items)->sum(fn($i) => $i->offer->harga);
    });

    // Latest 5 reservasi (semua status, terbaru duluan)
    $latest = $reservations->sortByDesc('id')->take(5);
@endphp

{{-- PAGE TITLE --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-sm text-gray-400 mt-1">Overview hotel Stayzy</p>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-5 rounded-2xl shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm opacity-80">Total Rooms</p>
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold">45</p>
        <p class="text-xs opacity-70 mt-1">3 floors · 15 rooms each</p>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-5 rounded-2xl shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm opacity-80">Active Reservations</p>
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <p class="text-4xl font-bold">{{ $aktif->count() }}</p>
        <p class="text-xs opacity-70 mt-1">{{ $confirmed->count() }} confirmed · {{ $pending->count() }} pending</p>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-5 rounded-2xl shadow-md">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm opacity-80">Total Income</p>
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold">Rp {{ number_format($income, 0, ',', '.') }}</p>
        <p class="text-xs opacity-70 mt-1">From {{ $riwayat->where('status','checked_out')->count() }} checked-out reservations</p>
    </div>
</div>

{{-- QUICK INFO --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">Available Rooms</p>
                <p class="text-2xl font-bold text-green-600">24</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">Occupied Rooms</p>
                <p class="text-2xl font-bold text-red-500">21</p>
            </div>
        </div>
    </div>
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400">Today's Check-ins</p>
                <p class="text-2xl font-bold text-blue-500">{{ $confirmed->count() }}</p>
            </div>
        </div>
    </div>
</div>

{{-- LATEST RESERVATIONS --}}
<div class="flex items-center justify-between mb-4">
    <h2 class="text-base font-semibold text-gray-800">Latest Reservations</h2>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-800">
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:48px">ID</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:120px">Code</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:165px">Guest</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">Room / Offer</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:108px">Check-in</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:120px">Check-out</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide" style="width:112px">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($latest->values() as $index => $res)
            @php
                $items     = collect($res->items);
                $kode      = 'RSV-' . date('ymd') . '-' . str_pad($res->id, 3, '0', STR_PAD_LEFT);
                $firstItem = $items->first();
                $nights    = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);

                $statusCls = match($res->status) {
                    'confirmed'   => 'bg-green-100 text-green-700 border border-green-200',
                    'pending'     => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                    'canceled'    => 'bg-red-100 text-red-600 border border-red-200',
                    'checked_out' => 'bg-gray-100 text-gray-500 border border-gray-200',
                    default       => 'bg-gray-100 text-gray-500',
                };
                $statusDot = match($res->status) {
                    'confirmed'   => 'bg-green-500',
                    'pending'     => 'bg-yellow-400',
                    'canceled'    => 'bg-red-400',
                    'checked_out' => 'bg-gray-400',
                    default       => 'bg-gray-400',
                };
                $statusLabel = match($res->status) {
                    'confirmed'   => 'Confirmed',
                    'pending'     => 'Pending',
                    'canceled'    => 'Canceled',
                    'checked_out' => 'Checked Out',
                    default       => ucfirst($res->status),
                };
            @endphp
            <tr class="hover:bg-gray-50 transition">

                {{-- # --}}
                <td class="px-4 py-3 text-sm text-gray-500">
                    {{ str_pad($index + 1, 3, '0', STR_PAD_LEFT) }}
                </td>

                {{-- Code --}}
                <td class="px-4 py-3">
                    <span class="font-mono text-xs bg-blue-50 text-blue-700 border border-blue-100 px-2 py-1 rounded-md whitespace-nowrap">
                        {{ $kode }}
                    </span>
                </td>

                {{-- Guest --}}
                <td class="px-4 py-3">
                    <div class="font-semibold text-gray-800 text-sm">{{ $res->user->name }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">{{ $res->user->email }}</div>
                </td>

                {{-- Room / Offer --}}
                <td class="px-4 py-3">
                    @if($items->count() > 1)
                        <span class="inline-block text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100 px-2 py-1 rounded-md">
                            {{ $items->count() }} rooms
                        </span>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $items->map(fn($i) => $i->room->tipe)->unique()->implode(' · ') }}
                        </div>
                    @else
                        <div class="font-semibold text-gray-800 text-sm">{{ $firstItem->offer->name }}</div>
                        <div class="text-xs text-gray-400 mt-0.5">{{ $firstItem->room->tipe }}</div>
                    @endif
                </td>

                {{-- Check-in --}}
                <td class="px-4 py-3 text-sm text-gray-700 whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                </td>

                {{-- Check-out --}}
                <td class="px-4 py-3 whitespace-nowrap">
                    <div class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</div>
                    <div class="text-xs text-gray-400 mt-0.5">{{ $nights }} nights</div>
                </td>

                {{-- Status --}}
                <td class="px-4 py-3">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusCls }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusDot }}"></span>
                        {{ $statusLabel }}
                    </span>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection