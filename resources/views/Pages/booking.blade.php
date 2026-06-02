@extends('layouts.app')

@section('title', 'About Us - Stayzy Hotel')

@section('content')

<div class="min-h-screen bg-[#f5f1eb] py-32 px-6">

  <!-- STEP PROGRESS -->
  <div class="max-w-6xl mx-auto px-6 mb-8">
    <div class="flex items-center justify-between text-sm font-medium">

      <!-- STEP 1 (ACTIVE) -->
      <div class="flex items-center gap-2 text-blue-600">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">
          1
        </div>
        <span class="font-semibold">Fill in data</span>
      </div>

      <!-- LINE -->
      <div class="flex-1 h-px bg-gray-300 mx-3"></div>

      <!-- STEP 2 -->
      <div class="flex items-center gap-2 text-gray-400">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-gray-200 text-gray-500 text-xs font-bold">
          2
        </div>
        <span>Payment</span>
      </div>

    </div>
  </div>

  <!-- MAIN GRID -->
  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-6">

    <!-- LEFT -->
    <div class="order-2 md:order-1 md:col-span-2 bg-white rounded-2xl shadow-xl p-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">Complete Your Booking</h2>

      @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600">
          <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('booking.store') }}" class="space-y-5">
        @csrf

        <!-- Hidden fields dari data kamar/reservasi -->
        <input type="hidden" name="room_id"    value="{{ $room->id }}">
        <input type="hidden" name="room_name"  value="{{ $room->name }}">
        <input type="hidden" name="room_type"  value="{{ $room->type }}">
        <input type="hidden" name="offer"      value="{{ $room->offer ?? null }}">
        <input type="hidden" name="check_in"   value="{{ $checkIn }}">
        <input type="hidden" name="check_out"  value="{{ $checkOut }}">
        <input type="hidden" name="guest_total" value="{{ $guestTotal }}">
        <input type="hidden" name="total_price" value="{{ $totalPrice }}">

        <!-- CHECKBOX -->
        <label class="flex items-center gap-2 mb-6">
          <input type="checkbox" name="booking_for_self" value="1" class="w-5 h-5">
          <span>I am booking for myself</span>
        </label>

        <!-- CONTACT -->
        <h2 class="font-semibold mb-1">Contact Detail</h2>
        <p class="text-sm text-gray-500 mb-4">
          Reservation information will be sent to this contact detail
        </p>

        <!-- EMAIL -->
        <input
          type="email"
          name="email"
          placeholder="Email Address"
          value="{{ old('email') }}"
          class="w-full mb-4 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('email') border-red-400 @enderror"
        >

        <!-- NAME -->
        <div class="grid grid-cols-2 gap-4 mb-6">
          <input
            type="text"
            name="first_name"
            placeholder="First Name"
            value="{{ old('first_name') }}"
            class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('first_name') border-red-400 @enderror"
          >
          <input
            type="text"
            name="last_name"
            placeholder="Last Name"
            value="{{ old('last_name') }}"
            class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none @error('last_name') border-red-400 @enderror"
          >
        </div>

        <!-- BUTTON -->
        <button type="submit"
          class="w-full bg-blue-600 text-white py-3 rounded-full font-semibold hover:bg-blue-700 transition">
          Review Reservation
        </button>
      </form>
    </div>

    <!-- RIGHT: SUMMARY -->
    <div class="order-1 md:order-2 bg-white rounded-2xl shadow-xl p-6 mb-6 md:mb-0">

      <h2 class="font-semibold text-lg mb-4">Reservation Details</h2>

      <!-- HOTEL -->
      <div class="flex gap-4 items-center mb-6">
        <div class="w-20 h-20 bg-gray-200 rounded-xl overflow-hidden">
          @if($room->image ?? null)
            <img src="{{ asset('storage/' . $room->image) }}" class="w-full h-full object-cover">
          @endif
        </div>
        <div>
          <h3 class="font-semibold">Stayzy Hotel</h3>
          <p class="text-sm text-gray-500">Batam, Kepulauan Riau</p>
        </div>
      </div>

      <hr class="mb-4">

      <!-- DATE -->
      <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
        <div>
          <p class="text-gray-500">Check In</p>
          <p class="font-semibold">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $checkIn)->format('D, j M Y') }}</p>
        </div>
        <div>
          <p class="text-gray-500">Check Out</p>
          <p class="font-semibold">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $checkOut)->format('D, j M Y') }}</p>  
        </div>
      </div>

      <div class="text-sm mb-4">
        <p class="text-gray-500">Guests</p>
        <p class="font-semibold">{{ $guestTotal }} Guest(s)</p>
      </div>

      <hr class="mb-4">

      <!-- PRICE -->
      <div class="mb-4">
        <p class="text-sm text-gray-500">Price Detail</p>
        <div class="border rounded-xl p-3 mt-2 text-sm">
    <p class="font-medium">{{ $room->type ?? 'Standard' }}</p>
    <p class="text-gray-500 text-xs mt-1">{{ $room->offer ?? '' }}</p>
</div>
      </div>

      <!-- TOTAL -->
      <div class="flex justify-between items-center mt-6">
        <span class="text-gray-500">Total Price</span>
        <span class="text-2xl font-bold">${{ number_format($totalPrice, 2) }}</span>
      </div>

      <p class="text-xs text-gray-400 mt-4">
        Direct booking guarantees best rates with no middleman fees.
      </p>

    </div>

  </div>
</div>

<script>
    const checkbox = document.querySelector('input[name="booking_for_self"]');

    // Data user dari Laravel (hanya jika login)
    const userData = {
        name:  "{{ auth()->check() ? auth()->user()->name : '' }}",
        email: "{{ auth()->check() ? auth()->user()->email : '' }}",
    };

    checkbox.addEventListener('change', function () {
        if (this.checked) {
            // Pisah name jadi first & last
            const parts     = userData.name.trim().split(' ');
            const firstName = parts[0] ?? '';
            const lastName  = parts.slice(1).join(' ') ?? '';

            document.querySelector('input[name="first_name"]').value = firstName;
            document.querySelector('input[name="last_name"]').value  = lastName;
            document.querySelector('input[name="email"]').value      = userData.email;
        } else {
            document.querySelector('input[name="first_name"]').value = '';
            document.querySelector('input[name="last_name"]').value  = '';
            document.querySelector('input[name="email"]').value      = '';
        }
    });
</script>
@endsection