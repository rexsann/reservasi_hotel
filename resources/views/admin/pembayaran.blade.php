@extends('layouts.layout')

@section('title', 'Payment Verification')

@section('content')

<div class="p-2 space-y-8 bg-gray-50 min-h-screen">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Payment Verification</h1>
        <p class="text-sm text-gray-500">Review and verify payment submissions from guests</p>
    </div>

    {{-- LIST PEMBAYARAN --}}
    <div class="space-y-5">

        @foreach($pembayaran as $item)

        {{-- strip warna --}}
        @php
            $strip = match($item->status) {
                'pending' => 'border-l-4 border-l-yellow-400',
                'success' => 'border-l-4 border-l-green-500',
                default   => 'border-l-4 border-l-red-400',
            };
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 {{ $strip }} p-6">
            <div class="grid md:grid-cols-3 gap-6">

                {{-- KOLOM 1 --}}
                <div class="space-y-3">

                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
                            Payment Info
                        </h2>

                        {{-- STATUS BADGE --}}
                        @if($item->status == 'pending')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">
                                Pending
                            </span>
                        @elseif($item->status == 'success')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 border border-green-200">
                                Approved
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200">
                                Rejected
                            </span>
                        @endif
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Payment No.</span>
                        <span class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded font-semibold">
                            {{ $item->kode }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Guest Name</span>
                        <span class="font-semibold text-gray-800">
                            {{ $item->reservation->guest_name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Room</span>
                        <span class="font-medium text-gray-700">
                            {{ $item->reservation->room_name ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Stay Dates</span>
                        <span class="font-medium text-gray-700 text-right">
                            {{ $item->reservation->check_in ?? '-' }}
                            -
                            {{ $item->reservation->check_out ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Total Amount</span>
                        <span class="text-lg font-bold text-blue-600">
                            Rp {{ number_format($item->total, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                {{-- KOLOM 2 --}}
                <div class="space-y-3">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Payment Proof
                    </p>

                    <div class="border border-gray-100 rounded-xl overflow-hidden">
                        <img
                            src="{{ $item->bukti }}"
                            class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition"
                            onclick="previewImage('{{ $item->bukti }}')">
                    </div>

                    <p class="text-xs text-gray-400">Click image to enlarge</p>
                </div>

                {{-- KOLOM 3 --}}
                <div class="flex flex-col justify-center space-y-3">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">
                        Actions
                    </p>

                    @if($item->status == 'pending')

                        <button onclick="updateStatus({{ $item->id }}, 'success')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                            ✓ Approve Payment
                        </button>

                        <button onclick="updateStatus({{ $item->id }}, 'rejected')"
                            class="w-full bg-white hover:bg-red-50 text-red-600 text-sm font-semibold py-2.5 rounded-xl border border-red-200 transition">
                            ✕ Reject Payment
                        </button>

                    @elseif($item->status == 'success')

                        <div class="bg-green-50 border border-green-200 rounded-xl px-4 py-4 text-center">
                            <p class="text-sm font-semibold text-green-700">Payment Approved</p>
                            <p class="text-xs text-green-500 mt-1">No further action needed</p>
                        </div>

                    @else

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

{{-- MODAL --}}
<div id="modalPreview" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <img id="previewImg" class="max-h-[80%] rounded-xl shadow-lg">
</div>

<script>
function previewImage(src) {
    const modal = document.getElementById('modalPreview');
    const img = document.getElementById('previewImg');

    img.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    modal.onclick = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };
}

function updateStatus(id, status) {
    fetch(`/pembayaran/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(() => location.reload());
}
</script>

@endsection