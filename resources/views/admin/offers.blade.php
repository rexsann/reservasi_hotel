@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">Offer Management</h1>
        <p class="text-sm text-gray-400">Kelola paket dan harga penawaran hotel</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI: FORM TAMBAH --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 sticky top-4">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">Tambah Offer Baru</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Nama Offer</label>
                    <input id="offerName" type="text" placeholder="e.g. Breakfast Package"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Kamar</label>
                    <select id="offerTipe"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="1">Standard — Floor 1</option>
                        <option value="2">Superior — Floor 2</option>
                        <option value="3">Deluxe — Floor 3</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Harga per Malam</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">Rp</span>
                        <input id="offerPrice" type="number" placeholder="350000"
                            class="w-full border border-gray-200 rounded-lg pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-2">Benefits</label>
                    <div class="space-y-2" id="benefitList">
                        @php
                        $benefits = [
                            'Sarapan pagi',
                            'Free WiFi',
                            'Air minum gratis',
                            'Akses kolam renang',
                            'Parkir gratis',
                            'Late check-out (hingga 14.00)',
                            'Early check-in (dari 11.00)',
                            'Laundry 2 potong/hari',
                            'Antar-jemput bandara',
                            'Diskon restoran 10%',
                        ];
                        @endphp
                        @foreach($benefits as $b)
                        <label class="flex items-center gap-2.5 border border-gray-200 rounded-lg px-3 py-2 cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition text-sm text-gray-700">
                            <input type="checkbox" value="{{ $b }}" class="benefitCheck accent-blue-600 rounded"> {{ $b }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <button onclick="saveOffer()"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition">
                    Simpan Offer
                </button>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: LIST OFFER PER TIPE --}}
    <div class="lg:col-span-2 space-y-6">

        @php
        $tipes = [
            1 => ['nama' => 'Standard', 'warna' => 'blue'],
            2 => ['nama' => 'Superior', 'warna' => 'purple'],
            3 => ['nama' => 'Deluxe',   'warna' => 'amber'],
        ];
        @endphp

        @foreach($tipes as $floor => $tipe)
        <div>
            <div class="flex items-center gap-2 mb-3">
                <h2 class="text-base font-semibold text-gray-800">{{ $tipe['nama'] }}</h2>
                <span class="text-xs text-gray-400 font-normal">· Floor {{ $floor }}</span>
            </div>
            <div id="offerList-{{ $floor }}" class="grid sm:grid-cols-2 gap-3"></div>
        </div>
        @endforeach

    </div>
</div>

<script>
const tipeLabel = { 1: 'Standard', 2: 'Superior', 3: 'Deluxe' };

let offers = {
    1: [
        {
            name: 'Room Only',
            price: 300000,
            benefits: ['Free WiFi', 'Air minum gratis', 'Parkir gratis']
        },
        {
            name: 'Breakfast Package',
            price: 350000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Air minum gratis', 'Parkir gratis']
        },
        {
            name: 'Staycation Deal',
            price: 400000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Late check-out (hingga 14.00)', 'Diskon restoran 10%']
        },
    ],
    2: [
        {
            name: 'Business Stay',
            price: 500000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Parkir gratis', 'Early check-in (dari 11.00)', 'Air minum gratis']
        },
        {
            name: 'Family Package',
            price: 600000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Parkir gratis', 'Laundry 2 potong/hari']
        },
        {
            name: 'Weekend Deal',
            price: 650000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Late check-out (hingga 14.00)', 'Early check-in (dari 11.00)', 'Diskon restoran 10%']
        },
    ],
    3: [
        {
            name: 'Luxury Stay',
            price: 750000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Laundry 2 potong/hari', 'Late check-out (hingga 14.00)', 'Diskon restoran 10%']
        },
        {
            name: 'Honeymoon Package',
            price: 900000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Late check-out (hingga 14.00)', 'Early check-in (dari 11.00)', 'Laundry 2 potong/hari', 'Antar-jemput bandara']
        },
        {
            name: 'VIP Experience',
            price: 1100000,
            benefits: ['Sarapan pagi', 'Free WiFi', 'Akses kolam renang', 'Late check-out (hingga 14.00)', 'Early check-in (dari 11.00)', 'Laundry 2 potong/hari', 'Antar-jemput bandara', 'Diskon restoran 10%']
        },
    ]
};

const tipeColor = {
    1: { badge: 'bg-blue-50 text-blue-700 border-blue-100',   price: 'text-blue-600'  },
    2: { badge: 'bg-purple-50 text-purple-700 border-purple-100', price: 'text-purple-600' },
    3: { badge: 'bg-amber-50 text-amber-700 border-amber-100',  price: 'text-amber-600' },
};

function renderOffers() {
    [1, 2, 3].forEach(floor => {
        const container = document.getElementById('offerList-' + floor);
        const list      = offers[floor] || [];
        const color     = tipeColor[floor];

        if (!list.length) {
            container.innerHTML = `<p class="text-sm text-gray-400 col-span-2">Belum ada offer untuk tipe ini.</p>`;
            return;
        }

        container.innerHTML = list.map((o, idx) => `
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-4 hover:shadow-md transition flex flex-col gap-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">${o.name}</p>
                        <p class="text-xs text-gray-400 mt-0.5">${tipeLabel[floor]} · Floor ${floor}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="font-bold text-sm ${color.price}">Rp ${Number(o.price).toLocaleString('id-ID')}</p>
                        <p class="text-xs text-gray-400">/malam</p>
                    </div>
                </div>
                <div class="flex flex-wrap gap-1.5">
                    ${o.benefits.map(b =>
                        `<span class="text-xs border px-2 py-0.5 rounded-full ${color.badge}">${b}</span>`
                    ).join('')}
                </div>
                <div class="flex gap-2 pt-1 border-t border-gray-100">
                    <button onclick="deleteOffer(${floor}, ${idx})"
                        class="flex-1 text-xs px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-100 hover:bg-red-100 transition font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        `).join('');
    });
}

function saveOffer() {
    const name  = document.getElementById('offerName').value.trim();
    const floor = document.getElementById('offerTipe').value;
    const price = document.getElementById('offerPrice').value;

    if (!name || !price) {
        alert('Nama dan harga wajib diisi!'); return;
    }

    const benefits = [];
    document.querySelectorAll('.benefitCheck:checked').forEach(cb => benefits.push(cb.value));

    if (!benefits.length) {
        alert('Pilih minimal satu benefit!'); return;
    }

    offers[floor].push({ name, price: parseInt(price), benefits });
    resetForm();
    renderOffers();
}

function deleteOffer(floor, idx) {
    if (!confirm('Hapus offer ini?')) return;
    offers[floor].splice(idx, 1);
    renderOffers();
}

function resetForm() {
    document.getElementById('offerName').value  = '';
    document.getElementById('offerPrice').value = '';
    document.querySelectorAll('.benefitCheck').forEach(cb => cb.checked = false);
}

renderOffers();
</script>

@endsection