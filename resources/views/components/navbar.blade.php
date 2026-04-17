<!-- Navbar -->
<nav class="bg-[#C8A96A]/80 backdrop-blur-md fixed w-full z-50 top-0 shadow-sm">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between p-4"> <!-- LEFT: Logo -->
        <div class="flex items-center"> <span class="text-xl font-bold text-black-800">🏨 Stayzy Hotel</span> </div> <!-- CENTER: Menu (desktop only) -->
        <div class="hidden md:flex gap-6 text-black-600 font-medium"> <a href="/" class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Home </a> <a href="/about" class="{{ request()->is('about') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> About </a> <a href="/reservation" class="{{ request()->is('reservation') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Reservation </a> <a href="/contact" class="{{ request()->is('contact') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Contact </a> </div> <!-- RIGHT: User + Hamburger -->
        <div class="flex items-center gap-3"> <!-- Hamburger --> <button data-collapse-toggle="navbar-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100"> ☰ </button> <!-- User -->
            <div class="relative"> <button id="user-menu-button" data-dropdown-toggle="user-dropdown"> <img src="https://ui-avatars.com/api/?name={{ session('user_name') ?? 'Guest' }}" class="w-10 h-10 rounded-full ring-2 ring-blue-500"> </button> <!-- Dropdown -->
                <div id="user-dropdown" class="hidden absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-lg border">
                    <div class="px-4 py-3 border-b">
                        <p class="font-semibold">{{ session('user_name') ?? 'Guest' }}</p>
                        <p class="text-sm text-gray-500">{{ session('email') ?? '-' }}</p>
                    </div> <a href="/profil" class="block px-4 py-2 hover:bg-gray-100">Profil</a> <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a> <a href="#" class="block px-4 py-2 hover:bg-gray-100">Transaksi</a>
                    <div class="border-t"></div> <a href="/logout" class="block px-4 py-2 text-red-500 hover:bg-red-50"> Logout </a>
                </div>
            </div>
        </div>
    </div> <!-- MOBILE MENU -->
    <div class="hidden md:hidden px-4 pb-4" id="navbar-menu">
        <div class="flex flex-col gap-2 text-gray-600 font-medium"> <a href="/" class="{{ request()->is('/') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Home </a> <a href="/about" class="{{ request()->is('about') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> About </a> <a href="/reservation" class="{{ request()->is('reservation') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Reservation </a> <a href="/contact" class="{{ request()->is('contact') ? 'text-blue-600 font-semibold' : 'hover:text-blue-600' }}"> Contact </a> </div>
    </div>
</nav>