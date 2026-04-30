@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="pt-32 px-6 max-w-7xl mx-auto pb-20">

  <div class="grid lg:grid-cols-2 gap-6">

    <!-- ================= ROW 1 - KIRI ================= -->
    <!-- INSTRUKSI -->
    <div class="bg-white rounded-2xl shadow p-6 space-y-4">

      <h2 class="text-lg font-semibold text-gray-800">Instruksi Pembayaran</h2>

      <div class="flex items-start gap-3 bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
        <span>ℹ️</span>
        <p>
          Silakan lakukan pembayaran ke nomor rekening berikut, lalu upload bukti pembayaran.
        </p>
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
            <p class="font-medium">
              Gunakan nomor pembayaran sebagai referensi transfer.
            </p>
          </div>
        </div>
      </div>

      <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-700 p-4 rounded-xl text-sm">
        <span>⚠️</span>
        <p>Pastikan jumlah transfer sesuai total pembayaran.</p>
      </div>

    </div>

    <!-- ================= ROW 1 - KANAN ================= -->
    <!-- INFORMASI PEMBAYARAN -->
    <div class="bg-white rounded-2xl shadow p-6 space-y-6 h-fit">

      <h2 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h2>

      <div class="flex justify-between items-center">

        <span class="text-gray-500">Status</span>

        <!-- STATUS BADGE BESAR -->
        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700">
          ⏳ Pending
        </span>

      </div>  

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

    </div>

    <!-- ================= ROW 2 (FULL WIDTH) ================= -->
    <!-- UPLOAD FULL -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6 space-y-6">

      <h2 class="text-lg font-semibold text-gray-800">Upload Bukti Pembayaran</h2>

      <div class="grid md:grid-cols-2 gap-6">

        <!-- KIRI UPLOAD -->
        <div class="border-2 border-dashed rounded-xl p-6 text-center flex flex-col items-center gap-3">

          <div class="text-4xl">☁️</div>

          <p class="text-gray-600 text-sm leading-relaxed">
            Upload bukti pembayaran
          </p>

          <span class="text-xs text-gray-400 block">
            JPG, PNG, PDF (Max. 5MB)
          </span>

          <input type="file" class="hidden" id="uploadBukti">

          <label for="uploadBukti"
            class="mt-2 bg-blue-600 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-blue-700 transition">
            Pilih File
          </label>

        </div>

        <!-- KANAN INFO -->
        <div class="space-y-3">
          <p class="text-sm font-medium text-gray-700">Bukti Pembayaran</p>
          <p class="text-sm text-red-500">Belum ada bukti pembayaran diupload.</p>

          <div class="bg-blue-50 border border-blue-200 text-blue-700 p-4 rounded-xl text-sm">
            <p class="font-medium mb-2">Ketentuan Upload</p>
            <ul class="list-disc list-inside space-y-1">
              <li>Bukti harus jelas</li>
              <li>Nominal harus sesuai</li>
              <li>Verifikasi maksimal 1x24 jam</li>
            </ul>
          </div>
        </div>

      </div>

      <!-- FOOTER -->
      <div class="flex items-center justify-between bg-gray-50 border rounded-xl p-4 text-sm">
        <p class="text-gray-600">
          Setelah bukti pembayaran diupload, admin akan memverifikasi pembayaran Anda.
        </p>

        <button class="bg-gray-300 text-white px-6 py-2 rounded-lg cursor-not-allowed">
          Kirim Bukti Pembayaran
        </button>
      </div>

    </div>

  </div>

</div>
@endsection