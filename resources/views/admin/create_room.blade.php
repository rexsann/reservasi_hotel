@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Add New Room</h1>

<form action="/admin/rooms" method="POST" class="bg-white p-6 rounded-xl shadow w-1/2">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Room Number</label>
        <input type="text" name="room_number" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Floor</label>
        <input type="number" name="floor" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Type</label>
        <select name="type" class="w-full border p-2 rounded">
            <option>Standard</option>
            <option>Deluxe</option>
            <option>Suite</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Price</label>
        <input type="number" name="price" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="available">Available</option>
            <option value="maintenance">Maintenance</option>
            <option value="booked">Booked</option>
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Save Room
    </button>

</form>

@endsection