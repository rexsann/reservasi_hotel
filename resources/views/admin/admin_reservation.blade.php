@extends('Layouts.layout')

@section('content')
    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Reservations Management</h2>
            <p class="text-sm text-gray-400">Manage your hotel reservations</p>
        </div>
        <button onclick="openModalTambah()"
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Reservation
        </button>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1">Total Active</p>
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
                    Active
                    <span
                        class="ml-1.5 bg-blue-100 text-blue-600 text-xs px-1.5 py-0.5 rounded-full">{{ $aktif->count() }}</span>
                </button>
            </li>
            <li>
                <button onclick="switchTab('riwayat')" id="tab-riwayat"
                    class="tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition">
                    History
                    <span
                        class="ml-1.5 bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">{{ $riwayat->count() }}</span>
                </button>
            </li>
        </ul>
    </div>

    {{-- SEARCH & FILTER (Active tab) --}}
    <div id="filter-aktif" class="flex flex-col sm:flex-row gap-2 mb-4">
        <div class="relative flex-1">
            <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
            <input id="search-aktif" type="text" oninput="filterTable()"
                placeholder="Search by guest name, email, code, or room..."
                class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <select id="filter-status" onchange="filterTable()"
            class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 sm:w-56">
            <option value="">All Status</option>
            <option value="Pending Payment">Pending Payment</option>
            <option value="Waiting Verification">Waiting Verification</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Checked In">Checked In</option>
        </select>
    </div>

    {{-- TAB: ACTIVE --}}
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
                <tbody class="divide-y divide-gray-100" id="table-body-aktif">
                    @forelse($aktif as $res)
                        @php
                            $nights = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                            $badgeClass = match ($res->status) {
                                'Confirmed' => 'bg-green-100 text-green-700',
                                'Checked In' => 'bg-blue-100 text-blue-700',
                                'Waiting Verification' => 'bg-purple-100 text-purple-700',
                                default => 'bg-yellow-100 text-yellow-700',
                            };
                        @endphp
                        <tr class="hover:bg-gray-50 transition" id="row-{{ $res->id }}" data-id="{{ $res->id }}"
                            data-name="{{ $res->name }}" data-email="{{ $res->email }}"
                            data-checkin="{{ $res->check_in }}" data-checkout="{{ $res->check_out }}"
                            data-status="{{ $res->status }}" data-kode="{{ $res->reservation_code }}"
                            data-total="{{ $res->total_price }}" data-room="{{ $res->room_name }}"
                            data-room-id="{{ $res->room_id }}" data-room-type-id="{{ $res->room_type_id }}"
                            data-type="{{ $res->roomType?->name }}"
                            data-search="{{ strtolower($res->name . ' ' . $res->email . ' ' . $res->reservation_code . ' ' . $res->room_name . ' ' . $res->roomType?->name) }}">

                            <td class="px-4 py-4 text-center text-xs text-gray-400">
                                {{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-4 text-center">
                                @if ($res->reservation_code)
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
                                <p class="text-xs font-semibold text-gray-800">{{ $res->room_name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $res->roomType?->name }}</p>
                            </td>
                            <td class="px-4 py-4 text-center text-gray-700">
                                {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-4 text-center text-gray-700">
                                <p>{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}
                                </p>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <p class="text-sm font-semibold text-gray-800">
                                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                </p>
                            </td>
                            <td class="px-4 py-4 text-center">
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $badgeClass }}">
                                    {{ $res->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <button onclick="openEdit({{ $res->id }})"
                                        class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                        Edit
                                    </button>
                                    <button onclick="deleteReservation({{ $res->id }})"
                                        class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                                        Delete
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
            <p id="no-result-aktif" class="hidden px-6 py-10 text-center text-gray-400 text-sm">
                No reservations match your search.
            </p>
        </div>
    </div>

    {{-- TAB: HISTORY --}}
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

        {{-- SEARCH (History tab) --}}
        <div class="mb-4">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                </svg>
                <input id="search-riwayat" type="text" oninput="filterHistoryTable()"
                    placeholder="Search by guest name, email, code, or room..."
                    class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-x-auto">
            <table class="w-full text-sm min-w-[800px]">
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
                <tbody class="divide-y divide-gray-100" id="table-body-riwayat">
                    @forelse($riwayat as $res)
                        @php
                            $nights = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                        @endphp
                        <tr class="hover:bg-gray-50 transition"
                            data-search="{{ strtolower($res->name . ' ' . $res->email . ' ' . $res->reservation_code . ' ' . $res->room_name . ' ' . $res->roomType?->name) }}">
                            <td class="px-4 py-3 text-gray-400 text-xs">#{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($res->reservation_code)
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
                                <p class="text-xs font-semibold text-gray-800">{{ $res->room_name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $res->roomType?->name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-700">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}
                                </p>
                            </td>
                            <td class="px-4 py-3">
                                @if ($res->status === 'Cancelled')
                                    <span class="text-xs text-red-400 line-through">
                                        Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-xs font-semibold text-green-700">
                                        Rp {{ number_format($res->total_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($res->status === 'Checked Out')
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Cancelled
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-400">No reservation history
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <p id="no-result-riwayat" class="hidden px-6 py-10 text-center text-gray-400 text-sm">
                No history matches your search.
            </p>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Income is only calculated from reservations with status <strong>Checked
                Out</strong>.</p>
    </div>

    {{-- MODAL: ADD RESERVATION --}}
    {{-- MODAL: ADD RESERVATION --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40" role="dialog"
        aria-modal="true" aria-labelledby="modal-tambah-title">
        <div
            class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h3 id="modal-tambah-title" class="text-base font-semibold text-gray-800">Add Reservation</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Initial status will be set to Pending Payment</p>
                </div>
                <button onclick="closeModalTambah()" aria-label="Close modal"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label for="f-name" class="block text-xs font-medium text-gray-500 mb-1">Full Name <span
                            class="text-red-500">*</span></label>
                    <input id="f-name" type="text" placeholder="Enter guest name"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="f-email" class="block text-xs font-medium text-gray-500 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input id="f-email" type="email" placeholder="email@example.com"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="f-room-type" class="block text-xs font-medium text-gray-500 mb-1">Room Type <span
                                class="text-red-500">*</span></label>
                        <select id="f-room-type" onchange="filterOffer()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select Type --</option>
                            @foreach ($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="f-offer" class="block text-xs font-medium text-gray-500 mb-1">Offer / Package <span
                                class="text-red-500">*</span></label>
                        <select id="f-offer" onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Select Offer --</option>
                            @foreach ($offers as $offer)
                                <option value="{{ $offer->id }}" data-price="{{ $offer->price }}"
                                    data-room-type-id="{{ $offer->room_type_id }}">
                                    {{ $offer->name }} — Rp {{ number_format($offer->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="f-checkin" class="block text-xs font-medium text-gray-500 mb-1">Check In <span
                                class="text-red-500">*</span></label>
                        <input id="f-checkin" type="date" min="{{ now()->format('Y-m-d') }}"
                            onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="f-checkout" class="block text-xs font-medium text-gray-500 mb-1">Check Out <span
                                class="text-red-500">*</span></label>
                        <input id="f-checkout" type="date" min="{{ now()->addDay()->format('Y-m-d') }}"
                            onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <p id="f-nights-info" class="text-xs text-gray-500"></p>
                <div class="bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-yellow-700">⏳ Initial status: <strong>Pending Payment</strong></p>
                    <p class="text-xs text-yellow-600 mt-1">Room number will be assigned later when the reservation is
                        confirmed.</p>
                </div>
            </div>
            <div class="px-5 pb-5 flex gap-2">
                <button onclick="closeModalTambah()"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button id="btn-save-tambah" onclick="saveReservation()"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Save Reservation
                </button>
            </div>
        </div>
    </div>

    {{-- MODAL: EDIT RESERVATION --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40" role="dialog"
        aria-modal="true" aria-labelledby="edit-modal-title">
        <div
            class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-5 border-b border-gray-100">
                <div>
                    <h3 id="edit-modal-title" class="text-base font-semibold text-gray-800">Edit Reservation</h3>
                    <p class="text-xs text-gray-400 mt-0.5" id="edit-modal-sub"></p>
                </div>
                <button onclick="closeEditModal()" aria-label="Close modal"
                    class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Guest Name</label>
                    <input id="e-name" type="text" disabled
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                    <input id="e-email" type="text" disabled
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Room</label>
                        <input id="e-room" type="text" disabled
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                        <input id="e-type" type="text" disabled
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>
                </div>

                {{-- ROOM NUMBER SELECTOR --}}
                {{-- ROOM NUMBER SELECTOR --}}
                <div id="e-room-number-wrapper" class="hidden">
                    <label class="block text-xs font-medium text-gray-500 mb-1">
                        Room Number
                        <span
                            class="ml-1 text-blue-600 text-[10px] font-semibold bg-blue-50 px-1.5 py-0.5 rounded-full">change
                            room</span>
                    </label>
                    <select id="e-room-number"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed">
                        <option value="">-- Loading available rooms... --</option>
                    </select>
                    <p class="text-[10px] text-gray-400 mt-1">Showing rooms available for the dates of this reservation</p>
                </div>

                <div>
                    <label for="e-status" class="block text-xs font-medium text-gray-500 mb-1">Update Status</label>
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
                    <p class="text-xs font-semibold text-red-600">⚠️ This reservation will be cancelled</p>
                    <p class="text-xs text-red-500 mt-0.5">The record will be moved to the History tab.</p>
                </div>
                <div id="e-checkout-warning" class="hidden bg-green-50 border border-green-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-semibold text-green-600">✅ Reservation complete</p>
                    <p class="text-xs text-green-600 mt-0.5">The record will be moved to History and counted as income.</p>
                </div>
            </div>
            <div class="px-5 pb-5 flex gap-2">
                <button onclick="closeEditModal()"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button id="btn-save-edit" onclick="saveEdit()"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Save Changes
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentEditId = null;
        let currentEditData = null;

        // ── TAB SWITCH ──────────────────────────────────────────────────────────
        function switchTab(tab) {
            const isAktif = tab === 'aktif';

            document.getElementById('panel-aktif').classList.toggle('hidden', !isAktif);
            document.getElementById('panel-riwayat').classList.toggle('hidden', isAktif);
            document.getElementById('filter-aktif').classList.toggle('hidden', !isAktif);

            const activeClass = 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition';
            const inactiveClass =
                'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';

            document.getElementById('tab-aktif').className = isAktif ? activeClass : inactiveClass;
            document.getElementById('tab-riwayat').className = isAktif ? inactiveClass : activeClass;
        }

        // ── SEARCH & FILTER (Active tab) ────────────────────────────────────────
        function filterTable() {
            const keyword = document.getElementById('search-aktif').value.trim().toLowerCase();
            const status = document.getElementById('filter-status').value;
            const rows = document.querySelectorAll('#table-body-aktif tr[data-search]');
            let visibleCount = 0;

            rows.forEach(row => {
                const matchKeyword = !keyword || row.dataset.search.includes(keyword);
                const matchStatus = !status || row.dataset.status === status;
                const show = matchKeyword && matchStatus;
                row.classList.toggle('hidden', !show);
                if (show) visibleCount++;
            });

            document.getElementById('no-result-aktif').classList.toggle('hidden', visibleCount > 0 || rows.length === 0);
        }

        // ── SEARCH (History tab) ─────────────────────────────────────────────────
        function filterHistoryTable() {
            const keyword = document.getElementById('search-riwayat').value.trim().toLowerCase();
            const rows = document.querySelectorAll('#table-body-riwayat tr[data-search]');
            let visibleCount = 0;

            rows.forEach(row => {
                const show = !keyword || row.dataset.search.includes(keyword);
                row.classList.toggle('hidden', !show);
                if (show) visibleCount++;
            });

            document.getElementById('no-result-riwayat').classList.toggle('hidden', visibleCount > 0 || rows.length === 0);
        }

        // ── FILTER OFFER BY ROOM TYPE ────────────────────────────────────────────
        function filterOffer() {
            const roomTypeId = document.getElementById('f-room-type').value;
            const offerSelect = document.getElementById('f-offer');
            const options = offerSelect.querySelectorAll('option');

            options.forEach(opt => {
                if (opt.value === '') return; // skip placeholder
                opt.hidden = opt.dataset.roomTypeId !== roomTypeId;
            });

            // Reset pilihan offer & estimasi
            offerSelect.value = '';
            hitungEstimasi();
        }

        // ── NIGHT COUNT + ESTIMATED PRICE ────────────────────────────────────────
        function hitungEstimasi() {
            const checkin = document.getElementById('f-checkin').value;
            const checkout = document.getElementById('f-checkout').value;
            const offerSelect = document.getElementById('f-offer');
            const info = document.getElementById('f-nights-info');

            if (!checkin || !checkout) {
                info.textContent = '';
                return;
            }

            const nights = Math.round((new Date(checkout) - new Date(checkin)) / (1000 * 60 * 60 * 24));

            if (nights <= 0) {
                info.textContent = 'Check-out must be after check-in.';
                info.className = 'text-xs text-red-500';
                return;
            }

            let text = `${nights} night${nights > 1 ? 's' : ''}`;

            const selected = offerSelect.options[offerSelect.selectedIndex];
            const price = selected ? Number(selected.dataset.price || 0) : 0;

            if (price > 0) {
                text += ` · Estimated Total: Rp ${(price * nights).toLocaleString('id-ID')}`;
            }

            info.textContent = text;
            info.className = 'text-xs text-gray-500';
        }

        // ── MODAL: ADD ───────────────────────────────────────────────────────────
        function openModalTambah() {
            document.getElementById('modal-tambah').classList.remove('hidden');
            document.getElementById('f-name').focus();
        }

        function closeModalTambah() {
            document.getElementById('modal-tambah').classList.add('hidden');
            resetTambahForm();
        }

        function resetTambahForm() {
            ['f-name', 'f-email', 'f-checkin', 'f-checkout'].forEach(id => {
                document.getElementById(id).value = '';
            });
            document.getElementById('f-room-type').value = '';
            document.getElementById('f-offer').value = '';
            document.getElementById('f-nights-info').textContent = '';

            // Reset semua offer agar tidak ada yang tersembunyi
            document.querySelectorAll('#f-offer option').forEach(opt => {
                opt.hidden = false;
            });

            const btn = document.getElementById('btn-save-tambah');
            btn.disabled = false;
            btn.textContent = 'Save Reservation';
        }

        // ── MODAL: EDIT ──────────────────────────────────────────────────────────
        function openEdit(id) {
            const row = document.getElementById('row-' + id);
            if (!row) return;

            currentEditId = id;

            currentEditData = {
                checkin: row.dataset.checkin,
                checkout: row.dataset.checkout,
                roomId: row.dataset.roomId,
                roomTypeId: row.dataset.roomTypeId,
            };

            document.getElementById('edit-modal-title').textContent = 'Edit Reservation #' + String(id).padStart(3, '0');
            document.getElementById('edit-modal-sub').textContent = row.dataset.name + ' · ' + row.dataset.email;
            document.getElementById('e-name').value = row.dataset.name;
            document.getElementById('e-email').value = row.dataset.email;
            document.getElementById('e-room').value = row.dataset.room || '—';
            document.getElementById('e-type').value = row.dataset.type || '—';
            document.getElementById('e-status').value = row.dataset.status;

            onStatusChange();

            document.getElementById('modal-edit').classList.remove('hidden');
        }

        function loadAvailableRooms(reservationId, checkin, checkout, currentRoomId, roomTypeId) {
            const select = document.getElementById('e-room-number');
            select.innerHTML = '<option value="">Loading available rooms...</option>';
            select.disabled = true;

            const params = new URLSearchParams({
                checkin: checkin,
                checkout: checkout,
                exclude_reservation: reservationId,
                type: roomTypeId ?? '',
            });

            fetch(`/admin/reservations/available-rooms?${params}`)
                .then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json();
                })
                .then(data => {
                    select.innerHTML = '<option value="">-- Select room number --</option>';

                    if (data.rooms && data.rooms.length > 0) {
                        data.rooms.forEach(room => {
                            const opt = document.createElement('option');
                            opt.value = room.id;
                            opt.textContent = room.room_name;
                            if (String(room.id) === String(currentRoomId)) opt.selected = true;
                            select.appendChild(opt);
                        });
                    } else {
                        select.innerHTML = '<option value="">No rooms available for these dates</option>';
                    }
                })
                .catch(() => {
                    select.innerHTML = '<option value="">Failed to load rooms</option>';
                })
                .finally(() => {
                    select.disabled = false;
                });
        }

        function closeEditModal() {
            document.getElementById('modal-edit').classList.add('hidden');
            document.getElementById('e-cancel-warning').classList.add('hidden');
            document.getElementById('e-checkout-warning').classList.add('hidden');
            document.getElementById('e-room-number-wrapper').classList.add('hidden');

            const btn = document.getElementById('btn-save-edit');
            btn.disabled = false;
            btn.textContent = 'Save Changes';

            currentEditId = null;
            currentEditData = null;
        }

        function onStatusChange() {
            const status = document.getElementById('e-status').value;
            document.getElementById('e-cancel-warning').classList.toggle('hidden', status !== 'Cancelled');
            document.getElementById('e-checkout-warning').classList.toggle('hidden', status !== 'Checked Out');

            const wrapper = document.getElementById('e-room-number-wrapper');
            const showRoomSelector = status === 'Checked In';
            wrapper.classList.toggle('hidden', !showRoomSelector);

            if (showRoomSelector && currentEditData) {
                loadAvailableRooms(
                    currentEditId,
                    currentEditData.checkin,
                    currentEditData.checkout,
                    currentEditData.roomId,
                    currentEditData.roomTypeId
                );
            }
        }

        function saveEdit() {
            const id = currentEditId;
            const status = document.getElementById('e-status').value;
            const roomId = document.getElementById('e-room-number').value || null;
            const btn = document.getElementById('btn-save-edit');

            if (!status) {
                alert('Please select a status.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Saving...';

            fetch(`/admin/reservations/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        status,
                        room_id: roomId
                    }),
                })
                .then(res => res.json().then(data => ({
                    ok: res.ok,
                    data
                })))
                .then(({
                    ok,
                    data
                }) => {
                    if (ok && data.success) {
                        closeEditModal();
                        location.reload();
                    } else {
                        alert(data.message || 'Update failed');
                        btn.disabled = false;
                        btn.textContent = 'Save Changes';
                    }
                })
                .catch(() => {
                    alert('Server error');
                    btn.disabled = false;
                    btn.textContent = 'Save Changes';
                });
        }

        // ── DELETE ───────────────────────────────────────────────────────────────
        function deleteReservation(id) {
            if (!confirm('Are you sure you want to permanently delete this reservation?')) return;

            fetch(`/admin/reservations/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'DELETE',
                    },
                })
                .then(res => {
                    if (!res.ok) throw new Error('Server error');
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to delete reservation.');
                    }
                })
                .catch(() => alert('A server error occurred. Please try again.'));
        }

        // ── SAVE: ADD RESERVATION ────────────────────────────────────────────────
        async function saveReservation() {
            const name = document.getElementById('f-name').value.trim();
            const email = document.getElementById('f-email').value.trim();
            const room_type_id = document.getElementById('f-room-type').value;
            const offer_id = document.getElementById('f-offer').value;
            const checkin = document.getElementById('f-checkin').value;
            const checkout = document.getElementById('f-checkout').value;
            const btn = document.getElementById('btn-save-tambah');

            if (!name || !email || !room_type_id || !offer_id || !checkin || !checkout) {
                alert('Please fill in all required fields.');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }

            if (new Date(checkout) <= new Date(checkin)) {
                alert('Check-out date must be after check-in date.');
                return;
            }

            btn.disabled = true;
            btn.textContent = 'Saving...';

            try {
                const response = await fetch('/admin/reservations', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        name,
                        email,
                        room_type_id,
                        offer_id,
                        check_in: checkin,
                        check_out: checkout,
                    }),
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    closeModalTambah();
                    location.reload();
                } else {
                    alert(result.message || 'Failed to save reservation.');
                    btn.disabled = false;
                    btn.textContent = 'Save Reservation';
                }
            } catch (error) {
                console.error(error);
                alert('A server error occurred. Please try again.');
                btn.disabled = false;
                btn.textContent = 'Save Reservation';
            }
        }

        // ── CLOSE MODALS ON BACKDROP CLICK ──────────────────────────────────────
        document.getElementById('modal-tambah').addEventListener('click', function(e) {
            if (e.target === this) closeModalTambah();
        });

        document.getElementById('modal-edit').addEventListener('click', function(e) {
            if (e.target === this) closeEditModal();
        });

        // ── CLOSE MODALS ON ESC KEY ──────────────────────────────────────────────
        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape') return;
            if (!document.getElementById('modal-tambah').classList.contains('hidden')) closeModalTambah();
            if (!document.getElementById('modal-edit').classList.contains('hidden')) closeEditModal();
        });
    </script>
@endsection
