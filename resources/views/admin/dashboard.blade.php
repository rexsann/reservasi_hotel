@extends('Layouts.layout')

@section('content')

{{-- ═══ STAT CARDS ═══ --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Total Rooms</div>
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value">{{ $totalRooms }}</div>
        <div class="stat-card-sub">Hotel rooms registered</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Active Reservations</div>
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value">{{ $activeReservations }}</div>
        <div class="stat-badge">
            <span style="width:6px;height:6px;border-radius:50%;background:#4ade80;display:inline-block;flex-shrink:0;"></span>
            {{ $confirmedReservations }} confirmed &middot; {{ $pendingReservations }} pending
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-card-label">Total Income</div>
            <div class="stat-card-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <div class="stat-card-value" style="font-size:28px;">Rp {{ number_format($income, 0, ',', '.') }}</div>
        <div class="stat-card-sub">From paid reservations</div>
    </div>

</div>

{{-- ═══ QUICK BAND ═══ --}}
@php
    $availPct  = $totalRooms > 0 ? round(($availableRooms / $totalRooms) * 100) : 0;
    $occupPct  = $totalRooms > 0 ? round(($occupiedRooms  / $totalRooms) * 100) : 0;
    $checkinPct = 60;
@endphp

<div class="quick-band">

    <div class="quick-card">
        <div class="quick-card-icon available">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div style="flex:1; min-width:0;">
            <div class="quick-card-label">Available Rooms</div>
            <div class="quick-card-value available">{{ $availableRooms }}</div>
        </div>
    </div>

    <div class="quick-card">
        <div class="quick-card-icon occupied">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <div style="flex:1; min-width:0;">
            <div class="quick-card-label">Occupied Rooms</div>
            <div class="quick-card-value occupied">{{ $occupiedRooms }}</div>
        </div>
    </div>

    <div class="quick-card">
        <div class="quick-card-icon checkin">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
        </div>
        <div style="flex:1; min-width:0;">
            <div class="quick-card-label">Today's Check-ins</div>
            <div class="quick-card-value checkin">{{ $todayCheckin }}</div>
        </div>
    </div>

</div>

{{-- ═══ TABLE ═══ --}}
<div class="table-section-head">
    <div>
        <div class="table-section-title">Latest Reservations</div>
        <div class="table-section-sub">5 latest reservations</div>
    </div>
    <a href="/admin/reservations"
       style="font-size:12px;color:#16a34a;font-weight:700;text-decoration:none;
              padding:8px 16px;border-radius:10px;background:#f0fdf4;border:1px solid #bbf7d0;
              transition:background 0.12s;"
       onmouseenter="this.style.background='#dcfce7'"
       onmouseleave="this.style.background='#f0fdf4'">
        View All →
    </a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Reservation Code</th>
                <th>Guest</th>
                <th>Room / Offer</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestReservations as $res)
            @php
                $statusClass = match($res->status) {
                    'Confirmed'   => 'status-confirmed',
                    'Pending'     => 'status-pending',
                    'Cancelled'   => 'status-cancelled',
                    'Checked Out' => 'status-checkedout',
                    default       => 'status-default',
                };
            @endphp
            <tr>
                <td class="td-id">{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</td>
                <td><span class="td-code">{{ $res->reservation_code }}</span></td>
                <td>
                    <div class="td-guest-name">{{ $res->name }}</div>
                    <div class="td-guest-email">{{ $res->email }}</div>
                </td>
                <td>
                    <div class="td-offer-name">{{ $res->offer }}</div>
                    <div class="td-room-type">{{ $res->room_type }}</div>
                </td>
                <td class="td-date">{{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}</td>
                <td class="td-date">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</td>
                <td><span class="status-badge {{ $statusClass }}">{{ $res->status }}</span></td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="7">No reservations found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection