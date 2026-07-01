<!-- Navbar -->
<nav class="bg-[#355E3B]/90 backdrop-blur-md fixed w-full top-0 z-50 shadow-md border-b border-white/20">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between px-6 py-4">

        <!-- LEFT : Logo -->
        <div class="flex items-center">
            <a href="/" class="flex items-center gap-3">

                <!-- Logo Image -->
                <img src="{{ asset('images/logo_hotel.png') }}" alt="Stayzy Hotel Logo"
                    class="w-14 h-14 rounded-xl object-cover shadow-md border-2 border-white">

                <!-- Hotel Name -->
                <span class="text-2xl font-bold text-gray-900 tracking-wide">
                    Stayzy Hotel
                </span>

            </a>
        </div>

        <!-- CENTER : Desktop Menu -->
        <div class="hidden md:flex items-center gap-8 text-gray-800 font-medium">

            <a href="/"
                class="{{ request()->is('/') ? 'text-blue-700 font-semibold border-b-2 border-blue-600 pb-1' : 'hover:text-blue-600 transition' }}">
                Home
            </a>

            <a href="/about"
                class="{{ request()->is('about') ? 'text-blue-700 font-semibold border-b-2 border-blue-600 pb-1' : 'hover:text-blue-600 transition' }}">
                About
            </a>

            <a href="/reservation"
                class="{{ request()->is('reservation') ? 'text-blue-700 font-semibold border-b-2 border-blue-600 pb-1' : 'hover:text-blue-600 transition' }}">
                Reservation
            </a>

            <a href="/contact"
                class="{{ request()->is('contact') ? 'text-blue-700 font-semibold border-b-2 border-blue-600 pb-1' : 'hover:text-blue-600 transition' }}">
                Contact
            </a>
        </div>

        <!-- RIGHT : User + Hamburger -->
        <div class="flex items-center gap-4">

            <!-- Hamburger Mobile -->
            <button data-collapse-toggle="navbar-menu" type="button"
                class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-gray-700 md:hidden hover:bg-white/30 transition">
                ☰
            </button>

            @auth
                <!-- User Dropdown (sudah login) -->
                <div class="relative">

                    <button id="user-menu-button" data-dropdown-toggle="user-dropdown"
                        class="flex items-center gap-2 hover:scale-105 transition">

                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                            class="w-11 h-11 rounded-full ring-2 ring-white shadow-md">

                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-dropdown"
                        class="hidden absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

                        <!-- User Info -->
                        <div class="px-5 py-4 bg-gray-50 border-b">
                            <p class="font-semibold text-gray-800 text-base">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ Auth::user()->email }}
                            </p>
                        </div>

                        <!-- Menu -->
                        <div class="py-2">

                            <a href="/profil" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">
                                👤 Profile
                            </a>

                            <a href="/history" class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition">
                                📖 Reservation History
                            </a>

                        </div>

                        <!-- Logout -->
                        <div class="border-t">
                            <button type="button" onclick="document.getElementById('logout-modal').classList.remove('hidden')"
                                class="w-full flex items-center gap-3 px-5 py-3 text-red-500 hover:bg-red-50 transition font-medium text-left">
                                🚪 Logout
                            </button>
                        </div>

                    </div>
                </div>
            @else
                <!-- Tombol Login (belum login) -->
                <a href="/login"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white text-[#355E3B] font-semibold shadow-md hover:bg-gray-100 transition">
                    🔑 Login
                </a>
            @endauth

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div class="hidden md:hidden px-6 pb-5" id="navbar-menu">
        <div class="flex flex-col gap-3 text-gray-800 font-medium pt-2">

            <a href="/"
                class="{{ request()->is('/') ? 'text-blue-700 font-semibold' : 'hover:text-blue-600 transition' }}">
                Home
            </a>

            <a href="/about"
                class="{{ request()->is('about') ? 'text-blue-700 font-semibold' : 'hover:text-blue-600 transition' }}">
                About
            </a>

            <a href="/reservation"
                class="{{ request()->is('reservation') ? 'text-blue-700 font-semibold' : 'hover:text-blue-600 transition' }}">
                Reservation
            </a>

            <a href="/contact"
                class="{{ request()->is('contact') ? 'text-blue-700 font-semibold' : 'hover:text-blue-600 transition' }}">
                Contact
            </a>

        </div>
    </div>
</nav>

@auth
<!-- Logout Confirmation Modal -->
<div id="logout-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6 text-center">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">
            Logout Confirmation
        </h3>
        <p class="text-sm text-gray-500 mb-6">
            Are you sure you want to log out of this account?
        </p>
        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('logout-modal').classList.add('hidden')"
                class="flex-1 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition">
                Cancel
            </button>
            <form action="{{ route('logout') }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                    class="w-full py-2.5 rounded-xl bg-red-500 text-white font-medium hover:bg-red-600 transition">
                    Yes, Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endauth