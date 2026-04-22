@extends('admin.layout')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold">Rooms Management</h1>

    <a href="/admin/rooms/create"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        + Add Room
    </a>

</div>

<div id="roomContainer"></div>

<!-- 🔥 EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Edit Room</h2>

        <input type="hidden" id="editIndex">

        <div class="mb-3">
            <label>Room ID</label>
            <input id="editRoomId" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>

        <div class="mb-3">
            <label>Floor</label>
            <input id="editFloor" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input id="editPrice" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Facilities</label>

            <div class="grid grid-cols-2 gap-2">
                <label><input type="checkbox" value="wifi" class="editFacility"> WiFi</label>
                <label><input type="checkbox" value="tv" class="editFacility"> TV</label>
                <label><input type="checkbox" value="ac" class="editFacility"> AC</label>
                <label><input type="checkbox" value="breakfast" class="editFacility"> Breakfast</label>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <button onclick="closeModal()" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
            <button onclick="saveEdit()" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
        </div>
    </div>
</div>

<script>
function renderRooms() {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];

    let container = document.getElementById('roomContainer');
    container.innerHTML = '';

    let types = [
        { name: 'Standard (Floor 1)', floor: 1 },
        { name: 'Superior (Floor 2)', floor: 2 },
        { name: 'Deluxe (Floor 3)', floor: 3 }
    ];

    types.forEach(type => {
        let filtered = rooms.filter(r => r.floor == type.floor);

        let html = `
        <h2 class="text-lg font-semibold mt-6 mb-2">${type.name}</h2>
        <div class="bg-white rounded-xl shadow overflow-hidden">

            <div class="grid grid-cols-5 bg-gray-100 p-3 text-sm font-semibold">
                <div>No</div>
                <div>Room ID</div>
                <div>Price</div>
                <div>Facilities</div>
                <div>Action</div>
            </div>
        `;

        if (filtered.length === 0) {
            html += `<div class="p-4 text-center text-gray-400">Empty</div>`;
        } else {
            filtered.forEach((room, index) => {

                // 🔥 fasilitas jadi badge
                let facilities = room.facilities.map(f => {
                    return `<span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded mr-1">${f}</span>`;
                }).join('');

                html += `
                <div class="grid grid-cols-5 items-center p-3 border-t text-sm">
                    <div>${index + 1}</div>
                    <div>${room.room_id}</div>
                    <div>Rp ${Number(room.price).toLocaleString('id-ID')}</div>
                    <div>${facilities}</div>
                    <div>
                        <button onclick="openEdit(${rooms.indexOf(room)})"
                            class="text-blue-500 text-xs">Edit</button>

                        <button onclick="deleteRoom(${rooms.indexOf(room)})"
                            class="text-red-500 text-xs ml-2">Delete</button>
                    </div>
                </div>
                `;
            });
        }

        html += `</div>`;
        container.innerHTML += html;
    });
}

// 🔥 DELETE
function deleteRoom(index) {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    rooms.splice(index, 1);
    localStorage.setItem('rooms', JSON.stringify(rooms));
    renderRooms();
}

// 🔥 OPEN MODAL
function openEdit(index) {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    let room = rooms[index];

    document.getElementById('editIndex').value = index;
    document.getElementById('editRoomId').value = room.room_id;
    document.getElementById('editFloor').value = room.floor;
    document.getElementById('editPrice').value = room.price;

    document.querySelectorAll('.editFacility').forEach(cb => {
        cb.checked = room.facilities.includes(cb.value);
    });

    document.getElementById('editModal').classList.remove('hidden');
}

// 🔥 CLOSE MODAL
function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// 🔥 SAVE EDIT
function saveEdit() {
    let rooms = JSON.parse(localStorage.getItem('rooms')) || [];
    let index = document.getElementById('editIndex').value;

    let facilities = [];
    document.querySelectorAll('.editFacility:checked').forEach(f => {
        facilities.push(f.value);
    });

    rooms[index].price = document.getElementById('editPrice').value;
    rooms[index].facilities = facilities;

    localStorage.setItem('rooms', JSON.stringify(rooms));

    closeModal();
    renderRooms();
}

// INIT
renderRooms();
</script>

@endsection