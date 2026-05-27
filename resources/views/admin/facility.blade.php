@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Facility Management
        </h1>

        <p class="text-sm text-gray-400">
            Manage facilities per room type
        </p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- FORM --}}
    <div class="lg:col-span-1">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-4">

            <h2 class="text-sm font-semibold text-gray-700 mb-4">
                Add Facility
            </h2>

           <form action="/admin/facility/store" method="POST">

                @csrf

                <div class="space-y-3">

                    {{-- ROOM --}}
                    <div>

                        <label class="block text-xs font-medium text-gray-500 mb-1">
                            Room
                        </label>

                        <select
    name="type"
    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">

    @foreach($rooms as $room)

        <option value="{{ $room->type }}">
            {{ $room->type }}
        </option>

    @endforeach

</select>

                    </div>

                    {{-- FACILITY NAME --}}
                    <div>

                        <label class="block text-xs font-medium text-gray-500 mb-1">
                            Facility Name
                        </label>

                        <input
                            name="name"
                            type="text"
                            placeholder="e.g. Hair Dryer"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                    <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">

                        + Add Facility

                    </button>

                </div>

            </form>

        </div>

    </div>

    {{-- LIST PER TYPE --}}
    <div class="lg:col-span-2 space-y-4">

        @php
            $types = ['Standard', 'Superior', 'Deluxe'];

            $colors = [
                'Standard' => 'bg-blue-500',
                'Superior' => 'bg-purple-500',
                'Deluxe'   => 'bg-amber-500',
            ];
        @endphp

        @foreach($types as $type)

        @php
            $facilityList = $facilities->filter(function ($facility) use ($type) {
                return $facility->room_type === $type;
            });
        @endphp

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

            {{-- HEADER --}}
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50">

                <div class="flex items-center gap-2">

                    <span class="w-2 h-2 rounded-full {{ $colors[$type] }}"></span>

                    <p class="text-sm font-semibold text-gray-700">
                        {{ $type }}
                    </p>

                </div>

                <span class="text-xs text-gray-400">
                    {{ $facilityList->count() }} facilities
                </span>

            </div>

            {{-- LIST --}}
            <div class="divide-y divide-gray-100">

                @forelse($facilityList as $facility)

                <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition">

                    <div class="flex items-center gap-3">

                        <span class="w-1.5 h-1.5 rounded-full {{ $colors[$type] }}"></span>

                        <span class="text-sm font-medium text-gray-800">
                            {{ $facility->name }}
                        </span>

                    </div>

                    <form action="/admin/facility/{{ $facility->id }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Delete this facility?')"
                            class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-medium">

                            Delete

                        </button>

                    </form>

                </div>

                @empty

                <p class="px-5 py-6 text-center text-sm text-gray-400">
                    No facilities added
                </p>

                @endforelse

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection