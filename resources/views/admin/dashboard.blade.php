@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    <div class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition">
        <p class="text-gray-500 text-sm">Total Rooms</p>
        <p class="text-3xl font-bold mt-2">{{ $totalRooms }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition">
        <p class="text-gray-500 text-sm">Reservations</p>
        <p class="text-3xl font-bold mt-2">{{ $totalReservations }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition">
        <p class="text-gray-500 text-sm">Customers</p>
        <p class="text-3xl font-bold mt-2">{{ $customers }}</p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm hover:shadow-md transition">
        <p class="text-gray-500 text-sm">Revenue</p>
        <p class="text-3xl font-bold mt-2 text-blue-600">
            Rp {{ number_format($revenue) }}
        </p>
    </div>

</div>

@endsection