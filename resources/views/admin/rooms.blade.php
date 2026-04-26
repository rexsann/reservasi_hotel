@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Rooms Management</h1>

    <button onclick="openAddModal()"
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Add Room
    </button>
</div>

<div id="roomContainer"></div>


<!-- 🔥 ADD MODAL -->
<div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">

        <h2 class="text-lg font-semibold mb-4">Add Room</h2>

        <!-- ROOM ID -->
        <div class="mb-3">
            <label>Room ID</label>
            <select class="w-full border p-2 rounded">
                @for ($i = 1; $i <= 10; $i++)
                    <option>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</option>
                @endfor
            </select>
        </div>

        <!-- FLOOR -->
        <div class="mb-3">
            <label>Floor</label>
            <select id="addFloor" class="w-full border p-2 rounded">
                <option value="1">Floor 1</option>
                <option value="2">Floor 2</option>
                <option value="3">Floor 3</option>
            </select>
        </div>

        <!-- TYPE -->
        <div class="mb-3">
            <label>Type</label>
            <input id="addType" class="w-full border p-2 rounded bg-gray-100" readonly>
        </div>

        <!-- 💎 FACILITIES -->
        <div class="mb-3">
            <label class="block mb-2">Facilities</label>
            <div id="facilityOptions" class="grid grid-cols-2 gap-2 text-sm"></div>
        </div>

        <!-- 🎁 OFFERS -->
        <div class="mb-3">
            <label class="block mb-2">Offers</label>
            <div id="offerOptions" class="space-y-2 text-sm"></div>
        </div>

        <!-- PRICE -->
        <div class="mb-3">
            <label>Price</label>
            <input class="w-full border p-2 rounded" placeholder="Rp 300.000">
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeAddModal()" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
            <button onclick="fakeAdd()" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
        </div>

    </div>
</div>


<!-- 🔥 EDIT MODAL -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md shadow-lg">

        <h2 class="text-lg font-semibold mb-4">Edit Room</h2>

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

        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal()" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
            <button onclick="fakeSave()" class="px-3 py-1 bg-blue-600 text-white rounded">Save</button>
        </div>

    </div>
</div>


<script>
// 🔥 DUMMY DATA ROOMS
const rooms = [
    { room_id: '01', floor: 1, price: 200000, facilities: ['wifi','ac'] },
    { room_id: '02', floor: 1, price: 200000, facilities: ['wifi'] },
    { room_id: '01', floor: 2, price: 350000, facilities: ['wifi','tv'] },
    { room_id: '01', floor: 3, price: 500000, facilities: ['wifi','ac','tv','breakfast'] }
];

// 🔥 FACILITY MANAGEMENT (SIMULASI)
const facilitiesData = {
    1: ['wifi', 'ac'],
    2: ['wifi', 'tv', 'ac'],
    3: ['wifi', 'tv', 'ac', 'breakfast']
};

// 🔥 OFFER MANAGEMENT (SIMULASI)
const offersData = {
    1: [
        { name: 'Basic Deal', price: 200000, benefits: ['No Breakfast'] }
    ],
    2: [
        { name: 'Family Package', price: 350000, benefits: ['Breakfast', 'Free WiFi'] }
    ],
    3: [
        { name: 'Luxury Stay', price: 500000, benefits: ['Breakfast', 'Spa', 'VIP Service'] }
    ]
};


function renderRooms() {
    let container = document.getElementById('roomContainer');
    container.innerHTML = '';

    let types = [
        { name: 'Standard', floor: 1 },
        { name: 'Superior', floor: 2 },
        { name: 'Deluxe', floor: 3 }
    ];

    types.forEach(type => {

        let filtered = rooms.filter(r => r.floor == type.floor);

        let offers = offersData[type.floor] || [];

        let html = `
        <div class="mb-8">
            <h2 class="text-xl font-semibold mb-3">
                ${type.name} (Floor ${type.floor})
            </h2>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">Room</th>
                            <th class="px-6 py-3">Price</th>
                            <th class="px-6 py-3">Facilities</th>
                            <th class="px-6 py-3">Offers</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody>
        `;

        if (filtered.length === 0) {
            html += `
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-400">
                        No rooms yet
                    </td>
                </tr>
            `;
        }

        filtered.forEach((room, index) => {

            let facilities = room.facilities.map(f =>
                `<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-1 px-2.5 py-0.5 rounded">
                    ${f}
                </span>`
            ).join('');

            let offerBadges = offers.map(o =>
                `<span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded mr-1">
                    ${o.name}
                </span>`
            ).join('');

            html += `
            <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">${index + 1}</td>
                <td class="px-6 py-4 font-medium text-gray-900">
                    ${room.room_id}
                </td>
                <td class="px-6 py-4">
                    Rp ${Number(room.price).toLocaleString('id-ID')}
                </td>
                <td class="px-6 py-4">${facilities}</td>
                <td class="px-6 py-4">${offerBadges}</td>
                <td class="px-6 py-4">
                    <button onclick="openEdit('${room.room_id}', '${room.floor}', '${room.price}')"
                        class="font-medium text-blue-600 hover:underline">
                        Edit
                    </button>
                </td>
            </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        </div>
        `;

        container.innerHTML += html;
    });
}

// 🔥 ADD MODAL
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    setAddType();
    loadDynamicOptions();
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
}

function fakeAdd() {
    alert('Room added (UI only)');
    closeAddModal();
}


// 🔥 AUTO TYPE
function setAddType() {
    const floor = document.getElementById('addFloor').value;
    const typeInput = document.getElementById('addType');

    if (floor == 1) typeInput.value = 'standard';
    if (floor == 2) typeInput.value = 'superior';
    if (floor == 3) typeInput.value = 'deluxe';
}


// 🔥 LOAD FACILITIES + OFFERS (INI KUNCI KONSEP KAMU)
function loadDynamicOptions() {
    let floor = document.getElementById('addFloor').value;

    // FACILITIES
    let facilityHTML = '';
    facilitiesData[floor].forEach(f => {
        facilityHTML += `
        <label class="flex items-center gap-2 border p-2 rounded cursor-pointer">
            <input type="checkbox"> ${f}
        </label>`;
    });
    document.getElementById('facilityOptions').innerHTML = facilityHTML;

    // OFFERS
    let offerHTML = '';
    offersData[floor].forEach(o => {
        let benefits = o.benefits.map(b => `<li>✔ ${b}</li>`).join('');
        offerHTML += `
        <div class="border p-2 rounded">
            <label class="flex items-center gap-2">
                <input type="radio" name="offer">
                <div>
                    <b>${o.name}</b>
                    <div class="text-xs text-gray-500">Rp ${o.price}</div>
                    <ul class="text-xs">${benefits}</ul>
                </div>
            </label>
        </div>`;
    });
    document.getElementById('offerOptions').innerHTML = offerHTML;
}


// 🔥 EDIT
function openEdit(roomId, floor, price) {
    document.getElementById('editRoomId').value = roomId;
    document.getElementById('editFloor').value = floor;
    document.getElementById('editPrice').value = price;

    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

function fakeSave() {
    alert('Saved (UI only)');
    closeModal();
}


// INIT
renderRooms();
document.getElementById('addFloor').addEventListener('change', () => {
    setAddType();
    loadDynamicOptions();
});
</script>

@endsection