@extends('layouts.app')

@section('title', 'My Reservations - Stayzy Hotel')

@section('content')

<style>
  @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap');

  .res-wrap {
    font-family: 'DM Sans', sans-serif;
    min-height: 100vh;
    background: #e8e0d4;
    padding: 100px 24px 60px;
  }

  .res-shell {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  /* PAGE HEADER */
  .page-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 4px;
  }

  .page-label {
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: #b8a98a;
    font-weight: 500;
    margin-bottom: 4px;
  }

  .page-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 36px;
    font-weight: 600;
    color: #1a1a2e;
    line-height: 1.1;
  }

  .back-link {
    font-size: 13px;
    color: #9e8f7a;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: color 0.2s;
  }

  .back-link:hover {
    color: #1a1a2e;
  }

  /* EMPTY STATE */
  .empty-card {
    background: #fff;
    border-radius: 20px;
    padding: 64px 48px;
    text-align: center;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
  }

  .empty-icon {
    font-size: 48px;
    margin-bottom: 16px;
    opacity: 0.4;
  }

  .empty-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    color: #1a1a2e;
    margin-bottom: 8px;
  }

  .empty-sub {
    font-size: 14px;
    color: #9e8f7a;
  }

  /* RESERVATION CARD */
  .res-card {
    background: #fff;
    border-radius: 20px;
    padding: 28px 36px;
    box-shadow: 0 2px 16px rgba(0, 0, 0, 0.04);
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 16px;
    align-items: center;
    transition: box-shadow 0.2s;
  }

  .res-card:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
  }

  .res-left {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .res-top {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .res-room {
    font-family: 'Cormorant Garamond', serif;
    font-size: 22px;
    font-weight: 600;
    color: #1a1a2e;
  }

  .res-package {
    font-size: 12px;
    background: #f5f0e8;
    color: #9e8f7a;
    padding: 4px 12px;
    border-radius: 999px;
    border: 1px solid #e5ddd0;
  }

  .res-meta {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
  }

  .meta-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .meta-label {
    font-size: 10px;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #b8a98a;
    font-weight: 500;
  }

  .meta-value {
    font-size: 14px;
    color: #1a1a2e;
    font-weight: 400;
  }

  .meta-price {
    font-size: 18px;
    font-weight: 500;
    color: #1a1a2e;
  }

  /* STATUS BADGES */
  .badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 500;
    padding: 5px 14px;
    border-radius: 999px;
  }

  .badge-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  .badge-pending {
    background: #fef9ec;
    color: #a16207;
    border: 1px solid #fde68a;
  }

  .badge-pending .badge-dot {
    background: #f59e0b;
  }

  .badge-confirmed {
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
  }

  .badge-confirmed .badge-dot {
    background: #22c55e;
  }

  .badge-rejected {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  .badge-rejected .badge-dot {
    background: #ef4444;
  }

  /* RIGHT SIDE */
  .res-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 12px;
  }

  .btn-detail {
    background: #1a1a2e;
    color: #f5f0e8;
    border: none;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
  }

  .btn-detail:hover {
    background: #2d2d4e;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(26, 26, 46, 0.15);
  }

  /* UPLOAD NOTICE untuk pending */
  .upload-notice {
    font-size: 11px;
    color: #a16207;
    background: #fef9ec;
    border: 1px solid #fde68a;
    border-radius: 8px;
    padding: 6px 12px;
    max-width: 180px;
    text-align: center;
    line-height: 1.4;
  }

  @media (max-width: 768px) {
    .res-card {
      grid-template-columns: 1fr;
    }

    .res-right {
      align-items: flex-start;
    }

    .page-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 12px;
    }
  }
</style>

<div class="res-wrap">
  <div class="res-shell">

    <!-- PAGE HEADER -->
    <div class="page-header">
      <div>
        <div class="page-label">Account</div>
        <div class="page-title">My Reservations</div>
      </div>
    </div>

    @if(empty($reservations))

    <!-- EMPTY STATE -->
    <div class="empty-card">
      <div class="empty-icon">🛎️</div>
      <div class="empty-title">No reservations yet</div>
      <div class="empty-sub">Your booking history will appear here after you make a reservation.</div>
    </div>

    @else

    @foreach($reservations as $res)
    <div class="res-card">

      <!-- LEFT -->
      <div class="res-left">
        <div class="res-top">
          <span class="res-room">{{ $res['room_name'] }}</span>
          <span class="res-package">{{ $res['package'] }}</span>
        </div>

        <div class="res-meta">
          <div class="meta-item">
            <span class="meta-label">Check-in</span>
            <span class="meta-value">{{ $res['check_in'] }}</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">Check-out</span>
            <span class="meta-value">{{ $res['check_out'] }}</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">Duration</span>
            <span class="meta-value">{{ $res['nights'] }} Night(s)</span>
          </div>
          <div class="meta-item">
            <span class="meta-label">Total</span>
            <span class="meta-price">Rp {{ number_format($res['total_price'], 0, ',', '.') }}</span>
          </div>
        </div>
      </div>

      <!-- RIGHT -->
      <div class="res-right">

        {{-- STATUS BADGE --}}
        @if($res['status'] === 'pending')
        <span class="badge badge-pending">
          <span class="badge-dot"></span> Awaiting Verification
        </span>
        <div class="upload-notice">Proof of transfer is being reviewed</div>

        @elseif($res['status'] === 'confirmed')
        <span class="badge badge-confirmed">
          <span class="badge-dot"></span> Confirmed
        </span>

        @elseif($res['status'] === 'rejected')
        <span class="badge badge-rejected">
          <span class="badge-dot"></span> Rejected
        </span>
        @endif

        <a href="/reservations/{{ $res['id'] }}" class="btn-detail">See Detail</a>

      </div>

    </div>
    @endforeach

    @endif

  </div>
</div>

@endsection