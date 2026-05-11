@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Facility Management</h1>
        <p class="text-sm text-gray-400">Manage facilities per room type</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- FORM --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">Add Facility</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Room Type</label>
                    <select id="facilityType"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="Standard">Standard — Floor 1</option>
                        <option value="Superior">Superior — Floor 2</option>
                        <option value="Deluxe">Deluxe — Floor 3</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Facility Name</label>
                    <input id="facilityInput" type="text" placeholder="e.g. Hair Dryer"
                        onkeydown="if(event.key==='Enter') addFacility()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="addFacility()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    + Add Facility
                </button>
            </div>
        </div>
    </div>

    {{-- LIST PER TIPE --}}
    <div class="lg:col-span-2 space-y-4">

        @php
        $tipes = [
            'Standard' => ['floor' => 1, 'color' => 'blue'],
            'Superior' => ['floor' => 2, 'color' => 'purple'],
            'Deluxe'   => ['floor' => 3, 'color' => 'amber'],
        ];
        @endphp

        @foreach($tipes as $nama => $info)
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3.5 border-b border-gray-100 bg-gray-50">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full
                        {{ $info['color'] === 'blue'   ? 'bg-blue-500'   : '' }}
                        {{ $info['color'] === 'purple' ? 'bg-purple-500' : '' }}
                        {{ $info['color'] === 'amber'  ? 'bg-amber-500'  : '' }}
                    "></span>
                    <p class="text-sm font-semibold text-gray-700">{{ $nama }}</p>
                    <span class="text-xs text-gray-400">· Floor {{ $info['floor'] }}</span>
                </div>
                <span class="text-xs text-gray-400" id="count-{{ $nama }}"></span>
            </div>
            <div id="list-{{ $nama }}" class="divide-y divide-gray-100"></div>
        </div>
        @endforeach

    </div>
</div>

<script>
// Master list fasilitas per tipe — nanti dari DB
let facilities = {
    'Standard': ['WiFi', 'AC'],
    'Superior': ['WiFi', 'TV', 'AC'],
    'Deluxe':   ['WiFi', 'TV', 'AC', 'Mini Fridge'],
};

const tipeColor = {
    'Standard': 'bg-blue-400',
    'Superior': 'bg-purple-400',
    'Deluxe':   'bg-amber-400',
};

function renderAll() {
    ['Standard', 'Superior', 'Deluxe'].forEach(tipe => renderTipe(tipe));
}

function renderTipe(tipe) {
    const list = facilities[tipe] || [];
    const dot  = tipeColor[tipe];

    document.getElementById('count-' + tipe).textContent = list.length + ' facilities';

    const container = document.getElementById('list-' + tipe);

    if (!list.length) {
        container.innerHTML = `
            <p class="px-5 py-6 text-center text-sm text-gray-400">
                No facilities added for this room type
            </p>`;
        return;
    }

    container.innerHTML = list.map((f, i) => `
        <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="w-1.5 h-1.5 rounded-full ${dot} flex-shrink-0"></span>
                <span class="text-sm font-medium text-gray-800">${f}</span>
            </div>
            <button onclick="deleteFacility('${tipe}', ${i})"
                class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-medium">
                Delete
            </button>
        </div>
    `).join('');
}

function addFacility() {
    const tipe = document.getElementById('facilityType').value;
    const val  = document.getElementById('facilityInput').value.trim();

    if (!val) { alert('Facility name cannot be empty!'); return; }

    if (facilities[tipe].find(f => f.toLowerCase() === val.toLowerCase())) {
        alert('Facility already exists in ' + tipe + '!'); return;
    }

    facilities[tipe].push(val);
    document.getElementById('facilityInput').value = '';
    renderTipe(tipe);
}

function deleteFacility(tipe, index) {
    if (!confirm('Delete "' + facilities[tipe][index] + '" from ' + tipe + '?')) return;
    facilities[tipe].splice(index, 1);
    renderTipe(tipe);
}

renderAll();
</script>

@endsection