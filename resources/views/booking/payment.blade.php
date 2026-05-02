@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="pt-32 px-6 max-w-6xl mx-auto pb-20">

  <!-- STEP PROGRESS -->
  <div class="mb-10">
    <div class="flex items-center justify-between text-sm font-medium">

      <!-- STEP 1 (DONE) -->
      <div class="flex items-center gap-2 text-green-600">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-green-100 text-green-600 text-xs font-bold">
          ✓
        </div>
        <span>Fill in data</span>
      </div>

      <!-- LINE -->
      <div class="flex-1 h-px bg-gray-300 mx-3"></div>

      <!-- STEP 2 (ACTIVE) -->
      <div class="flex items-center gap-2 text-blue-600">
        <div class="w-6 h-6 flex items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold">
          2
        </div>
        <span class="font-semibold">Payment</span>
      </div>

    </div>
  </div>

  <div class="grid lg:grid-cols-2 gap-6 items-stretch">

    <!-- ================= KIRI ================= -->
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
            <p class="font-medium">Gunakan nomor pembayaran sebagai referensi transfer.</p>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-xl text-sm">
        <span>⚠️</span>
        <p>Pastikan jumlah transfer sesuai total pembayaran.</p>
      </div>

      <!-- UPLOAD SECTION -->
      <div class="border-t pt-4 flex-1 flex flex-col justify-between gap-3">

        <h2 class="text-base font-semibold text-gray-800">Upload Bukti Pembayaran</h2>

        <div class="grid grid-cols-2 gap-3 flex-1">

          <!-- KIRI: Upload box kotak -->
          <div class="border-2 border-dashed rounded-xl p-4 flex flex-col items-center justify-center gap-2 text-center flex-1">
            <div class="text-2xl">☁️</div>
            <p class="text-xs text-gray-500">JPG, PNG, PDF (Max. 5MB)</p>
            <p class="text-xs text-red-500">Belum ada bukti diupload.</p>
            <input type="file" class="hidden" id="uploadBukti">
            <label for="uploadBukti"
              class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs cursor-pointer hover:bg-blue-700 transition">
              Pilih File
            </label>
          </div>

          <!-- KANAN: Ketentuan -->
          <div class="bg-blue-50 border border-blue-200 text-blue-700 p-3 rounded-xl text-xs flex flex-col justify-center gap-1">
            <p class="font-semibold text-sm mb-1">Ketentuan Upload</p>
            <ul class="list-disc list-inside space-y-1">
              <li>Bukti harus jelas</li>
              <li>Nominal harus sesuai</li>
              <li>Verifikasi maks. 1x24 jam</li>
            </ul>
          </div>

        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between bg-gray-50 border rounded-xl p-3 gap-3">
          <p class="text-gray-500 text-xs">Admin akan verifikasi setelah bukti diupload.</p>
          <button class="shrink-0 bg-gray-300 text-white px-4 py-1.5 rounded-lg text-sm cursor-not-allowed">
            Kirim Bukti
          </button>
        </div>

      </div>

    </div>

    <!-- ================= KANAN ================= -->
    <div class="bg-white rounded-2xl shadow p-6 flex flex-col gap-4">

      <h2 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h2>

      <div class="space-y-3 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-500">No. Pembayaran</span>
          <span class="font-medium">PAY-240501-001</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">No. Reservasi</span>
          <span class="font-medium">RES-240501-001</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Tamu</span>
          <span class="font-medium">Budi Santoso</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Kamar</span>
          <span class="font-medium">101 - Deluxe Room</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Tanggal Menginap</span>
          <span class="font-medium text-right">
            01 Mei 2024 - 03 Mei 2024 <br>
            <span class="text-xs text-gray-400">(2 Malam)</span>
          </span>
        </div>
      </div>

      <hr>

      <div class="space-y-3 text-sm">
        <h3 class="font-semibold text-gray-700">Rincian Pembayaran</h3>
        <div class="flex justify-between">
          <span class="text-gray-500">Harga Kamar (2 Malam)</span>
          <span>Rp 2.250.000</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-500">Pajak & Biaya Layanan (10%)</span>
          <span>Rp 225.000</span>
        </div>
        <div class="flex justify-between font-semibold text-blue-600 text-base pt-2 border-t">
          <span>Total Pembayaran</span>
          <span>Rp 2.475.000</span>
        </div>
      </div>

      <div class="flex justify-between items-center">
  <div class="flex flex-col gap-1">
    <span class="text-gray-500">Status</span>
    <span id="statusDesc" class="text-sm text-yellow-600">Sedang diverifikasi admin...</span>
  </div>
  <span id="statusBadge"
    class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700">
    ⏳ Pending
  </span>
</div>

      <button onclick="cekStatus()"
        class="w-full bg-blue-600 text-white py-4 rounded-2xl hover:bg-blue-700 transition text-sm font-medium">
        🔄 Cek Status Pembayaran
      </button>

      <!-- Butuh Bantuan — turun dengan mt-auto, huruf diperbesar -->
      <div class="bg-gray-50 border rounded-xl p-4 mt-auto">
        <p class="font-semibold text-gray-700 text-base mb-1">Butuh Bantuan?</p>
        <p class="text-gray-500 text-sm mb-3">Hubungi kami jika mengalami kendala saat pembayaran.</p>
        <button class="w-full bg-gray-800 text-white py-3 rounded-2xl hover:bg-black transition text-base font-medium">
          Hubungi Customer Service
        </button>
      </div>

    </div>
  </div>

  @endsection

  <script>
    function cekStatus() {
  const badge = document.getElementById('statusBadge');
  const desc = document.getElementById('statusDesc');

  badge.innerText = "⏳ Mengecek...";
  badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 text-gray-600";
  desc.innerText = "Sedang mengecek status...";
  desc.className = "text-sm text-gray-400";

  setTimeout(() => {
    let status = "success"; // ubah: pending / success / rejected

    if (status === "success") {
      badge.innerText = "✅ Berhasil";
      badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700";
      desc.innerText = "Kode booking telah dikirim ke email Anda.";
      desc.className = "text-sm text-green-600";
    } else if (status === "rejected") {
      badge.innerText = "❌ Ditolak";
      badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700";
      desc.innerText = "Pembayaran ditolak, silakan hubungi admin.";
      desc.className = "text-sm text-red-500";
    } else {
      badge.innerText = "⏳ Pending";
      badge.className = "px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700";
      desc.innerText = "Sedang diverifikasi admin...";
      desc.className = "text-sm text-yellow-600";
    }
  }, 1500);
}
  </script>