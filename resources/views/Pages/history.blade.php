@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')

<!-- BACKGROUND -->
<div class="pt-32 pb-24 px-6 bg-gradient-to-b from-gray-50 to-white min-h-screen">

  <div class="max-w-6xl mx-auto">

    <!-- CONTAINER -->
    <div class="bg-white/80 backdrop-blur-xl border border-gray-100 rounded-3xl shadow-xl p-8 md:p-10 space-y-10">

      <!-- HEADER -->
      <div class="space-y-2 border-b pb-6">
        <h1 class="text-3xl font-semibold text-gray-800 tracking-tight">
          Riwayat Reservasi
        </h1>
        <p class="text-gray-400 text-sm">
          Kelola dan pantau semua reservasi Anda dengan mudah
        </p>
      </div>

      <!-- LIST -->
      <div class="space-y-6">

        <!-- CARD 1 -->
        <div class="rounded-2xl border border-gray-100 p-6 hover:shadow-md transition bg-white">

          <div class="flex flex-col md:flex-row justify-between gap-6">

            <div class="space-y-3">
              <p class="text-xs uppercase tracking-wider text-gray-400">No. Reservasi</p>
              <p class="text-lg font-semibold text-gray-800">RES-240501-001</p>

              <div>
                <p class="text-sm text-gray-500">Kamar</p>
                <p class="font-medium">Deluxe Room • 101</p>
              </div>

              <div>
                <p class="text-sm text-gray-500">Tanggal</p>
                <p class="font-medium">
                  01 Mei — 03 Mei
                  <span class="text-xs text-gray-400">(2 malam)</span>
                </p>
              </div>
            </div>

            <div class="flex flex-col justify-center">
              <p class="text-sm text-gray-400">Total</p>
              <p class="text-2xl font-semibold text-gray-900">Rp 2.475.000</p>
            </div>

            <div class="flex flex-col justify-between items-end gap-4">

              <!-- STATUS -->
              <span id="status-1"
                class="px-4 py-1.5 text-xs font-medium rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                ⏳ Pending
              </span>

              <!-- BUTTON -->
              <button onclick="cekStatus(1)"
                class="px-5 py-2 text-sm rounded-lg 
bg-blue-600 text-white 
hover:bg-blue-700 hover:scale-105 active:scale-95 
transition flex items-center gap-2 shadow-sm">
                🔄 Cek Status
              </button>

            </div>

          </div>

        </div>

        <!-- CARD 2 -->
        <div class="rounded-2xl border border-gray-100 p-6 hover:shadow-md transition bg-white">

          <div class="flex flex-col md:flex-row justify-between gap-6">

            <div class="space-y-3">
              <p class="text-xs uppercase tracking-wider text-gray-400">No. Reservasi</p>
              <p class="text-lg font-semibold text-gray-800">RES-240430-002</p>

              <p class="text-sm text-gray-500">Kamar</p>
              <p class="font-medium">Superior Room • 202</p>

              <p class="text-sm text-gray-500">Tanggal</p>
              <p class="font-medium">28 Apr — 30 Apr</p>
            </div>

            <div class="flex flex-col justify-center">
              <p class="text-sm text-gray-400">Total</p>
              <p class="text-2xl font-semibold text-gray-900">Rp 1.800.000</p>
            </div>

            <div class="flex flex-col justify-between items-end gap-4">

              <span id="status-2"
                class="px-4 py-1.5 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200">
                ✅ Berhasil
              </span>

              <button onclick="cekStatus(2)"
                class="px-5 py-2 text-sm rounded-lg 
bg-blue-600 text-white 
hover:bg-blue-700 hover:scale-105 active:scale-95 
transition flex items-center gap-2 shadow-sm">
                🔄 Cek Status
              </button>

            </div>

          </div>

        </div>

        <!-- CARD 3 -->
        <div class="rounded-2xl border border-gray-100 p-6 hover:shadow-md transition bg-white">

          <div class="flex flex-col md:flex-row justify-between gap-6">

            <div class="space-y-3">
              <p class="text-xs uppercase tracking-wider text-gray-400">No. Reservasi</p>
              <p class="text-lg font-semibold text-gray-800">RES-240420-003</p>

              <p class="text-sm text-gray-500">Kamar</p>
              <p class="font-medium">Standard Room • 303</p>

              <p class="text-sm text-gray-500">Tanggal</p>
              <p class="font-medium">20 Apr — 21 Apr</p>
            </div>

            <div class="flex flex-col justify-center">
              <p class="text-sm text-gray-400">Total</p>
              <p class="text-2xl font-semibold text-gray-900">Rp 750.000</p>
            </div>

            <div class="flex flex-col justify-between items-end gap-4">

              <span id="status-3"
                class="px-4 py-1.5 text-xs font-medium rounded-full bg-red-50 text-red-700 border border-red-200">
                ❌ Ditolak
              </span>

              <button onclick="cekStatus(3)"
                class="px-5 py-2 text-sm rounded-lg 
bg-blue-600 text-white 
hover:bg-blue-700 hover:scale-105 active:scale-95 
transition flex items-center gap-2 shadow-sm">
                🔄 Cek Status
              </button>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

@endsection


<script>
function cekStatus(id) {
    const badge = document.getElementById(`status-${id}`);

    // loading
    badge.innerText = "⏳ Mengecek...";
    badge.className = "px-4 py-1.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600";

    setTimeout(() => {

        // simulasi random status
        let statuses = ["pending", "success", "rejected"];
        let status = statuses[Math.floor(Math.random() * statuses.length)];

        if (status === "success") {
            badge.innerText = "✅ Berhasil";
            badge.className = "px-4 py-1.5 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200";
        } 
        else if (status === "rejected") {
            badge.innerText = "❌ Ditolak";
            badge.className = "px-4 py-1.5 text-xs font-medium rounded-full bg-red-50 text-red-700 border border-red-200";
        } 
        else {
            badge.innerText = "⏳ Pending";
            badge.className = "px-4 py-1.5 text-xs font-medium rounded-full bg-amber-50 text-amber-700 border border-amber-200";
        }

    }, 1500);
}
</script>