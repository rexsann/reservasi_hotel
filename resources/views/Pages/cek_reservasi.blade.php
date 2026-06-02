@extends('layouts.app')

@section('title', 'Detail Reservasi')

@section('content')
<div class="pt-32 px-6 max-w-5xl mx-auto pb-20 space-y-6">

  <!-- HEADER + BANNER -->
  <div class="bg-white rounded-2xl shadow p-6 space-y-4">
    <div class="flex justify-between items-center">
      <div>
        <p class="text-gray-500 text-sm">Kode Booking</p>
        <h1 class="text-xl font-bold text-gray-800">{{ $data->reservation_code }}</h1>
      </div>
      <span class="px-4 py-2 text-sm font-semibold rounded-full
        {{ $data->status === 'Confirmed' ? 'bg-green-100 text-green-700' :
           ($data->status === 'Cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
        {{ $data->status }}
      </span>
    </div>

    @if($data->status === 'Confirmed')
    <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
      Reservasi Anda telah dikonfirmasi. Silakan datang sesuai jadwal check-in.
    </div>
    @elseif($data->status === 'Cancelled')
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-sm">
      Reservasi Anda telah dibatalkan.
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-xl text-sm">
      Reservasi Anda sedang diproses.
    </div>
    @endif
  </div>

  <!-- GRID -->
  <div class="grid md:grid-cols-2 gap-6">

    <!-- DATA TAMU -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="font-semibold text-gray-800 mb-4">Data Tamu</h2>
      <div class="space-y-3 text-sm">
        <div>
          <p class="text-gray-500">Nama</p>
          <p class="font-medium">{{ $data->name }}</p>
        </div>
        <div>
          <p class="text-gray-500">Email</p>
          <p class="font-medium">{{ $data->email }}</p>
        </div>
        <div>
          <p class="text-gray-500">Jumlah Tamu</p>
          <p class="font-medium">{{ $data->guest_total }} Orang</p>
        </div>
      </div>
    </div>

    <!-- DETAIL KAMAR -->
    <div class="bg-white rounded-2xl shadow p-6">
      <h2 class="font-semibold text-gray-800 mb-4">Detail Kamar</h2>
      <div class="space-y-3 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">Tipe Kamar</span>
          <span class="font-medium">{{ $data->room_type }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Nama Kamar</span>
          <span class="font-medium">{{ $data->room_name }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Penawaran</span>
          <span class="font-medium">{{ $data->offer ?? '-' }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Check-in</span>
          <span class="font-medium">{{ \Carbon\Carbon::parse($data->check_in)->format('d M Y') }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Check-out</span>
          <span class="font-medium">{{ \Carbon\Carbon::parse($data->check_out)->format('d M Y') }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Durasi</span>
          <span class="font-medium">
            {{ \Carbon\Carbon::parse($data->check_in)->diffInDays($data->check_out) }} Malam
          </span>
        </div>
      </div>
    </div>

  </div>

  <!-- RINGKASAN PEMBAYARAN -->
  <div class="bg-white rounded-2xl shadow p-6 space-y-3">
    <h2 class="font-semibold text-gray-800">Ringkasan Pembayaran</h2>

    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Total Harga</span>
      <span>Rp {{ number_format($data->total_price, 0, ',', '.') }}</span>
    </div>

    @if($data->paid_at)
    <div class="flex justify-between text-sm">
      <span class="text-gray-500">Dibayar Pada</span>
      <span>{{ \Carbon\Carbon::parse($data->paid_at)->format('d M Y, H:i') }}</span>
    </div>
    @endif

    <div class="border-t pt-3 flex justify-between font-semibold text-blue-600">
      <span>Total</span>
      <span>Rp {{ number_format($data->total_price, 0, ',', '.') }}</span>
    </div>

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
@endsection