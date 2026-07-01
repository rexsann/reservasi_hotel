@extends('layouts.layout')

@section('title', 'Payment Verification')

@section('content')

<div class="p-2 space-y-6 bg-gray-50 min-h-screen">

    {{-- SESSION ALERT (untuk redirect biasa, jaga-jaga) --}}
    @if(session('success'))
        <div id="sessionAlert" class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-semibold text-gray-800">Payment Verification</h1>
        <p class="text-sm text-gray-500">Review and verify payment submissions from guests</p>
    </div>

    {{-- TABS --}}
    <div class="border-b border-gray-200">
        <ul class="flex gap-1 text-sm font-medium">
            <li>
                <button onclick="switchTab('pending')" id="tab-pending"
                    class="tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition">
                    Pending
                    <span class="ml-1.5 bg-yellow-100 text-yellow-700 text-xs px-1.5 py-0.5 rounded-full">
                        {{ $pembayaran->where('status', 'Waiting Verification')->count() }}
                    </span>
                </button>
            </li>
            <li>
                <button onclick="switchTab('history')" id="tab-history"
                    class="tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition">
                    History
                    <span class="ml-1.5 bg-gray-100 text-gray-500 text-xs px-1.5 py-0.5 rounded-full">
                        {{ $pembayaran->whereIn('status', ['Paid', 'Rejected'])->count() }}
                    </span>
                </button>
            </li>
        </ul>
    </div>

    {{-- TAB: PENDING --}}
    <div id="panel-pending">
        <div class="space-y-5">
            @forelse($pembayaran->where('status', 'Waiting Verification') as $item)
                @include('admin.partials.payment-card', ['item' => $item])
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                    <p class="text-gray-400 text-sm">Tidak ada pembayaran yang menunggu verifikasi.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- TAB: HISTORY --}}
    <div id="panel-history" class="hidden">
        <div class="space-y-5">
            @forelse($pembayaran->whereIn('status', ['Paid', 'Rejected']) as $item)
                @include('admin.partials.payment-card', ['item' => $item])
            @empty
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-10 text-center">
                    <p class="text-gray-400 text-sm">Belum ada riwayat pembayaran.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- MODAL PREVIEW --}}
<div id="modalPreview" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
    <img id="previewImg" class="max-h-[80%] rounded-xl shadow-lg">
</div>

{{-- TOAST ALERT --}}
<div id="toastAlert" class="fixed top-5 right-5 z-[100] hidden items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium transition-all">
    <svg id="toastIcon" class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
    <span id="toastMessage"></span>
</div>

<script>
function switchTab(tab) {
    const isPending = tab === 'pending';

    document.getElementById('panel-pending').classList.toggle('hidden', !isPending);
    document.getElementById('panel-history').classList.toggle('hidden', isPending);

    document.getElementById('tab-pending').className = isPending
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';

    document.getElementById('tab-history').className = !isPending
        ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
        : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
}

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

function showToast(message, type = 'success') {
    const toast = document.getElementById('toastAlert');
    const icon = document.getElementById('toastIcon');
    const msg = document.getElementById('toastMessage');

    const styles = {
        success: {
            box: 'bg-green-50 border border-green-200 text-green-700',
            path: 'M5 13l4 4L19 7'
        },
        error: {
            box: 'bg-red-50 border border-red-200 text-red-700',
            path: 'M6 18L18 6M6 6l12 12'
        }
    };

    toast.className = `fixed top-5 right-5 z-[100] flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium transition-all ${styles[type].box}`;
    icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${styles[type].path}" />`;
    msg.textContent = message;

    toast.classList.remove('hidden');

    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

function updateStatus(id, status) {
    fetch(`/admin/pembayaran/${id}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ status: status })
    })
    .then(res => res.json())
    .then(() => {
        showToast(status === 'Paid' ? 'Payment confirmed successfully.' : 'Payment rejected.', 'success');
        setTimeout(() => location.reload(), 1000);
    })
    .catch(() => {
        showToast('Something went wrong.', 'error');
    });
}

// auto-hide session alert kalau ada
document.addEventListener('DOMContentLoaded', () => {
    const sessionAlert = document.getElementById('sessionAlert');
    if (sessionAlert) {
        setTimeout(() => sessionAlert.remove(), 3000);
    }
});
</script>

@endsection