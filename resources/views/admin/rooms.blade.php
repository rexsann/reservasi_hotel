@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-4">Rooms Management</h1>

<a href="/admin/rooms/create"
   class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-4 inline-block">
    + Add Room
</a>

<!-- 🔍 FILTER -->
<div class="flex gap-4 mb-6">
    <input type="text" placeholder="Search Room Number..."
        class="border rounded-full px-4 py-2 w-1/3 focus:ring focus:ring-blue-200">

    <select class="border rounded-full px-4 py-2">
        <option>All Floors</option>
        <option>Floor 1</option>
        <option>Floor 2</option>
        <option>Floor 3</option>
    </select>
</div>

<!-- 🔁 LOOP PER FLOOR -->
@php
    $groupedRooms = $rooms->groupBy('floor');
@endphp

@foreach($groupedRooms as $floor => $roomList)

<h2 class="font-semibold mb-2">Floor {{ $floor }}</h2>

<div class="bg-gray-800 text-white rounded-lg overflow-hidden mb-6 shadow">

    <!-- HEADER -->
    <div class="grid grid-cols-6 bg-gray-900 p-3 text-sm font-semibold">
        <div>ID</div>
        <div>Rooms</div>
        <div>Floor</div>
        <div>Type</div>
        <div>Price</div>
        <div>Status</div>
    </div>

    <!-- DATA -->
    @foreach($roomList as $index => $room)
    <div class="grid grid-cols-6 items-center p-3 border-t border-gray-700 text-sm">

        <div>{{ $index + 1 }}</div>
        <div>{{ $room->room_number }}</div>
        <div>{{ $room->floor }}</div>
        <div>{{ $room->type }}</div>
        <div>${{ $room->price }}</div>

        <!-- STATUS -->
        <div>
            @if($room->status == 'available')
                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                    Available
                </span>
            @elseif($room->status == 'maintenance')
                <span class="bg-yellow-400 text-black px-3 py-1 rounded-full text-xs">
                    Maintenance
                </span>
            @else
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                    Booked
                </span>
            @endif
        </div>

    </div>
    @endforeach

</div>

@endforeach

@endsection