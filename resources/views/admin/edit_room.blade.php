@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Edit Room</h1>

<form action="/admin/rooms/{{ $room->id }}" method="POST" class="bg-white p-6 rounded-2xl shadow w-1/2">
@csrf
@method('PUT')

    <div class="mb-4">
        <label>Room Number</label>
        <input type="text" value="{{ $room->room_id }}" 
       class="w-full border p-2 rounded bg-gray-100" readonly>
    </div>

    <div class="mb-4">
        <label>Floor</label>
        <input type="number" name="floor" value="{{ $room->floor }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label>Type</label>
        <input type="text" name="type" value="{{ $room->type }}" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label>Price</label>
        <input type="number" name="price" value="{{ $room->price }}" class="w-full border p-2 rounded">
    </div>

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection