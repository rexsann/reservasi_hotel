@extends('Layouts.layout')

@section('content')

{{-- PAGE TITLE --}}
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Dashboard
    </h1>

    <p class="text-sm text-gray-400 mt-1">
        Overview hotel Stayzy
    </p>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

    {{-- TOTAL ROOMS --}}
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-5 rounded-2xl shadow-md">

        <div class="flex items-center justify-between mb-3">

            <p class="text-sm opacity-80">
                Total Rooms
            </p>

            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>

                </svg>

            </div>

        </div>

        <p class="text-4xl font-bold">
            {{ $totalRooms }}
        </p>

        <p class="text-xs opacity-70 mt-1">
            Hotel room available
        </p>

    </div>

    {{-- ACTIVE RESERVATION --}}
    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-5 rounded-2xl shadow-md">

        <div class="flex items-center justify-between mb-3">

            <p class="text-sm opacity-80">
                Active Reservations
            </p>

            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>

                </svg>

            </div>

        </div>

        <p class="text-4xl font-bold">
            {{ $activeReservations }}
        </p>

        <p class="text-xs opacity-70 mt-1">
            {{ $confirmedReservations }} confirmed ·
            {{ $pendingReservations }} pending
        </p>

    </div>

    {{-- TOTAL INCOME --}}
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-5 rounded-2xl shadow-md">

        <div class="flex items-center justify-between mb-3">

            <p class="text-sm opacity-80">
                Total Income
            </p>

            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

        </div>

        <p class="text-3xl font-bold">
            Rp {{ number_format($income, 0, ',', '.') }}
        </p>

        <p class="text-xs opacity-70 mt-1">
            From paid reservations
        </p>

    </div>

</div>

{{-- QUICK INFO --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    {{-- AVAILABLE --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">

                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>

                </svg>

            </div>

            <div>

                <p class="text-xs text-gray-400">
                    Available Rooms
                </p>

                <p class="text-2xl font-bold text-green-600">
                    {{ $availableRooms }}
                </p>

            </div>

        </div>

    </div>

    {{-- OCCUPIED --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">

                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>

                </svg>

            </div>

            <div>

                <p class="text-xs text-gray-400">
                    Occupied Rooms
                </p>

                <p class="text-2xl font-bold text-red-500">
                    {{ $occupiedRooms }}
                </p>

            </div>

        </div>

    </div>

    {{-- TODAY CHECKIN --}}
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">

        <div class="flex items-center gap-3">

            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">

                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>

                </svg>

            </div>

            <div>

                <p class="text-xs text-gray-400">
                    Today's Check-ins
                </p>

                <p class="text-2xl font-bold text-blue-500">
                    {{ $todayCheckin }}
                </p>

            </div>

        </div>

    </div>

</div>

{{-- LATEST RESERVATIONS --}}
<div class="flex items-center justify-between mb-4">

    <h2 class="text-base font-semibold text-gray-800">
        Latest Reservations
    </h2>

</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    <table class="w-full text-sm">

        <thead>

            <tr class="bg-gray-800">

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    ID
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Reservation Code
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Guest
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Room / Offer
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Check In
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Check Out
                </th>

                <th class="px-4 py-3 text-left text-xs font-semibold text-white uppercase tracking-wide">
                    Status
                </th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($latestReservations as $index => $res)

            @php

                $statusCls = match($res->status) {

                    'Confirmed'  => 'bg-green-100 text-green-700 border border-green-200',

                    'Pending'    => 'bg-yellow-100 text-yellow-700 border border-yellow-200',

                    'Cancelled'  => 'bg-red-100 text-red-700 border border-red-200',

                    'Checked Out'=> 'bg-gray-100 text-gray-700 border border-gray-200',

                    default      => 'bg-blue-100 text-blue-700 border border-blue-200',
                };

            @endphp

            <tr class="hover:bg-gray-50 transition">

                {{-- ID --}}
                <td class="px-4 py-4 text-gray-500">

                    {{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}

                </td>

                {{-- CODE --}}
                <td class="px-4 py-4">

                    <span class="font-mono text-xs bg-blue-50 text-blue-700 border border-blue-100 px-2 py-1 rounded-md">

                        {{ $res->reservation_code }}

                    </span>

                </td>

                {{-- GUEST --}}
                <td class="px-4 py-4">

                    <div class="font-semibold text-gray-800">

                        {{ $res->name }}

                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">

                        {{ $res->email }}

                    </div>

                </td>

                {{-- ROOM --}}
                <td class="px-4 py-4">

                    <div class="font-semibold text-gray-800">

                        {{ $res->offer }}

                    </div>

                    <div class="text-xs text-gray-400 mt-0.5">

                        {{ $res->room_type }}

                    </div>

                </td>

                {{-- CHECKIN --}}
                <td class="px-4 py-4 text-gray-700">

                    {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}

                </td>

                {{-- CHECKOUT --}}
                <td class="px-4 py-4 text-gray-700">

                    {{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}

                </td>

                {{-- STATUS --}}
                <td class="px-4 py-4">

                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusCls }}">

                        {{ $res->status }}

                    </span>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="7" class="px-6 py-10 text-center text-gray-400">

                    No reservations yet.

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection