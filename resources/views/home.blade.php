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
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-blue-600">HotelKu</h1>

        <div>
            <a href="/" class="mx-2 text-blue-600 font-semibold">Home</a>
            <a href="/about" class="mx-2 text-gray-700 hover:text-gray-500">About</a>
            <a href="/contact" class="mx-2 text-gray-700 hover:text-gray-500">Contact</a>
        </div>
    </div>
</nav>

<!-- Hero -->
<div class="relative h-[90vh]">
    <img src="https://source.unsplash.com/1600x900/?hotel" class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-center">
        <div class="text-white">
            <h1 class="text-5xl font-bold">Selamat Datang</h1>
            <p>Nikmati pengalaman menginap terbaik</p>
        </div>
    </div>
</div>

<!-- Booking Form -->
<div class="container mx-auto px-6">
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

<!-- Rooms -->
<div class="container mx-auto px-6 mt-16">
    <h2 class="text-2xl font-bold text-center mb-8">Pilihan Kamar</h2>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($rooms as $room)
            <div class="bg-white rounded-xl shadow hover:shadow-lg">
                <img src="{{ $room['image'] }}" class="rounded-t-xl">

                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $room['name'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $room['desc'] }}</p>

                    <button class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg">
                        Detail
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white text-center py-4 mt-16">
    © 2026 HotelKu
</footer>

</body>
</html>
