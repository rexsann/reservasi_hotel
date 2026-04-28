<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stayzy — Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 overflow-hidden">

<div class="flex h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col h-full flex-shrink-0 shadow-sm">

        {{-- LOGO --}}
        <div class="px-5 py-5 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-base shadow-sm flex-shrink-0">
                    S
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800 leading-tight">Stayzy Hotel</p>
                    <p class="text-xs text-gray-400 leading-tight">Admin Panel</p>
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

            <p class="text-xs text-gray-400 font-medium uppercase tracking-widest px-3 mb-2">Main</p>

            <a href="/admin/dashboard"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>
                </svg>
                Dashboard
            </a>

            <a href="/admin/reservations"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/reservations*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Reservations
            </a>

            <a href="/admin/users"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/users*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Users Management
            </a>

            <p class="text-xs text-gray-400 font-medium uppercase tracking-widest px-3 pt-4 pb-2">Hotel</p>

            <a href="/admin/rooms"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/rooms*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Rooms Management
            </a>

            <a href="/admin/facilities"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/facilities*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Facility Management
            </a>

            <a href="/admin/offers"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition
               {{ request()->is('admin/offers*') ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-800' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Offer Management
            </a>

        </nav>

        {{-- FOOTER SIDEBAR — profil + logout --}}
        <div class="px-4 py-4 border-t border-gray-100 space-y-2">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold flex-shrink-0">
                    A
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-700 truncate">Administrator</p>
                    <p class="text-xs text-gray-400 truncate">admin@stayzy.com</p>
                </div>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- TOPBAR --}}
        <header class="bg-white border-b border-gray-100 px-6 py-3.5 flex items-center justify-between flex-shrink-0 shadow-sm">
            <div>
                <p class="text-sm font-semibold text-gray-800">
                    @if(request()->is('admin/dashboard'))         Dashboard
                    @elseif(request()->is('admin/reservations*')) Reservations
                    @elseif(request()->is('admin/users*'))        Users Management
                    @elseif(request()->is('admin/rooms*'))        Rooms Management
                    @elseif(request()->is('admin/facilities*'))   Facility Management
                    @elseif(request()->is('admin/offers*'))       Offer Management
                    @else                                          Admin Panel
                    @endif
                </p>
                <p class="text-xs text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</p>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html>