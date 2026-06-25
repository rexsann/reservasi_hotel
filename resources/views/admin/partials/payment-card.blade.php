@php
    $strip = match ($item->status) {
        'Waiting Verification' => 'border-l-4 border-l-yellow-400',
        'Paid' => 'border-l-4 border-l-green-500',
        'Rejected' => 'border-l-4 border-l-red-400',
        default => 'border-l-4 border-l-gray-300',
    };
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 {{ $strip }} p-6">
    <div class="grid md:grid-cols-3 gap-6">

        {{-- KOLOM 1: PAYMENT INFO --}}
        <div class="space-y-3">
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Payment Info</h2>
                @if ($item->status == 'Waiting Verification')
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700 border border-yellow-200">Waiting
                        Verification</span>
                @elseif($item->status == 'Paid')
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 border border-green-200">Paid</span>
                @elseif($item->status == 'Rejected')
                    <span
                        class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 border border-red-200">Rejected</span>
                @endif
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Payment No.</span>
                <span
                    class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded font-semibold">#{{ $item->id }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">No. Reservasi</span>
                <span
                    class="font-mono text-xs bg-gray-100 px-2 py-0.5 rounded font-semibold">{{ $item->reservation->reservation_code ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Guest Name</span>
                <span class="font-semibold text-gray-800">{{ $item->reservation->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Room</span>
                <div class="text-right space-y-0.5">
                    @foreach ($item->groupReservations as $gr)
                        <p class="font-medium text-gray-700">{{ $gr->roomType->name ?? '-' }}</p>
                    @endforeach
                </div>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Stay Dates</span>
                <span class="font-medium text-gray-700 text-right">
                    @if ($item->reservation)
                        {{ \Carbon\Carbon::parse($item->reservation->check_in)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($item->reservation->check_out)->format('d M Y') }}
                    @else
                        -
                    @endif
                </span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-400">Payment Method</span>
                <span class="font-medium text-gray-700">{{ $item->payment_method ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                <span class="text-gray-500 font-medium text-sm">Total Amount</span>
                <span class="text-lg font-bold text-blue-600">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- KOLOM 2: BUKTI BAYAR --}}
        <div class="space-y-3">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Payment Proof</p>
            <div class="border border-gray-100 rounded-xl overflow-hidden">
                <img src="{{ asset('storage/' . $item->proof_image) }}" alt="Bukti Pembayaran"
                    class="w-full h-48 object-cover cursor-pointer hover:scale-105 transition"
                    onclick="previewImage('{{ asset('storage/' . $item->proof_image) }}')">
            </div>
            <p class="text-xs text-gray-400">Click image to enlarge</p>
            @if ($item->paid_at)
                <p class="text-xs text-gray-400">Uploaded at:
                    {{ \Carbon\Carbon::parse($item->paid_at)->format('d M Y, H:i') }}</p>
            @endif
        </div>

        {{-- KOLOM 3: ACTIONS --}}
        <div class="flex flex-col justify-center space-y-3">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</p>

            @if ($item->status == 'Waiting Verification')
                <button onclick="updateStatus({{ $item->id }}, 'Paid')"
                    class="w-full bg-green-600 hover:bg-green-700 text-white text-sm font-semibold py-2.5 rounded-xl transition">
                    ✓ Approve Payment
                </button>
                <button onclick="updateStatus({{ $item->id }}, 'Rejected')"
                    class="w-full bg-white hover:bg-red-50 text-red-600 text-sm font-semibold py-2.5 rounded-xl border border-red-200 transition">
                    ✕ Reject Payment
                </button>
            @elseif($item->status == 'Paid')
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
