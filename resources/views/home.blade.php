<!DOCTYPE html>
<html lang="id">

<head>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta charset="UTF-8">
  <title>HotelKu</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gray-100">

  <!-- Navbar -->


  <nav class="bg-white fixed w-full z-50 top-0 border-b border-gray-200 shadow">

    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-7" alt="Flowbite Logo" />
        <span class="self-center text-xl text-heading font-semibold whitespace-nowrap">Flowbite</span>
      </a>
      <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
        <button type="button" class="flex text-sm bg-neutral-primary rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
          <span class="sr-only">Open user menu</span>
          <img class="w-8 h-8 rounded-full" src="/docs/images/people/profile-picture-5.jpg" alt="user photo">
        </button>
        <!-- Dropdown menu -->
        <div class="z-50 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44" id="user-dropdown">
          <div class="px-4 py-3 text-sm border-b border-default">
            <span class="block text-heading font-medium">Joseph McFall</span>
            <span class="block text-body truncate">name@flowbite.com</span>
          </div>
          <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
            <li>
              <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Dashboard</a>
            </li>
            <li>
              <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Settings</a>
            </li>
            <li>
              <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Earnings</a>
            </li>
            <li>
              <a href="#" class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">Sign out</a>
            </li>
          </ul>
        </div>
        <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-user" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
          <li>
            <a href="#" class="block py-2 px-3 text-white bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0" aria-current="page">Home</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Reservation</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Pricing</a>
          </li>
          <li>
            <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- HERO -->
  <!-- HERO CAROUSEL -->
  <div id="default-carousel" class="relative w-full mt-16" data-carousel="slide">

    <!-- Carousel wrapper -->
    <div class="relative h-[90vh] overflow-hidden">

      <!-- Item 1 -->
      <div class="duration-700 ease-in-out absolute inset-0" data-carousel-item="active">
        <img src="https://source.unsplash.com/1600x900/?hotel" class="absolute block w-full h-full object-cover">

        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center z-10">
          <div class="text-white">
            <h1 class="text-5xl font-bold">Selamat Datang</h1>
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
            <h1 class="text-5xl font-bold">Hotel Mewah</h1>
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
            <h1 class="text-5xl font-bold">Liburan Sempurna</h1>
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
  <div class="container mx-auto px-6 relative z-30">
    <div class="bg-white rounded-xl shadow-lg p-6 -mt-20">
      <form class="grid md:grid-cols-5 gap-4">
        <input type="date" class="border p-2 rounded-lg">
        <input type="date" class="border p-2 rounded-lg">
        <input type="number" placeholder="Tamu" class="border p-2 rounded-lg">
        <input type="number" placeholder="Kamar" class="border p-2 rounded-lg">

        <button class="bg-blue-600 text-white rounded-lg">
          Cari
        </button>
      </form>
    </div>
  </div>

  <body class="scroll-smooth">

    <!-- TABS -->
    <div class="container mx-auto px-6 mt-10 sticky top-16 z-40">

      <ul class="grid grid-cols-4 text-center font-semibold bg-gray-200 rounded-xl overflow-hidden">

        <li>
          <a href="#overview" class="menu-link block w-full py-4">OVERVIEW</a>
        </li>

        <li>
          <a href="#facilities" class="menu-link block w-full py-4">FACILITIES</a>
        </li>

        <li>
          <a href="#location" class="menu-link block w-full py-4">LOCATION</a>
        </li>

        <li>
          <a href="#rooms" class="menu-link block w-full py-4">ROOMS</a>
        </li>

      </ul>

    </div>




    <!-- CONTENT -->
    <div id="tab-content" class="bg-white p-6">

      <!-- OVERVIEW -->
      <div id="overview" class="pt-24">
        <h3 class="text-xl font-bold mb-4">About Our Hotel</h3>

        <p class="text-gray-600 leading-relaxed">
          HotelKu adalah hotel modern yang menawarkan kenyamanan dan kemewahan di pusat kota.
          Dengan desain elegan dan pelayanan terbaik, kami memastikan pengalaman menginap Anda
          menjadi tak terlupakan.
        </p>

        <div class="grid md:grid-cols-3 gap-6 mt-6">
          <div class="bg-gray-100 p-4 rounded-xl text-center">
            <h4 class="font-bold text-lg">⭐ 4.8 Rating</h4>
            <p class="text-sm text-gray-500">Dari 1.000+ review</p>
          </div>
          <div class="bg-gray-100 p-4 rounded-xl text-center">
            <h4 class="font-bold text-lg">🏨 60 Rooms</h4>
            <p class="text-sm text-gray-500">5 Lantai</p>
          </div>
          <div class="bg-gray-100 p-4 rounded-xl text-center">
            <h4 class="font-bold text-lg">📍 Lokasi Strategis</h4>
            <p class="text-sm text-gray-500">Dekat pusat kota</p>
          </div>
        </div>
      </div>

      <!-- FACILITIES -->
      <div id="facilities" class="pt-24">
        <h3 class="text-lg font-semibold mb-4">Facilities</h3>

        <div class="bg-gray-100 rounded-2xl p-6 grid md:grid-cols-3 gap-6 text-sm">
          <div>
            <p>Fire Safety System</p>
            <p class="mt-3">GYM/Fitness Center</p>
            <p class="mt-3">Smoke Alarm in Public Area</p>
          </div>
          <div>
            <p>Dry Cleaning</p>
            <p class="mt-3">Meeting Room</p>
            <p class="mt-3">Outdoor Pool</p>
          </div>
          <div>
            <p>Restaurant</p>
            <p class="mt-3">Elevator</p>
            <p class="mt-3">Laundry Service</p>
          </div>
        </div>
      </div>

      <!-- LOCATION -->
      <div id="location" class="pt-24">
        <h3 class="text-lg font-semibold mb-4">Our Location</h3>

        <p class="text-gray-600 mb-4">
          HotelKu berada di lokasi strategis yang mudah diakses dari berbagai tempat penting.
        </p>

        <!-- MAP -->
        <iframe
          src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
          class="w-full h-80 rounded-xl border">
        </iframe>

        <div class="mt-4 grid md:grid-cols-3 gap-4 text-sm">
          <div class="bg-gray-100 p-4 rounded-lg">
            ✈️ 20 menit dari Bandara
          </div>
          <div class="bg-gray-100 p-4 rounded-lg">
            🛍️ Dekat Mall
          </div>
          <div class="bg-gray-100 p-4 rounded-lg">
            🚕 Akses transportasi mudah
          </div>
        </div>
      </div>

      <!-- ROOMS -->
      <div id="rooms" class="scroll-mt-24 mt-16 container mx-auto px-6">

  <h2 class="text-3xl font-bold mb-8">Stay Choices</h2>

  @foreach ($rooms as $room)
    <div class="bg-white rounded-xl shadow-md mb-8 p-4">
      <div class="grid md:grid-cols-3 gap-6">

        <!-- LEFT -->
        <div>
          <img src="{{ $room['image'] }}" class="rounded-lg w-full h-48 object-cover">

          <h4 class="mt-3 font-semibold text-lg">{{ $room['name'] }}</h4>
          <p class="text-sm text-gray-500">
            {{ $room['bed'] }} • {{ $room['guest'] }}
          </p>

          <div class="mt-3 text-sm grid grid-cols-2 gap-2 text-gray-600">
            @foreach ($room['amenities'] as $item)
              <span>{{ $item }}</span>
            @endforeach
          </div>

          <button class="mt-4 w-full bg-teal-700 text-white py-2 rounded-lg">
            See Room Detail
          </button>
        </div>

        <!-- RIGHT -->
        <div class="md:col-span-2">
          <div class="max-h-[260px] overflow-y-auto space-y-4 pr-2">

            @foreach ($room['prices'] as $price)
              <div class="border rounded-xl p-4 flex justify-between items-center">

                <div>
                  <h5 class="font-semibold">{{ $price['title'] }}</h5>

                  <ul class="text-sm text-gray-500 mt-2">
                    @foreach ($price['features'] as $f)
                      <li>✔ {{ $f }}</li>
                    @endforeach
                  </ul>
                </div>

                <div class="text-right">

                  @if(isset($price['old_price']))
                    <p class="line-through text-gray-400 text-sm">
                      Rp {{ number_format($price['old_price'], 0, ',', '.') }}
                    </p>
                  @endif

                  <p class="text-xl font-bold text-teal-700">
                    Rp {{ number_format($price['price'], 0, ',', '.') }}
                  </p>

                  <button class="mt-2 px-4 py-2 rounded text-white 
                    {{ isset($price['highlight']) ? 'bg-orange-500' : 'bg-teal-700' }}">
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


    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white text-center py-4 mt-16">
      © 2026 HotelKu
    </footer>

  </body>

</html>