@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Facility Management</h1>
        <p class="text-sm text-gray-400">Kelola fasilitas kamar hotel</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    {{-- FORM --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Fasilitas</h2>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Fasilitas</label>
                    <input id="facilityInput" type="text" placeholder="e.g. Hair Dryer"
                        onkeydown="if(event.key==='Enter') addFacility()"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button onclick="addFacility()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    + Tambah
                </button>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-700">Daftar Fasilitas</p>
                <span class="text-xs text-gray-400" id="stat-total">0 fasilitas</span>
            </div>
            <div id="facilityList" class="divide-y divide-gray-100"></div>
        </div>
    </div>

</div>

<script>
let facilities = ['WiFi', 'AC', 'TV', 'Mini Fridge', 'Shower', 'Handuk', 'Air Panas'];

function renderFacilities() {
    document.getElementById('stat-total').textContent = facilities.length + ' fasilitas';

    const container = document.getElementById('facilityList');

    if (!facilities.length) {
        container.innerHTML = `<p class="px-5 py-10 text-center text-sm text-gray-400">Belum ada fasilitas</p>`;
        return;
    }

    container.innerHTML = facilities.map((f, i) => `
        <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="w-2 h-2 rounded-full bg-blue-400 flex-shrink-0"></span>
                <span class="text-sm font-medium text-gray-800">${f}</span>
            </div>
            <button onclick="deleteFacility(${i})"
                class="text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-medium">
                Hapus
            </button>
        </div>
    `).join('');
}

function addFacility() {
    const val = document.getElementById('facilityInput').value.trim();
    if (!val) return;
    if (facilities.find(f => f.toLowerCase() === val.toLowerCase())) {
        alert('Fasilitas sudah ada!'); return;
    }
    facilities.push(val);
    document.getElementById('facilityInput').value = '';
    renderFacilities();
}

function deleteFacility(index) {
    if (!confirm(`Hapus "${facilities[index]}"?`)) return;
    facilities.splice(index, 1);
    renderFacilities();
}

renderFacilities();
</script>

@endsection