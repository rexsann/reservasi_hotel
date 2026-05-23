@extends('Layouts.layout')

@section('content')

<style>
.table-scroll-wrap {
    max-height: 300px;
    overflow-y: auto;
    border-radius: 0 0 10px 10px;
}
.table-scroll-wrap::-webkit-scrollbar { width: 4px; }
.table-scroll-wrap::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

.room-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 13px;
}

.room-table col.c-id     { width: 52px; }
.room-table col.c-room   { width: 130px; }
.room-table col.c-offer  { width: 200px; }
.room-table col.c-price  { width: 160px; }
.room-table col.c-status { width: 130px; }
.room-table col.c-action { width: 90px; }

.room-table thead {
    position: sticky;
    top: 0;
    z-index: 5;
}

.room-table thead tr {
    background: #1e293b;
}

.room-table th {
    padding: 11px 14px;
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    color: #ffffff;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
}

.room-table th.th-c { text-align: center; }

.room-table tbody tr {
    border-top: 1px solid #f1f5f9;
    transition: background 0.1s;
}

.room-table tbody tr:hover {
    background: #f8fafc;
}

.room-table td {
    padding: 11px 14px;
    color: #1e293b;
    vertical-align: middle;
    font-size: 13px;
}

.room-table td.td-c { text-align: center; }

.room-table td.td-id {
    color: #94a3b8;
    font-size: 12px;
    text-align: center;
}

.room-table td.td-room {
    font-weight: 600;
    font-size: 13px;
}

.room-table td.td-price {
    font-weight: 600;
    color: #0f172a;
}

/* ===== Status Badge ===== */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 11px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 500;
    border: 1px solid;
    white-space: nowrap;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.s-available {
    background: #f0fdf4;
    color: #15803d;
    border-color: #bbf7d0;
}
.s-available .status-dot { background: #22c55e; }

.s-occupied {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #bfdbfe;
}
.s-occupied .status-dot { background: #3b82f6; }

.s-maintenance {
    background: #fffbeb;
    color: #b45309;
    border-color: #fde68a;
}
.s-maintenance .status-dot { background: #f59e0b; }

/* ===== Room Type Card ===== */
.room-type-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    margin-bottom: 1.75rem;
    overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}

.room-type-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 1.2rem 1.4rem 0.6rem;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.room-type-title {
    font-size: 1rem;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: inline;
}

.room-type-floor {
    color: #94a3b8;
    font-size: 0.9rem;
    margin-left: 4px;
}

.room-type-price {
    color: #64748b;
    font-size: 12px;
    margin: 4px 0 0;
}

.room-type-stats {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
    align-items: center;
}

/* ===== Summary Badges ===== */
.summary-badge {
    padding: 3px 12px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 500;
    border: 1.5px solid;
}
.sb-available   { color: #15803d; border-color: #bbf7d0; background: #f0fdf4; }
.sb-occupied    { color: #1d4ed8; border-color: #bfdbfe; background: #eff6ff; }
.sb-maintenance { color: #b45309; border-color: #fde68a; background: #fffbeb; }

/* ===== Facilities ===== */
.facilities-row {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 0 1.4rem 0.9rem;
    flex-wrap: wrap;
}
.facilities-label {
    color: #94a3b8;
    font-size: 12px;
}
.facility-tag {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 2px 9px;
    font-size: 11px;
    color: #475569;
}

/* ===== Edit Button ===== */
.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 500;
    color: #2563eb;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    padding: 4px 11px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.15s;
    text-decoration: none;
}
.btn-edit:hover { background: #dbeafe; }

/* ===== Empty ===== */
.empty-row {
    text-align: center;
    color: #94a3b8;
    padding: 1.5rem;
    font-size: 13px;
}
</style>

{{-- Page Header --}}
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rooms Management</h1>
        <p class="text-sm text-gray-400 mt-1">Manage hotel room data</p>
    </div>
</div>

{{-- Group by Room Type --}}
@php
    $grouped = $rooms->groupBy('type');
@endphp

@forelse($grouped as $typeName => $typeRooms)
<div class="room-type-card">

    {{-- Room Type Header --}}
    <div class="room-type-header">
        <div>
            <h2 class="room-type-title">{{ $typeName ?? 'Standard' }}</h2>
            <span class="room-type-floor">· Floor {{ $typeRooms->first()->floor ?? 1 }}</span>
            <p class="room-type-price">
                Rp {{ number_format($typeRooms->min('price_per_night'), 0, ',', '.') }}
                – Rp {{ number_format($typeRooms->max('price_per_night'), 0, ',', '.') }} / night
            </p>
        </div>
        <div class="room-type-stats">
            <span class="summary-badge sb-available">
                {{ $typeRooms->where('status', 'Available')->count() }} Available
            </span>
            <span class="summary-badge sb-occupied">
                {{ $typeRooms->where('status', 'Occupied')->count() }} Occupied
            </span>
            <span class="summary-badge sb-maintenance">
                {{ $typeRooms->where('status', 'Maintenance')->count() }} Maintenance
            </span>
        </div>
    </div>

    {{-- Facilities (opsional, jika ada kolom facilities) --}}
    @if($typeRooms->first()->facilities ?? false)
    <div class="facilities-row">
        <span class="facilities-label">Facilities:</span>
        @foreach(explode(',', $typeRooms->first()->facilities) as $fac)
            <span class="facility-tag">{{ trim($fac) }}</span>
        @endforeach
    </div>
    @endif

    {{-- Table --}}
    <div class="table-scroll-wrap">
        <table class="room-table">
            <colgroup>
                <col class="c-id">
                <col class="c-room">
                <col class="c-offer">
                <col class="c-price">
                <col class="c-status">
                <col class="c-action">
            </colgroup>
            <thead>
                <tr>
                    <th class="th-c">ID</th>
                    <th>Room</th>
                    <th>Offer</th>
                    <th>Price / Night</th>
                    <th class="th-c">Status</th>
                    <th class="th-c">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($typeRooms as $room)
                <tr>
                    <td class="td-id">{{ $room->id }}</td>
                    <td class="td-room">{{ $room->room_name }}</td>
                    <td>{{ $room->offer }}</td>
                    <td class="td-price">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</td>
                    <td class="td-c">
                        @if($room->status == 'Available')
                            <span class="status-badge s-available">
                                <span class="status-dot"></span> Available
                            </span>
                        @elseif($room->status == 'Occupied')
                            <span class="status-badge s-occupied">
                                <span class="status-dot"></span> Occupied
                            </span>
                        @else
                            <span class="status-badge s-maintenance">
                                <span class="status-dot"></span> Maintenance
                            </span>
                        @endif
                    </td>
                    <td class="td-c">
                        <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn-edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                            </svg>
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-row">Tidak ada kamar untuk tipe ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@empty
<div class="text-center text-gray-400 py-16">Belum ada data kamar.</div>
@endforelse

@endsection
