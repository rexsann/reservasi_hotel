@extends('Layouts.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Add Room</h1>

<div class="bg-white p-6 rounded-2xl shadow w-full max-w-lg">

    <!-- ROOM ID -->
    <div class="mb-4">
        <label class="block mb-1">Room ID</label>
        <select
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">

            <option>-- Select Room --</option>

            @for ($i = 1; $i <= 10; $i++)
                <option>
                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                </option>
            @endfor

        </select>
    </div>

    <!-- FLOOR -->
    <div class="mb-4">
        <label class="block mb-1">Floor</label>
        <select id="floorSelect"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
            <option value="1">Floor 1</option>
            <option value="2">Floor 2</option>
            <option value="3">Floor 3</option>
        </select>
    </div>

    <!-- TYPE AUTO -->
    <div class="mb-4">
        <label class="block mb-1">Room Type</label>
        <input type="text" id="typeInput"
            class="w-full border p-2 rounded bg-gray-100"
            readonly>
    </div>

    <!-- FACILITIES -->
    <div class="mb-6">
        <label class="block mb-2 font-medium">Facilities</label>

        <div class="grid grid-cols-2 gap-3">

            <label class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50">
                <input type="checkbox">
                <span>WiFi</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50">
                <input type="checkbox">
                <span>TV</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50">
                <input type="checkbox">
                <span>AC</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg hover:bg-gray-50">
                <input type="checkbox">
                <span>Breakfast</span>
            </label>

        </div>
    </div>

    <!-- PRICE -->
    <div class="mb-4">
        <label class="block mb-1">Price</label>
        <input type="text" id="priceInput"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400"
            placeholder="Rp 0">
    </div>

    <!-- BUTTON (DISABLED STYLE) -->
    <button
        class="bg-gray-400 text-white px-4 py-2 rounded-lg w-full cursor-not-allowed">
        Save Room (UI Only)
    </button>

</div>

<!-- 🔥 UI SCRIPT (AMAN, TANPA SIMPAN DATA) -->
<script>
// AUTO TYPE (boleh, ini cuma visual)
const floorSelect = document.getElementById('floorSelect');
const typeInput = document.getElementById('typeInput');

function setType() {
    if (floorSelect.value == 1) typeInput.value = 'standard';
    if (floorSelect.value == 2) typeInput.value = 'superior';
    if (floorSelect.value == 3) typeInput.value = 'deluxe';
}
floorSelect.addEventListener('change', setType);
setType();

// FORMAT RUPIAH (UI aja)
const priceInput = document.getElementById('priceInput');

priceInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');

    if (value) {
        e.target.value = 'Rp ' + Number(value).toLocaleString('id-ID');
    } else {
        e.target.value = '';
    }
});
</script>

@endsection