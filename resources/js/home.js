import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

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

        // Restore tampilan kalau balik dari hasil search
        const checkIn  = document.getElementById('checkIn')?.value;
        const checkOut = document.getElementById('checkOut')?.value;

        if (checkIn && checkOut) {
            el._flatpickr.setDate([checkIn, checkOut]);
        }
    }

    // ── Auto scroll ke #rooms setelah search ─────────────
    const urlParams = new URLSearchParams(window.location.search);
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

    if (!checkIn || !checkOut) {
        alert('Please select check-in and check-out date');
        return;
    }

    if (checkIn >= checkOut) {
        alert('Check-out must be after check-in');
        return;
    }

    const params = new URLSearchParams({ check_in: checkIn, check_out: checkOut });
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

// ── Order logic ───────────────────────────────────────────

let selectedOrders = [];

window.addToOrder = function (button) {
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
    document.getElementById('orderCount').innerText    = count;
    document.getElementById('sidebarCount').innerText  = count + ' rooms';
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
}

// ── Update link "View reservation" ───────────────────────

function updateBookingLink() {
    const link = document.getElementById('bookingLink');
    if (!link) return;

    if (selectedOrders.length === 0) {
        link.href = '#';
        link.classList.add('opacity-50', 'pointer-events-none');
        return;
    }

    link.classList.remove('opacity-50', 'pointer-events-none');

    const checkIn  = document.getElementById('checkIn')?.value  || '';
    const checkOut = document.getElementById('checkOut')?.value || '';
    const nights   = getNights();
    const total    = selectedOrders.reduce((s, i) => s + i.price * nights, 0);
    const guests   = document.getElementById('guestsInput')?.value || 1;

    const params = new URLSearchParams({
        check_in:    checkIn,
        check_out:   checkOut,
        guest_total: guests,
        total_price: total,
    });

    selectedOrders.forEach(item => {
        params.append('room_type_ids[]', item.roomTypeId);
        params.append('offer_ids[]', item.offerId);
    });

    link.href = '/booking?' + params.toString();
}