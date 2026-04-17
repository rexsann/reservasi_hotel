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
  <nav class="bg-[#C8A96A]/80 backdrop-blur-md fixed w-full z-50 top-0 border-b border-[#14afc7] shadow-sm">
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



  <div class="pt-20">
    <!-- HERO -->
    <!-- HERO CAROUSEL -->
    <div id="default-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="3000">
      <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
      <!-- Carousel wrapper -->
      <div class="relative h-[50vh] md:h-[65vh] overflow-hidden">

        <!-- Item 1 -->
        <div class="duration-700 ease-in-out absolute inset-0" data-carousel-item="active">
          <img src="https://source.unsplash.com/1600x900/?hotel" class="absolute block w-full h-full object-cover">

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
          <img src="https://source.unsplash.com/1600x900/?luxury-hotel"
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
          <img src="https://source.unsplash.com/1600x900/?resort"
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
        <div id="overview" class="scroll-mt-32">
          <h3 class="text-xl font-bold mb-4 text-gray-800">About Our Hotel</h3>

          <p class="text-gray-600 leading-relaxed">
            Stayzy Hotel adalah hotel modern yang menawarkan kenyamanan dan kemewahan di pusat kota.
            Dengan desain elegan dan pelayanan terbaik, kami memastikan pengalaman menginap Anda
            menjadi tak terlupakan.
          </p>

          <div class="grid md:grid-cols-3 gap-6 mt-6">

            <div class="bg-gray-50 p-4 rounded-xl text-center shadow-sm hover:shadow-md transition">
              <h4 class="font-bold text-lg">⭐ 4.8 Rating</h4>
              <p class="text-sm text-gray-500">Dari 1.000+ review</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl text-center shadow-sm hover:shadow-md transition">
              <h4 class="font-bold text-lg">🏨 60 Rooms</h4>
              <p class="text-sm text-gray-500">5 Lantai</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl text-center shadow-sm hover:shadow-md transition">
              <h4 class="font-bold text-lg">📍 Lokasi Strategis</h4>
              <p class="text-sm text-gray-500">Dekat pusat kota</p>
            </div>

          </div>
        </div>


        <!-- DIVIDER -->
        <div class="border-t"></div>


        <!-- FACILITIES -->
        <div id="facilities" class="scroll-mt-32">
          <h3 class="text-lg font-semibold mb-4 text-gray-800">Facilities</h3>

          <div class="grid md:grid-cols-3 gap-6 text-sm">

            <div class="bg-gray-50 p-4 rounded-xl">
              <p>Fire Safety System</p>
              <p class="mt-3">GYM/Fitness Center</p>
              <p class="mt-3">Smoke Alarm in Public Area</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
              <p>Dry Cleaning</p>
              <p class="mt-3">Meeting Room</p>
              <p class="mt-3">Outdoor Pool</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-xl">
              <p>Restaurant</p>
              <p class="mt-3">Elevator</p>
              <p class="mt-3">Laundry Service</p>
            </div>

          </div>
        </div>


        <!-- DIVIDER -->
        <div class="border-t"></div>


        <!-- LOCATION -->
        <div id="location" class="scroll-mt-32">
          <h3 class="text-lg font-semibold mb-4 text-gray-800">Our Location</h3>

          <p class="text-gray-600 mb-4">
            HotelKu berada di lokasi strategis yang mudah diakses dari berbagai tempat penting.
          </p>

          <iframe
            src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
            class="w-full h-80 rounded-xl border">
          </iframe>

          <div class="mt-4 grid md:grid-cols-3 gap-4 text-sm">
            <div class="bg-gray-50 p-4 rounded-lg">✈️ 20 menit dari Bandara</div>
            <div class="bg-gray-50 p-4 rounded-lg">🛍️ Dekat Mall</div>
            <div class="bg-gray-50 p-4 rounded-lg">🚕 Akses transportasi mudah</div>
          </div>
        </div>

      </div>

    </div>


    <!-- ROOMS -->
    <!-- BOOKING FILTER -->
    <!-- ROOMS SECTION -->
    <div id="rooms" class="scroll-mt-32 mt-20">

      <!-- Title -->
      <div class="max-w-screen-xl mx-auto px-4 mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Our Rooms</h3>
        <p class="text-gray-500 text-sm">Choose the best room for your stay</p>
      </div>

      <!-- BOOKING FILTER -->
      <div class="max-w-screen-xl mx-auto px-4 mb-10">
        <div class="bg-white shadow-lg rounded-2xl p-6 grid md:grid-cols-5 gap-4 items-end">

          <div>
            <label class="text-sm text-gray-500">Check-in</label>
            <input type="date" class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
          </div>

          <div>
            <label class="text-sm text-gray-500">Check-out</label>
            <input type="date" class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
          </div>

          <div>
            <label class="text-sm text-gray-500">Guests</label>
            <input type="number" placeholder="2" class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
          </div>

          <div>
            <label class="text-sm text-gray-500">Rooms</label>
            <input type="number" placeholder="1" class="w-full mt-1 border rounded-lg p-2 focus:ring-2 focus:ring-blue-400">
          </div>

          <button class="bg-blue-600 text-white rounded-lg py-2 mt-5 hover:bg-blue-700 transition">
            Search
          </button>

        </div>
      </div>

      <!-- ROOM LIST -->
      <div class="max-w-screen-xl mx-auto px-4 space-y-8">

        @foreach ($rooms as $room)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-5">

          <div class="grid md:grid-cols-3 gap-6">

            <!-- LEFT -->
            <div>
              <img src="{{ $room['image'] }}"
                class="rounded-xl w-full h-52 object-cover">

              <h4 class="mt-4 font-semibold text-lg text-gray-800">
                {{ $room['name'] }}
              </h4>

              <p class="text-sm text-gray-500">
                {{ $room['bed'] }} • {{ $room['guest'] }}
              </p>

              <div class="mt-3 text-sm grid grid-cols-2 gap-2 text-gray-600">
                @foreach ($room['amenities'] as $item)
                <span>✔ {{ $item }}</span>
                @endforeach
              </div>

              <button class="mt-4 w-full bg-gray-800 text-white py-2 rounded-lg hover:bg-black transition">
                See Details
              </button>
            </div>

            <!-- RIGHT -->
            <div class="md:col-span-2">
              <div class="space-y-4">

                @foreach ($room['prices'] as $price)
                <div class="border rounded-xl p-4 flex justify-between items-center hover:shadow-md transition">

                  <!-- INFO -->
                  <div>
                    <h5 class="font-semibold text-gray-800">
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

                    <p class="text-xl font-bold text-blue-600">
                      Rp {{ number_format($price['price'], 0, ',', '.') }}
                    </p>

                    <button class="mt-2 px-4 py-2 rounded-lg text-white 
                  {{ isset($price['highlight']) ? 'bg-orange-500' : 'bg-blue-600' }} hover:opacity-90 transition">
                      Select
                    </button>

                  </div>
                </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
        @endforeach

      </div>

    </div>
  </div>
  </div>

  <!-- FOOTER -->
  <footer class="bg-gray-900 text-white text-center py-4 mt-16">
    © 2026 HotelKu
  </footer>

</body>

</html>