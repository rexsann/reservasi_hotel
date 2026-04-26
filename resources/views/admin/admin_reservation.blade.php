@extends('Layouts.layout')

@section('content')

@php
$harga = ['Standard' => 350000, 'Superior' => 500000, 'Deluxe' => 750000];

$reservations = collect([
    (object)[
        'id' => 1,
        'user' => (object)['name' => 'Nareen', 'email' => 'nareen@mail.com'],
        'room' => (object)['nomor_kamar' => '01', 'lantai' => 1, 'tipe' => 'Standard'],
        'check_in' => '2026-04-20', 'check_out' => '2026-04-22', 'status' => 'confirmed'
    ],
    (object)[
        'id' => 2,
        'user' => (object)['name' => 'Kevin', 'email' => 'kevin@mail.com'],
        'room' => (object)['nomor_kamar' => '02', 'lantai' => 2, 'tipe' => 'Superior'],
        'check_in' => '2026-04-25', 'check_out' => '2026-04-27', 'status' => 'pending'
    ],
    (object)[
        'id' => 3,
        'user' => (object)['name' => 'Alicia', 'email' => 'alicia@mail.com'],
        'room' => (object)['nomor_kamar' => '01', 'lantai' => 3, 'tipe' => 'Deluxe'],
        'check_in' => '2026-04-28', 'check_out' => '2026-05-01', 'status' => 'canceled'
    ],
    (object)[
        'id' => 4,
        'user' => (object)['name' => 'Budi', 'email' => 'budi@mail.com'],
        'room' => (object)['nomor_kamar' => '01', 'lantai' => 1, 'tipe' => 'Standard'],
        'check_in' => '2026-03-10', 'check_out' => '2026-03-13', 'status' => 'checked_out'
    ],
    (object)[
        'id' => 5,
        'user' => (object)['name' => 'Sari', 'email' => 'sari@mail.com'],
        'room' => (object)['nomor_kamar' => '02', 'lantai' => 2, 'tipe' => 'Superior'],
        'check_in' => '2026-03-15', 'check_out' => '2026-03-17', 'status' => 'checked_out'
    ],
]);

$aktif   = $reservations->whereIn('status', ['pending', 'confirmed']);
$riwayat = $reservations->whereIn('status', ['checked_out', 'canceled']);

$income = $riwayat->where('status', 'checked_out')->sum(function($r) use ($harga) {
    $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
    return $nights * $harga[$r->room->tipe];
});
$lost = $riwayat->where('status', 'canceled')->sum(function($r) use ($harga) {
    $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
    return $nights * $harga[$r->room->tipe];
});
@endphp

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-semibold text-gray-800">Reservations Management</h2>
        <p class="text-sm text-gray-400">Kelola reservasi hotel</p>
    </div>
    <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Reservasi
    </button>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Total Aktif</p>
        <p class="text-2xl font-semibold text-gray-800">{{ $aktif->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Confirmed
        </p>
        <p class="text-2xl font-semibold text-green-600">{{ $aktif->where('status','confirmed')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Pending
        </p>
        <p class="text-2xl font-semibold text-yellow-500">{{ $aktif->where('status','pending')->count() }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span> Total Riwayat
        </p>
        <p class="text-2xl font-semibold text-blue-500">{{ $riwayat->count() }}</p>
    </div>
</div>

{{-- TABS --}}
<div class="mb-4 border-b border-gray-200">
    <ul class="flex gap-1 text-sm font-medium">
        <li>
            <button onclick="switchTab('aktif')" id="tab-aktif"
                class="tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition">
                Aktif
                <span class="ml-1.5 bg-blue-100 text-blue-600 text-xs px-1.5 py-0.5 rounded-full">{{ $aktif->count() }}</span>
            </button>
        </li>
        <li>
            <button onclick="switchTab('riwayat')" id="tab-riwayat"
                class="tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition">
                Riwayat
                <span class="ml-1.5 bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">{{ $riwayat->count() }}</span>
            </button>
        </li>
    </ul>
</div>

{{-- TAB: AKTIF --}}
<div id="panel-aktif">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Room</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Check In</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Check Out</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-black-500 uppercase">Action</th>
                </tr>
            </thead>

            <tbody id="aktif-table-body" class="divide-y divide-gray-100">
                @forelse($aktif as $res)
                <tr class="hover:bg-gray-50 transition">
                    
                    <td class="px-6 py-4 text-gray-600 text-sm font-medium">
                        {{ $res->id }}
                    </td>

                    <td class="px-6 py-4">
                        <p class="font-semibold text-gray-800">{{ $res->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $res->user->email }}</p>
                    </td>

                    <td class="px-6 py-4">
                        <p class="text-gray-700 font-medium">
                            Room {{ $res->room->nomor_kamar }} • Floor {{ $res->room->lantai }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $res->room->tipe }}</p>
                    </td>

                    <td class="px-6 py-4 text-gray-700">{{ $res->check_in }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $res->check_out }}</td>

                    <td class="px-6 py-4">
                        @if($res->status == 'confirmed')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                Confirmed
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <button
                                onclick="openEdit({{ $res->id }}, '{{ $res->user->name }}', '{{ $res->user->email }}', '{{ $res->room->lantai }}', '{{ $res->check_in }}', '{{ $res->check_out }}', '{{ $res->status }}')"
                                class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                Edit
                            </button>

                            <button
                                onclick="checkoutRow(this)"
                                class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition">
                                Check Out
                            </button>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                        Tidak ada reservasi aktif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

{{-- TAB: RIWAYAT --}}
<div id="panel-riwayat" class="hidden">

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Pemasukan Masuk
            </p>
            <p class="text-xl font-semibold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Potensi Hilang (Canceled)
            </p>
            <p class="text-xl font-semibold text-red-500">Rp {{ number_format($lost, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-800">
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Customer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Kamar & Tipe</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check In</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Check Out</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Total Bayar</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayat as $res)
                @php
                    $nights = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                    $total  = $nights * $harga[$res->room->tipe];
                @endphp
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3 text-gray-400 text-xs font-medium">#{{ $res->id }}</td>
                    <td class="px-4 py-3">
                        <p class="font-semibold text-gray-800">{{ $res->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $res->user->email }}</p>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-gray-700 font-medium">Kamar {{ $res->room->nomor_kamar }} &middot; Lt {{ $res->room->lantai }}</p>
                        <p class="text-xs text-gray-400">{{ $res->room->tipe }} &middot; Rp {{ number_format($harga[$res->room->tipe], 0, ',', '.') }}/malam</p>
                    </td>
                    <td class="px-4 py-3 text-gray-700 font-medium">{{ $res->check_in }}</td>
                    <td class="px-4 py-3">
                        <p class="text-gray-700 font-medium">{{ $res->check_out }}</p>
                        <p class="text-xs text-gray-400">{{ $nights }} malam</p>
                    </td>
                    <td class="px-4 py-3">
                        @if($res->status === 'canceled')
                            <span class="text-xs text-red-400 line-through">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @else
                            <span class="font-semibold text-green-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($res->status === 'checked_out')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Canceled
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-400">Belum ada riwayat reservasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <p class="text-xs text-gray-400 mt-3">* Pemasukan hanya dihitung dari reservasi berstatus <strong>Checked Out</strong>.</p>
</div>

{{-- MODAL TAMBAH --}}
<div id="modal-tambah" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Tambah Reservasi</h3>
                <button type="button" data-modal-hide="modal-tambah"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <input id="f-name" type="text" placeholder="Masukkan nama"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="f-email" type="email" placeholder="email@contoh.com"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Lantai</label>
                        <select id="f-floor"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih lantai</option>
                            <option value="1">Lantai 1</option>
                            <option value="2">Lantai 2</option>
                            <option value="3">Lantai 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Kamar</label>
                        <div id="f-type-display"
                            class="w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400">—</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check In</label>
                        <input id="f-checkin" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check Out</label>
                        <input id="f-checkout" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select id="f-status"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="saveReservation()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan Reservasi
                </button>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modal-edit" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800" id="edit-modal-title">Edit Reservasi</h3>
                <button type="button" data-modal-hide="modal-edit"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                    <input id="e-name" type="text"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="e-email" type="email"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Lantai</label>
                        <select id="e-floor"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="1">Lantai 1</option>
                            <option value="2">Lantai 2</option>
                            <option value="3">Lantai 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Kamar</label>
                        <div id="e-type-display"
                            class="w-full border border-blue-100 bg-blue-50 rounded-lg px-3 py-2 text-sm text-blue-700 font-medium">—</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check In</label>
                        <input id="e-checkin" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check Out</label>
                        <input id="e-checkout" type="date"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-blue-700 mb-0.5">Penambahan Malam</p>
                    <p class="text-xs text-blue-500">Ubah tanggal Check Out untuk memperpanjang masa menginap tamu.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select id="e-status"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="canceled">Canceled</option>
                    </select>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="saveEdit()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const roomMap = {
    '1': { room: '01', tipe: 'Standard' },
    '2': { room: '02', tipe: 'Superior' },
    '3': { room: '03', tipe: 'Deluxe'  }
};

let currentEditId = null;

// ── TAB SWITCH ──────────────────────────────────────────
function switchTab(tab) {
    const isAktif = tab === 'aktif';
    document.getElementById('panel-aktif').classList.toggle('hidden', !isAktif);
    document.getElementById('panel-riwayat').classList.toggle('hidden', isAktif);

    document.getElementById('tab-aktif').className = isAktif
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';

    document.getElementById('tab-riwayat').className = !isAktif
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
}

// ── MODAL TAMBAH ─────────────────────────────────────────
document.getElementById('f-floor').addEventListener('change', function () {
    const typeEl = document.getElementById('f-type-display');
    typeEl.textContent = this.value ? roomMap[this.value].tipe : '—';
    typeEl.className = this.value
        ? 'w-full border border-blue-100 bg-blue-50 rounded-lg px-3 py-2 text-sm text-blue-700 font-medium'
        : 'w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400';
});

function saveReservation() {
    const name     = document.getElementById('f-name').value.trim();
    const email    = document.getElementById('f-email').value.trim();
    const floor    = document.getElementById('f-floor').value;
    const checkin  = document.getElementById('f-checkin').value;
    const checkout = document.getElementById('f-checkout').value;
    const status   = document.getElementById('f-status').value;

    if (!name || !email || !floor || !checkin || !checkout) {
        alert('Harap lengkapi semua field!'); return;
    }
    if (checkout <= checkin) {
        alert('Check Out harus setelah Check In!'); return;
    }

    const rm    = roomMap[floor];
    const tbody = document.getElementById('aktif-table-body');
    const id    = tbody.querySelectorAll('tr').length + 1;

    const badgeMap = {
        confirmed: 'bg-green-100 text-green-700 border border-green-200',
        pending:   'bg-yellow-100 text-yellow-700 border border-yellow-200',
        canceled:  'bg-red-100 text-red-700 border border-red-200',
    };
    const dotMap = {
        confirmed: 'bg-green-500',
        pending:   'bg-yellow-400',
        canceled:  'bg-red-400',
    };

    const row = `
    <tr class="hover:bg-gray-50 transition">
        <td class="px-4 py-3 text-gray-400 text-xs font-medium">#${id}</td>
        <td class="px-4 py-3">
            <p class="font-semibold text-gray-800">${name}</p>
            <p class="text-xs text-gray-400">${email}</p>
        </td>
        <td class="px-4 py-3">
            <p class="text-gray-700 font-medium">Kamar ${rm.room} &middot; Lt ${floor}</p>
            <p class="text-xs text-gray-400">${rm.tipe}</p>
        </td>
        <td class="px-4 py-3 text-gray-700 font-medium">${checkin}</td>
        <td class="px-4 py-3 text-gray-700 font-medium">${checkout}</td>
        <td class="px-4 py-3">
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold ${badgeMap[status]}">
                <span class="w-1.5 h-1.5 rounded-full ${dotMap[status]}"></span>
                ${status.charAt(0).toUpperCase() + status.slice(1)}
            </span>
        </td>
        <td class="px-4 py-3">
            <div class="flex gap-2">
                <button onclick="openEdit(${id},'${name}','${email}','${floor}','${checkin}','${checkout}','${status}')"
                    class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition font-medium">Edit</button>
                <button onclick="checkoutRow(this)"
                    class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition font-medium">Check Out</button>
            </div>
        </td>
    </tr>`;

    tbody.insertAdjacentHTML('beforeend', row);

    ['f-name','f-email','f-checkin','f-checkout'].forEach(el => document.getElementById(el).value = '');
    document.getElementById('f-floor').value  = '';
    document.getElementById('f-status').value = 'pending';
    document.getElementById('f-type-display').textContent = '—';
    document.getElementById('f-type-display').className   = 'w-full border border-gray-100 bg-gray-50 rounded-lg px-3 py-2 text-sm text-gray-400';

    FlowbiteInstances.getInstance('Modal', 'modal-tambah')?.hide();
}

// ── MODAL EDIT ───────────────────────────────────────────
document.getElementById('e-floor').addEventListener('change', function () {
    document.getElementById('e-type-display').textContent = roomMap[this.value]?.tipe ?? '—';
});

function openEdit(id, name, email, lantai, checkin, checkout, status) {
    currentEditId = id;
    document.getElementById('edit-modal-title').textContent = 'Edit Reservasi #' + id;
    document.getElementById('e-name').value     = name;
    document.getElementById('e-email').value    = email;
    document.getElementById('e-floor').value    = lantai;
    document.getElementById('e-checkin').value  = checkin;
    document.getElementById('e-checkout').value = checkout;
    document.getElementById('e-status').value   = status;
    document.getElementById('e-type-display').textContent = roomMap[lantai]?.tipe ?? '—';

    const modal = FlowbiteInstances.getInstance('Modal', 'modal-edit')
        ?? new Modal(document.getElementById('modal-edit'));
    modal.show();
}

function saveEdit() {
    const checkin  = document.getElementById('e-checkin').value;
    const checkout = document.getElementById('e-checkout').value;
    if (checkout <= checkin) { alert('Check Out harus setelah Check In!'); return; }

    alert('Perubahan reservasi #' + currentEditId + ' disimpan!');
    FlowbiteInstances.getInstance('Modal', 'modal-edit')?.hide();
}

// ── CHECK OUT ────────────────────────────────────────────
function checkoutRow(btn) {
    if (!confirm('Tandai tamu ini sebagai sudah Check Out?')) return;
    btn.closest('tr').remove();
}
</script>

@endsection