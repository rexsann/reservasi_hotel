@extends('layouts.layout')

@section('title', 'Payment Verification')

@section('content')

@php
    // Data dummy sementara — nanti diganti data dari controller
    $pembayaran = [
        [
            'id'      => 1,
            'kode'    => 'PAY-260509-001',
            'nama'    => 'Moonlight',
            'kamar'   => 'Standard · Room 01',
            'tanggal' => '20 Apr 2026 – 22 Apr 2026',
            'malam'   => '2 Nights',
            'total'   => 700000,
            'status'  => 'pending',
            'bukti'   => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&q=80',
        ],
        [
            'id'      => 2,
            'kode'    => 'PAY-260509-002',
            'nama'    => 'Sunshine',
            'kamar'   => 'Superior · Room 02',
            'tanggal' => '25 Apr 2026 – 27 Apr 2026',
            'malam'   => '2 Nights',
            'total'   => 1800000,
            'status'  => 'success',
            'bukti'   => 'https://images.unsplash.com/photo-1565372195458-9de0b320ef04?w=600&q=80',
        ],
        [
            'id'      => 3,
            'kode'    => 'PAY-260509-003',
            'nama'    => 'Facha',
            'kamar'   => 'Deluxe · Room 01',
            'tanggal' => '28 Apr 2026 – 01 May 2026',
            'malam'   => '3 Nights',
            'total'   => 3300000,
            'status'  => 'rejected',
            'bukti'   => 'https://images.unsplash.com/photo-1580048915913-4f8f5cb481c4?w=600&q=80',
        ],
    ];
@endphp

<div class="p-2 space-y-8 bg-gray-50 min-h-screen">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Payment Verification</h1>
        <p class="text-sm text-gray-500">Review and verify payment submissions from guests</p>
    </div>

    {{-- LIST PEMBAYARAN --}}
    <div class="space-y-5">

        @foreach($pembayaran as $item)

        {{-- Warna strip kiri kartu sesuai status --}}
        @if($item['status'] == 'pending')
            @php $strip = 'border-l-4 border-l-yellow-400'; @endphp
        @elseif($item['status'] == 'success')
            @php $strip = 'border-l-4 border-l-green-500'; @endphp
        @else
            @php $strip = 'border-l-4 border-l-red-400'; @endphp
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 {{ $strip }} p-6">
            <div class="grid md:grid-cols-3 gap-6">

                {{-- KOLOM 1: INFO PEMBAYARAN --}}
                <div class="space-y-3">

                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Payment Info</h2>

                        {{-- Badge status --}}
                        @if($item['status'] == 'pending')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">Pending</span>
                        @elseif($item['status'] == 'success')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 border border-green-200">Approved</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200">Rejected</span>
                        @endif
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Payment No.</span>
                        <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded font-semibold">{{ $item['kode'] }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Guest Name</span>
                        <span class="font-semibold text-gray-800">{{ $item['nama'] }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Room</span>
                        <span class="font-medium text-gray-700">{{ $item['kamar'] }}</span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Stay Dates</span>
                        <span class="font-medium text-gray-700 text-right">
                            {{ $item['tanggal'] }}<br>
                            <span class="text-xs text-gray-400">({{ $item['malam'] }})</span>
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Total Amount</span>
                        <span class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($item['total'], 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                {{-- KOLOM 2: BUKTI PEMBAYARAN --}}
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Payment Proof</p>

                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <img
                            src="{{ $item['bukti'] }}"
                            class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition"
                            onclick="previewImage('{{ $item['bukti'] }}')">
                    </div>

                    <p class="text-xs text-gray-400">Click image to enlarge</p>
                </div>

                {{-- KOLOM 3: AKSI --}}
                <div class="flex flex-col justify-center space-y-3">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</p>

                    @if($item['status'] == 'pending')
                        {{-- Tombol hanya muncul kalau masih pending --}}
                        <button onclick="updateStatus({{ $item['id'] }}, 'success')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                            ✓ Approve Payment
                        </button>

                        <button onclick="updateStatus({{ $item['id'] }}, 'rejected')"
                            class="w-full bg-white hover:bg-red-50 text-red-600 text-sm font-semibold py-2.5 rounded-xl border border-red-200 transition">
                            ✕ Reject Payment
                        </button>

                    @elseif($item['status'] == 'success')
                        {{-- Sudah approved --}}
                        <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-4 text-center">
                            <p class="text-sm font-semibold text-green-700">Payment Approved</p>
                            <p class="text-xs text-green-500 mt-1">No further action needed</p>
                        </div>

                    @else
                        {{-- Sudah rejected --}}
                        <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-4 text-center">
                            <p class="text-sm font-semibold text-red-600">Payment Rejected</p>
                            <p class="text-xs text-red-400 mt-1">This payment has been declined</p>
                        </div>
                    @endif

                </div>

            </div>
        </div>

        @endforeach

    </div>

</div>

{{-- MODAL PREVIEW GAMBAR --}}
<div id="modalPreview" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <img id="previewImg" class="max-h-[80%] rounded-xl shadow-lg">
</div>

<script>
function previewImage(src) {
    const modal = document.getElementById('modalPreview');
    const img   = document.getElementById('previewImg');

    img.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    modal.onclick = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };
}

function updateStatus(id, status) {
    alert('Update ID ' + id + ' to status: ' + status);
}
</script>

@endsection