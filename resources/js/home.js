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
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    const fmt = (d) => d.toISOString().split('T')[0];
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

// ── Global functions (dipanggil dari onclick di blade) ────

window.handleSearch = function() {
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

window.openModal = function(btn) {
    document.getElementById('modalBadge').innerText    = btn.dataset.name;
    document.getElementById('modalTitle').innerText    = btn.dataset.name + ' Room';
    document.getElementById('modalBedText').innerText  = btn.dataset.bed;
    document.getElementById('modalGuestText').innerText = btn.dataset.guest;

    const facilities = btn.dataset.facilities.split(',');
    let html = '';
    facilities.forEach(f => {
        if (f.trim()) {
            html += `<li class="flex items-center gap-1 border border-gray-200 rounded-full px-3 py-1 text-gray-500 bg-gray-50">${f.trim()}</li>`;
        }
    });
    document.getElementById('modalFacilities').innerHTML = html;
    document.getElementById('roomModal').style.display = 'flex';
};

window.closeModal = function() {
    document.getElementById('roomModal').style.display = 'none';
};

window.openOrderSidebar = function() {
    document.getElementById('orderSidebar').classList.remove('translate-x-full');
};

window.closeOrderSidebar = function() {
    document.getElementById('orderSidebar').classList.add('translate-x-full');
};

// ── Order logic ───────────────────────────────────────────

let selectedOrders = [];

window.addToOrder = function(button) {
    const room    = button.dataset.room;
    const pkg     = button.dataset.package;
    const price   = parseInt(button.dataset.price);

    selectedOrders.push({ id: Date.now(), room, package: pkg, price });

    renderOrders();
    document.getElementById('orderCount').innerText = selectedOrders.length;
    document.getElementById('sidebarCount').innerText = selectedOrders.length + ' rooms';
    document.getElementById('viewOrderBtn').classList.remove('hidden');
    document.getElementById('viewOrderBtn').classList.add('flex');
};

window.removeOrder = function(id) {
    selectedOrders = selectedOrders.filter(item => item.id !== id);
    renderOrders();

    const count = selectedOrders.length;
    document.getElementById('orderCount').innerText = count;
    document.getElementById('sidebarCount').innerText = count + ' rooms';

    if (count === 0) {
        document.getElementById('viewOrderBtn').classList.add('hidden');
        document.getElementById('viewOrderBtn').classList.remove('flex');
    }
};

function renderOrders() {
    const orderList = document.getElementById('orderList');
    let total = 0;
    let html  = '';

    if (selectedOrders.length === 0) {
        html = `<div class="text-center text-gray-400 text-sm py-12">No reservation selected yet</div>`;
    } else {
        selectedOrders.forEach(item => {
            total += item.price;
            html  += `
                <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:mb-0">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-900">${item.room}</p>
                            <p class="text-xs text-gray-500 mt-0.5">${item.package}</p>
                            <p class="text-xs text-gray-400 mt-0.5">1 room · 1 night</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">Rp ${item.price.toLocaleString('id-ID')}</p>
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