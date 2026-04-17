@extends('layouts.app')

@section('title', 'Contact - Stayzy Hotel')

@section('content')

<!-- HERO -->
    <div class="relative h-[65vh] overflow-hidden">
        <img src="https://picsum.photos/400/500"
            class="w-full h-full object-cover scale-105 hover:scale-110 transition duration-700">

        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-4xl md:text-6xl font-bold tracking-wide mb-3">
                Hubungi Kami
            </h1>
            <p class="text-lg text-gray-200 max-w-xl">
                Kami siap memberikan pengalaman terbaik untuk Anda
            </p>
        </div>
    </div>

    <!-- CONTACT INFO -->
    <div class="max-w-6xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-12">

        <!-- INFO -->
        <div class="space-y-6">
            <h2 class="text-4xl font-bold text-gray-800">Hubungi Stayzy</h2>

            <p class="text-gray-600 leading-relaxed">
                Tim kami siap membantu Anda untuk reservasi, pertanyaan,
                atau kebutuhan lainnya dengan pelayanan terbaik.
            </p>

            <div class="space-y-4 text-gray-700">
                <div class="flex items-center gap-3">
                    <span class="text-xl">📍</span>
                    <p>Batam, Kepulauan Riau</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xl">📞</span>
                    <p>0812-3456-7890</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-xl">📧</span>
                    <p>info@stayzyhotel.com</p>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-xl border border-gray-200">
            <h3 class="text-2xl font-semibold mb-6 text-gray-800">Kirim Pesan</h3>

            <form class="space-y-4">
                <input type="text" placeholder="Nama"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">

                <input type="email" placeholder="Email"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">

                <textarea placeholder="Pesan"
                    class="w-full border border-gray-300 p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"></textarea>

                <button
                    class="bg-gradient-to-r from-blue-600 to-blue-500 text-white px-4 py-3 rounded-lg w-full font-semibold hover:opacity-90 transition">
                    Kirim Pesan
                </button>
            </form>
        </div>

    </div>

    <!-- MAP / EXTRA -->
    <div class="bg-[#f5f1eb] py-16">

        <div class="max-w-6xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-bold mb-8 text-gray-800">Lokasi Kami</h2>

            <div class="rounded-2xl overflow-hidden shadow-lg border">
                <iframe
                    src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    class="w-full h-96">
                </iframe>
            </div>

        </div>
    </div>

    <!-- CTA -->
    <!-- CTA -->
<div class="bg-gradient-to-r from-[#1e3a8a] to-[#3b82f6] text-white text-center py-16">
    <h2 class="text-3xl font-bold mb-4">
        Butuh Bantuan?
    </h2>
    <p class="mb-6 text-gray-200">
        Tim profesional kami siap melayani Anda 24/7
    </p>

    <a href="/"
        class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold shadow-lg hover:scale-105 transition inline-block">
        Kembali ke Home
    </a>
</div>

@endsection