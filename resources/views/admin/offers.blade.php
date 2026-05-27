@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Offer Management</h1>
        <p class="text-sm text-gray-400">Manage hotel offer packages and pricing</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI: FORM TAMBAH --}}
    <div class="lg:col-span-1">

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-4">

            <h2 class="text-sm font-semibold text-gray-700 mb-4">
                Add New Offer
            </h2>

            <form action="/admin/offers/store" method="POST" class="space-y-4">

                @csrf

                {{-- OFFER NAME --}}
                <div>

                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Offer Name
                    </label>

                    <input
                        name="name"
                        type="text"
                        placeholder="e.g. Breakfast Package"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                </div>

                {{-- ROOM TYPE --}}
                <div>

                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Room Type
                    </label>

                    <select
                        name="room_type"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <option value="Standard">
                            Standard — Floor 1
                        </option>

                        <option value="Superior">
                            Superior — Floor 2
                        </option>

                        <option value="Deluxe">
                            Deluxe — Floor 3
                        </option>

                    </select>

                </div>

                {{-- PRICE --}}
                <div>

                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Price per Night
                    </label>

                    <div class="relative">

                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">
                            Rp
                        </span>

                        <input
                            name="price"
                            type="number"
                            placeholder="350000"
                            class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                    </div>

                </div>

                {{-- BENEFITS --}}
                <div>

                    <label class="block text-xs font-medium text-gray-500 mb-2">
                        Benefits
                    </label>

                    <div class="space-y-2">

                       @php
                       $benefits = [
                        'Free Breakfast',
                        'Free WiFi',
                        'Free Mineral Water',

                        'Swimming Pool Access',
                        'Free Parking Area',

                        'Daily Housekeeping',
                        'Air Conditioning',

                        'Smart TV Entertainment',
                        'Private Bathroom',

                        'Coffee & Tea Amenities',
                        '24-Hour Front Desk',

                        'Early Check-In',
                        'Late Check-Out',

                        'Laundry Service',
                        'Restaurant Discount 10%',

                    ];
                    @endphp

                        @foreach($benefits as $b)

                        <label class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3 py-2 cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition text-sm text-gray-700">

                            <input
                                type="checkbox"
                                name="benefits[]"
                                value="{{ $b }}"
                                class="accent-blue-600 rounded">

                            {{ $b }}

                        </label>

                        @endforeach

                    </div>

                </div>

                {{-- BUTTON --}}
                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">

                    Save Offer

                </button>

            </form>

        </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div class="lg:col-span-2 space-y-6">

        @php
        $types = [
            'Standard' => 'blue',
            'Superior' => 'purple',
            'Deluxe'   => 'amber',
        ];
        @endphp

        @foreach($types as $type => $color)

        @php
            $offerList = $offers->where('room_type', $type);
        @endphp

        <div>

            {{-- HEADER --}}
            <div class="flex items-center gap-2 mb-3">

                <h2 class="text-base font-semibold text-gray-800">
                    {{ $type }}
                </h2>

            </div>

            {{-- LIST --}}
            <div class="grid sm:grid-cols-2 gap-3">

                @forelse($offerList as $offer)

                @php
                    $benefits = json_decode($offer->benefits);
                @endphp

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition flex flex-col gap-3">

                    {{-- TOP --}}
                    <div class="flex items-start justify-between gap-2">

                        <div>

                            <p class="font-semibold text-gray-800 text-sm">
                                {{ $offer->name }}
                            </p>

                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ $offer->room_type }}
                            </p>

                        </div>

                        <div class="text-right shrink-0">

                            <p class="font-bold text-sm text-{{ $color }}-600">
                                Rp {{ number_format($offer->price, 0, ',', '.') }}
                            </p>

                            <p class="text-xs text-gray-400">
                                /malam
                            </p>

                        </div>

                    </div>

                    {{-- BENEFITS --}}
                    <div class="flex flex-wrap gap-1.5">

                        @foreach($benefits as $benefit)

                        <span class="text-xs border px-2 py-0.5 rounded-full bg-{{ $color }}-50 text-{{ $color }}-700 border-{{ $color }}-100">

                            {{ $benefit }}

                        </span>

                        @endforeach

                    </div>

                    {{-- DELETE --}}
                    <div class="flex gap-2 pt-1 border-t border-gray-100">

                        <form action="/admin/offers/{{ $offer->id }}" method="POST" class="w-full">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('Delete this offer?')"
                                class="w-full text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-medium">

                                Delete

                            </button>

                        </form>

                    </div>

                </div>

                @empty

                <div class="text-sm text-gray-400">
                    No offers yet.
                </div>

                @endforelse

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection