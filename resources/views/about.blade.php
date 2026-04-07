<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>About Us - HotelKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>

<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-600">HotelKu</h1>

        <div>
            <a href="/home" class="mx-2 text-gray-700 hover:text-blue-500">Home</a>
            <a href="/about" class="mx-2 text-blue-600 font-semibold">About</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="relative h-[60vh]">
    <img src="{{ asset('images/hotel.jpg') }}" class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-white text-4xl md:text-5xl font-bold">
            Tentang Kami
        </h1>
    </div>
</div>

<!-- ABOUT -->
<div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-10 items-center">

    <div>
        <h2 class="text-3xl font-bold mb-4">HotelKu Batam</h2>

        <p class="text-gray-600 mb-4 leading-relaxed">
            HotelKu adalah hotel modern yang terletak di Batam dengan bangunan 5 lantai yang dirancang untuk memberikan kenyamanan maksimal bagi tamu. Cocok untuk wisatawan maupun pebisnis.
        </p>

        <p class="text-gray-600 leading-relaxed">
            Dengan lokasi strategis dekat pusat kota, pelabuhan, dan pusat perbelanjaan, HotelKu menjadi pilihan ideal untuk menginap dengan suasana nyaman dan pelayanan ramah.
        </p>
    </div>

    <img src="{{ asset('images/lobby.jpg') }}" class="rounded-xl shadow-lg">

</div>

<!-- FASILITAS -->
<div class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-8">Fasilitas Kami</h2>

        <div class="grid md:grid-cols-4 gap-6">

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">WiFi Gratis</h3>
                <p class="text-gray-500 text-sm">Akses internet cepat di seluruh area hotel</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">Restoran</h3>
                <p class="text-gray-500 text-sm">Menu lokal & internasional</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">Ruang Meeting</h3>
                <p class="text-gray-500 text-sm">Cocok untuk bisnis & acara</p>
            </div>

            <div class="p-6 shadow rounded-xl">
                <h3 class="font-semibold text-lg mb-2">24 Jam Service</h3>
                <p class="text-gray-500 text-sm">Layanan resepsionis 24 jam</p>
            </div>

        </div>
    </div>
</div>

<!-- KEUNGGULAN -->
<div class="max-w-6xl mx-auto px-6 py-12">
    <h2 class="text-2xl font-bold text-center mb-8">Kenapa Pilih Kami?</h2>

    <div class="grid md:grid-cols-3 gap-6">

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Lokasi Strategis</h3>
            <p class="text-gray-600 text-sm">Dekat pusat kota dan pelabuhan Batam</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Harga Terjangkau</h3>
            <p class="text-gray-600 text-sm">Kualitas terbaik dengan harga bersaing</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="font-semibold mb-2">Pelayanan Ramah</h3>
            <p class="text-gray-600 text-sm">Staff profesional dan bersahabat</p>
        </div>

    </div>
</div>

<!-- GALERI -->
<div class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-2xl font-bold text-center mb-8">Galeri Hotel</h2>

        <div class="grid md:grid-cols-3 gap-4">
            <img src="{{ asset('images/room1.jpg') }}" class="rounded-xl shadow">
            <img src="{{ asset('images/room2.jpg') }}" class="rounded-xl shadow">
            <img src="{{ asset('images/room3.jpg') }}" class="rounded-xl shadow">
        </div>
    </div>
</div>

<!-- CTA -->
<div class="bg-blue-600 text-white text-center py-12">
    <h2 class="text-2xl font-bold mb-4">
        Siap untuk Menginap?
    </h2>
    <p class="mb-6">Pesan kamar Anda sekarang dan nikmati pengalaman terbaik</p>

    <a href="/" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">
        Booking Sekarang
    </a>
</div>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white text-center py-4">
    © 2026 HotelKu Batam
</footer>

</body>
</html>
