 

    <script>
    // ════════════════════════════════════════════════════════════
    // STATE
    // ════════════════════════════════════════════════════════════
    const availableRooms = {
        'Standard': ['101','103','105','106'],
        'Superior': ['201','202','204','207'],
        'Deluxe':   ['301','302','309'],
    };

    let currentEditId    = null;   // numeric id dari data-id row
    let currentEditItems = [];     // array item offer
    let currentKode      = '';
    let currentEmail     = '';

    // ════════════════════════════════════════════════════════════
    // HELPERS
    // ════════════════════════════════════════════════════════════
    function generateKode(id) {
        // Format: RSV-YYMMDD-NNN
        const now = new Date();
        const yy  = String(now.getFullYear()).slice(2);
        const mm  = String(now.getMonth() + 1).padStart(2, '0');
        const dd  = String(now.getDate()).padStart(2, '0');
        return `RSV-${yy}${mm}${dd}-${String(id).padStart(3, '0')}`;
    }

    function getRow(id)         { return document.getElementById('row-' + id); }
    function getRowData(rowEl)  { return rowEl ? rowEl.dataset : {}; }

    // ════════════════════════════════════════════════════════════
    // TAB SWITCH
    // ════════════════════════════════════════════════════════════
    function switchTab(tab) {
        const isAktif = tab === 'aktif';
        document.getElementById('panel-aktif').classList.toggle('hidden', !isAktif);
        document.getElementById('panel-riwayat').classList.toggle('hidden', isAktif);
        document.getElementById('tab-aktif').className = isAktif
            ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
            : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
        document.getElementById('tab-riwayat').className = !isAktif
            ? 'tab-btn px-4 py-2.5 border-b-2 border-blue-600 text-blue-600 transition'
            : 'tab-btn px-4 py-2.5 border-b-2 border-transparent text-gray-400 hover:text-gray-600 transition';
    }

    // ════════════════════════════════════════════════════════════
    // EXPAND DETAIL ROW
    // ════════════════════════════════════════════════════════════
    function toggleDetail(detailId, btn) {
        const row  = document.getElementById(detailId);
        const icon = btn.querySelector('svg');
        const isHidden = row.classList.toggle('hidden');
        icon.style.transform = isHidden ? '' : 'rotate(180deg)';
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — BUKA
    // ════════════════════════════════════════════════════════════
    function openEdit(id) {
        const row = getRow(id);
        if (!row) return;

        currentEditId    = id;
        currentEditItems = JSON.parse(row.dataset.items || '[]');

        // Isi form
        document.getElementById('edit-modal-title').textContent = 'Edit Reservasi #' + String(id).padStart(3,'0');
        document.getElementById('edit-modal-sub').textContent   = row.dataset.name + ' · ' + row.dataset.email;
        document.getElementById('e-name').value     = row.dataset.name;
        document.getElementById('e-email').value    = row.dataset.email;
        document.getElementById('e-checkin').value  = row.dataset.checkin;
        document.getElementById('e-checkout').value = row.dataset.checkout;
        document.getElementById('e-status').value   = row.dataset.status;

        // Tampilkan ringkasan offer
        const display = document.getElementById('e-items-display');
        display.innerHTML = currentEditItems.map(item => `
            <div class="flex items-center justify-between bg-gray-50 border border-gray-100 rounded-lg px-3 py-2 text-sm">
                <span class="font-medium text-gray-700">${item.name}</span>
                <span class="text-xs text-gray-400">${item.tipe} · Rp ${Number(item.harga).toLocaleString('id-ID')}/malam</span>
            </div>`).join('');

        onStatusChange(); // render assign kamar / warning sesuai status awal

        // Buka modal
        const modal = document.getElementById('modal-edit');
        if (typeof FlowbiteInstances !== 'undefined') {
            (FlowbiteInstances.getInstance('Modal','modal-edit') ?? new Modal(modal)).show();
        } else {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — REAKSI PERUBAHAN STATUS
    // ════════════════════════════════════════════════════════════
    function onStatusChange() {
        const status   = document.getElementById('e-status').value;
        const wrap     = document.getElementById('e-room-assign-wrap');
        const list     = document.getElementById('e-room-assign-list');
        const warning  = document.getElementById('e-cancel-warning');

        warning.classList.add('hidden');
        wrap.classList.add('hidden');

        if (status === 'check_in') {
            // Tampilkan assign kamar
            wrap.classList.remove('hidden');
            list.innerHTML = currentEditItems.map((item, idx) => {
                const rooms = availableRooms[item.tipe] || [];
                const opts  = rooms.map(r =>
                    `<option value="${r}" ${item.nomor_kamar === r ? 'selected' : ''}>Kamar ${r}</option>`
                ).join('');
                return `
                <div class="bg-white border border-gray-100 rounded-lg p-3">
                    <p class="text-xs font-semibold text-gray-700 mb-1.5">
                        ${idx + 1}. ${item.name}
                        <span class="font-normal text-gray-400">(${item.tipe})</span>
                    </p>
                    <select id="e-kamar-${idx}"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Pilih nomor kamar --</option>
                        ${opts}
                    </select>
                </div>`;
            }).join('');

        } else if (status === 'canceled') {
            warning.classList.remove('hidden');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — SIMPAN
    // ════════════════════════════════════════════════════════════
    function saveEdit() {
        const status   = document.getElementById('e-status').value;
        const checkin  = document.getElementById('e-checkin').value;
        const checkout = document.getElementById('e-checkout').value;
        const id       = currentEditId;

        if (checkout <= checkin) {
            alert('Check Out harus setelah Check In!');
            return;
        }

        // Validasi: kalau check_in, semua kamar harus dipilih
        let assignedRooms = [];
        if (status === 'check_in') {
            for (let i = 0; i < currentEditItems.length; i++) {
                const val = document.getElementById('e-kamar-' + i)?.value;
                if (!val) {
                    alert(`Nomor kamar untuk "${currentEditItems[i].name}" belum dipilih!`);
                    return;
                }
                assignedRooms.push(val);
            }
        }

        const row = getRow(id);
        if (!row) { closeEditModal(); return; }

        if (status === 'canceled') {
            // ── Pindahkan ke history sebagai canceled
            moveToHistory(id, 'canceled');
            closeEditModal();
            return;
        }

        if (status === 'check_in') {
            // ── Generate kode
            const kode = generateKode(id);

            // Update dataset row
            row.dataset.status = 'check_in';
            row.dataset.kode   = kode;

            // Update kolom kode di tabel
            document.getElementById('kode-' + id).innerHTML =
                `<span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">${kode}</span>`;

            // Update status badge
            document.getElementById('status-badge-' + id).innerHTML =
                `<span class="text-xs font-semibold px-2 py-1 rounded-full bg-green-100 text-green-700">Check In</span>`;

            // Update kolom kamar (kamar pertama untuk row single, atau tetap "N Rooms")
            if (currentEditItems.length === 1) {
                document.getElementById('kamar-' + id).innerHTML =
                    `<span class="text-xs font-semibold bg-gray-100 px-2 py-1 rounded-lg">${assignedRooms[0]}</span>`;
            }

            // Update tombol Actions → Invoice + Check Out + Cancel
            document.getElementById('actions-' + id).innerHTML = `
                <div class="flex justify-center gap-2 flex-wrap">
                    <button onclick="showInvoice('${kode}','${row.dataset.email}','${row.dataset.name}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-green-600 text-white hover:bg-green-700 transition">
                        Invoice
                    </button>
                    <button onclick="doCheckOut('row-${id}','detail-${id}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-gray-700 text-white hover:bg-gray-800 transition">
                        Check Out
                    </button>
                    <button onclick="cancelRow('row-${id}','detail-${id}','${id}')"
                        class="text-xs px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 border border-red-200 transition">
                        Cancel
                    </button>
                </div>`;

            // Auto-tampilkan invoice/kode setelah simpan
            closeEditModal();
            showInvoice(kode, row.dataset.email, row.dataset.name);
            return;
        }

        // Status tetap pending — hanya update data
        row.dataset.checkin  = checkin;
        row.dataset.checkout = checkout;

        closeEditModal();
    }

    // ════════════════════════════════════════════════════════════
    // CANCEL ROW (dari tombol Cancel langsung, tanpa modal)
    // ════════════════════════════════════════════════════════════
    function cancelRow(rowId, detailId, id) {
        if (!confirm('Batalkan reservasi ini? Data akan pindah ke History.')) return;
        moveToHistory(id, 'canceled');
    }

    // ════════════════════════════════════════════════════════════
    // CHECK OUT (dari tombol Check Out langsung)
    // ════════════════════════════════════════════════════════════
    function doCheckOut(rowId, detailId) {
        const id = rowId.replace('row-', '');
        if (!confirm('Tandai tamu ini sebagai Checked Out?')) return;
        moveToHistory(id, 'checked_out');
    }

    // ════════════════════════════════════════════════════════════
    // PINDAHKAN BARIS KE HISTORY
    // ════════════════════════════════════════════════════════════
    function moveToHistory(id, newStatus) {
        const row       = document.getElementById('row-' + id);
        const detailRow = document.getElementById('detail-' + id);
        if (!row) return;

        const d           = row.dataset;
        const items       = JSON.parse(d.items || '[]');
        const nights      = Math.round((new Date(d.checkout) - new Date(d.checkin)) / 86400000);
        const total       = nights * parseInt(d.total || 0);
        const kode        = d.kode || '';
        const isCanceled  = newStatus === 'canceled';
        const statusBadge = isCanceled
            ? `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200"><span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Canceled</span>`
            : `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200"><span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Checked Out</span>`;
        const totalHtml   = isCanceled
            ? `<span class="text-xs text-red-400 line-through">Rp ${total.toLocaleString('id-ID')}</span>`
            : `<span class="font-semibold text-green-700">Rp ${total.toLocaleString('id-ID')}</span>`;
        const roomHtml    = items.length > 1
            ? `<span class="text-xs font-semibold bg-purple-50 text-purple-700 px-2 py-1 rounded-lg">${items.length} Rooms</span>`
            : `<p class="text-xs font-semibold text-gray-800">${items[0]?.name ?? ''}</p><p class="text-xs text-gray-400">Room ${items[0]?.nomor_kamar ?? '—'} · ${items[0]?.tipe ?? ''}</p>`;

        const newRow = `
        <tr class="hover:bg-gray-50 transition">
            <td class="px-4 py-3"></td>
            <td class="px-4 py-3 text-gray-400 text-xs font-medium">#${id}</td>
            <td class="px-4 py-3">
                ${kode ? `<span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">${kode}</span>` : '<span class="text-xs text-gray-300">—</span>'}
            </td>
            <td class="px-4 py-3"><p class="font-semibold text-gray-800">${d.name}</p><p class="text-xs text-gray-400">${d.email}</p></td>
            <td class="px-4 py-3">${roomHtml}</td>
            <td class="px-4 py-3 text-gray-700 font-medium">${d.checkin}</td>
            <td class="px-4 py-3"><p class="text-gray-700 font-medium">${d.checkout}</p><p class="text-xs text-gray-400">${nights} nights</p></td>
            <td class="px-4 py-3">${totalHtml}</td>
            <td class="px-4 py-3">${statusBadge}</td>
        </tr>`;

        document.getElementById('riwayat-table-body').insertAdjacentHTML('afterbegin', newRow);

        // Hapus dari tabel aktif
        row.remove();
        detailRow?.remove();
    }

    // ════════════════════════════════════════════════════════════
    // INVOICE MODAL
    // ════════════════════════════════════════════════════════════
    function showInvoice(kode, email, name) {
        currentKode  = kode;
        currentEmail = email;
        document.getElementById('inv-code').textContent = kode;
        document.getElementById('inv-guest').textContent = name + ' · ' + email;
        document.getElementById('modal-invoice').classList.remove('hidden');
    }

    function closeInvoice() {
        document.getElementById('modal-invoice').classList.add('hidden');
    }

    function sendInvoiceEmail() {
        fetch('/send-booking-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: currentEmail, kode: currentKode })
        })
        .then(res => res.json())
        .then(() => { alert('Kode reservasi berhasil dikirim ke ' + currentEmail); closeInvoice(); })
        .catch(() => alert('Gagal mengirim email, coba lagi.'));
    }

    // ════════════════════════════════════════════════════════════
    // MODAL EDIT — TUTUP
    // ════════════════════════════════════════════════════════════
    function closeEditModal() {
        const modal = document.getElementById('modal-edit');
        if (typeof FlowbiteInstances !== 'undefined') {
            FlowbiteInstances.getInstance('Modal','modal-edit')?.hide();
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // ════════════════════════════════════════════════════════════
    // MODAL TAMBAH — FORM HELPERS
    // ════════════════════════════════════════════════════════════
    function updateOfferCount() {
        const checked = document.querySelectorAll('.offer-checkbox:checked');
        const badge   = document.getElementById('f-offer-count');
        if (checked.length > 0) {
            badge.textContent = checked.length + ' dipilih';
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    }

    function hitungEstimasi() {
        const checkin  = document.getElementById('f-checkin').value;
        const checkout = document.getElementById('f-checkout').value;
        const checked  = document.querySelectorAll('.offer-checkbox:checked');

        if (!checkin || !checkout || checked.length === 0 || checkout <= checkin) {
            document.getElementById('f-estimasi').classList.add('hidden');
            return;
        }

        const nights = Math.round((new Date(checkout) - new Date(checkin)) / 86400000);
        let totalHarga = 0;
        let breakdownHtml = '';

        checked.forEach(cb => {
            const label = cb.closest('label');
            const harga = parseInt(label.dataset.harga);
            const name  = label.dataset.name;
            totalHarga += harga;
            breakdownHtml += `<p class="text-xs text-blue-600">${name}: ${nights} × Rp ${harga.toLocaleString('id-ID')} = Rp ${(nights*harga).toLocaleString('id-ID')}</p>`;
        });

        document.getElementById('f-estimasi-breakdown').innerHTML = breakdownHtml;
        document.getElementById('f-estimasi-total').textContent = 'Rp ' + (nights * totalHarga).toLocaleString('id-ID');
        document.getElementById('f-estimasi').classList.remove('hidden');
    }

    // ════════════════════════════════════════════════════════════
    // MODAL TAMBAH — SIMPAN
    // ════════════════════════════════════════════════════════════
async function saveReservation() {

    const name      = document.getElementById('f-name').value.trim();
    const email     = document.getElementById('f-email').value.trim();
    const checkin   = document.getElementById('f-checkin').value;
    const checkout  = document.getElementById('f-checkout').value;
    const checked   = document.querySelectorAll('.offer-checkbox:checked');

    // VALIDATION
    if (!name || !email || !checkin || !checkout || checked.length === 0) {
        alert('Please complete all fields.');
        return;
    }

    if (checkout <= checkin) {
        alert('Check out date must be after check in.');
        return;
    }

    // Ambil offer id
    let offers = [];

    checked.forEach(cb => {
        offers.push(cb.value);
    });

    try {

        const response = await fetch('/reservations/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },

            body: JSON.stringify({
                name: name,
                email: email,
                check_in: checkin,
                check_out: checkout,
                offers: offers
            })
        });

        const result = await response.json();

        if (result.success) {

            alert('Reservation created successfully.');

            // reset form
            document.getElementById('f-name').value = '';
            document.getElementById('f-email').value = '';
            document.getElementById('f-checkin').value = '';
            document.getElementById('f-checkout').value = '';

            document.querySelectorAll('.offer-checkbox')
                .forEach(cb => cb.checked = false);

            document.getElementById('f-estimasi')
                .classList.add('hidden');

            document.getElementById('f-offer-count')
                .classList.add('hidden');

            // close modal
            if (typeof FlowbiteInstances !== 'undefined') {
                FlowbiteInstances
                    .getInstance('Modal','modal-tambah')
                    ?.hide();
            }

            // reload table dari database
            location.reload();

        } else {

            alert(result.message || 'Failed to save reservation.');

        }

    } catch(error) {

        console.error(error);
        alert('Server error.');

    }
}
    </script>
@endsection