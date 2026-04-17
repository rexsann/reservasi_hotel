<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Reservation</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen relative">

    <!-- ✅ NAVBAR -->
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



    <!-- 🔥 BACKGROUND EFFECT -->
    <div class="absolute w-72 h-72 bg-blue-500 rounded-full blur-3xl opacity-20 top-20 left-10"></div>
    <div class="absolute w-72 h-72 bg-purple-500 rounded-full blur-3xl opacity-20 bottom-10 right-10"></div>

    <!-- ✅ CONTENT -->
    <div class="flex items-center justify-center min-h-screen pt-24 px-4">

        <div class="bg-white/90 backdrop-blur-md rounded-3xl p-10 w-full max-w-md shadow-2xl border border-white/30">

            <!-- Icon -->
            <div class="flex justify-center mb-4">
                <div class="bg-gradient-to-tr from-blue-500 to-indigo-600 text-white p-4 rounded-full text-2xl shadow-lg">
                    🏨
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center mb-1 text-gray-800">
                My Reservation
            </h2>
            <p class="text-center text-sm text-gray-500 mb-6">
                Check your booking instantly
            </p>

            <form action="{{ route('reservation.check') }}" method="POST" class="space-y-5">
                @csrf

                <input
                    type="text"
                    name="code"
                    placeholder="Reservation Code"
                    required
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none">

                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required
                    class="w-full px-5 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-400 outline-none">

                <button
                    type="submit"
                    class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition">
                    View Reservation
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-6">
                🔒 Secure & encrypted reservation lookup
            </p>

        </div>
    </div>

</body>

</html>