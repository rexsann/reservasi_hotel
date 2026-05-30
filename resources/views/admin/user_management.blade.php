@extends('Layouts.layout')

@section('content')

{{-- STAT CARDS --}}
<div class="stat-row">

    {{-- Total --}}
    <div class="stat-card total">
        <div class="stat-label">Total Guests</div>
        <div class="stat-number">{{ $users->count() }}</div>
    </div>

    {{-- Ever Reserved --}}
    <div class="stat-card reserved">
        <div class="stat-label">Ever Reserved</div>
        <div class="stat-number">{{ $users->where('total_reservations', '>', 0)->count() }}</div>
    </div>

    {{-- No Reservation --}}
    <div class="stat-card none">
        <div class="stat-label">No Reservation</div>
        <div class="stat-number">{{ $users->where('total_reservations', 0)->count() }}</div>
    </div>

</div>

{{-- SEARCH --}}
<div class="search-wrap">
    <form method="GET" action="{{ url()->current() }}">
        <div class="search-inner">
            <div class="search-field">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama atau email..."
                    autocomplete="off">
            </div>
        </div>
    </form>
</div>

{{-- TABLE --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:60px;">ID</th>
                <th>Guest</th>
                <th>Reservations</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>

            @forelse($users as $user)
            <tr>

                {{-- ID --}}
                <td>
                    <span class="cell-id">{{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}</span>
                </td>

                {{-- Guest --}}
                <td>
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="guest-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="guest-name">{{ $user->name }}</div>
                            <div class="guest-email">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>

                {{-- Reservations --}}
                <td>
                    @if($user->total_reservations > 0)
                        <span class="res-badge">
                            <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $user->total_reservations }}x
                        </span>
                    @else
                        <span class="res-badge zero">—</span>
                    @endif
                </td>

                {{-- Registered --}}
                <td>
                    <span class="cell-date">{{ $user->created_at->format('d M Y') }}</span>
                </td>

            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="4">
                    <svg class="empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    No users found
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>

@endsection