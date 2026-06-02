@extends('layouts.app')

@section('title', 'Reservation - Stayzy Hotel')

@section('content')

<!-- BACKGROUND EFFECT -->
<div class="absolute w-72 h-72 bg-blue-500 rounded-full blur-3xl opacity-20 top-20 left-10"></div>
<div class="absolute w-72 h-72 bg-purple-500 rounded-full blur-3xl opacity-20 bottom-10 right-10"></div>

<!-- CONTENT -->
<div class="flex items-center justify-center min-h-screen pt-24 px-4">

    <div class="bg-white/90 backdrop-blur-md rounded-3xl p-10 w-full max-w-md shadow-2xl border border-white/30">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="/" class="flex flex-col items-center">
                <img 
                    src="{{ asset('images/logo_hotel.png') }}" 
                    alt="Stayzy Hotel Logo"
                    class="w-20 h-20 rounded-2xl object-cover shadow-lg border-2 border-white"
                >
            </a>
        </div>

        <!-- Title -->
        <h2 class="text-2xl font-bold text-center mb-1 text-gray-800">My Reservation</h2>
        <p class="text-center text-sm text-gray-500 mb-6">Check your booking instantly</p>

        <!-- Error dari redirect back() -->
        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-4">
            ⚠️ {{ session('error') }}
        </div>
        @endif

        <!-- Error validasi -->
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl mb-4">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ route('reservation.check') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <input
                    type="text"
                    name="code"
                    placeholder="Reservation Code"
                    value="{{ old('code') }}"
                    required
                    class="w-full px-5 py-3 rounded-xl border {{ $errors->has('code') ? 'border-red-400' : 'border-gray-300' }} focus:ring-2 focus:ring-blue-400 outline-none"
                >
            </div>

            <div>
                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-5 py-3 rounded-xl border {{ $errors->has('email') ? 'border-red-400' : 'border-gray-300' }} focus:ring-2 focus:ring-blue-400 outline-none"
                >
            </div>

            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition"
            >
                View Reservation
            </button>
        </form>

        <p class="text-center text-xs text-gray-400 mt-6">
            🔒 Secure & encrypted reservation lookup
        </p>

    </div>
</div>

@endsection