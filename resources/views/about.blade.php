<!DOCTYPE html>
<html lang="id">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>About Us - Stayzy Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-[#f5f1eb] via-[#ece3d9] to-[#e6dccf] scroll-smooth">
    <!-- Navbar -->
    <nav class="bg-[#C8A96A]/80 backdrop-blur-md fixed w-full z-50 top-0 shadow-sm">
        <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">

            <!-- LEFT: Logo -->
            <div class="flex items-center">
                <span class="text-xl font-bold text-black-800">🏨 Stayzy Hotel</span>
            </div>

            <!-- CENTER: Menu (desktop only) -->
            <div class="hidden md:flex gap-6 text-black-600 font-medium">

                <a href="/"
                    class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Home
                </a>

                <a href="/about"
                    class="{{ request()->is('about') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    About
                </a>

                <a href="/reservation"
                    class="{{ request()->is('reservation') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Reservation
                </a>

                <a href="/contact"
                    class="{{ request()->is('contact') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Contact
                </a>

            </div>

            <!-- RIGHT: User + Hamburger -->
            <div class="flex items-center gap-3">

                <!-- Hamburger -->
                <button data-collapse-toggle="navbar-menu" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100">
                    ☰
                </button>

                <!-- User -->
                <div class="relative">
                    <button id="user-menu-button" data-dropdown-toggle="user-dropdown">
                        <img
                            src="https://ui-avatars.com/api/?name={{ session('user_name') ?? 'Guest' }}"
                            class="w-10 h-10 rounded-full ring-2 ring-blue-500">
                    </button>

                    <!-- Dropdown -->
                    <div id="user-dropdown"
                        class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-lg border">

                        <div class="px-4 py-3 border-b">
                            <p class="font-semibold">{{ session('user_name') ?? 'Guest' }}</p>
                            <p class="text-sm text-gray-500">{{ session('email') ?? '-' }}</p>
                        </div>

                        <a href="/profil" class="block px-4 py-2 hover:bg-gray-100">Profil</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Transaksi</a>

                        <div class="border-t"></div>

                        <a href="/logout" class="block px-4 py-2 text-red-500 hover:bg-red-50">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MOBILE MENU -->
        <div class="hidden md:hidden px-4 pb-4" id="navbar-menu">
            <div class="flex flex-col gap-2 text-gray-600 font-medium">

                <a href="/"
                    class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Home
                </a>

                <a href="/about"
                    class="{{ request()->is('about') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    About
                </a>

                <a href="/reservation"
                    class="{{ request()->is('reservation') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Reservation
                </a>

                <a href="/contact"
                    class="{{ request()->is('contact') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}">
                    Contact
                </a>

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
                Stayzy Hotel adalah hotel modern yang terletak di Batam dengan bangunan 5 lantai yang dirancang untuk memberikan kenyamanan maksimal bagi tamu. Cocok untuk wisatawan maupun pebisnis.
            </p>

            <p class="text-gray-600 leading-relaxed">
                Dengan lokasi strategis dekat pusat kota, pelabuhan, dan pusat perbelanjaan, Stayzy Hotel menjadi pilihan ideal untuk menginap dengan suasana nyaman dan pelayanan ramah.
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
  <footer class="bg-gray-900 text-gray-300 pt-12 pb-6">

    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-4 gap-10">

      <!-- 🏨 ABOUT HOTEL -->
      <div>
        <h2 class="text-xl font-semibold text-white mb-4">🏨 Stayzy Hotel</h2>
        <p class="text-sm leading-relaxed">
          Hotel modern dengan kenyamanan terbaik di pusat kota Batam.
          Cocok untuk bisnis maupun liburan bersama keluarga.
        </p>
      </div>

      <!-- 📍 CONTACT -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Contact Us</h3>
        <ul class="space-y-2 text-sm">
          <li>📍 Jl. XYZ No.123, Batam</li>
          <li>📞 +62 812 3456 7890</li>
          <li>✉️ info@stayzyhotel.com</li>
        </ul>
      </div>

      <!-- 🔗 QUICK LINKS -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Quick Links</h3>
        <ul class="space-y-2 text-sm">
          <li><a href="#overview" class="hover:text-white">Overview</a></li>
          <li><a href="#facilities" class="hover:text-white">Facilities</a></li>
          <li><a href="#location" class="hover:text-white">Location</a></li>
          <li><a href="#rooms" class="hover:text-white">Rooms</a></li>
        </ul>
      </div>

      <!-- 📲 SOCIAL MEDIA -->
      <div>
        <h3 class="text-lg font-semibold text-white mb-4">Follow Us</h3>
        <div class="flex space-x-4 text-lg">
          <a href="#" class="hover:text-white">🌐</a>
          <a href="#" class="hover:text-white">📘</a>
          <a href="#" class="hover:text-white">📸</a>
          <a href="#" class="hover:text-white">🐦</a>
        </div>
      </div>

    </div>

    <!-- 🔻 BOTTOM -->
    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-400">
      © 2026 Stayzy Hotel. All rights reserved.
    </div>

  </footer>

</body>

</html>