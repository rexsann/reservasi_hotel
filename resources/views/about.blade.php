<!DOCTYPE html>
<html lang="id">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>About Us - HotelKu</title>
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
        <button type="button"
          class="relative group focus:outline-none"
          id="user-menu-button"
          data-dropdown-toggle="user-dropdown">

          <!-- Avatar -->
          <div class="w-10 h-10 rounded-full overflow-hidden 
                ring-2 ring-blue-500 
                group-hover:ring-blue-600 
                transition duration-200">

            <img
              src="https://ui-avatars.com/api/?name={{ session('user_name') ?? 'Guest' }}&background=0D8ABC&color=fff&bold=true"
              alt="user"
              class="w-full h-full object-cover">
          </div>

          <!-- Online dot (optional keren) -->
          <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></span>

        </button>

        <!-- Dropdown menu -->
        <!-- Dropdown menu -->
        <div id="user-dropdown"
          class="hidden absolute right-4 top-16 w-56 
           bg-white rounded-2xl shadow-xl 
           border border-gray-100 overflow-hidden z-50">

          <!-- HEADER -->
          <div class="px-4 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-black">

            <p class="font-semibold text-base tracking-wide">
              {{ session('user_name') ?? 'Guest' }}
            </p>

            <p class="text-sm text-blue-100 truncate">
              {{ session('email') ?? '-' }}
            </p>

          </div>


          <!-- MENU -->
          <ul class="py-2 text-sm text-gray-700">

            <li>
              <a href="/profil"
                class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition">
                👤 Profil
              </a>
            </li>

            <li>
              <a href="#"
                class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition">
                ⚙️ Settings
              </a>
            </li>

            <li>
              <a href="#"
                class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 transition">
                💳 Transaksi
              </a>
            </li>

            <!-- Divider -->
            <div class="border-t my-2"></div>

            <li>
              <a href="/logout"
                class="flex items-center gap-2 px-4 py-2 text-red-500 hover:bg-red-50 transition">
                🚪 Logout
              </a>
            </li>

          </ul>
        </div>





      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-default rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-neutral-primary">
          <li>
            <a href="#" class="block py-2 px-3 text-white bg-brand rounded md:bg-transparent md:text-fg-brand md:p-0" aria-current="page">Home</a>
          </li>
          <li>
            <a href="/about" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About</a>
          </li>
          <li>
            <a href="/reservation" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Reservation</a>
          </li>
          <li>
            <a href="/pricing" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Pricing</a>
          </li>
          <li>
            <a href="/contact" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Contact</a>
          </li>
        </ul>
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
            HotelKu adalah hotel modern yang terletak di Batam dengan bangunan 5 lantai yang dirancang untuk memberikan kenyamanan maksimal bagi tamu. Cocok untuk wisatawan maupun pebisnis.
        </p>

        <p class="text-gray-600 leading-relaxed">
            Dengan lokasi strategis dekat pusat kota, pelabuhan, dan pusat perbelanjaan, HotelKu menjadi pilihan ideal untuk menginap dengan suasana nyaman dan pelayanan ramah.
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
<footer class="bg-gray-900 text-white text-center py-4">
    © 2026 HotelKu Batam
</footer>

</body>
</html>
