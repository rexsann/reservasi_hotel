@extends('layouts.app')

@section('title', 'About Us - Stayzy Hotel')

@section('content')

<!-- ABOUT -->
<div class="max-w-6xl mx-auto px-6 py-40 grid md:grid-cols-2 gap-10 items-center">
    <div>
        <h2 class="text-3xl font-bold mb-4">Stayzy Hotel</h2>
        <p class="text-gray-600 mb-4 leading-relaxed">
            Stayzy Hotel is a modern hotel located in Batam, featuring a 5-floor building designed to provide maximum comfort for every guest — whether you are traveling for leisure or business.
        </p>
        <p class="text-gray-600 leading-relaxed">
            With a strategic location close to the city center, ferry terminals, and shopping malls, Stayzy Hotel is the ideal choice for a comfortable stay with warm and professional hospitality.
        </p>
    </div>
    {{-- Gambar dikecilkan dengan max-w-xs/sm dan justify-center --}}
    <div class="flex justify-center">
        <img src="https://picsum.photos/800/800" class="rounded-xl shadow-lg w-full max-w-xs md:max-w-sm object-cover">
    </div>
</div>

<!-- FACILITIES -->
<div class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">

        <h2 class="text-2xl font-bold mb-8">Our Facilities</h2>

        <div class="grid md:grid-cols-4 gap-6">

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">📶 Free WiFi</h3>
                <p class="text-gray-500 text-sm">High-speed internet access throughout the hotel</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">🍽️ Restaurant</h3>
                <p class="text-gray-500 text-sm">Local & international cuisine menu</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">🏢 Meeting Room</h3>
                <p class="text-gray-500 text-sm">Perfect for business meetings & events</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">🛎️ 24/7 Service</h3>
                <p class="text-gray-500 text-sm">Round-the-clock front desk assistance</p>
            </div>

        </div>
    </div>
</div>

<!-- WHY CHOOSE US -->
<div class="max-w-6xl mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-center mb-8">Why Choose Us?</h2>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Strategic Location</h3>
            <p class="text-gray-600 text-sm">Close to the city center and Batam ferry terminals</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Affordable Rates</h3>
            <p class="text-gray-600 text-sm">Top quality experience at competitive prices</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Friendly Service</h3>
            <p class="text-gray-600 text-sm">Professional and welcoming staff at your service</p>
        </div>
    </div>
</div>

<!-- GALLERY -->
<div class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-center mb-8">Hotel Gallery</h2>
        <div class="grid md:grid-cols-3 gap-4">
            <img src="https://picsum.photos/800/700" class="rounded-xl shadow">
            <img src="https://picsum.photos/800/700" class="rounded-xl shadow">
            <img src="https://picsum.photos/800/700" class="rounded-xl shadow">
        </div>
    </div>
</div>

<!-- CTA -->
<div class="bg-blue-600 text-white text-center py-12">
    <h2 class="text-2xl font-bold mb-4">Ready to Stay?</h2>
    <p class="mb-6">Book your room now and enjoy the best experience with us</p>
    <a href="/" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">Book Now</a>
</div>

@endsection