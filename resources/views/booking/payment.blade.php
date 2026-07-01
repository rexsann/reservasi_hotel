@extends('layouts.app')

@section('title', 'Payment')

@section('content')

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="pt-32 px-6 max-w-6xl mx-auto pb-20">

        <div class="mb-10">
            <div class="flex items-center justify-between text-sm font-medium">

                <div class="flex items-center gap-2 text-green-600">
                    <div
                        class="w-6 h-6 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold">
                        ✓
                    </div>
                    <span>Fill in data</span>
                </div>

                <div class="flex-1 h-px bg-gray-300 mx-3"></div>

                <div class="flex items-center gap-2 text-blue-600">
                    <div
                        class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">
                        2
                    </div>
                    <span class="font-semibold">Payment</span>
                </div>

            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6 items-stretch">

            <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">

                <h2 class="text-lg font-semibold text-gray-800">Payment Instructions</h2>

                <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
                    <span>ℹ️</span>
                    <p>Please make your payment to the account number below, then upload your proof of payment.</p>
                </div>

                <div class="border rounded-xl p-5 space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" class="h-8">
                        <div>
                            <p class="font-semibold">BCA</p>
                            <p class="text-sm text-gray-500">Bank Central Asia</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm mt-3">
                        <div>
                            <p class="text-gray-500">Account Holder</p>
                            <p class="font-medium">Stayzy Hotel</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Account Number</p>
                            <p class="font-medium">9913 6678 9012</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-gray-500">Note</p>
                            <p class="font-medium">Use your reservation number as the transfer reference.</p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-xl text-sm">
                    <span>⚠️</span>
                    <p>Make sure the transfer amount matches the total payment.</p>
                </div>

                {{-- Proof of Payment Upload Form --}}
                <div class="border-t pt-4 flex-1 flex flex-col justify-between gap-3">

                    <h2 class="text-base font-semibold text-gray-800">Upload Proof of Payment</h2>

                    @if (in_array($reservation->status, ['Waiting Verification', 'Confirmed']))
                        {{-- Sudah upload, tampilkan info --}}
                        <div
                            class="flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-sm">
                            <span>✅</span>
                            <div>
                                <p class="font-semibold">Proof already submitted</p>
                                <p class="text-xs mt-1 text-green-600">Your proof of payment has been uploaded and is being
                                    processed. You cannot re-upload.</p>
                            </div>
                        </div>
                    @else
                        {{-- Belum upload, tampilkan form --}}
                        <form id="uploadBuktiForm" action="{{ route('payment.upload') }}" method="POST"
                            enctype="multipart/form-data" class="flex flex-col gap-3">
                            @csrf
                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

                            <div class="grid grid-cols-2 gap-3 flex-1">
                                <div
                                    class="border-2 border-dashed rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center flex-1">
                                    <div class="text-2xl">☁️</div>
                                    <p class="text-xs text-gray-500">JPG, PNG, PDF (Max. 3MB)</p>

                                    <p id="uploadFeedback" class="text-xs text-red-500">
                                        @if (session('success'))
                                            {{ session('success') }}
                                        @elseif($errors->has('proof_image'))
                                            {{ $errors->first('proof_image') }}
                                        @else
                                            No proof uploaded yet.
                                        @endif
                                    </p>

                                    <input type="file" name="proof_image" id="uploadBukti" class="hidden"
                                        onchange="document.getElementById('namaFile').innerText = this.files[0].name">
                                    <label for="uploadBukti"
                                        class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs cursor-pointer hover:bg-blue-700 transition">
                                        Choose File
                                    </label>
                                    <p id="namaFile" class="text-xs text-gray-400 mt-1"></p>
                                </div>

                                <div
                                    class="bg-blue-50 border border-blue-200 text-blue-700 p-3 rounded-xl text-xs flex flex-col justify-center gap-1">
                                    <p class="font-semibold text-sm mb-1">Upload Requirements</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Proof must be clear</li>
                                        <li>Amount must match</li>
                                        <li>Verification within 1x24 hours</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="flex items-center justify-between bg-gray-50 border rounded-xl p-3 gap-3">
                                <p class="text-gray-500 text-xs">Admin will verify once the proof has been uploaded.</p>
                                <button type="submit" id="uploadSubmitBtn"
                                    class="shrink-0 bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition">
                                    Submit Proof
                                </button>
                            </div>

                        </form>
                    @endif

                </div>

            </div>

            <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">

                <h2 class="text-lg font-semibold text-gray-800">Payment Information</h2>

                {{-- Reservation Information --}}
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Reservation No.</span>
                        <span class="font-medium">{{ $reservation->reservation_code }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Guest</span>
                        <span class="font-medium">{{ $reservation->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Room</span>
                        <div class="text-right">
                            @foreach ($groupReservations as $gr)
                                <p class="font-medium">{{ $gr->roomType->name ?? '-' }}</p>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Stay Dates</span>
                        <span class="font-medium text-right">
                            {{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }} -
                            {{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}
                            <br>
                            <span class="text-xs text-gray-400">
                                ({{ \Carbon\Carbon::parse($reservation->check_in)->diffInDays($reservation->check_out) }}
                                Night(s))
                            </span>
                        </span>
                    </div>
                </div>

                <hr>

                {{-- Payment Breakdown --}}
                <div class="space-y-3 text-sm">
                    <h3 class="font-semibold text-gray-700">Payment Breakdown</h3>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Room Price</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-blue-600 text-base pt-2 border-t">
                        <span>Total Payment</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                <hr>

                {{-- Payment Deadline --}}
                @if ($reservation->status === 'Pending Payment')
                    @php
                        $deadline = \Carbon\Carbon::parse($reservation->created_at)->addHours(24);
                    @endphp
                    <div id="paymentDeadlineBox" data-deadline="{{ $deadline->toIso8601String() }}"
                        class="flex items-start gap-3 bg-orange-50 border border-orange-200 text-orange-700 p-4 rounded-xl text-sm">
                        <span>⏰</span>
                        <div class="flex-1">
                            <p class="font-semibold">Payment deadline</p>
                            <p id="paymentCountdown" class="text-base font-bold">Calculating...</p>
                            <p class="text-xs text-orange-500 mt-1">The reservation will be automatically cancelled if this
                                deadline is missed.</p>
                        </div>
                    </div>
                @endif

                {{-- Status --}}
                <div class="flex justify-between items-center">
                    <div class="flex flex-col gap-1">
                        <span class="text-gray-500">Status</span>
                        <span id="statusDesc" class="text-sm text-yellow-600">
                            @if ($reservation->status === 'Waiting Verification')
                                Being verified by admin...
                            @elseif($reservation->status === 'Confirmed')
                                Reservation confirmed!
                            @elseif($reservation->status === 'Cancelled')
                                Reservation cancelled.
                            @else
                                Awaiting payment...
                            @endif
                        </span>
                    </div>
                    <span id="statusBadge"
                        class="px-4 py-2 text-sm font-semibold rounded-full
            {{ $reservation->status === 'Confirmed'
                ? 'bg-green-100 text-green-700'
                : ($reservation->status === 'Cancelled'
                    ? 'bg-red-100 text-red-700'
                    : 'bg-yellow-100 text-yellow-700') }}">
                        {{ $reservation->status === 'Confirmed' ? '✅' : ($reservation->status === 'Cancelled' ? '❌' : '⏳') }}
                        {{ $reservation->status }}
                    </span>
                </div>

                {{-- Check Status Button --}}
                <button onclick="cekStatus({{ $reservation->id }})"
                    class="w-full bg-blue-600 text-white py-4 rounded-2xl hover:bg-blue-700 transition text-sm font-medium">
                    🔄 Check Payment Status
                </button>

                <div class="bg-gray-50 border rounded-xl p-4 mt-auto">
                    <p class="font-semibold text-gray-700 text-base mb-1">Need Help?</p>
                    <p class="text-gray-500 text-sm mb-3">Contact us if you run into any issues with your payment.</p>
                    <button
                        class="w-full bg-gray-800 text-white py-3 rounded-2xl hover:bg-black transition text-base font-medium">
                        Contact Customer Service
                    </button>
                </div>

            </div>
        </div>

    </div>
@endsection

<script>
    function cekStatus(id) {
        const badge = document.getElementById('statusBadge');
        const desc = document.getElementById('statusDesc');

        badge.innerText = "⏳ Checking...";
        badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-600";
        desc.innerText = "Checking status...";

        fetch(`{{ route('payment.check') }}?reservation=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'Confirmed') {
                    badge.innerText = "✅ " + data.status;
                    badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700";
                    desc.innerText = "Your reservation has been confirmed!";
                } else if (data.status === 'Cancelled') {
                    badge.innerText = "❌ Cancelled";
                    badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700";
                    desc.innerText = "Reservation cancelled, please contact admin.";
                } else {
                    badge.innerText = "⏳ " + data.status;
                    badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700";
                    desc.innerText = "Being verified by admin...";
                }
            });
    }

    // Payment deadline countdown (24 hours)
    function startPaymentCountdown() {
        const box = document.getElementById('paymentDeadlineBox');
        if (!box) return;

        const deadline = new Date(box.dataset.deadline).getTime();
        const countdownEl = document.getElementById('paymentCountdown');

        function tick() {
            const now = Date.now();
            const diff = deadline - now;

            if (diff <= 0) {
                countdownEl.innerText = "Time's up, waiting for status update...";
                box.classList.remove('bg-orange-50', 'border-orange-200', 'text-orange-700');
                box.classList.add('bg-red-50', 'border-red-200', 'text-red-700');
                clearInterval(timer);
                return;
            }

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            countdownEl.innerText = `${hours}h ${minutes}m ${seconds}s`;
        }

        tick();
        const timer = setInterval(tick, 1000);
    }

    // Upload proof of payment via AJAX (no page reload)
    function initUploadForm() {
        const form = document.getElementById('uploadBuktiForm');
        if (!form) return;

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const btn = document.getElementById('uploadSubmitBtn');
            const feedback = document.getElementById('uploadFeedback');
            const fileInput = document.getElementById('uploadBukti');

            // Validasi: file belum dipilih
            if (!fileInput.files.length) {
                feedback.innerText = 'Please choose a proof of payment file first.';
                feedback.className = 'text-xs text-red-500';

                Swal.fire({
                    icon: 'warning',
                    title: 'No File Selected',
                    text: 'Please choose a proof of payment file before submitting.',
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'OK',
                });

                return false;
            }

            const originalBtnText = btn.innerText;
            btn.disabled = true;
            btn.innerText = 'Submitting...';
            feedback.innerText = 'Uploading...';
            feedback.className = 'text-xs text-gray-500';

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData,
                })
                .then(async (res) => {
                    const data = await res.json();
                    if (!res.ok) throw data;
                    return data;
                })
                .then((data) => {
                    feedback.innerText = data.message || 'Proof of payment uploaded successfully!';
                    feedback.className = 'text-xs text-green-500';

                    // Hapus deadline box setelah upload sukses
                    const deadlineBox = document.getElementById('paymentDeadlineBox');
                    if (deadlineBox) deadlineBox.remove();

                    // Update status badge & desc tanpa reload
                    const badge = document.getElementById('statusBadge');
                    const desc = document.getElementById('statusDesc');
                    if (badge && desc && data.status === 'Waiting Verification') {
                        badge.innerHTML = '⏳ Waiting Verification';
                        badge.className =
                            'px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700';
                        desc.innerText = 'Being verified by admin...';
                    }

                    btn.innerText = 'Submitted ✓';

                    // ✅ SweetAlert sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Proof Submitted!',
                        text: 'Your proof of payment has been uploaded. Admin will verify within 1×24 hours.',
                        confirmButtonColor: '#2563eb',
                        confirmButtonText: 'OK',
                    });
                })
                .catch((err) => {
                    const msg = err?.errors?.proof_image?.[0] || err?.message ||
                        'Failed to upload proof of payment.';
                    feedback.innerText = msg;
                    feedback.className = 'text-xs text-red-500';
                    btn.disabled = false;
                    btn.innerText = originalBtnText;

                    // ❌ SweetAlert gagal
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed!',
                        text: msg,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Try Again',
                    });
                });

            return false;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        startPaymentCountdown();
        initUploadForm();
    });
</script>