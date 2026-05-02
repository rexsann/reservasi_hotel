@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
<div class="pt-32 px-6 max-w-5xl mx-auto pb-20 space-y-6">

  <!-- HEADER + BANNER -->
  <div class="bg-white rounded-2xl shadow p-6 space-y-4">
    <div class="flex justify-between items-center">
      <div>
        <p class="text-gray-500 text-sm">Kode Booking</p>
        <h1 class="text-xl font-bold text-gray-800">RES-240501-001</h1>
      </div>
      <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700">
        ✔ Confirmed
      </span>
    </div>

    <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
      Reservasi Anda telah dikonfirmasi. Silakan datang sesuai jadwal check-in.
    </div>
  

  <!-- GRID -->
  <div class="grid md:grid-cols-2 gap-6">

    <!-- DATA TAMU -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="font-semibold text-gray-800 mb-4">Data Tamu</h2>
      <div class="space-y-3 text-sm">
        <div>
          <p class="text-gray-500">Nama</p>
          <p class="font-medium">Budi Santoso</p>
        </div>
        <div>
          <p class="text-gray-500">Email</p>
          <p class="font-medium">budi@email.com</p>
        </div>
        <div>
          <p class="text-gray-500">No. HP</p>
          <p class="font-medium">08123456789</p>
        </div>
      </div>
    </div>

    <!-- DETAIL KAMAR -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="font-semibold text-gray-800 mb-4">Detail Kamar</h2>
      <div class="space-y-3 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">Tipe Kamar</span>
          <span class="font-medium">Deluxe Room</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Nomor Kamar</span>
          <span class="font-medium">101</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Check-in</span>
          <span class="font-medium">01 Mei 2024</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Check-out</span>
          <span class="font-medium">03 Mei 2024</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Durasi</span>
          <span class="font-medium">2 Malam</span>
        </div>
      </div>
    </div>

  </div>
  

  <!-- RINGKASAN PEMBAYARAN + STATUS + TOMBOL -->
  <div class="bg-white rounded-2xl shadow p-6 space-y-3">

    <h2 class="font-semibold text-gray-800">Ringkasan Pembayaran</h2>

    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Harga Kamar</span>
      <span>Rp 2.250.000</span>
    </div>

    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Pajak & Service</span>
      <span>Rp 225.000</span>
    </div>

    <div class="border-t pt-3 flex justify-between font-semibold text-blue-600">
      <span>Total</span>
      <span>Rp 2.475.000</span>
    </div>

    <!-- STATUS + TOMBOL (digabung di sini) -->
    <div class="border-t pt-3 space-y-3">


      <button class="w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-black transition text-sm">
        Download Invoice
      </button>

      <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-sm">
        Hubungi Customer Service
      </button>

    </div>
  </div>
</div>
</div>
@endsection