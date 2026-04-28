@extends('Layouts.layout')

@section('content')

<style>
.table-scroll-wrap {
    max-height: 300px;
    overflow-y: auto;
    border-radius: 0 0 10px 10px;
}
.table-scroll-wrap::-webkit-scrollbar { width: 4px; }
.table-scroll-wrap::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

.room-table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed;
    font-size: 13px;
}

/* Lebar kolom no auto */
.room-table col.c-id     { width: 52px; }
.room-table col.c-room   { width: 130px; }
.room-table col.c-offer  { width: 200px; }
.room-table col.c-price  { width: 160px; }
.room-table col.c-status { width: 130px; }
.room-table col.c-action { width: 90px; }

.room-table thead { position: sticky; top: 0; z-index: 5; }
.room-table thead tr { background: #1e293b; }
.room-table th {
    padding: 11px 14px;
    text-align: left;
    font-size: 11px;
    font-weight: 600;
    color: #ffffff;             
    letter-spacing: 0.06em;
    text-transform: uppercase;
    white-space: nowrap;
}
.room-table th.th-c { text-align: center; }

.room-table tbody tr { border-top: 1px solid #f1f5f9; transition: background 0.1s; }
.room-table tbody tr:hover { background: #f8fafc; }
.room-table td {
    padding: 11px 14px;
    color: #1e293b;
    vertical-align: middle;
    font-size: 13px;
}
.room-table td.td-c    { text-align: center; }
.room-table td.td-id   { color: #94a3b8; font-size: 12px; text-align: center; }
.room-table td.td-room { font-weight: 600; font-size: 13px; }
.room-table td.td-price{ font-weight: 600; color: #0f172a; }

.fac-row {
    display: flex; align-items: center; gap: 6px;
    flex-wrap: wrap;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}
.fac-label { font-size: 12px; color: #94a3b8; flex-shrink: 0; }
.fac-tag {
    font-size: 11px; background: #eff6ff; color: #1d4ed8;
    padding: 3px 10px; border-radius: 5px;
    border: 1px solid #bfdbfe; white-space: nowrap;
}

.status-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 99px;
    font-size: 11px; font-weight: 500; border: 1px solid;
    white-space: nowrap;
}
.status-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.s-available   { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
.s-available   .status-dot { background:#22c55e; }
.s-occupied    { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
.s-occupied    .status-dot { background:#3b82f6; }
.s-maintenance { background:#fffbeb; color:#b45309; border-color:#fde68a; }
.s-maintenance .status-dot { background:#f59e0b; }

.btn-edit {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 11px; font-weight: 500; color: #2563eb;
    background: #eff6ff; border: 1px solid #bfdbfe;
    padding: 4px 11px; border-radius: 6px; cursor: pointer;
    transition: background 0.15s;
}
.btn-edit:hover { background: #dbeafe; }
.btn-edit svg  { width: 11px; height: 11px; }

.pill {
    font-size: 11px; font-weight: 500;
    padding: 3px 11px; border-radius: 99px; border: 1px solid;
}
.pill-green { background:#f0fdf4; color:#15803d; border-color:#bbf7d0; }
.pill-blue  { background:#eff6ff; color:#1d4ed8; border-color:#bfdbfe; }
.pill-amber { background:#fffbeb; color:#b45309; border-color:#fde68a; }

/* MODAL */
.modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(15,23,42,0.55);
    z-index: 100; align-items: center; justify-content: center;
}
.modal-overlay.open { display: flex; }
.modal {
    background: #fff; border-radius: 12px;
    width: 400px; padding: 28px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
}
.modal-title { font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 4px; }
.modal-sub   { font-size: 12px; color: #94a3b8; margin-bottom: 20px; }
.form-group  { margin-bottom: 16px; }
.form-label  { font-size: 12px; font-weight: 500; color: #475569; margin-bottom: 6px; display: block; }
.form-select, .form-input {
    width: 100%; padding: 9px 12px;
    border: 1px solid #cbd5e1; border-radius: 8px;
    font-size: 13px; color: #0f172a; background: #fff;
    outline: none; transition: border 0.15s;
}
.form-select:focus, .form-input:focus { border-color: #3b82f6; }
.modal-actions { display: flex; gap: 8px; justify-content: flex-end; margin-top: 24px; }
.btn-cancel {
    padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
    border: 1px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer;
}
.btn-cancel:hover { background: #f8fafc; }
.btn-save {
    padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 500;
    border: none; background: #2563eb; color: #fff; cursor: pointer;
}
.btn-save:hover { background: #1d4ed8; }
</style>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rooms Management</h1>
        <p class="text-sm text-gray-400 mt-1">Manage hotel room data</p>
    </div>
</div>

<div id="roomContainer"></div>

<!-- MODAL EDIT OFFER -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <div class="modal-title">Edit Room Offer</div>
        <div class="modal-sub" id="modalSub"></div>
        <div class="form-group">
            <label class="form-label">Offer Package</label>
            <select class="form-select" id="editOffer"></select>
        </div>
        <div class="form-group">
            <label class="form-label">Price (Rp)</label>
            <input class="form-input" type="text" id="editPrice" readonly>
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Cancel</button>
            <button class="btn-save" onclick="saveEdit()">Save Changes</button>
        </div>
    </div>
</div>

<script>
const facilitiesData = {
    1: ['WiFi', 'AC'],
    2: ['WiFi', 'TV', 'AC'],
    3: ['WiFi', 'TV', 'AC', 'Mini Fridge']
};

const offersData = {
    1: [
        { name: 'Room Only',         price: 300000 },
        { name: 'Breakfast Package', price: 350000 },
        { name: 'Staycation Deal',   price: 400000 }
    ],
    2: [
        { name: 'Business Stay',  price: 500000 },
        { name: 'Family Package', price: 600000 },
        { name: 'Weekend Deal',   price: 650000 }
    ],
    3: [
        { name: 'Luxury Stay',       price:  750000 },
        { name: 'Honeymoon Package', price:  900000 },
        { name: 'VIP Experience',    price: 1100000 }
    ]
};

const tipeMap = { 1: 'Standard', 2: 'Superior', 3: 'Deluxe' };

const rooms = [];
let idCounter = 1;
for (let floor = 1; floor <= 3; floor++) {
    for (let i = 0; i < 15; i++) {
        const offerIndex = Math.floor(i / 5);
        const offer = offersData[floor][offerIndex];
        rooms.push({
            id:          idCounter++,
            room_number: String(floor) + String(i + 1).padStart(2, '0'),
            floor,
            offer_name:  offer.name,
            offer_price: offer.price,
            status: (i + 1) % 5 === 0 ? 'maintenance'
                  : (i + 1) % 3 === 0 ? 'occupied'
                  : 'available'
        });
    }
}

const statusCls   = { available: 's-available', occupied: 's-occupied', maintenance: 's-maintenance' };
const statusLabel = { available: 'Available',   occupied: 'Occupied',   maintenance: 'Maintenance'   };

function fmt(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
function countStatus(arr, s) { return arr.filter(r => r.status === s).length; }

let editingId = null;

function openEdit(id) {
    const room = rooms.find(r => r.id === id);
    if (!room) return;
    editingId = id;
    document.getElementById('modalSub').textContent = 'Room ' + room.room_number;

    const offers = offersData[room.floor];
    const sel = document.getElementById('editOffer');
    sel.innerHTML = offers.map((o, i) =>
        `<option value="${i}" ${o.name === room.offer_name ? 'selected' : ''}>${o.name}</option>`
    ).join('');

    const chosen = offers.find(o => o.name === room.offer_name);
    document.getElementById('editPrice').value = fmt(chosen ? chosen.price : offers[0].price);

    sel.onchange = function () {
        const o = offers[parseInt(this.value)];
        document.getElementById('editPrice').value = fmt(o.price);
    };

    document.getElementById('editModal').classList.add('open');
}

function closeModal() {
    document.getElementById('editModal').classList.remove('open');
    editingId = null;
}

function saveEdit() {
    if (!editingId) return;
    const room  = rooms.find(r => r.id === editingId);
    const sel   = document.getElementById('editOffer');
    const offer = offersData[room.floor][parseInt(sel.value)];
    room.offer_name  = offer.name;
    room.offer_price = offer.price;
    closeModal();
    renderRooms();
}

function renderRooms() {
    const container = document.getElementById('roomContainer');
    container.innerHTML = '';

    [1, 2, 3].forEach(floor => {
        const tipe     = tipeMap[floor];
        const filtered = rooms.filter(r => r.floor === floor);
        const offers   = offersData[floor];
        const minP     = Math.min(...offers.map(o => o.price));
        const maxP     = Math.max(...offers.map(o => o.price));

        const avail = countStatus(filtered, 'available');
        const occup = countStatus(filtered, 'occupied');
        const maint = countStatus(filtered, 'maintenance');

        const facTags = facilitiesData[floor]
            .map(f => `<span class="fac-tag">${f}</span>`).join('');

        let rows = '';
        filtered.forEach((room) => {
            const sc = statusCls[room.status];
            const sl = statusLabel[room.status];
            rows += `
            <tr>
                <td class="td-id td-c">${room.id}</td>
                <td class="td-room">Room ${room.room_number}</td>
                <td>${room.offer_name}</td>
                <td class="td-price">${fmt(room.offer_price)}</td>
                <td class="td-c">
                    <span class="status-badge ${sc}">
                        <span class="status-dot"></span>${sl}
                    </span>
                </td>
                <td class="td-c">
                    <button class="btn-edit" onclick="openEdit(${room.id})">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                </td>
            </tr>`;
        });

        container.innerHTML += `
        <div class="mb-8">
            <div class="bg-white border border-gray-200 rounded-t-xl px-5 py-4">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h2 class="font-bold text-gray-800 text-base">
                            ${tipe}
                            <span class="text-gray-400 font-normal text-sm">&middot; Floor ${floor}</span>
                        </h2>
                        <p class="text-xs text-gray-400 mt-0.5">${fmt(minP)} &ndash; ${fmt(maxP)} / night</p>
                    </div>
                    <div class="flex gap-2 flex-wrap justify-end">
                        <span class="pill pill-green">${avail} Available</span>
                        <span class="pill pill-blue">${occup} Occupied</span>
                        <span class="pill pill-amber">${maint} Maintenance</span>
                    </div>
                </div>
                <div class="fac-row">
                    <span class="fac-label">Facilities:</span>
                    ${facTags}
                </div>
            </div>
            <div class="bg-white border border-gray-200 border-t-0 rounded-b-xl overflow-hidden">
                <div class="table-scroll-wrap">
                    <table class="room-table">
                        <colgroup>
                            <col class="c-id">
                            <col class="c-room">
                            <col class="c-offer">
                            <col class="c-price">
                            <col class="c-status">
                            <col class="c-action">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="th-c">ID</th>
                                <th>Room</th>
                                <th>Offer</th>
                                <th>Price / Night</th>
                                <th class="th-c">Status</th>
                                <th class="th-c">Action</th>
                            </tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            </div>
        </div>`;
    });
}

renderRooms();

document.getElementById('editModal').addEventListener('click', function (e) {
    if (e.target === this) closeModal();
});
</script>

@endsection