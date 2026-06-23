@extends('Layouts.layout')

@section('content')

{{-- ═══ BARIS 1: ROOM ═══ --}}
<div class="stat-grid">

    {{-- Total Rooms --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M5 21H3M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Rooms</div>
        </div>
        <div class="stat-card-value">{{ $totalRooms }}</div>
        <div class="stat-card-sub">Hotel rooms registered</div>
    </div>

    {{-- Available Rooms --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-card-label">Available Rooms</div>
        </div>
        <div class="stat-card-value">{{ $availableRooms }}</div>
        <div class="stat-card-sub">Rooms ready to book</div>
    </div>

    {{-- Occupied Rooms --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon red">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
            </div>
            <div class="stat-card-label">Occupied Rooms</div>
        </div>
        <div class="stat-card-value">{{ $occupiedRooms }}</div>
        <div class="stat-card-sub">Currently occupied</div>
    </div>

</div>

{{-- ═══ BARIS 2: RESERVASI ═══ --}}
<div class="stat-grid" style="margin-bottom: 28px;">

    {{-- Active Reservations --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-card-label">Active Reservations</div>
        </div>
        <div class="stat-card-value">{{ $activeReservations }}</div>
        <div class="stat-chips">
            <span class="chip chip-green">
                <span class="chip-dot" style="background:#16a34a"></span>
                {{ $confirmedReservations }} confirmed
            </span>
            <span class="chip chip-amber">
                <span class="chip-dot" style="background:#d97706"></span>
                {{ $pendingReservations }} pending
            </span>
        </div>
    </div>

    {{-- Cancelled Reservations --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-card-label">Cancelled Reservations</div>
        </div>
        <div class="stat-card-value">{{ $cancelledReservations }}</div>
        <div class="stat-card-sub">Total cancelled</div>
    </div>

    {{-- Total Income --}}
    <div class="stat-card">
        <div class="stat-card-accent" style="background: linear-gradient(180deg,#22c55e,#16a34a)"></div>
        <div class="stat-card-top">
            <div class="stat-card-icon amber">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Income</div>
        </div>
        <div class="stat-card-value income">Rp {{ number_format($income, 0, ',', '.') }}</div>
        <div class="stat-card-sub">From paid reservations</div>
    </div>

</div>

{{-- ═══ TABLE ═══ --}}
<div class="table-section-head">
    <div>
        <div class="table-section-title">Latest Reservations</div>
        <div class="table-section-sub">5 most recent reservations</div>
    </div>
    <a href="/admin/reservations" class="table-link">View All →</a>
</div>

<div class="table-wrapper">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Guest</th>
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
                <td class="td-date">{{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}</td>
                <td class="td-date">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</td>
                <td>
                    <span class="status-badge {{ $statusClass }}">
                        <span class="status-dot"></span>
                        {{ $res->status }}
                    </span>
                </td>
            </tr>
            @empty
            <tr class="empty-row"><td colspan="6">No reservations found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection