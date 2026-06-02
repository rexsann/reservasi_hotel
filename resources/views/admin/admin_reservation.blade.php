@extends('Layouts.layout')

@section('content')

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Reservations Management</h2>
            <p class="text-sm text-gray-400">manage your hotel reservations</p>
        </div>
        <button onclick="openModalTambah()"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Reservasi
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
            <p class="text-2xl font-semibold text-green-600">{{ $confirmed }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Pending
            </p>
            <p class="text-2xl font-semibold text-yellow-500">{{ $pending }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-blue-400 inline-block"></span> Total History
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
                    History
                    <span class="ml-1.5 bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">{{ $riwayat->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    {{-- TAB: AKTIF --}}
    <div id="panel-aktif">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-x-auto">
            <table class="w-full text-sm min-w-[900px]">
                <thead>
                    <tr class="bg-gray-800 text-gray-300 text-xs uppercase tracking-wider">
                        <th class="px-4 py-3 text-center">ID</th>
                        <th class="px-4 py-3 text-center">Code</th>
                        <th class="px-6 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-center">Room</th>
                        <th class="px-4 py-3 text-center">Check In</th>
                        <th class="px-4 py-3 text-center">Check Out</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($aktif as $res)
                    <tr class="hover:bg-gray-50 transition" id="row-{{ $res->id }}"
                        data-id="{{ $res->id }}"
                        data-name="{{ $res->name }}"
                        data-email="{{ $res->email }}"
                        data-checkin="{{ $res->check_in }}"
                        data-checkout="{{ $res->check_out }}"
                        data-status="{{ $res->status }}"
                        data-kode="{{ $res->reservation_code }}"
                        data-total="{{ $res->total_price }}"
                        data-room="{{ $res->room_name }}"
                        data-type="{{ $res->room_type }}">

                        <td class="px-4 py-4 text-center text-xs text-gray-400">
                            {{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="px-4 py-4 text-center" id="kode-{{ $res->id }}">
                            @if($res->reservation_code)
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                                    {{ $res->reservation_code }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300 italic">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-800">{{ $res->name }}</p>
                            <p class="text-xs text-gray-400">{{ $res->email }}</p>
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-xs font-semibold text-gray-800">{{ $res->room_name }}</p>
                            <p class="text-xs text-gray-400">{{ $res->room_type }}</p>
                        </td>
                        <td class="px-4 py-4 text-center text-gray-700">
                            {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4 text-center text-gray-700">
                            {{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            <p class="text-sm font-semibold text-gray-800">
                                Rp {{ number_format($res->total_price, 0, ',', '.') }}
                            </p>
                        </td>
                        <td class="px-4 py-4 text-center" id="status-badge-{{ $res->id }}">
                            @php
                                $badgeClass = match($res->status) {
                                    'Confirmed'            => 'bg-green-100 text-green-700',
                                    'Checked In'           => 'bg-blue-100 text-blue-700',
                                    'Waiting Verification' => 'bg-purple-100 text-purple-700',
                                    default                => 'bg-yellow-100 text-yellow-700',
                                };
                            @endphp
                            <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $badgeClass }}">
                                {{ $res->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4" id="actions-{{ $res->id }}">
                            <div class="flex justify-center gap-2 flex-wrap">
                                <button onclick="openEdit({{ $res->id }})"
                                    class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                    Edit
                                </button>
                                <button onclick="deleteReservation({{ $res->id }})"
                                    class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-gray-400">No active reservations</td>
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
                    <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Income (Checked Out)
                </p>
                <p class="text-xl font-semibold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
                <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Potential Loss (Cancelled)
                </p>
                <p class="text-xl font-semibold text-red-500">Rp {{ number_format($lost, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Room</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Check In</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Check Out</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Total</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $res)
                    @php
                        $nights = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">#{{ $res->id }}</td>
                        <td class="px-4 py-3">
                            @if($res->reservation_code)
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">
                                    {{ $res->reservation_code }}
                                </span>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-800">{{ $res->name }}</p>
                            <p class="text-xs text-gray-400">{{ $res->email }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-xs font-semibold text-gray-800">{{ $res->room_name }}</p>
                            <p class="text-xs text-gray-400">{{ $res->room_type }}</p>
                        </td>
                        <td class="px-4 py-3 text-gray-700">
                            {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-gray-700">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $nights }} nights</p>
                        </td>
                        <td class="px-4 py-3">
                            @if($res->status === 'Cancelled')
                                <span class="text-xs text-red-400 line-through">
                                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="font-semibold text-green-700">
                                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($res->status === 'Checked Out')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Cancelled
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-400">No reservation history</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Income only calculated from reservations with status <strong>Checked Out</strong>.</p>
    </div>

    {{-- MODAL TAMBAH --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Add Reservation</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Status awal otomatis Pending Payment</p>
                </div>
                <button onclick="closeModalTambah()" class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Full Name</label>
                    <input id="f-name" type="text" placeholder="Enter guest name"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="f-email" type="email" placeholder="email@contoh.com"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Room Name</label>
                        <input id="f-room-name" type="text" placeholder="Deluxe Room"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Room Type</label>
                        <select id="f-room-type"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Standard">Standard</option>
                            <option value="Superior">Superior</option>
                            <option value="Deluxe">Deluxe</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Offer / Package</label>
                    <input id="f-offer" type="text" placeholder="Room Only, Breakfast Package, dll"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check In</label>
                        <input id="f-checkin" type="date" onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Check Out</label>
                        <input id="f-checkout" type="date" onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Total Price</label>
                    <input id="f-total-price" type="number" placeholder="750000"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-yellow-700">⏳ Status awal: Pending Payment</p>
                </div>
            </div>
            <div class="px-5 pb-5">
                <button onclick="saveReservation()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Save Reservation
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-md">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-800" id="edit-modal-title">Edit Reservation</h3>
                    <p class="text-xs text-gray-400 mt-0.5" id="edit-modal-sub"></p>
                </div>
                <button onclick="closeEditModal()" class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Guest Name</label>
                    <input id="e-name" type="text" disabled
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="e-email" type="text" disabled
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Room</label>
                        <input id="e-room" type="text" disabled
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                        <input id="e-type" type="text" disabled
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Ubah Status</label>
                    <select id="e-status" onchange="onStatusChange()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Pending Payment">Pending Payment</option>
                        <option value="Waiting Verification">Waiting Verification</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Checked In">Checked In</option>
                        <option value="Checked Out">Checked Out</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div id="e-cancel-warning" class="hidden bg-red-50 border border-red-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-semibold text-red-600">⚠️ Reservasi akan dibatalkan</p>
                    <p class="text-xs text-red-500 mt-0.5">Data akan pindah ke tab History.</p>
                </div>
            </div>
            <div class="px-5 pb-5 flex gap-2">
                <button onclick="closeEditModal()"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button onclick="saveEdit()"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    <script>
    let currentEditId = null;

    // ── TAB SWITCH ──
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

    // ── MODAL TAMBAH ──
    function openModalTambah() {
        document.getElementById('modal-tambah').classList.remove('hidden');
    }

    function closeModalTambah() {
        document.getElementById('modal-tambah').classList.add('hidden');
    }

    // ── MODAL EDIT ──
    function openEdit(id) {
        const row = document.getElementById('row-' + id);
        if (!row) return;

        currentEditId = id;

        document.getElementById('edit-modal-title').textContent = 'Edit Reservasi #' + String(id).padStart(3, '0');
        document.getElementById('edit-modal-sub').textContent   = row.dataset.name + ' · ' + row.dataset.email;
        document.getElementById('e-name').value   = row.dataset.name;
        document.getElementById('e-email').value  = row.dataset.email;
        document.getElementById('e-room').value   = row.dataset.room;
        document.getElementById('e-type').value   = row.dataset.type;
        document.getElementById('e-status').value = row.dataset.status;

        onStatusChange();
        document.getElementById('modal-edit').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('modal-edit').classList.add('hidden');
    }

    function onStatusChange() {
        const status  = document.getElementById('e-status').value;
        const warning = document.getElementById('e-cancel-warning');
        warning.classList.toggle('hidden', status !== 'Cancelled');
    }

    function saveEdit() {
        const status = document.getElementById('e-status').value;
        const id     = currentEditId;

        fetch(`/admin/reservations/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'PUT'
            },
            body: JSON.stringify({ status: status })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeEditModal();
                location.reload();
            } else {
                alert('Gagal update status.');
            }
        });
    }

    // ── DELETE ──
    function deleteReservation(id) {
        if (!confirm('Hapus reservasi ini permanen?')) return;

        fetch(`/admin/reservations/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-HTTP-Method-Override': 'DELETE'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert('Gagal menghapus.');
        });
    }

    // ── SAVE TAMBAH ──
    async function saveReservation() {
        const name       = document.getElementById('f-name').value.trim();
        const email      = document.getElementById('f-email').value.trim();
        const room_name  = document.getElementById('f-room-name').value.trim();
        const room_type  = document.getElementById('f-room-type').value;
        const offer      = document.getElementById('f-offer').value.trim();
        const checkin    = document.getElementById('f-checkin').value;
        const checkout   = document.getElementById('f-checkout').value;
        const totalPrice = document.getElementById('f-total-price').value;

        if (!name || !email || !room_name || !room_type || !checkin || !checkout || !totalPrice) {
            alert('Lengkapi semua field.');
            return;
        }

        if (checkout <= checkin) {
            alert('Check out harus setelah check in.');
            return;
        }

        try {
            const response = await fetch('/admin/reservations', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    name:        name,
                    email:       email,
                    room_name:   room_name,
                    room_type:   room_type,
                    offer:       offer,
                    check_in:    checkin,
                    check_out:   checkout,
                    total_price: totalPrice,
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('Reservasi berhasil ditambahkan.');
                closeModalTambah();
                location.reload();
            } else {
                alert(result.message || 'Gagal menyimpan.');
            }
        } catch (error) {
            console.error(error);
            alert('Server error.');
        }
    }
    </script>

@endsection