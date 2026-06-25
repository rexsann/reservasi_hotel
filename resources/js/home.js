import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", () => {

    // ── Flatpickr date range ──────────────────────────────
    const el = document.querySelector("#dateRange");
    if (el) {
        flatpickr(el, {
            mode: "range",
            dateFormat: "d M Y",
            minDate: "today",
            showMonths: 2,
            disableMobile: true,
            onChange: function (selectedDates) {
                if (selectedDates.length === 2) {
                    const fmt = (d) => {
                        const year  = d.getFullYear();
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const day   = String(d.getDate()).padStart(2, '0');
                        return `${year}-${month}-${day}`;
                    };
                    document.getElementById('checkIn').value  = fmt(selectedDates[0]);
                    document.getElementById('checkOut').value = fmt(selectedDates[1]);
                }
            }
        });

        const checkIn  = document.getElementById('checkIn')?.value;
        const checkOut = document.getElementById('checkOut')?.value;
        if (checkIn && checkOut) {
            el._flatpickr.setDate([checkIn, checkOut]);
        }
    }

    // ── Restore dari URL ──────────────────────────────────
    const urlParams = new URLSearchParams(window.location.search);

    const savedRooms  = urlParams.get('rooms');
    const savedGuests = urlParams.get('guests');
    if (savedRooms) {
        const el = document.getElementById('roomsInput');
        if (el) el.value = savedRooms;
    }
    if (savedGuests) {
        const el = document.getElementById('guestsInput');
        if (el) el.value = savedGuests;
    }

    // ── Validasi guest saat input berubah ─────────────────
    const guestsInput = document.getElementById('guestsInput');
    const roomsInput  = document.getElementById('roomsInput');

    function validateGuests() {
        const rooms     = parseInt(roomsInput?.value)  || 1;
        const guests    = parseInt(guestsInput?.value) || 1;
        const maxGuests = rooms * 2;

        if (guests > maxGuests) {
            guestsInput.value = maxGuests;
            Swal.fire({
                icon: 'warning',
                title: 'Too Many Guests',
                html: `Maximum <b>${maxGuests} guests</b> for <b>${rooms} room${rooms > 1 ? 's' : ''}</b>.<br>Each room fits up to 2 guests.`,
                confirmButtonColor: '#2563eb',
                confirmButtonText: 'Got it',
            });
        }
    }

    if (guestsInput) guestsInput.addEventListener('change', validateGuests);
    if (roomsInput)  roomsInput.addEventListener('change', validateGuests);

    // ── Auto scroll ke #rooms setelah search ─────────────
    if (urlParams.get('check_in') && urlParams.get('check_out')) {
        setTimeout(() => {
            document.getElementById('rooms')?.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    }

});

// ── Search ────────────────────────────────────────────────

window.handleSearch = function () {
    const checkIn  = document.getElementById('checkIn').value;
    const checkOut = document.getElementById('checkOut').value;
    const rooms    = parseInt(document.getElementById('roomsInput')?.value)  || 1;
    const guests   = parseInt(document.getElementById('guestsInput')?.value) || 1;
    const maxGuests = rooms * 2;

    if (!checkIn || !checkOut) {
        Swal.fire({
            icon: 'warning',
            title: 'Date Required',
            text: 'Please select your check-in and check-out date.',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'OK',
        });
        return;
    }

    if (checkIn >= checkOut) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date',
            text: 'Check-out date must be after check-in date.',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Fix Date',
        });
        return;
    }

    if (guests > maxGuests) {
        Swal.fire({
            icon: 'warning',
            title: 'Too Many Guests',
            html: `You selected <b>${rooms} room${rooms > 1 ? 's' : ''}</b> but <b>${guests} guests</b>.<br>Maximum is <b>${maxGuests} guests</b> (2 per room).`,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'Got it',
        });
        return;
    }

    const params = new URLSearchParams({ check_in: checkIn, check_out: checkOut, rooms, guests });
    window.location.href = '/?' + params.toString() + '#rooms';
};

// ── Modal ─────────────────────────────────────────────────

window.openModal = function (btn) {
    document.getElementById('modalBadge').innerText     = btn.dataset.name;
    document.getElementById('modalTitle').innerText     = btn.dataset.name + ' Room';
    document.getElementById('modalBedText').innerText   = btn.dataset.bed;
    document.getElementById('modalGuestText').innerText = btn.dataset.guest;

    const facilities = btn.dataset.facilities.split(',');
    let html = '';
    facilities.forEach(f => {
        if (f.trim()) {
            html += `<li class="flex items-center gap-1 border border-gray-200 rounded-full px-3 py-1 text-gray-500 bg-gray-50">${f.trim()}</li>`;
        }
    });
    document.getElementById('modalFacilities').innerHTML = html;
    document.getElementById('roomModal').style.display  = 'flex';
};

window.closeModal = function () {
    document.getElementById('roomModal').style.display = 'none';
};

// ── Sidebar ───────────────────────────────────────────────

window.openOrderSidebar = function () {
    document.getElementById('orderSidebar').classList.remove('translate-x-full');
};

window.closeOrderSidebar = function () {
    document.getElementById('orderSidebar').classList.add('translate-x-full');
};

// ── Helpers ───────────────────────────────────────────────

function getNights() {
    const checkIn  = document.getElementById('checkIn')?.value;
    const checkOut = document.getElementById('checkOut')?.value;
    if (!checkIn || !checkOut) return 1;
    const diff = new Date(checkOut) - new Date(checkIn);
    return Math.max(1, Math.round(diff / (1000 * 60 * 60 * 24)));
}

function getRooms() {
    return parseInt(document.getElementById('roomsInput')?.value) || 1;
}

// ── Order logic ───────────────────────────────────────────

let selectedOrders = [];

window.addToOrder = function (button) {
    const required = getRooms();

    if (selectedOrders.length >= required) {
        Swal.fire({
            icon: 'warning',
            title: 'Room Limit Reached',
            html: `You can only select <b>${required} room${required > 1 ? 's' : ''}</b> based on your request.<br>Remove a room first or increase your room count.`,
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'OK',
        });
        return;
    }

    selectedOrders.push({
        id:         Date.now(),
        room:       button.dataset.room,
        roomTypeId: button.dataset.roomTypeId,
        offerId:    button.dataset.offerId,
        package:    button.dataset.package,
        price:      parseInt(button.dataset.price),
    });

    renderOrders();
    updateBookingLink();

    const count = selectedOrders.length;
    document.getElementById('orderCount').innerText   = count;
    document.getElementById('sidebarCount').innerText = count + ' rooms';
    document.getElementById('viewOrderBtn').classList.remove('hidden');
    document.getElementById('viewOrderBtn').classList.add('flex');
};

window.removeOrder = function (id) {
    selectedOrders = selectedOrders.filter(item => item.id !== id);

    renderOrders();
    updateBookingLink();

    const count = selectedOrders.length;
    document.getElementById('orderCount').innerText   = count;
    document.getElementById('sidebarCount').innerText = count + ' rooms';

    if (count === 0) {
        document.getElementById('viewOrderBtn').classList.add('hidden');
        document.getElementById('viewOrderBtn').classList.remove('flex');
    }
};

function renderOrders() {
    const orderList = document.getElementById('orderList');
    const nights    = getNights();
    const required  = getRooms();
    const count     = selectedOrders.length;
    let total = 0;
    let html  = '';

    if (selectedOrders.length === 0) {
        html = `<div class="text-center text-gray-400 text-sm py-12">No reservation selected yet</div>`;
    } else {
        selectedOrders.forEach(item => {
            const itemTotal = item.price * nights;
            total += itemTotal;
            html  += `
                <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:mb-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">${item.room}</p>
                            <p class="text-xs text-gray-500 mt-0.5">${item.package}</p>
                            <p class="text-xs text-gray-400 mt-0.5">1 room · ${nights} night${nights > 1 ? 's' : ''}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                            <button onclick="removeOrder(${item.id})"
                                class="text-xs text-red-400 hover:text-red-600 mt-1">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    orderList.innerHTML = html;
    document.getElementById('sidebarTotal').innerText = 'Rp ' + total.toLocaleString('id-ID');

    const bookingLink  = document.getElementById('bookingLink');
    const progressHint = document.getElementById('roomProgressHint');

    if (count < required) {
        if (bookingLink) {
            bookingLink.classList.add('opacity-50', 'pointer-events-none');
        }
        if (progressHint) {
            progressHint.innerText = `Select ${required - count} more room${(required - count) > 1 ? 's' : ''} (${count}/${required})`;
            progressHint.classList.remove('hidden');
        }
    } else {
        if (progressHint) {
            progressHint.classList.add('hidden');
        }
        updateBookingLink();
    }
}

// ── Update link "View reservation" ───────────────────────

function updateBookingLink() {
    const link     = document.getElementById('bookingLink');
    const required = getRooms();
    if (!link) return;

    if (selectedOrders.length === 0 || selectedOrders.length < required) {
        link.href = '#';
        link.classList.add('opacity-50', 'pointer-events-none');
        return;
    }

    link.classList.remove('opacity-50', 'pointer-events-none');

    const checkIn  = document.getElementById('checkIn')?.value  || '';
    const checkOut = document.getElementById('checkOut')?.value || '';
    const nights   = getNights();
    const rooms    = getRooms();
    const total    = selectedOrders.reduce((s, i) => s + i.price * nights, 0);
    const guests   = document.getElementById('guestsInput')?.value || 1;

    const params = new URLSearchParams({
        check_in:    checkIn,
        check_out:   checkOut,
        guest_total: guests,
        rooms:       rooms,
        total_price: total,
    });

    selectedOrders.forEach(item => {
        params.append('room_type_ids[]', item.roomTypeId);
        params.append('offer_ids[]', item.offerId);
    });

    link.href = '/booking?' + params.toString();
}