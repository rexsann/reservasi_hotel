@extends('admin.layout')

@section('content')

<style>
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .badge-confirmed { background: #dcfce7; color: #15803d; }
    .badge-pending   { background: #fef9c3; color: #a16207; }
    .badge-canceled  { background: #fee2e2; color: #b91c1c; }

    .stat-card { transition: box-shadow .2s; }
    .stat-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,.08); }

    .btn-edit {
        background: #1e293b;
        color: white;
        padding: 5px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: background .2s;
        border: none;
        cursor: pointer;
    }
    .btn-edit:hover { background: #334155; }

    .btn-detail {
        background: transparent;
        border: 1.5px solid #e2e8f0;
        color: #64748b;
        padding: 5px 9px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .2s;
    }
    .btn-detail:hover { border-color: #3b82f6; color: #3b82f6; }

    .btn-hapus {
        background: transparent;
        border: 1.5px solid #fecaca;
        color: #ef4444;
        padding: 5px 9px;
        border-radius: 8px;
        cursor: pointer;
        transition: all .2s;
        font-size: 12px;
        font-weight: 600;
    }
    .btn-hapus:hover { background: #fee2e2; }
</style>

{{-- ===== HEADER ===== --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">Reservations Management</h2>
        <p class="text-sm text-gray-400 mt-0.5">Kelola semua data reservasi tamu hotel</p>
    </div>
    <button
        data-modal-target="modal-tambah"
        data-modal-toggle="modal-tambah"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Reservasi
    </button>
</div>

{{-- ===== FLASH MESSAGE ===== --}}
@if(session('success'))
    <div id="alert-success" class="flex items-center p-4 mb-5 text-green-800 bg-green-50 rounded-xl border border-green-200 text-sm" role="alert">
        <svg class="w-4 h-4 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="stat-card bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Reservasi</p>
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $total }}</p>
        <p class="text-xs text-gray-400 mt-1">Semua waktu</p>
    </div>
    <div class="stat-card bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Confirmed</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $confirmed }}</p>
        <p class="text-xs text-green-400 mt-1">Aktif</p>
    </div>
    <div class="stat-card bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Pending</p>
        <p class="text-3xl font-bold text-yellow-500 mt-1">{{ $pending }}</p>
        <p class="text-xs text-yellow-400 mt-1">Menunggu konfirmasi</p>
    </div>
    <div class="stat-card bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Canceled</p>
        <p class="text-3xl font-bold text-red-500 mt-1">{{ $canceled }}</p>
        <p class="text-xs text-red-400 mt-1">Dibatalkan</p>
    </div>
</div>

{{-- ===== TABLE CARD ===== --}}
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">

    {{-- Filter Bar --}}
    <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-3 items-center">
        <form method="GET" action="{{ route('admin.reservations.index') }}"
              class="flex flex-wrap gap-3 items-center w-full">

            {{-- Search --}}
            <div class="relative flex-1 min-w-[200px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search Customer..."
                       class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition" />
            </div>

            {{-- Status --}}
            <select name="status"
                    class="py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition min-w-[140px]">
                <option value="">All Status</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                <option value="canceled"  {{ request('status') === 'canceled'  ? 'selected' : '' }}>Canceled</option>
            </select>

            {{-- Date --}}
            <input type="date" name="date" value="{{ request('date') }}"
                   class="py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition min-w-[160px]" />

            {{-- Buttons --}}
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">
                Filter
            </button>
            <a href="{{ route('admin.reservations.index') }}"
               class="text-sm text-gray-400 hover:text-gray-600 font-medium transition">
                Reset
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">ID</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Customers</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Rooms</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Floor</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Check In</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Check Out</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">

                @forelse($reservations as $res)
                <tr class="hover:bg-gray-50 transition">

                    {{-- ID --}}
                    <td class="px-5 py-4">
                        <span class="text-gray-400 font-mono text-xs">#{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</span>
                    </td>

                    {{-- Customer --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ $res->user->name ?? '-' }}</span>
                        </div>
                    </td>

                    {{-- Room Number --}}
                    <td class="px-5 py-4">
                        <span class="font-mono font-semibold text-gray-700 text-sm">{{ $res->room->nomor_kamar ?? '-' }}</span>
                    </td>

                    {{-- Floor --}}
                    <td class="px-5 py-4 text-sm text-gray-500">
                        Lt. {{ $res->room->lantai ?? '-' }}
                    </td>

                    {{-- Check In --}}
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($res->check_in)->format('Y-m-d') }}
                    </td>

                    {{-- Check Out --}}
                    <td class="px-5 py-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($res->check_out)->format('Y-m-d') }}
                    </td>

                    {{-- Status Badge --}}
                    <td class="px-5 py-4">
                        @if($res->status === 'confirmed')
                            <span class="badge badge-confirmed">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Confirmed
                            </span>
                        @elseif($res->status === 'pending')
                            <span class="badge badge-pending">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Pending
                            </span>
                        @elseif($res->status === 'canceled')
                            <span class="badge badge-canceled">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Canceled
                            </span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">

                            {{-- Tombol Detail --}}
                            <button class="btn-detail"
                                    title="Lihat Detail"
                                    data-modal-target="modal-detail-{{ $res->id }}"
                                    data-modal-toggle="modal-detail-{{ $res->id }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </button>

                            {{-- Tombol Edit --}}
                            <a href="{{ route('admin.reservations.edit', $res->id) }}"
                               class="btn-edit">Edit</a>

                            {{-- Tombol Hapus --}}
                            <form method="POST" action="{{ route('admin.reservations.destroy', $res->id) }}"
                                  onsubmit="return confirm('Yakin ingin menghapus reservasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus">Hapus</button>
                            </form>

                        </div>
                    </td>
                </tr>

                {{-- Modal Detail per baris --}}
                <div id="modal-detail-{{ $res->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                        <div class="relative bg-white rounded-2xl shadow-2xl">
                            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                                <h3 class="text-base font-bold text-gray-800">Detail Reservasi #{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</h3>
                                <button type="button" data-modal-hide="modal-detail-{{ $res->id }}" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-5 grid grid-cols-2 gap-3 text-sm">
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Customer</p>
                                    <p class="font-semibold text-gray-700">{{ $res->user->name ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Email</p>
                                    <p class="font-semibold text-gray-700 text-xs">{{ $res->user->email ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">No. Kamar</p>
                                    <p class="font-semibold text-gray-700">{{ $res->room->nomor_kamar ?? '-' }} — Lt. {{ $res->room->lantai ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Tipe Kamar</p>
                                    <p class="font-semibold text-gray-700">{{ $res->room->tipe ?? '-' }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Check In</p>
                                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Check Out</p>
                                    <p class="font-semibold text-gray-700">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Status</p>
                                    @if($res->status === 'confirmed')
                                        <span class="badge badge-confirmed mt-1">Confirmed</span>
                                    @elseif($res->status === 'pending')
                                        <span class="badge badge-pending mt-1">Pending</span>
                                    @elseif($res->status === 'canceled')
                                        <span class="badge badge-canceled mt-1">Canceled</span>
                                    @endif
                                </div>
                                <div class="bg-gray-50 rounded-xl p-3">
                                    <p class="text-xs text-gray-400 mb-0.5">Durasi</p>
                                    <p class="font-semibold text-gray-700">
                                        {{ \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out) }} malam
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-3 px-5 pb-5">
                                <button data-modal-hide="modal-detail-{{ $res->id }}"
                                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition font-medium">
                                    Tutup
                                </button>
                                <a href="{{ route('admin.reservations.edit', $res->id) }}"
                                   class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition text-center">
                                    Edit Reservasi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="8" class="text-center py-16 text-gray-400 text-sm">
                        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Belum ada data reservasi.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <p class="text-xs text-gray-400">
            Menampilkan <span class="font-semibold text-gray-600">{{ $reservations->firstItem() ?? 0 }}</span>–<span class="font-semibold text-gray-600">{{ $reservations->lastItem() ?? 0 }}</span>
            dari <span class="font-semibold text-gray-600">{{ $reservations->total() }}</span> reservasi
        </p>
        <div>
            {{ $reservations->links() }}
        </div>
    </div>
</div>


{{-- ===== MODAL TAMBAH RESERVASI ===== --}}
<div id="modal-tambah" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
        <div class="relative bg-white rounded-2xl shadow-2xl">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">Tambah Reservasi Baru</h3>
                <button type="button" data-modal-hide="modal-tambah" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.reservations.store') }}" class="p-5 space-y-4">
                @csrf

                {{-- Nama Tamu --}}
<div>
    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Nama Tamu</label>
    <input type="text" name="guest_name" required
        class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition" />
</div>

{{-- Email --}}
<div>
    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Email</label>
    <input type="email" name="guest_email" required
        class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition" />
</div>

   {{-- ROOM ID --}}
<div>
    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Room ID</label>
    <select name="room_id" id="room_id"
        class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50"
        required>
        <option value="">-- Pilih Room ID --</option>
        @for ($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}">
                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
            </option>
        @endfor
    </select>
</div>

{{-- FLOOR --}}
<div>
    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Floor</label>
    <select name="floor" id="floor"
        class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50"
        required>
        <option value="">-- Pilih Floor --</option>
        <option value="1">Floor 1</option>
        <option value="2">Floor 2</option>
        <option value="3">Floor 3</option>
    </select>
</div>

{{-- TYPE AUTO --}}
<div>
    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Room Type</label>
    <input type="text" id="room_type"
        class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-100"
        readonly>
</div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Check In</label>
                        <input type="date" name="check_in" required
                               class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5">Check Out</label>
                        <input type="date" name="check_out" required
                               class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5">Status</label>
                    <select name="status" required class="w-full py-2 px-3 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button" data-modal-hide="modal-tambah"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                        Simpan Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('floor').addEventListener('change', function () {
    let floor = this.value;
    let typeInput = document.getElementById('room_type');

    if (floor == 1) {
        typeInput.value = 'Standard';
    } else if (floor == 2) {
        typeInput.value = 'Superior';
    } else if (floor == 3) {
        typeInput.value = 'Deluxe';
    } else {
        typeInput.value = '';
    }
});
</script>

@endsection