@extends('layouts.app')

@section('title', 'Home - Stayzy Hotel')

@section('content')
<div class="pt-16">
  <!-- HERO -->
  <!-- HERO CAROUSEL -->
  <div id="default-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="3000">
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
    <!-- Carousel wrapper -->
    <div class="relative h-[50vh] md:h-[65vh] overflow-hidden">

      <!-- Item 1 -->
      <div class="duration-700 ease-in-out absolute inset-0" data-carousel-item="active">
        <img src="/images/logopdi.jpg" class="absolute block w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent *
        flex items-center justify-center text-center z-10">
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
      <ul class="grid grid-cols-4 text-center font-medium text-gray-600" style="height: 75px;">

  <li class="flex h-full">
    <a href="#overview"
      class="flex flex-1 h-full items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
      Overview
      <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all"></span>
    </a>
  </li>

  <li class="flex h-full">
    <a href="#facilities"
      class="flex flex-1 h-full items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
      Facilities
      <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all"></span>
    </a>
  </li>

  <li class="flex h-full">
    <a href="#location"
      class="flex flex-1 h-full items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
      Location
      <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all"></span>
    </a>
  </li>

  <li class="flex h-full">
    <a href="#rooms"
      class="flex flex-1 h-full items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
      Rooms
      <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all"></span>
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
      <div id="overview" class="scroll-mt-40 mt-16">
      

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
              Stayzy Hotel is a modern hotel offering comfort and luxury in the city center.
              With elegant design and excellent service, we ensure your stay is unforgettable.
              Our facilities include a restaurant, outdoor pool, fitness center, and meeting rooms.
              With a strategic location near attractions and transportation, Stayzy Hotel is the perfect choice for both leisure and business travelers.
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
      <div id="facilities" class="scroll-mt-40 mt-16">
  
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
      <div id="location" class="scroll-mt-40 mt-16">

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
              Stayzy Hotel is strategically located and easily accessible from various important locations,
              making your trip more comfortable and efficient.
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
  <div id="rooms" class="scroll-mt-40 mt-24">

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

      <!-- BUBBLE CARD -->
      <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-6 md:p-8 border border-white/60">

        <!-- TITLE -->
        <div class="mb-6">
          <h2 class="text-2xl font-semibold text-gray-800">
            Book Your Stay
          </h2>
          <p class="text-sm text-gray-500 mt-1">
            Find the best rooms for your comfort
          </p>
        </div>

        <!-- FORM GRID FIX -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

          <!-- STAY DATE (LEBIH BESAR) -->
          <div class="md:col-span-6">
            <label class="text-xs text-gray-500 mb-1 block">Stay Date</label>

            <input type="text" id="dateRange"
              placeholder="Select check-in - check-out"
              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white shadow-sm
          focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
          </div>

          <!-- GUESTS -->
          <div class="md:col-span-2">
            <label class="text-xs text-gray-500">Guests</label>
            <input type="number" placeholder="2"
              class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl
          focus:ring-2 focus:ring-blue-500 outline-none">
          </div>

          <!-- ROOMS -->
          <div class="md:col-span-2">
            <label class="text-xs text-gray-500">Rooms</label>
            <input type="number" placeholder="1"
              class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl
          focus:ring-2 focus:ring-blue-500 outline-none">
          </div>

          <!-- SEARCH -->
          <div class="md:col-span-2">
            <button
              class="w-full h-[48px] bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-md hover:shadow-xl hover:scale-[1.02] transition-all">
              Search
            </button>
          </div>

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

            <img src="https://picsum.photos/800/500"
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

@endsection