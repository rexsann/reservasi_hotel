@extends('layouts.layout')

@section('title', 'Verifikasi Pembayaran')

@section('content')

<div class="p-2 space-y-8 bg-gray-50 min-h-screen">

  <!-- HEADER -->
  <div>
    <h1 class="text-2xl font-semibold text-gray-800">Verifikasi Pembayaran</h1>
    <p class="text-sm text-gray-500">Kelola dan verifikasi pembayaran dari tamu</p>
  </div>

  <!-- LIST -->
  <div class="space-y-6">

    @foreach($pembayaran as $item)
    <div class="bg-white rounded-2xl shadow p-6 border border-gray-100">

      <div class="grid md:grid-cols-3 gap-6">

        <!-- 🔥 INFORMASI PEMBAYARAN -->
        <div class="space-y-4">

          <h2 class="text-lg font-semibold text-gray-800 mb-2">
            Informasi Pembayaran
          </h2>

          <div class="space-y-3 text-sm">

            <div class="flex justify-between">
              <span class="text-gray-500">No. Pembayaran</span>
              <span class="font-medium">{{ $item['kode'] }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-500">Nama Tamu</span>
              <span class="font-medium">{{ $item['nama'] }}</span>
            </div>

            <!-- 🔥 TAMBAHAN KAMAR -->
            <div class="flex justify-between">
              <span class="text-gray-500">Kamar</span>
              <span class="font-medium">
                {{ $item['kamar'] ?? 'Deluxe Room - 101' }}
              </span>
            </div>

            <!-- 🔥 TAMBAHAN TANGGAL -->
            <div class="flex justify-between">
              <span class="text-gray-500">Tanggal Menginap</span>
              <span class="font-medium text-right">
                {{ $item['tanggal'] ?? '01 Mei 2024 - 03 Mei 2024' }} <br>
                <span class="text-xs text-gray-400">
                  ({{ $item['malam'] ?? '2 Malam' }})
                </span>
              </span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-500">Total</span>
              <span class="font-semibold text-blue-600">
                Rp {{ number_format($item['total'],0,',','.') }}
              </span>
            </div>

            <!-- STATUS -->
            <div class="flex justify-between items-center pt-2">
              <span class="text-gray-500">Status</span>

              @if($item['status'] == 'pending')
                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                  ⏳ Pending
                </span>
              @elseif($item['status'] == 'success')
                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                  ✅ Berhasil
                </span>
              @else
                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">
                  ❌ Ditolak
                </span>
              @endif

            </div>

          </div>

        </div>

        <!-- BUKTI PEMBAYARAN -->
        <div class="space-y-3">
          <p class="text-sm text-gray-500">Bukti Pembayaran</p>

          <div class="border rounded-xl p-3">
            <img src="{{ $item['bukti'] ?? 'https://via.placeholder.com/400' }}" 
              class="rounded-lg w-full h-48 object-cover cursor-pointer hover:scale-105 transition"
              onclick="previewImage('{{ $item['bukti'] ?? '' }}')">
          </div>

          <p class="text-xs text-gray-400">Klik gambar untuk memperbesar</p>
        </div>

        <!-- AKSI -->
        <div class="flex flex-col justify-between">

          <div class="space-y-3">

            <button onclick="updateStatus({{ $item['id'] }}, 'success')"
              class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
              ✅ Terima Pembayaran
            </button>

            <button onclick="updateStatus({{ $item['id'] }}, 'rejected')"
              class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
              ❌ Tolak Pembayaran
            </button>

          </div>

        </div>

      </div>

    </div>
    @endforeach

  </div>

</div>


<!-- MODAL PREVIEW -->
<div id="modalPreview" class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">
  <img id="previewImg" class="max-h-[80%] rounded-xl shadow-lg">
</div>

@endsection


@push('scripts')
<script>
function previewImage(src) {
  const modal = document.getElementById('modalPreview');
  const img = document.getElementById('previewImg');

  img.src = src;
  modal.classList.remove('hidden');
  modal.classList.add('flex');

  modal.onclick = () => {
    modal.classList.add('hidden');
  };
}

function updateStatus(id, status) {
  alert("Update ID " + id + " ke status: " + status);
}
</script>
@endpush