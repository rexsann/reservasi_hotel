@extends('admin.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Add Room</h1>

@if(session('error'))
<div class="bg-red-100 text-red-600 p-3 rounded mb-4">
    {{ session('error') }}
</div>
@endif

@if(session('success'))
<div class="bg-green-100 text-green-600 p-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<form id="roomForm" class="bg-white p-6 rounded-2xl shadow w-full max-w-lg">

    <!-- ROOM ID -->
    <div class="mb-4">
        <label class="block mb-1">Room ID</label>
        <select name="room_id" id="roomSelect"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400" required>

            <option value="">-- Select Room --</option>

            @for ($i = 1; $i <= 10; $i++)
                <option value="{{ $i }}">
                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                </option>
            @endfor

        </select>
    </div>

    <!-- FLOOR -->
    <div class="mb-4">
        <label class="block mb-1">Floor</label>
        <select name="floor" id="floorSelect"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400" required>
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

            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                <input type="checkbox" value="wifi" class="facility">
                <span>WiFi</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                <input type="checkbox" value="tv" class="facility">
                <span>TV</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                <input type="checkbox" value="ac" class="facility">
                <span>AC</span>
            </label>

            <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                <input type="checkbox" value="breakfast" class="facility">
                <span>Breakfast</span>
            </label>

        </div>
    </div>

    <!-- PRICE -->
    <div class="mb-4">
        <label class="block mb-1">Price</label>
        <input type="text" id="priceInput"
            class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400"
            placeholder="Rp 0" required>

        <input type="hidden" id="priceValue">
    </div>

    <button type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition w-full">
        Save Room
    </button>

</form>

<script>
// AUTO TYPE
const floorSelect = document.getElementById('floorSelect');
const typeInput = document.getElementById('typeInput');

function setType() {
    if (floorSelect.value == 1) typeInput.value = 'standard';
    if (floorSelect.value == 2) typeInput.value = 'superior';
    if (floorSelect.value == 3) typeInput.value = 'deluxe';
}
floorSelect.addEventListener('change', () => {
    setType();
    disableUsedRooms();
});
setType();

// FORMAT RUPIAH
const priceInput = document.getElementById('priceInput');
const priceValue = document.getElementById('priceValue');

priceInput.addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    priceValue.value = value;

    if (value) {
        e.target.value = 'Rp ' + Number(value).toLocaleString('id-ID');
    } else {
        e.target.value = '';
    }
});

// DISABLE ROOM YANG SUDAH DIPAKAI
function disableUsedRooms() {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    let floor = floorSelect.value;

    let select = document.getElementById('roomSelect');
    let options = select.querySelectorAll('option');

    options.forEach(opt => {
        opt.disabled = false;

        if (opt.value !== "") {
            let used = rooms.find(r => r.room_id == opt.value && r.floor == floor);
            if (used) {
                opt.disabled = true;
            }
        }
    });
}
disableUsedRooms();

// SAVE ROOM (LOCAL STORAGE)
document.getElementById('roomForm').addEventListener('submit', function(e) {
    e.preventDefault();

    let room_id = document.getElementById('roomSelect').value;

    if (!room_id) {
        alert('Please select room ID');
        return;
    }

    let facilities = [];
    document.querySelectorAll('.facility:checked').forEach(f => {
        facilities.push(f.value);
    });

    let room = {
        room_id: room_id,
        floor: floorSelect.value,
        type: typeInput.value,
        price: priceValue.value,
        facilities: facilities
    };

    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];

    let exists = rooms.find(r => r.room_id == room.room_id && r.floor == room.floor);

    if (exists) {
        alert('Room already exists!');
        return;
    }

    rooms.push(room);
    localStorage.setItem('rooms', JSON.stringify(rooms));

    window.location.href = '/admin/rooms';
});
</script>

@endsection