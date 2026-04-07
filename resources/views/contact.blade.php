<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Contact - HotelKu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-600">HotelKu</h1>

        <div>
            <a href="/home" class="mx-2 text-gray-700 hover:text-blue-500">Home</a>
            <a href="/about" class="mx-2 text-gray-700 hover:text-blue-500">About</a>
            <a href="/contact" class="mx-2 text-blue-600 font-semibold">Contact</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<div class="relative h-[60vh]">
    <img src="{{ asset('images/hotel.jpg') }}" class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
        <h1 class="text-white text-4xl md:text-5xl font-bold">
            Hubungi Kami
        </h1>
    </div>
</div>

<!-- CONTACT INFO -->
<div class="max-w-6xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-10">

    <div>
        <h2 class="text-3xl font-bold mb-4">Kontak HotelKu</h2>

        <p class="text-gray-600 mb-4">
            Jika Anda memiliki pertanyaan, reservasi, atau membutuhkan bantuan, silakan hubungi kami melalui informasi di bawah ini.
        </p>

        <ul class="text-gray-600 space-y-2">
            <li>📍 Alamat: Batam, Kepulauan Riau</li>
            <li>📞 Telepon: 0812-3456-7890</li>
            <li>📧 Email: info@hotelku.com</li>
        </ul>
    </div>

    <!-- FORM -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-xl font-semibold mb-4">Kirim Pesan</h3>

        <form class="space-y-4">
            <input type="text" placeholder="Nama" class="w-full border p-2 rounded-lg">
            <input type="email" placeholder="Email" class="w-full border p-2 rounded-lg">
            <textarea placeholder="Pesan" class="w-full border p-2 rounded-lg"></textarea>

            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full">
                Kirim
            </button>
        </form>
    </div>

</div>

<!-- MAP / EXTRA -->
<div class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-6 text-center">
        <h2 class="text-2xl font-bold mb-6">Lokasi Kami</h2>

        <div class="w-full h-64 bg-gray-300 flex items-center justify-center rounded-xl">
            <p class="text-gray-600">Map Placeholder</p>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="bg-blue-600 text-white text-center py-12">
    <h2 class="text-2xl font-bold mb-4">
        Butuh Bantuan?
    </h2>
    <p class="mb-6">Tim kami siap membantu Anda kapan saja</p>

    <a href="/" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">
        Kembali ke Home
    </a>
</div>

<!-- FOOTER -->
<footer class="bg-gray-900 text-white text-center py-4">
    © 2026 HotelKu Batam
</footer>

</body>
</html>