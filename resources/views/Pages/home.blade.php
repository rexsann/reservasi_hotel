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
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent flex items-center justify-center text-center z-10">
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
            <button type="button"
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                data-carousel-prev>❮</button>
            <button type="button"
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer"
                data-carousel-next>❯</button>

        </div>


        <!-- Sticky Navigation -->
        <div class="w-full sticky top-[88px] z-40">
            <div class="w-full bg-white/95 backdrop-blur-md border-b shadow-sm">
                <ul class="grid grid-cols-4 text-center font-medium text-gray-700 h-[75px]">

                    <li class="flex h-full">
                        <a href="#overview"
                            class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
                            Overview
                            <span
                                class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>

                    <li class="flex h-full">
                        <a href="#facilities"
                            class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
                            Facilities
                            <span
                                class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>

                    <li class="flex h-full">
                        <a href="#location"
                            class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
                            Location
                            <span
                                class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
                        </a>
                    </li>

                    <li class="flex h-full">
                        <a href="#rooms"
                            class="flex flex-1 items-center justify-center hover:text-blue-600 hover:bg-blue-50 transition relative">
                            Rooms
                            <span
                                class="absolute bottom-0 left-0 h-0.5 bg-blue-600 w-0 hover:w-full transition-all duration-300"></span>
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
                                With a strategic location near attractions and transportation, Stayzy Hotel is the perfect
                                choice for both leisure and business travelers.
                            </p>
                        </div>
                    </div>

                    <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6">
                        <div
                            class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
                            <div class="text-3xl mb-2">⭐</div>
                            <h4 class="text-2xl font-bold text-gray-800">4.8</h4>
                            <p class="text-sm text-gray-500 mt-1">Rating from 1.000+ reviews</p>
                        </div>
                        <div
                            class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
                            <div class="text-3xl mb-2">🏨</div>
                            <h4 class="text-2xl font-bold text-gray-800">30 Rooms</h4>
                            <p class="text-sm text-gray-500 mt-1">3 Floors Premium Building</p>
                        </div>
                        <div
                            class="bg-white rounded-3xl p-6 text-center shadow-sm hover:shadow-xl transition border border-gray-100">
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
                        <div
                            class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
                            <div class="flex items-center gap-3"><span class="text-xl">🔥</span>
                                <p>Fire Safety System</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🏋️</span>
                                <p>GYM / Fitness Center</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🚨</span>
                                <p>Smoke Alarm in Public Area</p>
                            </div>
                        </div>
                        <div
                            class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
                            <div class="flex items-center gap-3"><span class="text-xl">🧺</span>
                                <p>Dry Cleaning</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🏢</span>
                                <p>Meeting Room</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🏊</span>
                                <p>Outdoor Pool</p>
                            </div>
                        </div>
                        <div
                            class="bg-white shadow-sm hover:shadow-lg transition p-6 rounded-2xl border border-gray-100 space-y-4">
                            <div class="flex items-center gap-3"><span class="text-xl">🍽️</span>
                                <p>Restaurant</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🛗</span>
                                <p>Elevator</p>
                            </div>
                            <div class="flex items-center gap-3"><span class="text-xl">🧼</span>
                                <p>Laundry Service</p>
                            </div>
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
                                Stayzy Hotel is strategically located and easily accessible from various important
                                locations,
                                making your trip more comfortable and efficient.
                            </p>
                        </div>
                    </div>

                    <div class="max-w-screen-xl mx-auto px-4">
                        <div
                            class="rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:shadow-2xl transition">
                            <iframe src="https://maps.google.com/maps?q=batam&t=&z=13&ie=UTF8&iwloc=&output=embed"
                                class="w-full h-96">
                            </iframe>
                        </div>
                    </div>

                    <div class="max-w-screen-xl mx-auto px-4 mt-10 grid md:grid-cols-3 gap-6 text-sm">
                        <div
                            class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
                            <div class="text-3xl mb-2">✈️</div>
                            <h4 class="font-semibold text-gray-800">20 Minutes</h4>
                            <p class="text-gray-500 mt-1">From Airport</p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
                            <div class="text-3xl mb-2">🛍️</div>
                            <h4 class="font-semibold text-gray-800">Nearby Mall</h4>
                            <p class="text-gray-500 mt-1">Shopping & Entertainment</p>
                        </div>
                        <div
                            class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl transition border border-gray-100 text-center">
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

            <!-- BOOKING FILTER -->
            <div class="max-w-screen-xl mx-auto px-4 mb-14">
        <div class="bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-6 md:p-8 border">

            <h2 class="text-2xl font-semibold">Book Your Stay</h2>
            <p class="text-sm text-gray-500 mt-1">Find the best rooms for your comfort</p>

           <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6">

    <div class="md:col-span-8">
        <label class="text-xs text-gray-500">Stay Date</label>
        <input type="text" id="dateRange" class="w-full px-4 py-3 border rounded-2xl"
            placeholder="Select check-in - check-out" readonly>
        {{-- Hidden inputs untuk dikirim ke controller --}}
        <input type="hidden" id="checkIn"  value="{{ $checkIn ?? '' }}">
        <input type="hidden" id="checkOut" value="{{ $checkOut ?? '' }}">
    </div>

    <div class="md:col-span-2">
        <label class="text-xs text-gray-500">Rooms</label>
        <input type="number" id="roomsInput" min="1" value="1"
            class="w-full px-3 py-3 border rounded-xl">
    </div>

    <div class="md:col-span-2 flex items-end">
        <button onclick="handleSearch()"
            class="w-full bg-blue-600 text-white py-3 rounded-xl">
            Search
        </button>
    </div>

</div>

        </div>
    </div>

    <!-- =========================
        ROOM LIST
    ========================== -->
    <div class="max-w-screen-xl mx-auto px-4 space-y-12" id="roomContainer">

        @php
            $types = ['Standard', 'Superior', 'Deluxe'];
        @endphp

        @foreach ($types as $type)

            @php
                $typeOffers = $offers->where('room_type', $type);
                $typeFacilities = $facilities->where('room_type', $type);
            @endphp

            @if ($typeOffers->count() == 0)
                @continue
            @endif

            <div class="room-item bg-white rounded-3xl border shadow-sm overflow-hidden">

                <div class="grid md:grid-cols-3">

                    <!-- LEFT -->
                    <div class="p-6 md:border-r">

                        <img src="https://picsum.photos/800/500"
                            class="rounded-2xl w-full h-56 object-cover">

                        <h4 class="mt-5 font-bold text-2xl">{{ $type }}</h4>

                        <p class="text-sm text-gray-500">1 Bed • 2 Guest</p>

                        <!-- FACILITY PREVIEW -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($typeFacilities->take(3) as $facility)
                                <span class="text-xs border px-2 py-1 rounded-full">
                                    {{ $facility->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- DETAIL BUTTON -->
                        <button
                            onclick="openModal(this)"
                            data-name="{{ $type }}"
                            data-bed="1 Bed"
                            data-guest="2 Guest"
                            data-facilities="{{ $typeFacilities->pluck('name')->join(', ') }}"
                            class="mt-6 w-full bg-gray-900 text-white py-3 rounded-xl">
                            See Details
                        </button>

                    </div>

                    <!-- RIGHT -->
                    <div class="md:col-span-2 p-6 bg-gray-50">

                        @foreach ($typeOffers as $offer)

                            @php
                                $benefits = json_decode($offer->benefits, true) ?? [];
                            @endphp

                            <div class="bg-white border rounded-2xl p-5 flex justify-between mb-4">

                                <div>
                                    <h5 class="font-semibold">{{ $offer->name }}</h5>
                                    <ul class="text-sm text-gray-500 mt-2">
                                        @foreach ($benefits as $b)
                                            <li>✔ {{ $b }}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="text-right">

                                    <p class="font-bold text-blue-600">
                                        Rp {{ number_format($offer->price,0,',','.') }}
                                    </p>

                                    <button
                                        onclick="addToOrder(this)"
                                        data-room="{{ $type }}"
                                        data-package="{{ $offer->name }}"
                                        data-price="{{ $offer->price }}"
                                        class="mt-3 bg-blue-600 text-white px-4 py-2 rounded-xl">
                                        Add
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

<!-- =========================
    MODAL DETAIL
========================== -->
<div id="roomModal"
    style="display:none"
    class="fixed inset-0 bg-black/50 items-center justify-center z-[9999] p-4">

    <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-2xl">

        {{-- Image --}}
        <div class="relative h-48 bg-gray-100">
            <img src="https://picsum.photos/800/400" class="w-full h-full object-cover">
            <button onclick="closeModal()"
                class="absolute top-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-600 hover:bg-white transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6">
            <span id="modalBadge" class="inline-block text-xs px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100 mb-3"></span>
            <h2 id="modalTitle" class="text-xl font-semibold text-gray-900 mb-1"></h2>

            <div class="flex gap-5 text-sm text-gray-500 mb-5">
                <span id="modalBed" class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 7v11M21 7v11M3 12h18M3 7a2 2 0 012-2h14a2 2 0 012 2"/></svg>
                    <span id="modalBedText"></span>
                </span>
                <span id="modalGuest" class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    <span id="modalGuestText"></span>
                </span>
            </div>

            <hr class="border-gray-100 mb-4">

            <p class="text-xs text-gray-400 uppercase tracking-widest mb-3">Facilities</p>
            <ul id="modalFacilities" class="flex flex-wrap gap-2 text-sm"></ul>
        </div>

    </div>
</div>

<!-- =========================
    VIEW ORDER BUTTON
========================== -->
<div class="fixed bottom-8 right-8 z-40">
    <button id="viewOrderBtn"
        onclick="openOrderSidebar()"
        class="hidden items-center gap-2 bg-teal-700 text-white px-5 py-3 rounded-2xl shadow-lg text-sm font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4zM3 6h18M16 10a4 4 0 01-8 0"/></svg>
        View order
        <span class="bg-white/25 text-white text-xs px-2 py-0.5 rounded-full" id="orderCount">0</span>
    </button>
</div>

<!-- =========================
    ORDER SIDEBAR
========================== -->
<div id="orderSidebar"
    class="fixed inset-y-0 right-0 w-[380px] bg-white shadow-2xl translate-x-full transition-transform duration-300 flex flex-col z-[999]">

    <div class="flex justify-between items-center px-5 py-4 border-b">
        <div class="flex items-center gap-2">
            <h2 class="text-base font-semibold text-gray-900">Your order</h2>
            <span id="sidebarCount" class="text-xs bg-blue-50 text-blue-600 border border-blue-100 px-2 py-0.5 rounded-full">0 rooms</span>
        </div>
        <button onclick="closeOrderSidebar()" class="text-gray-400 hover:text-gray-600 text-xl">×</button>
    </div>

    <div class="flex-1 overflow-y-auto px-5 py-4">
        <div id="orderList">
            <div class="text-center text-gray-400 text-sm py-12">
                No reservation selected yet
            </div>
        </div>
    </div>

    <div class="px-5 py-4 border-t">
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-gray-500">Total</span>
            <span class="text-lg font-semibold text-gray-900" id="sidebarTotal">Rp 0</span>
        </div>
        <a href="/detail"
           class="block w-full text-center bg-teal-700 text-white py-3 rounded-xl text-sm font-medium hover:bg-teal-800 transition">
            View reservation →
        </a>
    </div>

</div>


    {{-- FIX: Flowbite dipindah ke sini, bukan di dalam carousel --}}
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>

    {{-- FIX: Tambah litepicker untuk date range picker --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>

    <script>
        // FIX: Data price sekarang angka mentah, tidak perlu replace
        let selectedOrders = [];

        // FIX: Init litepicker untuk date range
        // document.addEventListener('DOMContentLoaded', function () {
        // new Litepicker({
        // element: document.getElementById('dateRange'),
        //singleMode: false,
        //format: 'DD MMM YYYY',
        //numberOfMonths: 2,
        //numberOfColumns: 2,
        //});
        //});

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
            console.log('Search:', {
                dateRange,
                guests,
                rooms
            });
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
        function openModal(btn) {
            document.getElementById('modalTitle').innerText = btn.dataset.name;
            document.getElementById('modalBed').innerText = 'Bed Type: ' + btn.dataset.bed;
            document.getElementById('modalGuest').innerText = 'Capacity: ' + btn.dataset.guest;

            let facilities = btn.dataset.facilities.split(',');

            let html = '';
            facilities.forEach(f => {
                if (f.trim() !== '') {
                    html += `<li>✔ ${f.trim()}</li>`;
                }
            });

            document.getElementById('modalFacilities').innerHTML = html;

            document.getElementById('roomModal').style.display = 'flex';
        }
    </script>

@endsection
