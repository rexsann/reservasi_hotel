@extends('Layouts.layout')

@section('styles')
    @vite(['resources/css/pages/room-types.css'])
@endsection

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="flash-success">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="flash-error">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9a1 1 0 112 0v4a1 1 0 11-2 0V9zm1-5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- Header --}}
<div class="page-header">
    <button onclick="openModalTambah()" class="btn-add">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Type
    </button>
</div>

{{-- Tabel --}}
<div class="table-wrap">
    <table>
        <thead>
            <tr>
                <th style="width:48px;">#</th>
                <th>Type Name</th>
                <th>Rooms</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="types-tbody">

            @forelse($types as $type)
            <tr id="row-{{ $type->id }}">

                {{-- Nomor --}}
                <td><span class="cell-no">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></td>

                {{-- Nama — normal & edit dalam satu td --}}
                <td>
                    <div id="name-display-{{ $type->id }}">
                        <div class="type-pill">
                            <span class="type-dot"></span>
                            <span class="type-name">{{ $type->name }}</span>
                        </div>
                    </div>
                    <div id="name-edit-{{ $type->id }}" style="display:none;">
                        <input
                            type="text"
                            id="input-{{ $type->id }}"
                            value="{{ $type->name }}"
                            class="inline-input">
                    </div>
                </td>

                {{-- Jumlah kamar --}}
                <td>
                    @if($type->rooms_count > 0)
                        <span class="room-count-badge">
                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            {{ $type->rooms_count }} rooms
                        </span>
                    @else
                        <span class="room-count-empty">No rooms yet</span>
                    @endif
                </td>

                {{-- Actions — normal & edit dalam satu td --}}
                <td>
                    <div id="actions-normal-{{ $type->id }}">
                        <div class="actions-cell">
                            <button onclick="startEdit({{ $type->id }})" class="btn-edit">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>
                            <form method="POST" action="{{ route('admin.room-types.destroy', $type->id) }}"
                                  onsubmit="return confirm('Delete type {{ $type->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    <div id="actions-edit-{{ $type->id }}" style="display:none;">
    <div class="actions-cell" style="display:flex; align-items:center; gap:6px;">
        <button onclick="saveEdit({{ $type->id }})" class="btn-save" style="width:auto !important; flex:none !important;">Save</button>
        <button onclick="cancelEdit({{ $type->id }}, '{{ addslashes($type->name) }}')" class="btn-cancel-edit" style="width:auto !important; flex:none !important;">Cancel</button>
    </div>
</div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="empty-td">
                    <div class="empty-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                        </svg>
                    </div>
                    <div class="empty-title">No room types yet</div>
                    <div class="empty-desc">Click "Add Type" to create your first room category.</div>
                </td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>

{{-- MODAL TAMBAH --}}
<div id="modal-tambah" class="modal-overlay" style="display:none;">
    <div class="modal-box">

        <div class="modal-topbar">
            <span class="modal-topbar-title">Add Room Type</span>
            <button type="button" onclick="closeModalTambah()" class="modal-close">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="modal-body">
            <form method="POST" action="{{ route('admin.room-types.store') }}">
                @csrf
                <label class="form-label">Type Name</label>
                <input
                    type="text"
                    name="name"
                    required
                    autofocus
                    placeholder="e.g. Deluxe, Suite, Standard…"
                    class="form-input">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-hint">This name will appear in the room assignment form.</p>

                <div class="modal-footer">
                    <button type="button" onclick="closeModalTambah()" class="btn-modal-cancel">Cancel</button>
                    <button type="submit" class="btn-modal-save">Save Type</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
// ── Buka / tutup modal tambah ────────────────────────────────
function openModalTambah() {
    document.getElementById('modal-tambah').style.display = 'flex';
}

function closeModalTambah() {
    document.getElementById('modal-tambah').style.display = 'none';
}

// Klik overlay untuk tutup modal
document.getElementById('modal-tambah').addEventListener('click', function(e) {
    if (e.target === this) closeModalTambah();
});

// ── State: simpan nama asli saat mulai edit ──────────────────
const originalNames = {};

// ── Mulai inline edit ────────────────────────────────────────
function startEdit(id) {
    originalNames[id] = document.getElementById('input-' + id).value;

    document.getElementById('name-display-' + id).style.display = 'none';
    document.getElementById('name-edit-' + id).style.display    = 'block';
    document.getElementById('actions-normal-' + id).style.display = 'none';
    document.getElementById('actions-edit-' + id).style.display   = 'block';

    document.getElementById('row-' + id).classList.add('editing');
    document.getElementById('input-' + id).focus();
}

// ── Batal edit ───────────────────────────────────────────────
function cancelEdit(id, originalName) {
    document.getElementById('input-' + id).value = originalNames[id] || originalName;

    document.getElementById('name-display-' + id).style.display   = 'block';
    document.getElementById('name-edit-' + id).style.display      = 'none';
    document.getElementById('actions-normal-' + id).style.display = 'block';
    document.getElementById('actions-edit-' + id).style.display   = 'none';

    document.getElementById('row-' + id).classList.remove('editing');
}

// ── Simpan edit via fetch (tanpa reload halaman) ─────────────
function saveEdit(id) {
    const input   = document.getElementById('input-' + id);
    const newName = input.value.trim();
    const oldName = originalNames[id];

    if (!newName) {
        input.focus();
        input.classList.add('error');
        return;
    }

    input.classList.remove('error');

    if (newName === oldName) {
        cancelEdit(id, oldName);
        return;
    }

    const btn = document.querySelector(`#actions-edit-${id} button:first-child`);
    btn.disabled    = true;
    btn.textContent = 'Saving...';

    fetch(`/admin/room-types/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept':       'application/json',
        },
        body: JSON.stringify({ name: newName })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`#name-display-${id} .type-name`).textContent = newName;
            originalNames[id] = newName;
            cancelEdit(id, newName);
            showToast(data.message || `Type renamed to "${newName}"`);
        } else {
            alert(data.message || 'Gagal menyimpan.');
            btn.disabled    = false;
            btn.textContent = 'Save';
        }
    })
    .catch(() => {
        alert('Terjadi kesalahan, coba lagi.');
        btn.disabled    = false;
        btn.textContent = 'Save';
    });
}

// ── Toast notifikasi ─────────────────────────────────────────
function showToast(msg) {
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> ${msg}`;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 2800);
}

// ── Enter untuk simpan, Escape untuk batal ───────────────────
document.addEventListener('keydown', function(e) {
    const active = document.activeElement;
    if (!active || !active.id.startsWith('input-')) return;
    const id = active.id.replace('input-', '');

    if (e.key === 'Enter')  { e.preventDefault(); saveEdit(id); }
    if (e.key === 'Escape') { cancelEdit(id, originalNames[id]); }
});
</script>

@endsection