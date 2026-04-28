@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Users Management</h1>
        <p class="text-sm text-gray-400">Daftar tamu terdaftar</p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Total Tamu</p>
        <p class="text-2xl font-semibold text-gray-800" id="stat-total">0</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-green-500 inline-block"></span> Pernah Menginap
        </p>
        <p class="text-2xl font-semibold text-green-600" id="stat-menginap">0</p>
    </div>
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">
        <p class="text-xs text-gray-400 mb-1 flex items-center gap-1">
            <span class="w-2 h-2 rounded-full bg-yellow-400 inline-block"></span> Belum Menginap
        </p>
        <p class="text-2xl font-semibold text-yellow-500" id="stat-belum">0</p>
    </div>
</div>

{{-- SEARCH --}}
<div class="mb-4">
    <input type="text" id="searchInput" placeholder="Cari nama atau email tamu..."
        oninput="renderUsers()"
        class="w-full max-w-sm border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-800">
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Tamu</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Total Reservasi</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Terdaftar</th>
            </tr>
        </thead>
        <tbody id="userTableBody" class="divide-y divide-gray-100"></tbody>
    </table>
</div>

<script>
const users = [
    { id: 1, name: 'Moonlight',  email: 'moon@gmail.com',    reservasi: 3, terdaftar: '2026-01-10' },
    { id: 2, name: 'Sunshine',   email: 'shine@gmail.com',   reservasi: 1, terdaftar: '2026-02-14' },
    { id: 3, name: 'Facha',      email: 'chacha@gmail.com',  reservasi: 0, terdaftar: '2026-03-05' },
    { id: 4, name: 'Nareen',     email: 'nareen@mail.com',   reservasi: 2, terdaftar: '2026-03-20' },
    { id: 5, name: 'Baobao',      email: 'baobao@mail.com',    reservasi: 1, terdaftar: '2026-04-01' },
    { id: 6, name: 'Allysum',     email: 'ally@mail.com',   reservasi: 0, terdaftar: '2026-04-10' },
];

function renderUsers() {
    const q       = document.getElementById('searchInput').value.toLowerCase();
    const filtered = users.filter(u =>
        u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q)
    );

    // Stats
    document.getElementById('stat-total').textContent    = users.length;
    document.getElementById('stat-menginap').textContent = users.filter(u => u.reservasi > 0).length;
    document.getElementById('stat-belum').textContent    = users.filter(u => u.reservasi === 0).length;

    const tbody = document.getElementById('userTableBody');

    if (!filtered.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-400">
                    Tidak ada tamu yang cocok dengan pencarian
                </td>
            </tr>`;
        return;
    }

    tbody.innerHTML = filtered.map(u => {
        const sudahMenginap = u.reservasi > 0;
        return `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-xs text-gray-400 font-medium">${String(u.id).padStart(3, '0')}</td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold flex-shrink-0">
                        ${u.name.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">${u.name}</p>
                        <p class="text-xs text-gray-400">${u.email}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <span class="font-semibold text-gray-800">${u.reservasi}</span>
                <span class="text-xs text-gray-400 ml-1">reservasi</span>
            </td>
            <td class="px-6 py-4">
                ${sudahMenginap
                    ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Pernah Menginap
                       </span>`
                    : `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700 border border-yellow-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span> Belum Menginap
                       </span>`
                }
            </td>
            <td class="px-6 py-4 text-gray-500 text-xs">${u.terdaftar}</td>
        </tr>`;
    }).join('');
}

renderUsers();
</script>

@endsection