<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-100">

<!--NAVBAR -->
<nav class="bg-white border-b shadow-sm">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center p-4">
        
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">
                S
            </div>
            <span class="text-lg font-semibold">Stayzy Hotel</span>
        </div>

    </div>
</nav>

<div class="flex">

    <!-- 🔥 SIDEBAR MODERN -->
    <aside class="w-64 bg-white h-screen p-4 border-r shadow-sm">

        <h2 class="text-xs text-gray-400 uppercase mb-4">Menu</h2>

        <a href="/admin/dashboard"
           class="flex items-center gap-3 p-2 rounded-lg mb-2 transition
           {{ request()->is('admin/dashboard') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100' }}">
            Dashboard
        </a>

        <a href="/admin/rooms"
           class="flex items-center gap-3 p-2 rounded-lg mb-2 transition
           {{ request()->is('admin/rooms*') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100' }}">
            Rooms Management
        </a>

        <a href="/admin/users"
           class="flex items-center gap-3 p-2 rounded-lg mb-2 transition
           {{ request()->is('admin/users') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100' }}">
            Users Management
        </a>

        <a href="/admin/reservations"
           class="flex items-center gap-3 p-2 rounded-lg transition
           {{ request()->is('admin/reservations') ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100' }}">
            Reservations
        </a>

    </aside>

    <!-- 🔥 CONTENT -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>