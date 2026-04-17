<!DOCTYPE html>
<html lang="id">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Contact - Stayzy Hotel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white fixed w-full z-50 top-0 border-b border-gray-200 shadow">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4">

        <!-- LEFT: Logo -->
        <div class="flex items-center">
            <span class="text-xl font-bold text-gray-800">🏨 Stayzy Hotel</span>
        </div>

        <!-- CENTER: Menu (desktop only) -->
        <div class="hidden md:flex gap-6 text-gray-600 font-medium">

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