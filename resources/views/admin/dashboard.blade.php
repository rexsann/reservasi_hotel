@extends('Layouts.layout')

@section('content')

<h1 class="text-3xl font-bold mb-8 text-gray-800">Dashboard Admin</h1>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
        <p class="text-sm opacity-80">Total Rooms</p>
        <p class="text-4xl font-bold mt-2">45</p>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
        <p class="text-sm opacity-80">Reservations</p>
        <p class="text-4xl font-bold mt-2">23</p>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition">
        <p class="text-sm opacity-80">Customers</p>
        <p class="text-4xl font-bold mt-2">6</p>
    </div>

</div>

<!-- QUICK INFO -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition border border-gray-100">
        <p class="text-gray-400 text-sm">Available Rooms</p>
        <p class="text-3xl font-bold mt-2 text-green-600">24</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition border border-gray-100">
        <p class="text-gray-400 text-sm">Occupied Rooms</p>
        <p class="text-3xl font-bold mt-2 text-red-500">21</p>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition border border-gray-100">
        <p class="text-gray-400 text-sm">Today Check-ins</p>
        <p class="text-3xl font-bold mt-2 text-blue-500">19</p>
    </div>

</div>

<!-- RESERVATIONS -->
<h2 class="text-xl font-semibold mb-4 text-gray-800">Latest Reservations</h2>

<div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

    <!-- HEADER -->
    <div class="grid grid-cols-6 bg-gray-800 px-6 py-3 text-xs font-bold text-gray-300 uppercase tracking-wide">
        <div>ID</div>
        <div>Name</div>
        <div>Room</div>
        <div>Floor</div>
        <div>Date</div>
        <div>Status</div>
    </div>

    <!-- ROW 1 -->
    <div class="grid grid-cols-6 px-6 py-4 text-sm items-center border-t hover:bg-gray-50 transition">
        <div class="text-gray-400 font-mono">001</div>
        <div class="font-medium text-gray-700">Moonlight</div>
        <div class="font-semibold">01</div>
        <div>1</div>
        <div class="text-gray-500">20 Apr 2026</div>
        <div>
            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600 font-semibold">
                Confirmed
            </span>
        </div>
    </div>

    <!-- ROW 2 -->
    <div class="grid grid-cols-6 px-6 py-4 text-sm items-center border-t hover:bg-gray-50 transition">
        <div class="text-gray-400 font-mono">002</div>
        <div class="font-medium text-gray-700">Sunshine</div>
        <div class="font-semibold">03</div>
        <div>2</div>
        <div class="text-gray-500">21 Apr 2026</div>
        <div>
            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600 font-semibold">
                Pending
            </span>
        </div>
    </div>

    <!-- ROW 3 -->
    <div class="grid grid-cols-6 px-6 py-4 text-sm items-center border-t hover:bg-gray-50 transition">
        <div class="text-gray-400 font-mono">003</div>
        <div class="font-medium text-gray-700">Facha</div>
        <div class="font-semibold">02</div>
        <div>3</div>
        <div class="text-gray-500">22 Apr 2026</div>
        <div>
            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600 font-semibold">
                Canceled
            </span>
        </div>
    </div>

</div>

@endsection