@extends('admin.layout')

@section('content')

<h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

<!-- 🔥 CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow">
        <p class="text-sm opacity-80">Total Rooms</p>
        <p id="totalRooms" class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-2xl shadow">
        <p class="text-sm opacity-80">Reservations</p>
        <p id="totalReservations" class="text-3xl font-bold mt-2">0</p>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow">
        <p class="text-sm opacity-80">Customers</p>
        <p class="text-3xl font-bold mt-2">0</p>
    </div>

</div>

<!-- 🔥 RESERVATIONS -->
<h2 class="text-xl font-semibold mb-3">Latest Reservations</h2>

<div class="bg-gray-900 text-white rounded-2xl shadow overflow-hidden">

    <div class="grid grid-cols-6 bg-gray-800 p-3 text-sm font-semibold">
        <div>ID</div>
        <div>Name</div>
        <div>Room</div>
        <div>Floor</div>
        <div>Date</div>
        <div>Status</div>
    </div>

    <div id="reservationTable"></div>

</div>

<!-- 🔥 SCRIPT -->
<script>

// LOAD ROOMS
function loadRooms() {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    let table = document.getElementById('roomTable');
    let total = document.getElementById('totalRooms');

    total.innerText = rooms.length;
    table.innerHTML = '';

    if (rooms.length === 0) {
        table.innerHTML = `<div class="p-4 text-center text-gray-400">No rooms yet</div>`;
        return;
    }

    rooms.slice(-5).reverse().forEach((r, i) => {
        table.innerHTML += `
        <div class="grid grid-cols-5 p-3 border-t text-sm hover:bg-gray-50">
            <div>${i+1}</div>
            <div>${r.room_id}</div>
            <div class="capitalize">${r.type}</div>
            <div>Rp ${Number(r.price).toLocaleString('id-ID')}</div>
            <div>${r.facilities.join(', ')}</div>
        </div>
        `;
    });
}

// LOAD RESERVATIONS (dummy)
function loadReservations() {
    let table = document.getElementById('reservationTable');

    table.innerHTML = `
    <div class="p-4 text-center text-gray-400">
        No reservations yet
    </div>
    `;
}

// INIT
loadRooms();
loadReservations();

</script>

@endsection