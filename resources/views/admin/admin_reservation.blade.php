@extends('Layouts.layout')

@section('styles')
    @vite(['resources/css/pages/reservation.css'])
@endsection

@section('content')

{{-- ═══ FLASH MESSAGES ═══ --}}
@if (session('success'))
    <div id="flash-success"
         class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-5">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-success').remove()"
                class="ml-auto text-green-400 hover:text-green-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
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
                </button>
            </li>
            <li>
                <button onclick="switchTab('riwayat')" id="tab-riwayat"
                    class="tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition">
                    History
                </button>
            </li>
        </ul>
    </div>

    {{-- SEARCH & FILTER (Active tab) --}}
    <div id="filter-aktif" class="flex flex-col sm:flex-row gap-2 mb-4">
        <div class="relative flex-1">
            <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
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
                            data-room-count="{{ $res->room_count ?? 1 }}"
                            data-room-types-list="{{ $res->room_types_list ?? '' }}"
                            data-group-members='{{ htmlspecialchars($res->group_members ?? '[]', ENT_QUOTES, 'UTF-8') }}'
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
                                @if (($res->room_count ?? 1) > 1)
                                    <details class="text-left">
                                        <summary class="cursor-pointer text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-block">
                                            {{ $res->room_count }} Rooms ▾
                                        </summary>
                                        <div class="mt-1 space-y-1">
                                            @foreach (explode(', ', $res->room_types_list) as $rt)
                                                <p class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">{{ trim($rt) }}</p>
                                            @endforeach
                                        </div>
                                    </details>
                                @else
                                    <p class="text-xs font-semibold text-gray-800">{{ $res->room_name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ $res->roomType?->name }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center text-gray-700">
                                {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-4 text-center text-gray-700">
                                <p>{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}</p>
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

        <div class="mb-4">
            <div class="relative">
                <svg class="w-4 h-4 text-gray-300 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
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
                            <td class="px-4 py-3 text-gray-400 text-xs">{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</td>
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
                                @if (($res->room_count ?? 1) > 1)
                                    <details class="text-left">
                                        <summary class="cursor-pointer text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full inline-block">
                                            {{ $res->room_count }} Rooms ▾
                                        </summary>
                                        <div class="mt-1 space-y-1">
                                            @foreach (explode(', ', $res->room_types_list) as $rt)
                                                <p class="text-xs text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">{{ trim($rt) }}</p>
                                            @endforeach
                                        </div>
                                    </details>
                                @else
                                    <p class="text-xs font-semibold text-gray-800">{{ $res->room_name ?? '—' }}</p>
                                    <p class="text-xs text-gray-400">{{ $res->roomType?->name ?? 'N/A' }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                {{ \Carbon\Carbon::parse($res->check_in)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                <p class="text-gray-700">{{ \Carbon\Carbon::parse($res->check_out)->format('d M Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $nights }} night{{ $nights > 1 ? 's' : '' }}</p>
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
            <p id="no-result-riwayat" class="hidden px-6 py-10 text-center text-gray-400 text-sm">
                No history matches your search.
            </p>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Income is only calculated from reservations with status <strong>Checked Out</strong>.</p>
    </div>

    {{-- MODAL: ADD RESERVATION --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40" role="dialog"
        aria-modal="true" aria-labelledby="modal-tambah-title">
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-lg max-h-[90vh] overflow-y-auto">
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

                {{-- GUEST INFO --}}
                <div>
                    <label for="f-name" class="block text-xs font-medium text-gray-500 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input id="f-name" type="text" placeholder="Enter guest name"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="f-email" class="block text-xs font-medium text-gray-500 mb-1">Email <span class="text-red-500">*</span></label>
                    <input id="f-email" type="email" placeholder="email@example.com"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- DATES --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="f-checkin" class="block text-xs font-medium text-gray-500 mb-1">Check In <span class="text-red-500">*</span></label>
                        <input id="f-checkin" type="date" min="{{ now()->format('Y-m-d') }}"
                            onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="f-checkout" class="block text-xs font-medium text-gray-500 mb-1">Check Out <span class="text-red-500">*</span></label>
                        <input id="f-checkout" type="date" min="{{ now()->addDay()->format('Y-m-d') }}"
                            onchange="hitungEstimasi()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <p id="f-nights-info" class="text-xs text-gray-500"></p>

                {{-- JUMLAH KAMAR --}}
                <div>
                    <label for="f-room-count" class="block text-xs font-medium text-gray-500 mb-1">Number of Rooms <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-3">
                        <input id="f-room-count" type="number" min="1" max="10" value="1"
                            class="w-24 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" onclick="generateRoomForms()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                            Apply
                        </button>
                    </div>
                </div>

                {{-- ROOM FORMS (diisi JS) --}}
                <div id="f-room-forms" class="space-y-3"></div>

                {{-- ESTIMASI TOTAL --}}
                <div id="f-estimasi-wrapper" class="hidden bg-blue-50 border border-blue-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-semibold text-blue-700">💰 Estimated Total: <span id="f-estimasi-total">Rp 0</span></p>
                    <p class="text-xs text-blue-500 mt-0.5" id="f-estimasi-detail"></p>
                </div>

                <div class="bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2.5">
                    <p class="text-xs font-medium text-yellow-700">⏳ Initial status: <strong>Pending Payment</strong></p>
                    <p class="text-xs text-yellow-600 mt-1">Room number will be assigned later when the reservation is confirmed.</p>
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
        <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100 w-full max-w-md max-h-[90vh] overflow-y-auto">
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

                <div id="e-room-info-single" class="grid grid-cols-2 gap-3">
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

                <div id="e-room-info-multi" class="hidden">
                    <label class="block text-xs font-medium text-gray-500 mb-2">Rooms Booked</label>
                    <div id="e-room-multi-list" class="space-y-1.5"></div>
                </div>

                <div id="e-room-number-wrapper" class="hidden">
                    <div class="flex items-center gap-2 mb-2">
                        <label class="block text-xs font-medium text-gray-500">Assign Room Number(s)</label>
                        <span class="text-blue-600 text-[10px] font-semibold bg-blue-50 px-1.5 py-0.5 rounded-full">check in</span>
                    </div>
                    <div id="e-room-selectors" class="space-y-2"></div>
                    <p class="text-[10px] text-gray-400 mt-1.5">Showing rooms available for the reservation dates</p>
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
        // ── DATA FROM BLADE ──────────────────────────────────────────────────────
        const allOffers    = @json($offers);
        const allRoomTypes = @json($roomTypes);

        // ── STATE ────────────────────────────────────────────────────────────────
        let currentGroup    = [];
        let currentEditData = null;

        // ── TAB SWITCH ──────────────────────────────────────────────────────────
        function switchTab(tab) {
    const isAktif = tab === 'aktif';
    document.getElementById('panel-aktif').classList.toggle('hidden', !isAktif);
    document.getElementById('panel-riwayat').classList.toggle('hidden', isAktif);
    document.getElementById('filter-aktif').classList.toggle('hidden', !isAktif);

    const tabAktif   = document.getElementById('tab-aktif');
    const tabRiwayat = document.getElementById('tab-riwayat');

    tabAktif.style.borderBottom   = isAktif ? '2px solid #16a34a' : '2px solid transparent';
    tabAktif.style.color          = isAktif ? '#16a34a' : '#9ca3af';
    tabRiwayat.style.borderBottom = isAktif ? '2px solid transparent' : '2px solid #16a34a';
    tabRiwayat.style.color        = isAktif ? '#9ca3af' : '#16a34a';
}

        // ── SEARCH & FILTER ──────────────────────────────────────────────────────
        function filterTable() {
            const keyword = document.getElementById('search-aktif').value.trim().toLowerCase();
            const status  = document.getElementById('filter-status').value;
            const rows    = document.querySelectorAll('#table-body-aktif tr[data-search]');
            let visible   = 0;

            rows.forEach(row => {
                const ok = (!keyword || row.dataset.search.includes(keyword)) &&
                           (!status  || row.dataset.status === status);
                row.classList.toggle('hidden', !ok);
                if (ok) visible++;
            });

            document.getElementById('no-result-aktif').classList.toggle('hidden', visible > 0 || rows.length === 0);
        }

        function filterHistoryTable() {
            const keyword = document.getElementById('search-riwayat').value.trim().toLowerCase();
            const rows    = document.querySelectorAll('#table-body-riwayat tr[data-search]');
            let visible   = 0;

            rows.forEach(row => {
                const ok = !keyword || row.dataset.search.includes(keyword);
                row.classList.toggle('hidden', !ok);
                if (ok) visible++;
            });

            document.getElementById('no-result-riwayat').classList.toggle('hidden', visible > 0 || rows.length === 0);
        }

        // ── GENERATE ROOM FORMS ──────────────────────────────────────────────────
        function generateRoomForms() {
            const count     = parseInt(document.getElementById('f-room-count').value) || 1;
            const container = document.getElementById('f-room-forms');
            container.innerHTML = '';

            for (let i = 0; i < count; i++) {
                const roomTypeOptions = allRoomTypes.map(rt =>
                    `<option value="${rt.id}">${rt.name}</option>`
                ).join('');

                container.innerHTML += `
                    <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 space-y-3">
                        ${count > 1 ? `<p class="text-xs font-semibold text-blue-600">Room ${i + 1}</p>` : ''}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Room Type <span class="text-red-500">*</span></label>
                                <select data-index="${i}" class="f-room-type w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onchange="filterOfferByIndex(${i})">
                                    <option value="">-- Select Type --</option>
                                    ${roomTypeOptions}
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Offer / Package <span class="text-red-500">*</span></label>
                                <select data-index="${i}" class="f-offer w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    onchange="hitungEstimasi()">
                                    <option value="">-- Select Type First --</option>
                                </select>
                            </div>
                        </div>
                    </div>`;
            }

            hitungEstimasi();
        }

        // ── FILTER OFFER PER ROOM ────────────────────────────────────────────────
        function filterOfferByIndex(index) {
            const offerSelects = document.querySelectorAll('.f-offer');
            const typeSelects  = document.querySelectorAll('.f-room-type');
            const roomTypeId   = typeSelects[index].value;
            const offerSel     = offerSelects[index];

            const filtered = allOffers.filter(o => String(o.room_type_id) === String(roomTypeId));

            offerSel.innerHTML = filtered.length > 0
                ? `<option value="">-- Select Offer --</option>` +
                  filtered.map(o =>
                    `<option value="${o.id}" data-price="${o.price}">${o.name} — Rp ${Number(o.price).toLocaleString('id-ID')}</option>`
                  ).join('')
                : `<option value="">No offers available</option>`;

            hitungEstimasi();
        }

        // ── ESTIMATE ─────────────────────────────────────────────────────────────
        function hitungEstimasi() {
            const checkin  = document.getElementById('f-checkin').value;
            const checkout = document.getElementById('f-checkout').value;
            const info     = document.getElementById('f-nights-info');

            if (!checkin || !checkout) { info.textContent = ''; return; }

            const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
            if (nights <= 0) {
                info.textContent = 'Check-out must be after check-in.';
                info.className   = 'text-xs text-red-500';
                document.getElementById('f-estimasi-wrapper').classList.add('hidden');
                return;
            }

            info.textContent = `${nights} night${nights > 1 ? 's' : ''}`;
            info.className   = 'text-xs text-gray-500';

            const offerSelects = document.querySelectorAll('.f-offer');
            let total   = 0;
            let details = [];

            offerSelects.forEach((sel, i) => {
                const opt   = sel.options[sel.selectedIndex];
                const price = opt ? Number(opt.dataset.price || 0) : 0;
                if (price > 0) {
                    total += price * nights;
                    details.push(`Room ${i + 1}: Rp ${(price * nights).toLocaleString('id-ID')}`);
                }
            });

            const wrapper = document.getElementById('f-estimasi-wrapper');
            if (total > 0) {
                wrapper.classList.remove('hidden');
                document.getElementById('f-estimasi-total').textContent  = `Rp ${total.toLocaleString('id-ID')}`;
                document.getElementById('f-estimasi-detail').textContent = details.join(' · ');
            } else {
                wrapper.classList.add('hidden');
            }
        }

        // ── MODAL ADD ────────────────────────────────────────────────────────────
        function openModalTambah() {
            document.getElementById('modal-tambah').classList.remove('hidden');
            generateRoomForms();
            document.getElementById('f-name').focus();
        }

        function closeModalTambah() {
            document.getElementById('modal-tambah').classList.add('hidden');
            resetTambahForm();
        }

        function resetTambahForm() {
            ['f-name', 'f-email', 'f-checkin', 'f-checkout'].forEach(id => document.getElementById(id).value = '');
            document.getElementById('f-room-count').value = 1;
            document.getElementById('f-room-forms').innerHTML = '';
            document.getElementById('f-nights-info').textContent = '';
            document.getElementById('f-estimasi-wrapper').classList.add('hidden');
            const btn = document.getElementById('btn-save-tambah');
            btn.disabled    = false;
            btn.textContent = 'Save Reservation';
        }

        // ── MODAL EDIT: OPEN ─────────────────────────────────────────────────────
        function openEdit(id) {
            const row = document.getElementById('row-' + id);
            if (!row) return;

            const roomCount = parseInt(row.dataset.roomCount || '1');

            let groupMembers = [];
            try {
                const txt   = document.createElement('textarea');
                txt.innerHTML = row.dataset.groupMembers || '[]';
                groupMembers  = JSON.parse(txt.value);
            } catch(e) {
                groupMembers = [];
            }

            currentGroup = groupMembers.length > 0
                ? groupMembers.map(m => ({
                    id:         m.id,
                    roomId:     m.room_id,
                    roomTypeId: m.room_type_id,
                    roomName:   m.room_name || '—',
                    roomType:   m.room_type  || '—',
                }))
                : [{
                    id:         parseInt(row.dataset.id),
                    roomId:     row.dataset.roomId,
                    roomTypeId: row.dataset.roomTypeId,
                    roomName:   row.dataset.room || '—',
                    roomType:   row.dataset.type  || '—',
                }];

            currentEditData = {
                checkin:  row.dataset.checkin,
                checkout: row.dataset.checkout,
            };

            const idLabel = roomCount > 1
                ? `Reservation Group (${roomCount} rooms)`
                : `Reservation #${String(id).padStart(3, '0')}`;
            document.getElementById('edit-modal-title').textContent = 'Edit ' + idLabel;
            document.getElementById('edit-modal-sub').textContent   = row.dataset.name + ' · ' + row.dataset.email;

            document.getElementById('e-name').value  = row.dataset.name;
            document.getElementById('e-email').value = row.dataset.email;

            if (roomCount > 1) {
                document.getElementById('e-room-info-single').classList.add('hidden');
                document.getElementById('e-room-info-multi').classList.remove('hidden');

                const list = document.getElementById('e-room-multi-list');
                list.innerHTML = '';
                currentGroup.forEach((item, i) => {
                    list.innerHTML += `
                        <div class="flex items-center gap-2 bg-gray-50 rounded-lg px-3 py-2">
                            <span class="text-xs font-semibold text-gray-400 w-5">${i + 1}.</span>
                            <span class="text-xs font-semibold text-gray-800">${item.roomName}</span>
                            <span class="text-xs text-gray-400">${item.roomType}</span>
                        </div>`;
                });
            } else {
                document.getElementById('e-room-info-single').classList.remove('hidden');
                document.getElementById('e-room-info-multi').classList.add('hidden');
                document.getElementById('e-room').value = currentGroup[0]?.roomName || '—';
                document.getElementById('e-type').value = currentGroup[0]?.roomType  || '—';
            }

            document.getElementById('e-status').value = row.dataset.status;
            onStatusChange();
            document.getElementById('modal-edit').classList.remove('hidden');
        }

        // ── LOAD AVAILABLE ROOMS ─────────────────────────────────────────────────
        function fetchAvailableRooms(reservationId, checkin, checkout, roomTypeId) {
            const params = new URLSearchParams({
                checkin,
                checkout,
                exclude_reservation: reservationId,
                type: roomTypeId ?? '',
            });

            return fetch(`/admin/reservations/available-rooms?${params}`)
                .then(res => { if (!res.ok) throw new Error('Network error'); return res.json(); })
                .then(data => data.rooms || []);
        }

        // Simpan semua data rooms per index secara global agar bisa di-filter ulang
        let allRoomData = [];

        async function buildRoomSelectors() {
            const container = document.getElementById('e-room-selectors');
            container.innerHTML = '';
            allRoomData = [];

            const allRooms = await Promise.all(
                currentGroup.map(item =>
                    fetchAvailableRooms(item.id, currentEditData.checkin, currentEditData.checkout, item.roomTypeId)
                )
            );

            // Simpan data rooms per index
            currentGroup.forEach((item, i) => {
                allRoomData[i] = allRooms[i];
            });

            // Render semua selector
            currentGroup.forEach((item, i) => {
                const label    = currentGroup.length > 1
                    ? `Room ${i + 1} — <span class="font-normal text-gray-400">${item.roomType}</span>`
                    : 'Room Number';
                const selectId = `e-room-select-${i}`;

                container.innerHTML += `
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">${label}</label>
                        <select id="${selectId}" data-index="${i}"
                            onchange="onRoomSelectChange()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </select>
                    </div>`;
            });

            // Isi options awal
            refreshRoomOptions();
        }

        // Ambil semua nilai yang sedang dipilih di semua dropdown (kecuali index tertentu)
        function getSelectedRoomIds(excludeIndex = -1) {
            return currentGroup
                .map((_, i) => {
                    if (i === excludeIndex) return null;
                    const sel = document.getElementById(`e-room-select-${i}`);
                    return sel ? sel.value : null;
                })
                .filter(v => v && v !== '');
        }

        // Re-render options semua dropdown berdasarkan pilihan saat ini
        function refreshRoomOptions() {
            currentGroup.forEach((item, i) => {
                const sel      = document.getElementById(`e-room-select-${i}`);
                if (!sel) return;

                const selected    = sel.value; // simpan nilai sekarang
                const takenIds    = getSelectedRoomIds(i); // room yang dipakai dropdown lain
                const rooms       = allRoomData[i] || [];
                const available   = rooms.filter(r => !takenIds.includes(String(r.id)));

                let options = '<option value="">-- Select room --</option>';
                if (available.length > 0) {
                    available.forEach(room => {
                        const isSelected = String(room.id) === String(selected) ? 'selected' : '';
                        options += `<option value="${room.id}" ${isSelected}>${room.room_name}</option>`;
                    });
                } else {
                    options = '<option value="">No rooms available</option>';
                }

                sel.innerHTML = options;

                // Restore pilihan sebelumnya kalau masih tersedia
                if (selected && available.some(r => String(r.id) === String(selected))) {
                    sel.value = selected;
                }
            });
        }

        // Dipanggil tiap kali user ganti pilihan
        function onRoomSelectChange() {
            refreshRoomOptions();
        }

        // ── STATUS CHANGE ────────────────────────────────────────────────────────
        function onStatusChange() {
            const status = document.getElementById('e-status').value;

            document.getElementById('e-cancel-warning').classList.toggle('hidden',  status !== 'Cancelled');
            document.getElementById('e-checkout-warning').classList.toggle('hidden', status !== 'Checked Out');

            const wrapper = document.getElementById('e-room-number-wrapper');
            if (status === 'Checked In') {
                wrapper.classList.remove('hidden');
                buildRoomSelectors();
            } else {
                wrapper.classList.add('hidden');
                document.getElementById('e-room-selectors').innerHTML = '';
            }
        }

        // ── CLOSE EDIT ───────────────────────────────────────────────────────────
        function closeEditModal() {
            document.getElementById('modal-edit').classList.add('hidden');
            document.getElementById('e-cancel-warning').classList.add('hidden');
            document.getElementById('e-checkout-warning').classList.add('hidden');
            document.getElementById('e-room-number-wrapper').classList.add('hidden');
            document.getElementById('e-room-selectors').innerHTML = '';
            document.getElementById('e-room-info-multi').classList.add('hidden');
            document.getElementById('e-room-info-single').classList.remove('hidden');

            const btn = document.getElementById('btn-save-edit');
            btn.disabled    = false;
            btn.textContent = 'Save Changes';

            currentGroup    = [];
            currentEditData = null;
        }

        // ── SAVE EDIT ────────────────────────────────────────────────────────────
        function saveEdit() {
            const status = document.getElementById('e-status').value;
            const btn    = document.getElementById('btn-save-edit');

            if (!status) { alert('Please select a status.'); return; }

            const assignments = currentGroup.map((item, i) => {
                const sel    = document.getElementById(`e-room-select-${i}`);
                const roomId = sel ? (sel.value || null) : null;
                return { reservation_id: item.id, room_id: roomId };
            });

            btn.disabled    = true;
            btn.textContent = 'Saving...';

            const primaryId = currentGroup[0].id;
            fetch(`/admin/reservations/${primaryId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ status, assignments }),
            })
            .then(res => res.json().then(data => ({ ok: res.ok, data })))
            .then(({ ok, data }) => {
                if (ok && data.success) {
                    closeEditModal();
                    location.reload();
                } else {
                    alert(data.message || 'Update failed');
                    btn.disabled    = false;
                    btn.textContent = 'Save Changes';
                }
            })
            .catch(() => {
                alert('Server error');
                btn.disabled    = false;
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
            .then(res => { if (!res.ok) throw new Error('Server error'); return res.json(); })
            .then(data => {
                if (data.success) location.reload();
                else alert('Failed to delete reservation.');
            })
            .catch(() => alert('A server error occurred. Please try again.'));
        }

        // ── SAVE ADD ─────────────────────────────────────────────────────────────
        async function saveReservation() {
            const name     = document.getElementById('f-name').value.trim();
            const email    = document.getElementById('f-email').value.trim();
            const checkin  = document.getElementById('f-checkin').value;
            const checkout = document.getElementById('f-checkout').value;
            const btn      = document.getElementById('btn-save-tambah');

            if (!name || !email || !checkin || !checkout) {
                alert('Please fill in all required fields.'); return;
            }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Please enter a valid email address.'); return;
            }
            if (new Date(checkout) <= new Date(checkin)) {
                alert('Check-out date must be after check-in date.'); return;
            }

            const typeSelects  = document.querySelectorAll('.f-room-type');
            const offerSelects = document.querySelectorAll('.f-offer');
            const rooms        = [];

            for (let i = 0; i < typeSelects.length; i++) {
                const room_type_id = typeSelects[i].value;
                const offer_id     = offerSelects[i].value;
                if (!room_type_id || !offer_id) {
                    alert(`Please select room type and offer for Room ${i + 1}.`); return;
                }
                rooms.push({ room_type_id, offer_id });
            }

            btn.disabled    = true;
            btn.textContent = 'Saving...';

            try {
                const response = await fetch('/admin/reservations', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ name, email, check_in: checkin, check_out: checkout, rooms }),
                });
                const result = await response.json();
                if (response.ok && result.success) {
                    closeModalTambah();
                    location.reload();
                } else {
                    alert(result.message || 'Failed to save reservation.');
                    btn.disabled    = false;
                    btn.textContent = 'Save Reservation';
                }
            } catch {
                alert('A server error occurred. Please try again.');
                btn.disabled    = false;
                btn.textContent = 'Save Reservation';
            }
        }

        // ── CLOSE ON BACKDROP / ESC ──────────────────────────────────────────────
        document.getElementById('modal-tambah').addEventListener('click', e => { if (e.target === e.currentTarget) closeModalTambah(); });
        document.getElementById('modal-edit').addEventListener('click',   e => { if (e.target === e.currentTarget) closeEditModal(); });
        document.addEventListener('keydown', e => {
            if (e.key !== 'Escape') return;
            if (!document.getElementById('modal-tambah').classList.contains('hidden')) closeModalTambah();
            if (!document.getElementById('modal-edit').classList.contains('hidden'))   closeEditModal();
        });
    </script>

<script>
setTimeout(() => {
    const s = document.getElementById('flash-success');
    if (s) s.remove();
}, 4000);
</script>
@endsection