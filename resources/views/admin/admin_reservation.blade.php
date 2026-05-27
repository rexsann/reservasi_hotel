@extends('Layouts.layout')

@section('content')
    @php
        $offers = collect([
            (object)['id'=>1,'name'=>'Room Only',         'tipe'=>'Standard','lantai'=>1,'harga'=>300000,'benefits'=>['Free WiFi','Air minum gratis','Parkir gratis']],
            (object)['id'=>2,'name'=>'Breakfast Package', 'tipe'=>'Standard','lantai'=>1,'harga'=>350000,'benefits'=>['Sarapan pagi','Free WiFi','Air minum gratis','Parkir gratis']],
            (object)['id'=>3,'name'=>'Staycation Deal',   'tipe'=>'Standard','lantai'=>1,'harga'=>400000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Late check-out (hingga 14.00)','Diskon restoran 10%']],
            (object)['id'=>4,'name'=>'Business Stay',     'tipe'=>'Superior','lantai'=>2,'harga'=>500000,'benefits'=>['Sarapan pagi','Free WiFi','Parkir gratis','Early check-in (dari 11.00)','Air minum gratis']],
            (object)['id'=>5,'name'=>'Family Package',    'tipe'=>'Superior','lantai'=>2,'harga'=>600000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Parkir gratis','Laundry 2 potong/hari']],
            (object)['id'=>6,'name'=>'Weekend Deal',      'tipe'=>'Superior','lantai'=>2,'harga'=>650000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Late check-out (hingga 14.00)','Early check-in (dari 11.00)','Diskon restoran 10%']],
            (object)['id'=>7,'name'=>'Luxury Stay',       'tipe'=>'Deluxe','lantai'=>3,'harga'=>750000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Laundry 2 potong/hari','Late check-out (hingga 14.00)','Diskon restoran 10%']],
            (object)['id'=>8,'name'=>'Honeymoon Package', 'tipe'=>'Deluxe','lantai'=>3,'harga'=>900000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Late check-out (hingga 14.00)','Early check-in (dari 11.00)','Laundry 2 potong/hari','Antar-jemput bandara']],
            (object)['id'=>9,'name'=>'VIP Experience',    'tipe'=>'Deluxe','lantai'=>3,'harga'=>1100000,'benefits'=>['Sarapan pagi','Free WiFi','Akses kolam renang','Late check-out (hingga 14.00)','Early check-in (dari 11.00)','Laundry 2 potong/hari','Antar-jemput bandara','Diskon restoran 10%']],
        ]);

        $reservations = collect([
            (object)[
                'id' => 1,
                'user' => (object)['name'=>'Moonlight','email'=>'moon@gmail.com'],
                'items' => [
                    (object)['offer'=>(object)['id'=>2,'name'=>'Breakfast Package','harga'=>350000],'room'=>(object)['nomor_kamar'=>'106','lantai'=>1,'tipe'=>'Standard']],
                ],
                'check_in' => '2026-04-20',
                'check_out' => '2026-04-22',
                'status' => 'check_in',
                'kode' => 'RSV-260420-001',
            ],
            (object)[
                'id' => 2,
                'user' => (object)['name'=>'Sunshine','email'=>'shine@gmail.com'],
                'items' => [
                    (object)['offer'=>(object)['id'=>5,'name'=>'Family Package','harga'=>600000],'room'=>(object)['nomor_kamar'=>'107','lantai'=>2,'tipe'=>'Superior']],
                    (object)['offer'=>(object)['id'=>1,'name'=>'Room Only','harga'=>300000],'room'=>(object)['nomor_kamar'=>'101','lantai'=>1,'tipe'=>'Standard']],
                ],
                'check_in' => '2026-04-25',
                'check_out' => '2026-04-27',
                'status' => 'pending',
                'kode' => null,
            ],
            (object)[
                'id' => 3,
                'user' => (object)['name'=>'Facha','email'=>'chacha@gmail.com'],
                'items' => [
                    (object)['offer'=>(object)['id'=>9,'name'=>'VIP Experience','harga'=>1100000],'room'=>(object)['nomor_kamar'=>'109','lantai'=>3,'tipe'=>'Deluxe']],
                ],
                'check_in' => '2026-04-28',
                'check_out' => '2026-05-01',
                'status' => 'canceled',
                'kode' => null,
            ],
            (object)[
                'id' => 4,
                'user' => (object)['name'=>'Allysum','email'=>'ally@gmail.com'],
                'items' => [
                    (object)['offer'=>(object)['id'=>3,'name'=>'Staycation Deal','harga'=>400000],'room'=>(object)['nomor_kamar'=>'103','lantai'=>1,'tipe'=>'Standard']],
                ],
                'check_in' => '2026-03-10',
                'check_out' => '2026-03-13',
                'status' => 'checked_out',
                'kode' => 'RSV-260310-004',
            ],
            (object)[
                'id' => 5,
                'user' => (object)['name'=>'Baobao','email'=>'baobao@gmail.com'],
                'items' => [
                    (object)['offer'=>(object)['id'=>4,'name'=>'Business Stay','harga'=>500000],'room'=>(object)['nomor_kamar'=>'102','lantai'=>2,'tipe'=>'Superior']],
                    (object)['offer'=>(object)['id'=>7,'name'=>'Luxury Stay','harga'=>750000],'room'=>(object)['nomor_kamar'=>'101','lantai'=>3,'tipe'=>'Deluxe']],
                ],
                'check_in' => '2026-03-15',
                'check_out' => '2026-03-17',
                'status' => 'checked_out',
                'kode' => 'RSV-260315-005',
            ],
        ]);

        $aktif   = $reservations->whereIn('status', ['pending','check_in']);
        $riwayat = $reservations->whereIn('status', ['checked_out','canceled']);

        $income = $riwayat->where('status','checked_out')->sum(function($r) {
            $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
            return $nights * collect($r->items)->sum(fn($i) => $i->offer->harga);
        });
        $lost = $riwayat->where('status','canceled')->sum(function($r) {
            $nights = \Carbon\Carbon::parse($r->check_in)->diffInDays($r->check_out);
            return $nights * collect($r->items)->sum(fn($i) => $i->offer->harga);
        });
    @endphp

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Reservations Management</h2>
            <p class="text-sm text-gray-400">manage your hotel reservations</p>
        </div>
        <button data-modal-target="modal-tambah" data-modal-toggle="modal-tambah"
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
                <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Check In
            </p>
            <p class="text-2xl font-semibold text-green-600">{{ $aktif->where('status','check_in')->count() }}</p>
        </div>
        <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
                <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Pending
            </p>
            <p class="text-2xl font-semibold text-yellow-500">{{ $aktif->where('status','pending')->count() }}</p>
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
                        <th class="px-4 py-3 text-center w-10"></th>
                        <th class="px-4 py-3 text-center">ID</th>
                        <th class="px-4 py-3 text-center">Code</th>
                        <th class="px-6 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-center">Room</th>
                        <th class="px-4 py-3 text-center">Check In</th>
                        <th class="px-4 py-3 text-center">Check Out</th>
                        <th class="px-4 py-3 text-center">Total/Night</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="aktif-table-body" class="divide-y divide-gray-100">
                    @forelse($aktif as $res)
                        @php
                            $items         = collect($res->items);
                            $totalPerMalam = $items->sum(fn($i) => $i->offer->harga);
                            $allAssigned   = $items->every(fn($i) => $i->room->nomor_kamar !== null);
                            $rowId         = 'row-' . $res->id;
                            $detailId      = 'detail-' . $res->id;
                            $kode          = $res->kode ?? null;

                            $itemsJson = $items->map(fn($i) => [
                                'name'        => $i->offer->name,
                                'tipe'        => $i->room->tipe,
                                'harga'       => $i->offer->harga,
                                'nomor_kamar' => $i->room->nomor_kamar,
                            ])->values()->toArray();
                        @endphp

                        <tr class="hover:bg-gray-50 transition" id="{{ $rowId }}"
                            data-status="{{ $res->status }}"
                            data-kode="{{ $kode }}"
                            data-name="{{ $res->user->name }}"
                            data-email="{{ $res->user->email }}"
                            data-checkin="{{ $res->check_in }}"
                            data-checkout="{{ $res->check_out }}"
                            data-items="{{ json_encode($itemsJson) }}"
                            data-total="{{ $totalPerMalam }}"
                            data-id="{{ $res->id }}">

                            {{-- EXPAND --}}
                            <td class="px-4 py-4 text-center">
                                @if($items->count() > 1)
                                    <button onclick="toggleDetail('{{ $detailId }}', this)"
                                        class="text-gray-400 hover:text-blue-600 transition expand-btn">
                                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-xs text-gray-200">—</span>
                                @endif
                            </td>

                            {{-- ID --}}
                            <td class="px-4 py-4 text-center text-xs text-gray-400 whitespace-nowrap">
                                {{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}
                            </td>

                            {{-- KODE — kosong saat pending, muncul saat check_in --}}
                            <td class="px-4 py-4 text-center whitespace-nowrap" id="kode-{{ $res->id }}">
                                @if($kode)
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ $kode }}</span>
                                @else
                                    <span class="text-xs text-gray-300 italic">—</span>
                                @endif
                            </td>

                            {{-- CUSTOMER --}}
                            <td class="px-6 py-4 max-w-[180px]">
                                <p class="font-semibold text-gray-800 truncate">{{ $res->user->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $res->user->email }}</p>
                            </td>

                            {{-- KAMAR --}}
                            <td class="px-4 py-4 text-center" id="kamar-{{ $res->id }}">
                                @if($items->count() > 1)
                                    <span class="text-xs font-semibold bg-purple-50 text-purple-700 px-2 py-1 rounded-lg">
                                        {{ $items->count() }} Rooms
                                    </span>
                                    @if(!$allAssigned)
                                        <p class="text-xs text-orange-500 mt-0.5">Some not assigned</p>
                                    @endif
                                @else
                                    @php $singleRoom = $items->first()->room @endphp
                                    @if($singleRoom->nomor_kamar)
                                        <span class="text-xs font-semibold bg-gray-100 px-2 py-1 rounded-lg">{{ $singleRoom->nomor_kamar }}</span>
                                    @else
                                        <span class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">Not assigned</span>
                                    @endif
                                @endif
                            </td>

                            {{-- CHECKIN DATE --}}
                            <td class="px-4 py-4 text-center text-gray-700 whitespace-nowrap">{{ $res->check_in }}</td>

                            {{-- CHECKOUT DATE --}}
                            <td class="px-4 py-4 text-center text-gray-700 whitespace-nowrap">{{ $res->check_out }}</td>

                            {{-- TOTAL --}}
                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($totalPerMalam, 0, ',', '.') }}</p>
                                @if($items->count() > 1)
                                    <p class="text-xs text-gray-400">{{ $items->count() }} offers</p>
                                @endif
                            </td>

                            {{-- STATUS BADGE --}}
                            <td class="px-4 py-4 text-center" id="status-badge-{{ $res->id }}">
                                @if($res->status === 'check_in')
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">Check In</span>
                                @else
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                @endif
                            </td>

                            {{-- ACTIONS — berbeda tergantung status --}}
                            <td class="px-6 py-4" id="actions-{{ $res->id }}">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    @if($res->status === 'pending')
                                        {{-- PENDING: hanya Edit (untuk check-in) + Cancel --}}
                                        <button
                                            onclick="openEdit({{ $res->id }})"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                                            Edit
                                        </button>
                                        <button
                                            onclick="cancelRow('{{ $rowId }}','{{ $detailId }}','{{ $res->id }}')"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                                            Cancel
                                        </button>
                                    @else
                                        {{-- CHECK IN: Invoice + Check Out + Cancel --}}
                                        <button
                                            onclick="showInvoice('{{ $kode }}','{{ $res->user->email }}','{{ $res->user->name }}')"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                                            Invoice
                                        </button>
                                        <button
                                            onclick="doCheckOut('{{ $rowId }}','{{ $detailId }}')"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition">
                                            Check Out
                                        </button>
                                        <button
                                            onclick="cancelRow('{{ $rowId }}','{{ $detailId }}','{{ $res->id }}')"
                                            class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                                            Cancel
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- DETAIL ROW multi-kamar --}}
                        @if($items->count() > 1)
                            <tr id="{{ $detailId }}" class="hidden bg-blue-50/40 border-b border-blue-100">
                                <td colspan="10" class="px-6 py-3">
                                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                                        Detail {{ $items->count() }} Kamar — Reservasi #{{ $res->id }}
                                    </p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        @foreach($items as $idx => $item)
                                            <div class="flex items-start gap-3 bg-white rounded-xl border border-gray-100 px-4 py-3 shadow-sm">
                                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-blue-100 text-blue-700 text-xs font-bold flex items-center justify-center mt-0.5">
                                                    {{ $idx + 1 }}
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center justify-between gap-2">
                                                        <p class="text-sm font-semibold text-gray-800">{{ $item->offer->name }}</p>
                                                        <p class="text-sm font-bold text-blue-600 whitespace-nowrap">
                                                            Rp {{ number_format($item->offer->harga, 0, ',', '.') }}/night
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        <span class="text-xs text-gray-500">{{ $item->room->tipe }}</span>
                                                        <span class="text-gray-300">·</span>
                                                        @if($item->room->nomor_kamar)
                                                            <span class="text-xs font-semibold bg-gray-100 text-gray-700 px-2 py-0.5 rounded-lg">
                                                                Room {{ $item->room->nomor_kamar }}
                                                            </span>
                                                        @else
                                                            <span class="text-xs bg-orange-50 text-orange-600 px-2 py-0.5 rounded-lg">Not assigned</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @php
                                        $nights     = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                                        $grandTotal = $nights * $totalPerMalam;
                                    @endphp
                                    <div class="mt-2 flex items-center justify-end gap-2">
                                        <p class="text-xs text-gray-400">{{ $nights }} nights × Rp {{ number_format($totalPerMalam, 0, ',', '.') }}</p>
                                        <span class="text-gray-300">→</span>
                                        <p class="text-sm font-bold text-gray-800">Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endif

                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-10 text-center text-gray-400">No active reservations</td>
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
                    <span class="w-2 h-2 rounded-full bg-red-400 inline-block"></span> Potential Loss (Canceled)
                </p>
                <p class="text-xl font-semibold text-red-500">Rp {{ number_format($lost, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-800">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase w-8"></th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Customer</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Rooms</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Check In</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Check Out</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Total Pay</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="riwayat-table-body">
                    @forelse($riwayat as $res)
                        @php
                            $items         = collect($res->items);
                            $nights        = \Carbon\Carbon::parse($res->check_in)->diffInDays($res->check_out);
                            $totalPerMalam = $items->sum(fn($i) => $i->offer->harga);
                            $total         = $nights * $totalPerMalam;
                            $rHistId       = 'rhist-' . $res->id;
                        @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 text-center">
                                @if($items->count() > 1)
                                    <button onclick="toggleDetail('{{ $rHistId }}', this)" class="text-gray-400 hover:text-blue-600 transition expand-btn">
                                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </button>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-400 text-xs font-medium">#{{ $res->id }}</td>
                            <td class="px-4 py-3">
                                @if(!empty($res->kode))
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">{{ $res->kode }}</span>
                                @else
                                    <span class="text-xs text-gray-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-gray-800">{{ $res->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $res->user->email }}</p>
                            </td>
                            <td class="px-4 py-3">
                                @if($items->count() > 1)
                                    <span class="text-xs font-semibold bg-purple-50 text-purple-700 px-2 py-1 rounded-lg">{{ $items->count() }} Rooms</span>
                                @else
                                    <p class="text-gray-800 font-semibold text-xs">{{ $items->first()->offer->name }}</p>
                                    <p class="text-xs text-gray-400">Room {{ $items->first()->room->nomor_kamar }} · {{ $items->first()->room->tipe }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700 font-medium">{{ $res->check_in }}</td>
                            <td class="px-4 py-3">
                                <p class="text-gray-700 font-medium">{{ $res->check_out }}</p>
                                <p class="text-xs text-gray-400">{{ $nights }} nights</p>
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
                        @if($items->count() > 1)
                            <tr id="{{ $rHistId }}" class="hidden bg-gray-50">
                                <td colspan="9" class="px-6 py-3">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                        @foreach($items as $idx => $item)
                                            <div class="flex items-center gap-3 bg-white rounded-lg border border-gray-100 px-3 py-2">
                                                <span class="w-5 h-5 rounded-full bg-gray-100 text-gray-600 text-xs font-bold flex items-center justify-center flex-shrink-0">{{ $idx+1 }}</span>
                                                <div class="flex-1">
                                                    <p class="text-xs font-semibold text-gray-800">{{ $item->offer->name }}</p>
                                                    <p class="text-xs text-gray-400">
                                                        {{ $item->room->tipe }} · Room {{ $item->room->nomor_kamar ?? '—' }}
                                                        · Rp {{ number_format($item->offer->harga,0,',','.') }}/night
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-sm text-gray-400">No reservation history available</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="text-xs text-gray-400 mt-3">* Income only calculated from reservations with status <strong>Checked Out</strong>.</p>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         MODAL TAMBAH RESERVASI
    ══════════════════════════════════════════════════════════ --}}
    <div id="modal-tambah" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Add Reservation</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Status awal otomatis Pending</p>
                    </div>
                    <button type="button" data-modal-hide="modal-tambah"
                        class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-5 space-y-4 max-h-[80vh] overflow-y-auto">
                    <div class="pb-3 border-b border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Data Guest</p>
                        <div class="space-y-3">
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
                        </div>
                    </div>
                    <div class="pb-3 border-b border-gray-100">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Select Offer / Room</p>
                            <span id="f-offer-count" class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full hidden">0 selected</span>
                        </div>
                        <div id="f-offer-list" class="space-y-2">
                            @foreach($offers as $offer)
                                <label class="flex items-start gap-3 border border-gray-200 rounded-lg p-3 cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition offer-option"
                                    data-offer-id="{{ $offer->id }}"
                                    data-tipe="{{ $offer->tipe }}"
                                    data-lantai="{{ $offer->lantai }}"
                                    data-harga="{{ $offer->harga }}"
                                    data-name="{{ $offer->name }}">
                                    <input type="checkbox" name="f-offer[]" value="{{ $offer->id }}"
                                        class="mt-0.5 accent-blue-600 offer-checkbox" onchange="updateOfferCount(); hitungEstimasi()">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-semibold text-gray-800">{{ $offer->name }}</p>
                                            <p class="text-sm font-bold text-blue-600">
                                                Rp {{ number_format($offer->harga, 0, ',', '.') }}<span class="text-xs font-normal text-gray-400">/malam</span>
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $offer->tipe }} · Lantai {{ $offer->lantai }}</p>
                                        <div class="flex flex-wrap gap-1 mt-1.5">
                                            @foreach($offer->benefits as $b)
                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $b }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Tanggal Menginap</p>
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
                        <div id="f-estimasi" class="hidden mt-3 bg-blue-50 border border-blue-100 rounded-lg px-3 py-2.5 space-y-1">
                            <div id="f-estimasi-breakdown" class="space-y-0.5"></div>
                            <div class="border-t border-blue-200 pt-1.5 mt-1">
                                <p class="text-xs font-bold text-blue-700">Total: <span id="f-estimasi-total"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 border border-yellow-100 rounded-lg px-3 py-2.5">
                        <p class="text-xs font-medium text-yellow-700">⏳ Status awal: Pending</p>
                        <p class="text-xs text-yellow-600 mt-0.5">Nomor kamar & kode reservasi akan digenerate saat tamu Check In.</p>
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
    </div>

    {{-- ══════════════════════════════════════════════════════════
         MODAL EDIT / CHECK IN
         Hanya untuk: pending → check_in ATAU cancel
    ══════════════════════════════════════════════════════════ --}}
    <div id="modal-edit" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-2xl shadow-lg border border-gray-100">
                <div class="flex items-center justify-between p-5 border-b border-gray-100">
                    <div>
                        <h3 class="text-base font-semibold text-gray-800" id="edit-modal-title">Edit Reservation</h3>
                        <p class="text-xs text-gray-400 mt-0.5" id="edit-modal-sub"></p>
                    </div>
                    <button type="button" onclick="closeEditModal()"
                        class="text-gray-400 hover:bg-gray-100 rounded-lg p-1.5 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-5 space-y-4">

                    {{-- Info tamu (read only saat check-in) --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Full Name</label>
                        <input id="e-name" type="text"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                        <input id="e-email" type="email"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    {{-- Offer summary (readonly) --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Offer Summary</label>
                        <div id="e-items-display" class="space-y-1.5"></div>
                        <p class="text-xs text-gray-400 mt-1">Offer tidak bisa diubah setelah reservasi dibuat.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check In Date</label>
                            <input id="e-checkin" type="date"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Check Out Date</label>
                            <input id="e-checkout" type="date"
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    {{-- STATUS: hanya check_in & canceled --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Ubah Status</label>
                        <select id="e-status" onchange="onStatusChange()"
                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="pending">Pending (belum datang)</option>
                            <option value="check_in">Check In (tamu sudah datang)</option>
                            <option value="canceled">Canceled (batalkan reservasi)</option>
                        </select>
                    </div>

                    {{-- ⚠️ WARNING canceled --}}
                    <div id="e-cancel-warning" class="hidden bg-red-50 border border-red-100 rounded-lg px-3 py-2.5">
                        <p class="text-xs font-semibold text-red-600">⚠️ Reservasi akan dibatalkan</p>
                        <p class="text-xs text-red-500 mt-0.5">Tindakan ini akan memindahkan reservasi ke tab History.</p>
                    </div>

                    {{-- ASSIGN KAMAR — hanya muncul saat pilih check_in --}}
                    <div id="e-room-assign-wrap" class="hidden">
                        <div class="bg-blue-50 border border-blue-100 rounded-lg px-3 py-2 mb-3">
                            <p class="text-xs font-semibold text-blue-700">🏨 Assign nomor kamar untuk setiap offer</p>
                            <p class="text-xs text-blue-600 mt-0.5">Kode reservasi akan digenerate otomatis setelah disimpan.</p>
                        </div>
                        <div id="e-room-assign-list" class="space-y-2"></div>
                    </div>
                </div>

                <div class="px-5 pb-5 flex gap-2">
                    <button onclick="closeEditModal()"
                        class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-500 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button onclick="saveEdit()"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         MODAL INVOICE
    ══════════════════════════════════════════════════════════ --}}
    <div id="modal-invoice" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white w-full max-w-sm rounded-2xl shadow-lg p-6 space-y-4 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center mx-auto">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-base font-semibold text-gray-800">Kode Reservasi</h2>
                <p class="text-xs text-gray-400 mt-1">Berikan kode ini ke tamu untuk proses check-in</p>
            </div>
            <div class="bg-blue-50 border border-blue-100 rounded-xl py-4 px-6">
                <p id="inv-code" class="text-2xl font-bold text-blue-600 tracking-widest font-mono"></p>
            </div>
            <div id="inv-guest" class="text-xs text-gray-400"></div>
            <div class="flex gap-2 pt-2">
                <button onclick="sendInvoiceEmail()"
                    class="flex-1 text-sm py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                    Kirim ke Email
                </button>
                <button onclick="closeInvoice()"
                    class="flex-1 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    // ════════════════════════════════════════════════════════════
    // STATE
    // ════════════════════════════════════════════════════════════
    const availableRooms = {
        'Standard': ['101','103','105','106'],
        'Superior': ['201','202','204','207'],
        'Deluxe':   ['301','302','309'],
    };

    let currentEditId    = null;   // numeric id dari data-id row
    let currentEditItems = [];     // array item offer
    let currentKode      = '';
    let currentEmail     = '';

    // ════════════════════════════════════════════════════════════
    // HELPERS
    // ════════════════════════════════════════════════════════════
    function generateKode(id) {
        // Format: RSV-YYMMDD-NNN
        const now = new Date();
        const yy  = String(now.getFullYear()).slice(2);
        const mm  = String(now.getMonth() + 1).padStart(2, '0');
        const dd  = String(now.getDate()).padStart(2, '0');
        return `RSV-${yy}${mm}${dd}-${String(id).padStart(3, '0')}`;
    }

    function getRow(id)         { return document.getElementById('row-' + id); }
    function getRowData(rowEl)  { return rowEl ? rowEl.dataset : {}; }

    // ════════════════════════════════════════════════════════════
    // TAB SWITCH
    // ════════════════════════════════════════════════════════════
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

    // ════════════════════════════════════════════════════════════
    // EXPAND DETAIL ROW
    // ════════════════════════════════════════════════════════════
    function toggleDetail(detailId, btn) {
        const row  = document.getElementById(detailId);
        const icon = btn.querySelector('svg');
        const isHidden = row.classList.toggle('hidden');
        icon.style.transform = isHidden ? '' : 'rotate(180deg)';
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — BUKA
    // ════════════════════════════════════════════════════════════
    function openEdit(id) {
        const row = getRow(id);
        if (!row) return;

        currentEditId    = id;
        currentEditItems = JSON.parse(row.dataset.items || '[]');

        // Isi form
        document.getElementById('edit-modal-title').textContent = 'Edit Reservasi #' + String(id).padStart(3,'0');
        document.getElementById('edit-modal-sub').textContent   = row.dataset.name + ' · ' + row.dataset.email;
        document.getElementById('e-name').value     = row.dataset.name;
        document.getElementById('e-email').value    = row.dataset.email;
        document.getElementById('e-checkin').value  = row.dataset.checkin;
        document.getElementById('e-checkout').value = row.dataset.checkout;
        document.getElementById('e-status').value   = row.dataset.status;

        // Tampilkan ringkasan offer
        const display = document.getElementById('e-items-display');
        display.innerHTML = currentEditItems.map(item => `
            <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-lg px-3 py-2 text-sm">
                <span class="font-medium text-gray-700">${item.name}</span>
                <span class="text-xs text-gray-400">${item.tipe} · Rp ${Number(item.harga).toLocaleString('id-ID')}/malam</span>
            </div>`).join('');

        onStatusChange(); // render assign kamar / warning sesuai status awal

        // Buka modal
        const modal = document.getElementById('modal-edit');
        if (typeof FlowbiteInstances !== 'undefined') {
            (FlowbiteInstances.getInstance('Modal','modal-edit') ?? new Modal(modal)).show();
        } else {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — REAKSI PERUBAHAN STATUS
    // ════════════════════════════════════════════════════════════
    function onStatusChange() {
        const status   = document.getElementById('e-status').value;
        const wrap     = document.getElementById('e-room-assign-wrap');
        const list     = document.getElementById('e-room-assign-list');
        const warning  = document.getElementById('e-cancel-warning');

        warning.classList.add('hidden');
        wrap.classList.add('hidden');

        if (status === 'check_in') {
            // Tampilkan assign kamar
            wrap.classList.remove('hidden');
            list.innerHTML = currentEditItems.map((item, idx) => {
                const rooms = availableRooms[item.tipe] || [];
                const opts  = rooms.map(r =>
                    `<option value="${r}" ${item.nomor_kamar === r ? 'selected' : ''}>Kamar ${r}</option>`
                ).join('');
                return `
                <div class="bg-white border border-gray-100 rounded-lg p-3">
                    <p class="text-xs font-semibold text-gray-700 mb-1.5">
                        ${idx + 1}. ${item.name}
                        <span class="font-normal text-gray-400">(${item.tipe})</span>
                    </p>
                    <select id="e-kamar-${idx}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih nomor kamar --</option>
                        ${opts}
                    </select>
                </div>`;
            }).join('');

        } else if (status === 'canceled') {
            warning.classList.remove('hidden');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — SIMPAN
    // ════════════════════════════════════════════════════════════
    function saveEdit() {
        const status   = document.getElementById('e-status').value;
        const checkin  = document.getElementById('e-checkin').value;
        const checkout = document.getElementById('e-checkout').value;
        const id       = currentEditId;

        if (checkout <= checkin) {
            alert('Check Out harus setelah Check In!');
            return;
        }

        // Validasi: kalau check_in, semua kamar harus dipilih
        let assignedRooms = [];
        if (status === 'check_in') {
            for (let i = 0; i < currentEditItems.length; i++) {
                const val = document.getElementById('e-kamar-' + i)?.value;
                if (!val) {
                    alert(`Nomor kamar untuk "${currentEditItems[i].name}" belum dipilih!`);
                    return;
                }
                assignedRooms.push(val);
            }
        }

        const row = getRow(id);
        if (!row) { closeEditModal(); return; }

        if (status === 'canceled') {
            // ── Pindahkan ke history sebagai canceled
            moveToHistory(id, 'canceled');
            closeEditModal();
            return;
        }

        if (status === 'check_in') {
            // ── Generate kode
            const kode = generateKode(id);

            // Update dataset row
            row.dataset.status = 'check_in';
            row.dataset.kode   = kode;

            // Update kolom kode di tabel
            document.getElementById('kode-' + id).innerHTML =
                `<span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">${kode}</span>`;

            // Update status badge
            document.getElementById('status-badge-' + id).innerHTML =
                `<span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">Check In</span>`;

            // Update kolom kamar (kamar pertama untuk row single, atau tetap "N Rooms")
            if (currentEditItems.length === 1) {
                document.getElementById('kamar-' + id).innerHTML =
                    `<span class="text-xs font-semibold bg-gray-100 px-2 py-1 rounded-lg">${assignedRooms[0]}</span>`;
            }

            // Update tombol Actions → Invoice + Check Out + Cancel
            document.getElementById('actions-' + id).innerHTML = `
                <div class="flex justify-center gap-2 flex-wrap">
                    <button onclick="showInvoice('${kode}','${row.dataset.email}','${row.dataset.name}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                        Invoice
                    </button>
                    <button onclick="doCheckOut('row-${id}','detail-${id}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition">
                        Check Out
                    </button>
                    <button onclick="cancelRow('row-${id}','detail-${id}','${id}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                        Cancel
                    </button>
                </div>`;

            // Auto-tampilkan invoice/kode setelah simpan
            closeEditModal();
            showInvoice(kode, row.dataset.email, row.dataset.name);
            return;
        }

        // Status tetap pending — hanya update data
        row.dataset.checkin  = checkin;
        row.dataset.checkout = checkout;

        closeEditModal();
    }

    // ════════════════════════════════════════════════════════════
    // CANCEL ROW (dari tombol Cancel langsung, tanpa modal)
    // ════════════════════════════════════════════════════════════
    function cancelRow(rowId, detailId, id) {
        if (!confirm('Batalkan reservasi ini? Data akan pindah ke History.')) return;
        moveToHistory(id, 'canceled');
    }

    // ════════════════════════════════════════════════════════════
    // CHECK OUT (dari tombol Check Out langsung)
    // ════════════════════════════════════════════════════════════
    function doCheckOut(rowId, detailId) {
        const id = rowId.replace('row-', '');
        if (!confirm('Tandai tamu ini sebagai Checked Out?')) return;
        moveToHistory(id, 'checked_out');
    }

    // ════════════════════════════════════════════════════════════
    // PINDAHKAN BARIS KE HISTORY
    // ════════════════════════════════════════════════════════════
    function moveToHistory(id, newStatus) {
        const row       = document.getElementById('row-' + id);
        const detailRow = document.getElementById('detail-' + id);
        if (!row) return;

        const d           = row.dataset;
        const items       = JSON.parse(d.items || '[]');
        const nights      = Math.round((new Date(d.checkout) - new Date(d.checkin)) / 86400000);
        const total       = nights * parseInt(d.total || 0);
        const kode        = d.kode || '';
        const isCanceled  = newStatus === 'canceled';
        const statusBadge = isCanceled
            ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Canceled</span>`
            : `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out</span>`;
        const totalHtml   = isCanceled
            ? `<span class="text-xs text-red-400 line-through">Rp ${total.toLocaleString('id-ID')}</span>`
            : `<span class="font-semibold text-green-700">Rp ${total.toLocaleString('id-ID')}</span>`;
        const roomHtml    = items.length > 1
            ? `<span class="text-xs font-semibold bg-purple-50 text-purple-700 px-2 py-1 rounded-lg">${items.length} Rooms</span>`
            : `<p class="text-xs font-semibold text-gray-800">${items[0]?.name ?? ''}</p><p class="text-xs text-gray-400">Room ${items[0]?.nomor_kamar ?? '—'} · ${items[0]?.tipe ?? ''}</p>`;

        const newRow = `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3"></td>
            <td class="px-4 py-3 text-gray-400 text-xs font-medium">#${id}</td>
            <td class="px-4 py-3">
                ${kode ? `<span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">${kode}</span>` : '<span class="text-xs text-gray-300">—</span>'}
            </td>
            <td class="px-4 py-3"><p class="font-semibold text-gray-800">${d.name}</p><p class="text-xs text-gray-400">${d.email}</p></td>
            <td class="px-4 py-3">${roomHtml}</td>
            <td class="px-4 py-3 text-gray-700 font-medium">${d.checkin}</td>
            <td class="px-4 py-3"><p class="text-gray-700 font-medium">${d.checkout}</p><p class="text-xs text-gray-400">${nights} nights</p></td>
            <td class="px-4 py-3">${totalHtml}</td>
            <td class="px-4 py-3">${statusBadge}</td>
        </tr>`;

        document.getElementById('riwayat-table-body').insertAdjacentHTML('afterbegin', newRow);

        // Hapus dari tabel aktif
        row.remove();
        detailRow?.remove();
    }

    // ════════════════════════════════════════════════════════════
    // INVOICE MODAL
    // ════════════════════════════════════════════════════════════
    function showInvoice(kode, email, name) {
        currentKode  = kode;
        currentEmail = email;
        document.getElementById('inv-code').textContent = kode;
        document.getElementById('inv-guest').textContent = name + ' · ' + email;
        document.getElementById('modal-invoice').classList.remove('hidden');
    }

    function closeInvoice() {
        document.getElementById('modal-invoice').classList.add('hidden');
    }

    function sendInvoiceEmail() {
        fetch('/send-booking-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: currentEmail, kode: currentKode })
        })
        .then(res => res.json())
        .then(() => { alert('Kode reservasi berhasil dikirim ke ' + currentEmail); closeInvoice(); })
        .catch(() => alert('Gagal mengirim email, coba lagi.'));
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — TUTUP
    // ════════════════════════════════════════════════════════════
    function closeEditModal() {
        const modal = document.getElementById('modal-edit');
        if (typeof FlowbiteInstances !== 'undefined') {
            FlowbiteInstances.getInstance('Modal','modal-edit')?.hide();
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL TAMBAH — FORM HELPERS
    // ════════════════════════════════════════════════════════════
    function updateOfferCount() {
        const checked = document.querySelectorAll('.offer-checkbox:checked');
        const badge   = document.getElementById('f-offer-count');
        if (checked.length > 0) {
            badge.textContent = checked.length + ' dipilih';
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function hitungEstimasi() {
        const checkin  = document.getElementById('f-checkin').value;
        const checkout = document.getElementById('f-checkout').value;
        const checked  = document.querySelectorAll('.offer-checkbox:checked');

        if (!checkin || !checkout || checked.length === 0 || checkout <= checkin) {
            document.getElementById('f-estimasi').classList.add('hidden');
            return;
        }

        const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
        let totalHarga = 0;
        let breakdownHtml = '';

        checked.forEach(cb => {
            const label = cb.closest('label');
            const harga = parseInt(label.dataset.harga);
            const name  = label.dataset.name;
            totalHarga += harga;
            breakdownHtml += `<p class="text-xs text-blue-600">${name}: ${nights} × Rp ${harga.toLocaleString('id-ID')} = Rp ${(nights*harga).toLocaleString('id-ID')}</p>`;
        });

        document.getElementById('f-estimasi-breakdown').innerHTML = breakdownHtml;
        document.getElementById('f-estimasi-total').textContent = 'Rp ' + (nights * totalHarga).toLocaleString('id-ID');
        document.getElementById('f-estimasi').classList.remove('hidden');
    }

    // ════════════════════════════════════════════════════════════
    // MODAL TAMBAH — SIMPAN
    // ════════════════════════════════════════════════════════════
async function saveReservation() {

    const name      = document.getElementById('f-name').value.trim();
    const email     = document.getElementById('f-email').value.trim();
    const checkin   = document.getElementById('f-checkin').value;
    const checkout  = document.getElementById('f-checkout').value;
    const checked   = document.querySelectorAll('.offer-checkbox:checked');

    // VALIDATION
    if (!name || !email || !checkin || !checkout || checked.length === 0) {
        alert('Please complete all fields.');
        return;
    }

    if (checkout <= checkin) {
        alert('Check out date must be after check in.');
        return;
    }

    // Ambil offer id
    let offers = [];

    checked.forEach(cb => {
        offers.push(cb.value);
    });

    try {

        const response = await fetch('/reservations/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                name: name,
                email: email,
                check_in: checkin,
                check_out: checkout,
                offers: offers
            })
        });

        const result = await response.json();

        if (result.success) {

            alert('Reservation created successfully.');

            // reset form
            document.getElementById('f-name').value = '';
            document.getElementById('f-email').value = '';
            document.getElementById('f-checkin').value = '';
            document.getElementById('f-checkout').value = '';

            document.querySelectorAll('.offer-checkbox')
                .forEach(cb => cb.checked = false);

            document.getElementById('f-estimasi')
                .classList.add('hidden');

            document.getElementById('f-offer-count')
                .classList.add('hidden');

            // close modal
            if (typeof FlowbiteInstances !== 'undefined') {
                FlowbiteInstances
                    .getInstance('Modal','modal-tambah')
                    ?.hide();
            }

            // reload table dari database
            location.reload();

        } else {

            alert(result.message || 'Failed to save reservation.');

        }

    } catch(error) {

        console.error(error);
        alert('Server error.');

    }
}
    </script>
@endsection