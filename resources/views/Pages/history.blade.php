@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')

<div class="pt-32 pb-24 px-6 bg-gradient-to-b from-gray-50 to-white min-h-screen">
  <div class="max-w-6xl mx-auto">
    <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl shadow-xl p-8 md:p-10 space-y-10">

      <!-- HEADER -->
      <div class="space-y-2 border-b pb-6">
        <h1 class="text-3xl font-semibold text-gray-800 tracking-tight">
          Riwayat Reservasi
        </h1>
        <p class="text-gray-400 text-sm">
          Halo, <strong>{{ auth()->user()->name ?? 'Tamu' }}</strong>! Berikut riwayat reservasi Anda.
        </p>
      </div>

      <!-- JIKA TIDAK ADA RESERVASI -->
      @if ($reservasi->isEmpty())
        <div class="text-center py-16">
          <p class="text-5xl mb-4">🏨</p>
          <p class="text-gray-500 text-lg mb-6">Anda belum memiliki reservasi.</p>

          {{-- ✅ Tombol menuju halaman home bagian #rooms --}}
          <a href="{{ url('/') }}#rooms"
             class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
            Reservasi Sekarang
          </a>
        </div>

      @else
        <div class="space-y-6">
          @foreach ($reservasi as $item)
          <div class="rounded-2xl border border-gray-100 p-6 hover:shadow-md transition bg-white">
            <div class="flex flex-col md:flex-row justify-between gap-6">

              <!-- INFO KIRI -->
              <div class="space-y-3">
                <p class="text-xs uppercase tracking-wider text-gray-400">No. Reservasi</p>
                <p class="text-lg font-semibold text-gray-800">{{ $item->reservation_code }}</p>

                <div>
                  <p class="text-sm text-gray-500">Kamar</p>
                  <p class="font-medium">
                    {{ $item->room_name ?? 'Tidak tersedia' }} • {{ $item->room_type ?? '-' }}
                  </p>
                </div>

                <div>
                  <p class="text-sm text-gray-500">Tanggal</p>
                  <p class="font-medium">
                    {{ $item->check_in ? \Carbon\Carbon::parse($item->check_in)->format('d M Y') : '-' }}
                    —
                    {{ $item->check_out ? \Carbon\Carbon::parse($item->check_out)->format('d M Y') : '-' }}
                    @if ($item->check_in && $item->check_out)
                      <span class="text-xs text-gray-400">
                        ({{ \Carbon\Carbon::parse($item->check_in)->diffInDays($item->check_out) }} malam)
                      </span>
                    @endif
                  </p>
                </div>

                <div>
                  <p class="text-sm text-gray-500">Tamu</p>
                  <p class="font-medium">{{ $item->guest_total }} orang</p>
                </div>

                {{-- ✅ Offer selalu ditampilkan, dengan fallback jika null --}}
                <div>
                  <p class="text-sm text-gray-500">Penawaran</p>
                  @php
                    $offerName = '-'; // default jika tidak ada offer
                    if ($item->offer) {
                        $decoded = json_decode($item->offer, true);
                        $offerName = '-';
                    }
                  @endphp
                  <p class="font-medium {{ $offerName !== '-' ? 'text-blue-600' : 'text-gray-400' }}">
                    {{ $offerName !== '-' ? '🎁 ' . $offerName : $offerName }}
                  </p>
                </div>

              </div>

              <!-- TOTAL HARGA -->
              <div class="flex flex-col justify-center">
                <p class="text-sm text-gray-400">Total Harga</p>
                <p class="text-2xl font-semibold text-gray-900">
                  Rp {{ number_format($item->total_price, 0, ',', '.') }}
                </p>
              </div>

              <!-- STATUS -->
              <div class="flex flex-col justify-between items-end gap-4">
                @php
                  $statusConfig = [
                    'Pending Payment'      => ['bg-amber-50',  'text-amber-700',  'border-amber-200',  '⏳'],
                    'Waiting Verification' => ['bg-blue-50',   'text-blue-700',   'border-blue-200',   '🔍'],
                    'Confirmed'            => ['bg-green-50',  'text-green-700',  'border-green-200',  '✅'],
                    'Checked In'           => ['bg-purple-50', 'text-purple-700', 'border-purple-200', '🏨'],
                    'Checked Out'          => ['bg-gray-50',   'text-gray-700',   'border-gray-200',   '🚪'],
                    'Cancelled'            => ['bg-red-50',    'text-red-700',    'border-red-200',    '❌'],
                    'Expired'              => ['bg-orange-50', 'text-orange-700', 'border-orange-200', '⌛'],
                  ];
                  $cfg = $statusConfig[$item->status] ?? ['bg-gray-50', 'text-gray-700', 'border-gray-200', '❓'];
                @endphp

                <span class="px-4 py-1.5 text-xs font-medium rounded-full border
                             {{ $cfg[0] }} {{ $cfg[1] }} {{ $cfg[2] }}">
                  {{ $cfg[3] }} {{ $item->status }}
                </span>

                <p class="text-xs text-gray-400">
                  Dibuat: {{ $item->created_at->format('d M Y') }}
                </p>
              </div>

            </div>
          </div>
          @endforeach
        </div>
      @endif

    </div>
  </div>
</div>

@endsection