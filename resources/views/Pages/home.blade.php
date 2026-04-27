@extends('layouts.app')

@section('title', 'Home - Stayzy Hotel')

@section('content')
<div class="pt-16">

  <!-- HERO CAROUSEL -->
  {{-- FIX: Flowbite script dipindah ke bawah sebelum @endsection --}}
  <div id="default-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="3000">

    <!-- Carousel wrapper -->
    <div class="relative h-[50vh] md:h-[65vh] overflow-hidden">

      <!-- Item 1 -->
      <div class="duration-700 ease-in-out absolute inset-0" data-carousel-item="active">
        <img src="/images/logopdi.jpg" class="absolute block w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent flex items-center justify-center text-center z-10">
          <div class="text-white">
            <h1 class="text-3xl md:text-5xl font-bold">Welcome to Stayzy Hotel</h1>
            <p>Enjoy the best staying experience</p>
          </div>
        </div>
      </div>

      <!-- Item 2 -->
      <div class="hidden duration-700 ease-in-out absolute inset-0" data-carousel-item>
        <img src="https://picsum.photos/800/500" class="absolute block w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center">
          <div class="text-white">
            <h1 class="text-3xl md:text-5xl font-bold">Luxury Hotels</h1>
            <p>Complete & comfortable facilities</p>
          </div>
        </div>
      </div>

      <!-- Item 3 -->
      <div class="hidden duration-700 ease-in-out absolute inset-0" data-carousel-item>
        <img src="https://picsum.photos/800/700" class="absolute block w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center">
          <div class="text-white">
            <h1 class="text-3xl md:text-5xl font-bold">Perfect Vacation</h1>
            <p>Experience the best</p>
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
    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-prev>❮</button>
    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-next>❯</button>

  </div>


  <!-- Sticky Navigation -->
  <div class="w-full sticky top-[88px] z-40">
    <div class="w-full bg-white/95 backdrop-blur-md border-b shadow-sm">
      <ul class="grid grid-cols-4 text-center font-medium text-gray-700 h-[75px]">

        <li class="flex h-full">
          <a href="#overview" class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
            Overview
            <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
          </a>
        </li>

        <li class="flex h-full">
          <a href="#facilities" class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
            Facilities
            <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
          </a>
        </li>

        <li class="flex h-full">
          <a href="#location" class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
            Location
            <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
          </a>
        </li>

        <li class="flex h-full">
          <a href="#rooms" class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
            Rooms
            <span class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
          </a>
        </li>

      </ul>
    </div>
  </div>


  <!-- CONTENT -->
  <div id="tab-content" class="bg-[#cfc7c7] p-6">
    <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 space-y-16">

      <!-- OVERVIEW -->
      <section id="overview" class="scroll-mt-[170px]">
        <div class="max-w-screen-xl mx-auto px-4 mb-6">
          <h3 class="text-3xl font-bold text-gray-800">About Our Hotel</h3>
          <p class="text-sm text-gray-500 mt-1">Discover comfort, elegance, and premium hospitality</p>
        </div>

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

        <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6">
          <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
            <div class="text-3xl mb-2">⭐</div>
            <h4 class="text-2xl font-bold text-gray-800">4.8</h4>
            <p class="text-sm text-gray-500 mt-1">Rating from 1.000+ reviews</p>
          </div>
          <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
            <div class="text-3xl mb-2">🏨</div>
            <h4 class="text-2xl font-bold text-gray-800">30 Rooms</h4>
            <p class="text-sm text-gray-500 mt-1">3 Floors Premium Building</p>
          </div>
          <div class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
            <div class="text-3xl mb-2">📍</div>
            <h4 class="text-2xl font-bold text-gray-800">Strategic Location</h4>
            <p class="text-sm text-gray-500 mt-1">Near city center & attractions</p>
          </div>
        </div>
      </section>


      <div class="border-t"></div>


      <!-- FACILITIES -->
      <section id="facilities" class="scroll-mt-[170px]">
        <div class="max-w-screen-xl mx-auto px-4 mb-6">
          <h3 class="text-3xl font-bold text-gray-800">Facilities</h3>
          <p class="text-sm text-gray-500 mt-1">Premium amenities for your comfort and safety</p>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 grid md:grid-cols-3 gap-6 text-sm">
          <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
            <div class="flex items-center gap-3"><span class="text-xl">🔥</span><p>Fire Safety System</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🏋️</span><p>GYM / Fitness Center</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🚨</span><p>Smoke Alarm in Public Area</p></div>
          </div>
          <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
            <div class="flex items-center gap-3"><span class="text-xl">🧺</span><p>Dry Cleaning</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🏢</span><p>Meeting Room</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🏊</span><p>Outdoor Pool</p></div>
          </div>
          <div class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
            <div class="flex items-center gap-3"><span class="text-xl">🍽️</span><p>Restaurant</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🛗</span><p>Elevator</p></div>
            <div class="flex items-center gap-3"><span class="text-xl">🧼</span><p>Laundry Service</p></div>
          </div>
        </div>
      </section>


      <div class="border-t"></div>


      <!-- LOCATION -->
      <section id="location" class="scroll-mt-[170px]">
        <div class="max-w-screen-xl mx-auto px-4 mb-6">
          <h3 class="text-3xl font-bold text-gray-800">Our Location</h3>
          <p class="text-sm text-gray-500 mt-1">Strategically located for your convenience and comfort</p>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 mb-6">
          <div class="bg-white/70 backdrop-blur-xl border border-gray-100 shadow-sm rounded-3xl p-6 md:p-8">
            <p class="text-gray-600 leading-relaxed">
              Stayzy Hotel is strategically located and easily accessible from various important locations,
              making your trip more comfortable and efficient.
            </p>
          </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4">
          <div class="rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:shadow-2xl transition">
            <iframe
              src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
              class="w-full h-96">
            </iframe>
          </div>
        </div>

        <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6 text-sm">
          <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
            <div class="text-3xl mb-2">✈️</div>
            <h4 class="font-semibold text-gray-800">20 Minutes</h4>
            <p class="text-gray-500 mt-1">From Airport</p>
          </div>
          <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
            <div class="text-3xl mb-2">🛍️</div>
            <h4 class="font-semibold text-gray-800">Nearby Mall</h4>
            <p class="text-gray-500 mt-1">Shopping & Entertainment</p>
          </div>
          <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
            <div class="text-3xl mb-2">🚕</div>
            <h4 class="font-semibold text-gray-800">Easy Transport</h4>
            <p class="text-gray-500 mt-1">Taxi & Ride Available</p>
          </div>
        </div>
      </section>

    </div>
  </div>


  <!-- ROOMS SECTION -->
  {{-- FIX: Section #rooms dipindah ke luar bubble agar konsisten dengan scroll behavior --}}
  <section id="rooms" class="scroll-mt-[170px] bg-[#cfc7c7] px-6 pt-10 pb-6">

    <div class="max-w-screen-xl mx-auto px-4 mb-10">
      <h3 class="text-4xl font-bold text-gray-800 tracking-tight">Our Rooms</h3>
      <p class="text-gray-500 text-sm mt-2">Choose the best room for your stay</p>
    </div>

    <!-- BOOKING FILTER -->
    <div class="max-w-screen-xl mx-auto px-4 mb-14">
      <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-6 md:p-8 border border-white/60">

        <div class="mb-6">
          <h2 class="text-2xl font-semibold text-gray-800">Book Your Stay</h2>
          <p class="text-sm text-gray-500 mt-1">Find the best rooms for your comfort</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

          <!-- FIX: Tambah litepicker untuk date range -->
          <div class="md:col-span-6">
            <label class="text-xs text-gray-500 mb-1 block">Stay Date</label>
            <input type="text" id="dateRange"
              placeholder="Select check-in - check-out"
              readonly
              class="w-full px-4 py-3 border border-gray-200 rounded-2xl bg-white shadow-sm
                focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all cursor-pointer">
          </div>

          <div class="md:col-span-2">
            <label class="text-xs text-gray-500">Guests</label>
            <input type="number" id="guestsInput" placeholder="2" min="1"
              class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
          </div>

          <div class="md:col-span-2">
            <label class="text-xs text-gray-500">Rooms</label>
            <input type="number" id="roomsInput" placeholder="1" min="1"
              class="w-full mt-1 px-3 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none">
          </div>

          <div class="md:col-span-2">
            <button onclick="handleSearch()"
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
      <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid md:grid-cols-3 gap-0">

          <!-- LEFT -->
          <div class="p-6 md:border-r border-gray-100">
            <img src="https://picsum.photos/800/500" class="rounded-2xl w-full h-56 object-cover">

            <h4 class="mt-5 font-semibold text-2xl text-gray-800">{{ $room['name'] }}</h4>
            <p class="text-sm text-gray-500 mt-1">{{ $room['bed'] }} • {{ $room['guest'] }}</p>

            <button
              data-name="{{ $room['name'] }}"
              data-bed="{{ $room['bed'] }}"
              data-guest="{{ $room['guest'] }}"
              onclick="openModal(this)"
              class="mt-6 w-full bg-gray-900 text-white py-3 rounded-xl hover:bg-black transition font-medium">
              See Details
            </button>
          </div>

          <!-- RIGHT -->
          <div class="md:col-span-2 p-6 space-y-5 bg-gray-50/40">
            @foreach ($room['prices'] as $price)
            <div class="bg-white border border-gray-100 rounded-2xl p-5 flex justify-between items-center">
              <div>
                <h5 class="font-semibold text-gray-800 text-lg">{{ $price['title'] }}</h5>
                <ul class="text-sm text-gray-500 mt-2 space-y-1">
                  @foreach ($price['features'] as $f)
                  <li>✔ {{ $f }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="text-right">
                <p class="text-2xl font-bold text-blue-600">
                  Rp {{ number_format($price['price'], 0, ',', '.') }}
                </p>
                {{-- FIX: data-price pakai angka mentah tanpa format agar tidak perlu replace di JS --}}
                <button
                  data-room="{{ $room['name'] }}"
                  data-package="{{ $price['title'] }}"
                  data-price="{{ $price['price'] }}"
                  onclick="addToOrder(this)"
                  class="mt-3 px-6 py-2 rounded-xl text-white text-sm font-semibold bg-blue-600 hover:opacity-90 transition shadow-sm">
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

  </section>


  <!-- VIEW ORDER BUTTON -->
  <div class="fixed bottom-8 right-8 z-40">
    <button
      id="viewOrderBtn"
      onclick="openOrderSidebar()"
      class="hidden bg-[#2d6d73] text-white px-8 py-4 rounded-2xl shadow-xl text-lg font-semibold hover:opacity-90 transition">
      View Order (<span id="orderCount">0</span>)
    </button>
  </div>


  <!-- DETAIL POPUP -->
  {{-- FIX: Ganti hidden+flex conflict ke style inline --}}
  <div id="roomModal"
    style="display:none"
    class="fixed top-0 left-0 w-full h-screen bg-black/60 items-center justify-center z-[9999]">
    <div class="bg-white rounded-2xl p-8 w-full max-w-2xl min-h-[420px] max-h-[80vh] overflow-y-auto relative shadow-2xl mx-4">
      <button onclick="closeModal()" class="absolute top-4 right-4 text-2xl">×</button>
      <h2 id="modalTitle" class="text-2xl font-bold mb-4"></h2>
      <p id="modalBed" class="mb-2"></p>
      <p id="modalGuest" class="mb-4"></p>
      <p class="text-sm text-gray-500">
        Premium room facilities, breakfast included, flexible cancellation,
        and exclusive hotel services.
      </p>
    </div>
  </div>


  <!-- ORDER SIDEBAR -->
  <div id="orderSidebar"
    class="fixed inset-y-0 right-0 w-[460px] bg-white shadow-2xl translate-x-full transition duration-300 z-[999] flex flex-col">

    <!-- HEADER -->
    <div class="bg-[#2f2d28] text-white px-6 py-6 flex justify-between items-center shrink-0">
      <h2 class="text-2xl font-semibold">Price Details</h2>
      <button onclick="closeOrderSidebar()" class="text-4xl leading-none hover:opacity-70">×</button>
    </div>

    <!-- CONTENT -->
    <div class="flex-1 overflow-y-auto bg-[#fafafa] p-6 min-h-0">
      <div id="orderList" class="space-y-6">
        <div class="bg-[#f5f5f5] rounded-3xl p-6">
          <p class="text-gray-500 text-center">No reservation selected yet</p>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <div class="border-t border-dashed bg-white p-6 space-y-5 shrink-0">
      <div class="flex justify-between items-center">
        <h3 class="text-2xl font-medium text-gray-700">Total Price</h3>
        <p id="sidebarTotal" class="text-4xl font-bold text-[#0f5f75]">Rp 0</p>
      </div>
      <div class="text-right text-gray-500">
        Earn up to <span class="font-bold">4% points</span>
      </div>
      <button class="w-full bg-[#2d6d73] hover:opacity-90 text-white py-5 rounded-2xl text-2xl font-semibold transition">
        Create Reservation
      </button>
      <p class="text-center text-sm text-gray-400 leading-relaxed">
        Room rates may differ per night for multi night stays.
      </p>
    </div>

  </div>

</div>


{{-- FIX: Flowbite dipindah ke sini, bukan di dalam carousel --}}
<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

{{-- FIX: Tambah litepicker untuk date range picker --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css"/>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

<script>
  // FIX: Data price sekarang angka mentah, tidak perlu replace
  let selectedOrders = [];

  // FIX: Init litepicker untuk date range
  document.addEventListener('DOMContentLoaded', function () {
    new Litepicker({
      element: document.getElementById('dateRange'),
      singleMode: false,
      format: 'DD MMM YYYY',
      numberOfMonths: 2,
      numberOfColumns: 2,
    });
  });

  // FIX: Handler untuk tombol Search (sebelumnya tidak ada)
  function handleSearch() {
    const dateRange = document.getElementById('dateRange').value;
    const guests = document.getElementById('guestsInput').value;
    const rooms = document.getElementById('roomsInput').value;

    if (!dateRange) {
      alert('Silakan pilih tanggal menginap terlebih dahulu.');
      return;
    }
    // Implementasi filter rooms bisa ditambahkan di sini
    // Contoh: kirim ke controller via AJAX atau reload page dengan query params
    console.log('Search:', { dateRange, guests, rooms });
  }

  function addToOrder(button) {
    const room = button.dataset.room;
    const packageName = button.dataset.package;
    // FIX: price sekarang angka mentah, langsung parseInt tanpa replace
    const price = parseInt(button.dataset.price);

    selectedOrders.push({
      id: Date.now(), // FIX: Tambah id unik untuk keperluan removeOrder
      room: room,
      package: packageName,
      price: price
    });

    renderOrders();
    document.getElementById('orderCount').innerText = selectedOrders.length;
    document.getElementById('viewOrderBtn').classList.remove('hidden');
  }

  // FIX: Tambah fungsi removeOrder yang sebelumnya tidak ada
  function removeOrder(id) {
    selectedOrders = selectedOrders.filter(item => item.id !== id);
    renderOrders();

    document.getElementById('orderCount').innerText = selectedOrders.length;
    if (selectedOrders.length === 0) {
      document.getElementById('viewOrderBtn').classList.add('hidden');
    }
  }

  function renderOrders() {
    let orderList = document.getElementById('orderList');
    let total = 0;
    let html = '';

    if (selectedOrders.length === 0) {
      html = `<div class="bg-[#f5f5f5] rounded-3xl p-6">
        <p class="text-gray-500 text-center">No reservation selected yet</p>
      </div>`;
    } else {
      selectedOrders.forEach((item) => {
        total += item.price;
        html += `
          <div class="border-b pb-5 mb-5">
            <p class="text-gray-700 text-lg">Room</p>
            <div class="flex justify-between items-start mt-2">
              <div>
                <h3 class="text-2xl font-semibold text-slate-700">${item.room}</h3>
                <p class="font-medium text-slate-600 mt-2">${item.package}</p>
                <p class="text-gray-500 text-sm mt-1">1 room • 1 night</p>
              </div>
              <div class="text-right">
                <p class="text-xl font-bold text-[#0f5f75]">Rp ${item.price.toLocaleString('id-ID')}</p>
                <button onclick="removeOrder(${item.id})"
                  class="mt-2 text-sm text-red-500 hover:underline">
                  Hapus
                </button>
              </div>
            </div>
          </div>
        `;
      });
    }

    orderList.innerHTML = html;
    document.getElementById('sidebarTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');
  }

  function openOrderSidebar() {
    document.getElementById('orderSidebar').classList.remove('translate-x-full');
  }

  function closeOrderSidebar() {
    document.getElementById('orderSidebar').classList.add('translate-x-full');
  }

  // FIX: Pakai style display flex/none, bukan toggle class hidden (menghindari conflict dengan Tailwind JIT)
  function openModal(button) {
    document.getElementById('modalTitle').innerText = button.dataset.name;
    document.getElementById('modalBed').innerText = 'Bed Type: ' + button.dataset.bed;
    document.getElementById('modalGuest').innerText = 'Guest Capacity: ' + button.dataset.guest;
    document.getElementById('roomModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('roomModal').style.display = 'none';
  }

  // Tutup modal kalau klik di luar
  document.getElementById('roomModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
  });
</script>

@endsection