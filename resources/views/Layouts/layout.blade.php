<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stayzy — Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])

</head>

<body class="admin-layout">
<div class="flex h-screen">

    <!-- ═══════════ SIDEBAR ═══════════ -->
    <aside class="sidebar">

        <div class="sidebar-logo">
            <div class="logo-mark">S</div>
            <div>
                <div class="logo-text-main">Stayzy Hotel</div>
                <div class="logo-text-sub">Admin Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">

            <div class="nav-section-label">Main</div>

            <a href="/admin/dashboard"
               class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l9-9 9 9M5 10v9a1 1 0 001 1h4v-5h4v5h4a1 1 0 001-1v-9"/>
                </svg>
                Dashboard
            </a>

            <a href="/admin/reservations"
               class="nav-item {{ request()->is('admin/reservations*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Reservations
            </a>

            <a href="/admin/users"
               class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Users Management
            </a>

            <div class="sidebar-divider"></div>
            <div class="nav-section-label">Hotel</div>

            <a href="/admin/rooms"
               class="nav-item {{ request()->is('admin/rooms*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Rooms
            </a>

            <a href="/admin/facility"
               class="nav-item {{ request()->is('admin/facility*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                Facilities
            </a>

            <a href="/admin/offers"
               class="nav-item {{ request()->is('admin/offers*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Offers
            </a>

            <a href="/admin/pembayaran"
               class="nav-item {{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Pembayaran
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="profile-name">{{ Auth::user()->name ?? 'AdminiSZy' }}</div>
                    <div class="profile-role">{{ Auth::user()->email ?? 'admin@stayzy.com' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>

    </aside>

    <!-- ═══════════ MAIN AREA ═══════════ -->
    <div class="main-area">

        <header class="topbar">
            <div class="topbar-left">
                <div class="topbar-title">
                    @if(request()->is('admin/dashboard'))         Dashboard
                    @elseif(request()->is('admin/reservations*')) Reservations
                    @elseif(request()->is('admin/users*'))        Users Management
                    @elseif(request()->is('admin/rooms*'))        Rooms Management
                    @elseif(request()->is('admin/facility*'))     Facility Management
                    @elseif(request()->is('admin/offers*'))       Offer Management
                    @elseif(request()->is('admin/pembayaran*'))   Pembayaran
                    @else                                          Admin Panel
                    @endif
                </div>
                                <div class="topbar-breadcrumb">
                    @if(request()->is('admin/dashboard'))         
                        Monitor all hotel activities and performance overview

                    @elseif(request()->is('admin/reservations*')) 
                        Manage and track all guest reservations

                    @elseif(request()->is('admin/users*'))        
                        Manage user accounts and access permissions

                    @elseif(request()->is('admin/rooms*'))        
                        Manage room listings and availability

                    @elseif(request()->is('admin/facility*'))     
                        Manage facilities available for each room type

                    @elseif(request()->is('admin/offers*'))       
                        Create and manage special offers or promotions

                    @elseif(request()->is('admin/pembayaran*'))   
                        Monitor and verify payment transactions

                    @else                                          
                        Welcome to the Stayzy admin panel
                    @endif
                </div>
            </div>

            <div class="topbar-right">
                <div class="topbar-date-badge">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
                <div class="topbar-dot" title="Online"></div>
            </div>
        </header>

        <main class="page-content">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>