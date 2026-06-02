@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="pt-32 px-6 max-w-6xl mx-auto pb-20">

  <div class="mb-10">
    <div class="flex items-center justify-between text-sm font-medium">

      <div class="flex items-center gap-2 text-green-600">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold">
          ✓
        </div>
        <span>Fill in data</span>
      </div>

      <div class="flex-1 h-px bg-gray-300 mx-3"></div>

      <div class="flex items-center gap-2 text-blue-600">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">
          2
        </div>
        <span class="font-semibold">Payment</span>
      </div>

    </div>
  </div>

  <div class="grid lg:grid-cols-2 gap-6 items-stretch">

    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">

      <h2 class="text-lg font-semibold text-gray-800">Instruksi Pembayaran</h2>

      <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
        <span>ℹ️</span>
        <p>Silakan lakukan pembayaran ke nomor rekening berikut, lalu upload bukti pembayaran.</p>
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
            <p class="text-gray-500">Nama Pemilik</p>
            <p class="font-medium">Stayzy Hotel</p>
          </div>
          <div>
            <p class="text-gray-500">Nomor Rekening</p>
            <p class="font-medium">9913 6678 9012</p>
          </div>
          <div class="col-span-2">
            <p class="text-gray-500">Catatan</p>
            <p class="font-medium">Gunakan nomor reservasi sebagai referensi transfer.</p>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-xl text-sm">
        <span>⚠️</span>
        <p>Pastikan jumlah transfer sesuai total pembayaran.</p>
      </div>

      {{-- Form Upload Bukti Pembayaran --}}
      <div class="border-t pt-4 flex-1 flex flex-col justify-between gap-3">

        <h2 class="text-base font-semibold text-gray-800">Upload Bukti Pembayaran</h2>

        <form action="{{ route('payment.upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3">
          @csrf
          <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">

          <div class="grid grid-cols-2 gap-3 flex-1">

            {{-- Box Upload --}}
            <div class="border-2 border-dashed rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center flex-1">
              <div class="text-2xl">☁️</div>
              <p class="text-xs text-gray-500">JPG, PNG, PDF (Max. 5MB)</p>

              @if(session('success'))
                <p class="text-xs text-green-500">{{ session('success') }}</p>
              @elseif($errors->has('proof_image'))
                <p class="text-xs text-red-500">{{ $errors->first('proof_image') }}</p>
              @else
                <p class="text-xs text-red-500">Belum ada bukti diupload.</p>
              @endif

              <input type="file" name="proof_image" id="uploadBukti" class="hidden"
                onchange="document.getElementById('namaFile').innerText = this.files[0].name">
              <label for="uploadBukti"
                class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs cursor-pointer hover:bg-blue-700 transition">
                Pilih File
              </label>
              <p id="namaFile" class="text-xs text-gray-400 mt-1"></p>
            </div>

            {{-- Ketentuan Upload --}}
            <div class="bg-blue-50 border border-blue-200 text-blue-700 p-3 rounded-xl text-xs flex flex-col justify-center gap-1">
              <p class="font-semibold text-sm mb-1">Ketentuan Upload</p>
              <ul class="list-disc list-inside space-y-1">
                <li>Bukti harus jelas</li>
                <li>Nominal harus sesuai</li>
                <li>Verifikasi maks. 1x24 jam</li>
              </ul>
            </div>

          </div>

          <div class="flex items-center justify-between bg-gray-50 border rounded-xl p-3 gap-3">
            <p class="text-gray-500 text-xs">Admin akan verifikasi setelah bukti diupload.</p>
            <button type="submit"
              class="shrink-0 bg-blue-600 text-white px-4 py-1.5 rounded-lg text-sm hover:bg-blue-700 transition">
              Kirim Bukti
            </button>
          </div>

        </form>

      </div>

    </div>

    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">

      <h2 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h2>

      {{-- Informasi Reservasi --}}
      <div class="space-y-3 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">No. Reservasi</span>
          <span class="font-medium">{{ $reservation->reservation_code }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Tamu</span>
          <span class="font-medium">{{ $reservation->name }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Kamar</span>
          <span class="font-medium">{{ $reservation->room_name }} - {{ $reservation->room_type }}</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Tanggal Menginap</span>
          <span class="font-medium text-right">
            {{ \Carbon\Carbon::parse($reservation->check_in)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($reservation->check_out)->format('d M Y') }}
            <br>
            <span class="text-xs text-gray-400">
              ({{ \Carbon\Carbon::parse($reservation->check_in)->diffInDays($reservation->check_out) }} Malam)
            </span>
          </span>
        </div>
      </div>

      <hr>

      {{-- Rincian Pembayaran --}}
      <div class="space-y-3 text-sm">
        <h3 class="font-semibold text-gray-700">Rincian Pembayaran</h3>
        <div class="flex justify-between">
          <span class="text-gray-500">Harga Kamar</span>
          <span>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="flex justify-between font-semibold text-blue-600 text-base pt-2 border-t">
          <span>Total Pembayaran</span>
          <span>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
        </div>
      </div>

      <hr>

      {{-- Status --}}
      <div class="flex justify-between items-center">
        <div class="flex flex-col gap-1">
          <span class="text-gray-500">Status</span>
          <span id="statusDesc" class="text-sm text-yellow-600">
            @if($reservation->status === 'Waiting Verification')
              Sedang diverifikasi admin...
            @elseif($reservation->status === 'Confirmed')
              Reservasi telah dikonfirmasi!
            @elseif($reservation->status === 'Cancelled')
              Reservasi dibatalkan.
            @else
              Menunggu pembayaran...
            @endif
          </span>
        </div>
        <span id="statusBadge"
          class="px-4 py-2 text-sm font-semibold rounded-full
            {{ $reservation->status === 'Confirmed' ? 'bg-green-100 text-green-700' :
              ($reservation->status === 'Cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
          {{ $reservation->status === 'Confirmed' ? '✅' : ($reservation->status === 'Cancelled' ? '❌' : '⏳') }}
          {{ $reservation->status }}
        </span>
      </div>

      {{-- Tombol Cek Status --}}
      <button onclick="cekStatus({{ $reservation->id }})"
        class="w-full bg-blue-600 text-white py-4 rounded-2xl hover:bg-blue-700 transition text-sm font-medium">
        🔄 Cek Status Pembayaran
      </button>

      <div class="bg-gray-50 border rounded-xl p-4 mt-auto">
        <p class="font-semibold text-gray-700 text-base mb-1">Butuh Bantuan?</p>
        <p class="text-gray-500 text-sm mb-3">Hubungi kami jika mengalami kendala saat pembayaran.</p>
        <button class="w-full bg-gray-800 text-white py-3 rounded-2xl hover:bg-black transition text-base font-medium">
          Hubungi Customer Service
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

    badge.innerText = "⏳ Mengecek...";
    badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-600";
    desc.innerText = "Sedang mengecek status...";

    fetch(`/cek-status/${id}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'Confirmed' || data.status === 'Checked In') {
          badge.innerText = "✅ " + data.status;
          badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700";
          desc.innerText = "Reservasi kamu telah dikonfirmasi!";
        } else if (data.status === 'Cancelled') {
          badge.innerText = "❌ Dibatalkan";
          badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700";
          desc.innerText = "Reservasi dibatalkan, silakan hubungi admin.";
        } else {
          badge.innerText = "⏳ " + data.status;
          badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700";
          desc.innerText = "Sedang diverifikasi admin...";
        }
      });
  }
</script>