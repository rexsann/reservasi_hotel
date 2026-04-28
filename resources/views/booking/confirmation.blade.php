@extends('layouts.app')

@section('title', 'Booking Confirmation - Stayzy Hotel')

@section('content')

<div class="min-h-screen bg-gray-200 flex items-center justify-center px-4 py-10 mt-20">
  <div class="bg-white rounded-2xl shadow-lg w-full max-w-md overflow-hidden">

    {{-- Step indicator --}}
    <div class="bg-gray-50 border-b border-gray-200 px-6 py-3 flex items-center gap-2 text-sm">
      <span class="text-gray-400">1. Fill in data</span>
      <div class="flex-1 border-t border-dashed border-gray-300"></div>
      <span class="font-semibold text-gray-700">2. Payment</span>
    </div>

    {{-- Body --}}
    <div class="p-6">

      {{-- Header --}}
      <div class="mb-4">
        <p class="font-bold text-gray-800 text-lg">Booking Information Sent!</p>
        <p class="text-sm text-gray-500">
          Your booking information has been sent to your email.
        </p>
      </div>

      {{-- Wrapper --}}
      <div class="border-2 rounded-xl p-5 space-y-5">

        {{-- STATUS --}}
        <div class="w-full h-10 flex items-center justify-center rounded-full font-bold border border-black text-sm
            {{ $status == 'pending' ? 'bg-yellow-400 text-black' : 'bg-green-500 text-white' }}">

            {{ $status == 'pending' ? 'Pending' : 'Confirmed' }}

        </div>

        {{-- Hotel --}}
        <div class="flex gap-4 items-center">
          <div class="w-16 h-16 border-2 border-black rounded-lg"></div>
          <div>
            <p class="font-semibold text-gray-800">Stayzy Hotel</p>
            <p class="text-sm text-gray-500">Batam, Kepulauan Riau</p>
          </div>
        </div>

        <div class="border-t border-gray-300"></div>

        {{-- Dates --}}
        <div class="flex justify-between text-sm">
          <div>
            <p class="text-gray-500">Check In</p>
            <p class="font-bold">Tue, 5 May 2028</p>
          </div>
          <div>
            <p class="text-gray-500">Check Out</p>
            <p class="font-bold">Tue, 8 May 2028</p>
          </div>
        </div>

        <div class="border-t border-gray-300"></div>

        {{-- BUTTON (POST KE SERVER) --}}
        <form method="GET" action="{{ route('payment.check') }}">
            @csrf
            <button
              class="w-full py-3 rounded-full border-2 border-black font-bold hover:bg-gray-100 transition">
              Check status
            </button>
        </form>

        {{-- Note --}}
        <p class="text-xs text-gray-500">
          To view your invoice, please enter your booking code in the reservation section.
        </p>

      </div>
    </div>
  </div>
</div>

@endsection