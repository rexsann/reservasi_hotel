<!DOCTYPE html>
<html lang="id">

<head>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta charset="UTF-8">
  <title>Stayzy Hotel</title>
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



  <div class="pt-16">
    <!-- HERO -->
    <!-- HERO CAROUSEL -->
    <div id="default-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="3000">
      <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
      <!-- Carousel wrapper -->
      <div class="relative h-[50vh] md:h-[65vh] overflow-hidden">

        <!-- Item 1 -->
        <div class="duration-700 ease-in-out absolute inset-0" data-carousel-item="active">
          <img src="https://picsum.photos/800/600" class="absolute block w-full h-full object-cover">

          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent flex items-center justify-center text-center z-10">
            <div class="text-white">
              <h1 class="text-3xl md:text-5xl font-bold">
                Selamat Datang di Stayzy Hotel
              </h1>
              <p>Nikmati pengalaman menginap terbaik</p>
            </div>
          </div>
        </div>

        <!-- Item 2 -->
        <div class="hidden duration-700 ease-in-out absolute inset-0" data-carousel-item>
          <img src="https://picsum.photos/800/500"
            class="absolute block w-full h-full object-cover">

          <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center">
            <div class="text-white">
              <h1 class="text-3xl md:text-5xl font-bold">Hotel Mewah</h1>
              <p>Fasilitas lengkap & nyaman</p>
            </div>
          </div>
        </div>

        <!-- Item 3 -->
        <div class="hidden duration-700 ease-in-out absolute inset-0" data-carousel-item>
          <img src="https://picsum.photos/800/700"
            class="absolute block w-full h-full object-cover">

          <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center">
            <div class="text-white">
              <h1 class="text-3xl md:text-5xl font-bold">Liburan Sempurna</h1>
              <p>Rasakan pengalaman terbaik</p>
            </div>
          </div>
        </div>

      </div>

      <!-- Slider indicators -->
      <div class="absolute z-30 flex space-x-3 -translate-x-1/2 bottom-5 left-1/2">
        <button type="button" class="w-3 h-3 rounded-full bg-white" data-carousel-slide-to="0"></button>
        <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="1"></button>
        <button type="button" class="w-3 h-3 rounded-full bg-white/50" data-carousel-slide-to="2"></button>
      </div>

      <!-- Controls -->
      <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-prev>
        ❮
      </button>
      <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-next>
        ❯
      </button>

    </div>

    <!-- BOOKING -->



    <!-- TABS -->
    <div class="w-full sticky top-16 z-40">

      <div class="w-full bg-white/90 backdrop-blur-md border-b shadow-sm">
        <ul class="grid grid-cols-4 text-center font-medium text-gray-600">

          <li>
            <a href="#overview"
              class="block py-4 hover:text-blue-600 hover:bg-blue-50 transition relative">
              Overview
              <span class="block h-0.5 bg-blue-600 w-0 hover:w-full transition-all mx-auto mt-1"></span>
            </a>
          </li>

          <li>
            <a href="#facilities"
              class="block py-4 hover:text-blue-600 hover:bg-blue-50 transition relative">
              Facilities
              <span class="block h-0.5 bg-blue-600 w-0 hover:w-full transition-all mx-auto mt-1"></span>
            </a>
          </li>

          <li>
            <a href="#location"
              class="block py-4 hover:text-blue-600 hover:bg-blue-50 transition relative">
              Location
              <span class="block h-0.5 bg-blue-600 w-0 hover:w-full transition-all mx-auto mt-1"></span>
            </a>
          </li>

          <li>
            <a href="#rooms"
              class="block py-4 hover:text-blue-600 hover:bg-blue-50 transition relative">
              Rooms
              <span class="block h-0.5 bg-blue-600 w-0 hover:w-full transition-all mx-auto mt-1"></span>
            </a>
          </li>

        </ul>
      </div>

    </div>

    <!-- CONTENT -->
    <div id="tab-content" class="bg-[#cfc7c7] p-6">

      <!-- ONE BIG BUBBLE -->
      <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 space-y-16">

        <!-- OVERVIEW -->
        <div id="overview" class="scroll-mt-32 mt-16">

          <!-- TITLE -->
          <div class="max-w-screen-xl mx-auto px-4 mb-6">
            <h3 class="text-3xl font-bold text-gray-800">About Our Hotel</h3>
            <p class="text-sm text-gray-500 mt-1">
              Discover comfort, elegance, and premium hospitality
            </p>
          </div>

          <!-- DESCRIPTION -->
          <div class="max-w-screen-xl mx-auto px-4">

            <div class="bg-white/70 backdrop-blur-xl border border-gray-100 shadow-sm rounded-3xl p-6 md:p-8">

              <p class="text-gray-600 leading-relaxed text-base md:text-lg">
                Stayzy Hotel adalah hotel modern yang menawarkan kenyamanan dan kemewahan di pusat kota.
                Dengan desain elegan dan pelayanan terbaik, kami memastikan pengalaman menginap Anda
                menjadi tak terlupakan.
              </p>

            </div>

          </div>

          <!-- STATS -->
          <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6">

            <!-- CARD 1 -->
            <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">

              <div class="text-3xl mb-2">⭐</div>
              <h4 class="text-2xl font-bold text-gray-800">4.8</h4>
              <p class="text-sm text-gray-500 mt-1">Rating from 1.000+ reviews</p>

            </div>

            <!-- CARD 2 -->
            <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">

              <div class="text-3xl mb-2">🏨</div>
              <h4 class="text-2xl font-bold text-gray-800">60 Rooms</h4>
              <p class="text-sm text-gray-500 mt-1">5 Floors Premium Building</p>

            </div>

            <!-- CARD 3 -->
            <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">

              <div class="text-3xl mb-2">📍</div>
              <h4 class="text-2xl font-bold text-gray-800">Strategic Location</h4>
              <p class="text-sm text-gray-500 mt-1">Near city center & attractions</p>

            </div>

          </div>

        </div>


        <!-- DIVIDER -->
        <div class="border-t"></div>


        <!-- FACILITIES -->
        <div id="facilities" class="scroll-mt-32 mt-16">

          <!-- TITLE -->
          <div class="max-w-screen-xl mx-auto px-4 mb-6">
            <h3 class="text-3xl font-bold text-gray-800">Facilities</h3>
            <p class="text-sm text-gray-500 mt-1">
              Premium amenities for your comfort and safety
            </p>
          </div>

          <!-- GRID -->
          <div class="max-w-screen-xl mx-auto px-4 grid md:grid-cols-3 gap-6 text-sm">

            <!-- COL 1 -->
            <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">

              <div class="flex items-center gap-3">
                <span class="text-xl">🔥</span>
                <p>Fire Safety System</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🏋️</span>
                <p>GYM / Fitness Center</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🚨</span>
                <p>Smoke Alarm in Public Area</p>
              </div>

            </div>

            <!-- COL 2 -->
            <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">

              <div class="flex items-center gap-3">
                <span class="text-xl">🧺</span>
                <p>Dry Cleaning</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🏢</span>
                <p>Meeting Room</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🏊</span>
                <p>Outdoor Pool</p>
              </div>

            </div>

            <!-- COL 3 -->
            <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">

              <div class="flex items-center gap-3">
                <span class="text-xl">🍽️</span>
                <p>Restaurant</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🛗</span>
                <p>Elevator</p>
              </div>

              <div class="flex items-center gap-3">
                <span class="text-xl">🧼</span>
                <p>Laundry Service</p>
              </div>

            </div>

          </div>
        </div>


        <!-- DIVIDER -->
        <div class="border-t"></div>


        <!-- LOCATION -->
        <div id="location" class="scroll-mt-32 mt-16">

          <!-- TITLE -->
          <div class="max-w-screen-xl mx-auto px-4 mb-6">
            <h3 class="text-3xl font-bold text-gray-800">Our Location</h3>
            <p class="text-sm text-gray-500 mt-1">
              Strategically located for your convenience and comfort
            </p>
          </div>

          <!-- DESCRIPTION -->
          <div class="max-w-screen-xl mx-auto px-4 mb-6">

            <div class="bg-white/70 backdrop-blur-xl border border-gray-100 shadow-sm rounded-3xl p-6 md:p-8">

              <p class="text-gray-600 leading-relaxed">
                HotelKu berada di lokasi strategis yang mudah diakses dari berbagai tempat penting,
                menjadikan perjalanan Anda lebih nyaman dan efisien.
              </p>

            </div>

          </div>

          <!-- MAP -->
          <div class="max-w-screen-xl mx-auto px-4">

            <div class="rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:shadow-2xl transition">

              <iframe
                src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
                class="w-full h-96">
              </iframe>

            </div>

          </div>

          <!-- FEATURES -->
          <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6 text-sm">

            <!-- CARD 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">

              <div class="text-3xl mb-2">✈️</div>
              <h4 class="font-semibold text-gray-800">20 Minutes</h4>
              <p class="text-gray-500 mt-1">From Airport</p>

            </div>

            <!-- CARD 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">

              <div class="text-3xl mb-2">🛍️</div>
              <h4 class="font-semibold text-gray-800">Nearby Mall</h4>
              <p class="text-gray-500 mt-1">Shopping & Entertainment</p>

            </div>

            <!-- CARD 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">

              <div class="text-3xl mb-2">🚕</div>
              <h4 class="font-semibold text-gray-800">Easy Transport</h4>
              <p class="text-gray-500 mt-1">Taxi & Ride Available</p>

            </div>

          </div>

        </div>

      </div>

    </div>


    <!-- ROOMS -->
    <!-- BOOKING FILTER -->
    <!-- ROOMS SECTION -->
    <div id="rooms" class="scroll-mt-32 mt-24">

      <!-- TITLE -->
      <!-- TITLE -->
      <div class="max-w-screen-xl mx-auto px-4 mb-10">
        <h3 class="text-4xl font-bold text-gray-800 tracking-tight">
          Our Rooms
        </h3>
        <p class="text-gray-500 text-sm mt-2">
          Choose the best room for your stay
        </p>
      </div>

      <!-- BOOKING FILTER -->
      <div class="max-w-screen-xl mx-auto px-4 -mt-8 relative z-20 mb-14">

        <div class="bg-white/70 backdrop-blur-2xl shadow-xl rounded-3xl p-6 md:p-8 border border-white/50">

          <div class="mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">
              Book Your Stay
            </h2>
            <p class="text-sm text-gray-500 mt-1">
              Find the best rooms for your comfort
            </p>
          </div>

          <div class="grid md:grid-cols-5 gap-4 items-end">

            <div>
              <label class="text-xs text-gray-500">Check-in</label>
              <input type="date"
                class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
              <label class="text-xs text-gray-500">Check-out</label>
              <input type="date"
                class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
              <label class="text-xs text-gray-500">Guests</label>
              <input type="number" placeholder="2"
                class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div>
              <label class="text-xs text-gray-500">Rooms</label>
              <input type="number" placeholder="1"
                class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <button
              class="h-[48px] bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-md hover:shadow-xl hover:scale-[1.02] transition-all">
              Search
            </button>

          </div>

        </div>
      </div>

      <!-- ROOM LIST -->
      <div class="max-w-screen-xl mx-auto px-4 space-y-12">

        @foreach ($rooms as $room)
        <div class="bg-white rounded-3xl shadow-sm hover:shadow-2xl transition overflow-hidden border border-gray-100">

          <div class="grid md:grid-cols-3 gap-0">

            <!-- LEFT -->
            <div class="p-6 md:border-r border-gray-100">

              <img src="{{ $room['image'] }}"
                class="rounded-2xl w-full h-56 object-cover hover:scale-105 transition duration-500">

              <h4 class="mt-5 font-semibold text-2xl text-gray-800">
                {{ $room['name'] }}
              </h4>

              <p class="text-sm text-gray-500 mt-1">
                {{ $room['bed'] }} • {{ $room['guest'] }}
              </p>

              <div class="mt-5 grid grid-cols-2 gap-2 text-sm text-gray-600">
                @foreach ($room['amenities'] as $item)
                <span class="flex items-center gap-1">✔ {{ $item }}</span>
                @endforeach
              </div>

              <button
                class="mt-6 w-full bg-gray-900 text-white py-3 rounded-xl hover:bg-black transition font-medium">
                See Details
              </button>

            </div>

            <!-- RIGHT -->
            <div class="md:col-span-2 p-6 space-y-5 bg-gray-50/40">

              @foreach ($room['prices'] as $price)
              <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center hover:shadow-md transition">

                <!-- INFO -->
                <div>
                  <h5 class="font-semibold text-gray-800 text-lg">
                    {{ $price['title'] }}
                  </h5>

                  <ul class="text-sm text-gray-500 mt-2 space-y-1">
                    @foreach ($price['features'] as $f)
                    <li>✔ {{ $f }}</li>
                    @endforeach
                  </ul>
                </div>

                <!-- PRICE -->
                <div class="text-right">

                  @if(isset($price['old_price']))
                  <p class="line-through text-gray-400 text-sm">
                    Rp {{ number_format($price['old_price'], 0, ',', '.') }}
                  </p>
                  @endif

                  <p class="text-2xl font-bold text-blue-600">
                    Rp {{ number_format($price['price'], 0, ',', '.') }}
                  </p>

                  <button
                    class="mt-3 px-6 py-2 rounded-xl text-white text-sm font-semibold
              {{ isset($price['highlight']) ? 'bg-orange-500' : 'bg-blue-600' }}
              hover:opacity-90 transition shadow-sm">
                    Select
                  </button>

                </div>

              </div>
              @endforeach

            </div>

          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-gray-300 pt-12 pb-6 mt-10">

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