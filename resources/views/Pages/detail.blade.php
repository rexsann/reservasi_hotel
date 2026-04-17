
@extends('layouts.app')

@section('title', 'About Us - Stayzy Hotel')

@section('content')


<div class="min-h-screen bg-[#f5f1eb] py-48 px-6">

  <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-3 gap-6">

    <!-- LEFT: FORM -->
    <div class="md:col-span-2 bg-white rounded-2xl shadow-xl p-6">

      <!-- STEP -->
      <div class="flex justify-between text-sm font-medium mb-6">
        <span class="text-blue-600">1. Fill in data</span>
        <span class="text-gray-400">2. Payment</span>
      </div>

      <div class="border-b mb-6"></div>

      <!-- CHECKBOX -->
      <label class="flex items-center gap-2 mb-6">
        <input type="checkbox" class="w-5 h-5">
        <span>I am booking for myself</span>
      </label>

      <!-- CONTACT -->
      <h2 class="font-semibold mb-1">Contact Detail</h2>
      <p class="text-sm text-gray-500 mb-4">
        Reservation information will be sent to this contact detail
      </p>

      <!-- EMAIL -->
      <input type="email" placeholder="Email Address"
        class="w-full mb-4 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">

      <!-- NAME -->
      <div class="grid grid-cols-2 gap-4 mb-4">
        <input type="text" placeholder="First Name"
          class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">

        <input type="text" placeholder="Last Name"
          class="px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
      </div>

      <!-- PHONE -->
      <div class="flex gap-2 mb-6">
        <div class="w-24 px-3 py-3 border rounded-xl text-center bg-gray-50">
          +62
        </div>
        <input type="text" placeholder="Phone Number"
          class="flex-1 px-4 py-3 border rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
      </div>

      <!-- BUTTON -->
      <button
        class="w-full bg-black text-white py-3 rounded-full font-semibold hover:bg-gray-800 transition">
        Review Reservation
      </button>

    </div>

    <!-- RIGHT: SUMMARY -->
    <div class="bg-white rounded-2xl shadow-xl p-6">

      <h2 class="font-semibold text-lg mb-4">Reservation Details</h2>

      <!-- HOTEL -->
      <div class="flex gap-4 items-center mb-6">
        <div class="w-20 h-20 bg-gray-200 rounded-xl"></div>
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
          <p class="font-semibold">Tue, 5 May 2028</p>
        </div>
        <div>
          <p class="text-gray-500">Check Out</p>
          <p class="font-semibold">Tue, 8 May 2028</p>
        </div>
      </div>

      <hr class="mb-4">

      <!-- PRICE -->
      <div class="mb-4">
        <p class="text-sm text-gray-500">Price Detail</p>

        <div class="border rounded-xl p-3 mt-2">
          Deluxe Room
        </div>
      </div>

      <!-- TOTAL -->
      <div class="flex justify-between items-center mt-6">
        <span class="text-gray-500">Total Price</span>
        <span class="text-2xl font-bold">$150.00</span>
      </div>

      <p class="text-xs text-gray-400 mt-4">
        Direct booking guarantees best rates with no middleman fees.
      </p>

    </div>

  </div>
</div>

@endsection
