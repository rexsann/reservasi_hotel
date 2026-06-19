@extends('Layouts.layout')

@section('styles')
    @vite(['resources/css/pages/room-types.css'])
@endsection

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="rt-flash rt-flash-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="rt-flash rt-flash-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

{{-- Header --}}
<div class="rt-header">
    <button onclick="openRtModal()" class="rt-btn-add">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Room Type
    </button>
</div>

{{-- Tabel --}}
<div class="rt-table-wrap">
    <table class="rt-table">
        <thead>
            <tr>
                <th class="rt-th" style="width:52px">No</th>
                <th class="rt-th">Type Name</th>
                <th class="rt-th">Rooms</th>
                <th class="rt-th" style="width:160px">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($types as $type)
            <tr class="rt-tr" id="rt-row-{{ $type->id }}">

                {{-- Nomor --}}
                <td class="rt-td">
                    <span class="rt-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                </td>

                {{-- Nama --}}
                <td class="rt-td">
                    <div id="rt-view-{{ $type->id }}" class="rt-name-wrap">
                        <span class="rt-dot"></span>
                        <span class="rt-name">{{ $type->name }}</span>
                    </div>
                    <div id="rt-edit-{{ $type->id }}" style="display:none;">
                        <input type="text" id="rt-input-{{ $type->id }}"
                               value="{{ $type->name }}"
                               class="rt-input">
                    </div>
                </td>

                {{-- Rooms count --}}
                <td class="rt-td">
                    @if($type->rooms_count > 0)
                        <span class="rt-badge">{{ $type->rooms_count }} rooms</span>
                    @else
                        <span class="rt-badge-empty">No rooms</span>
                    @endif
                </td>

                {{-- Actions --}}
                <td class="rt-td">
                    <div id="rt-actions-{{ $type->id }}" style="display:flex; gap:6px; align-items:center;">
                        <button onclick="startEdit({{ $type->id }})" class="rt-btn-edit">Edit</button>
                        <form method="POST" action="{{ route('admin.room-types.destroy', $type->id) }}"
                              onsubmit="return confirm('Delete type {{ $type->name }}?')"
                              style="margin:0; padding:0; display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rt-btn-delete">Delete</button>
                        </form>
                    </div>
                    <div id="rt-save-{{ $type->id }}" style="display:none; gap:6px; align-items:center;">
                        <button onclick="saveEdit({{ $type->id }})" class="rt-btn-save" id="rt-savebtn-{{ $type->id }}">Save</button>
                        <button onclick="cancelEdit({{ $type->id }}, '{{ addslashes($type->name) }}')" class="rt-btn-cancel">Cancel</button>
                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="rt-empty">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 10px; display:block; color:#d1d5db;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"/>
                    </svg>
                    <div style="font-weight:600; color:#6b7280; font-size:13.5px;">No room types yet</div>
                    <div style="color:#9ca3af; font-size:12px; margin-top:3px;">Click "Add Type" to get started</div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal --}}
<div id="rt-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:50; align-items:center; justify-content:center;">
    <div class="rt-modal-box">
        <div class="rt-modal-header">
            <span class="rt-modal-title">Add Room Type</span>
            <button onclick="closeRtModal()" class="rt-modal-close">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="rt-modal-body">
            <form method="POST" action="{{ route('admin.room-types.store') }}">
                @csrf
                <label class="rt-label">Type Name</label>
                <input type="text" name="name" required autofocus
                       placeholder="e.g. Standard, Deluxe, Suite…"
                       class="rt-modal-input">
                @error('name')
                    <p class="rt-error">{{ $message }}</p>
                @enderror
                <p class="rt-hint">This name will appear in the room assignment form.</p>
                <div class="rt-modal-footer">
                    <button type="button" onclick="closeRtModal()" class="rt-btn-cancel-modal">Cancel</button>
                    <button type="submit" class="rt-btn-submit">Save Type</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const _orig = {};

function openRtModal() {
    document.getElementById('rt-modal').style.display = 'flex';
}
function closeRtModal() {
    document.getElementById('rt-modal').style.display = 'none';
}
document.getElementById('rt-modal').addEventListener('click', function(e) {
    if (e.target === this) closeRtModal();
});

function startEdit(id) {
    _orig[id] = document.getElementById('rt-input-' + id).value;
    document.getElementById('rt-view-' + id).style.display    = 'none';
    document.getElementById('rt-edit-' + id).style.display    = 'block';
    document.getElementById('rt-actions-' + id).style.display = 'none';
    document.getElementById('rt-save-' + id).style.display    = 'flex';
    document.getElementById('rt-row-' + id).classList.add('rt-editing');
    document.getElementById('rt-input-' + id).focus();
}

function cancelEdit(id, orig) {
    document.getElementById('rt-input-' + id).value           = _orig[id] || orig;
    document.getElementById('rt-view-' + id).style.display    = 'flex';
    document.getElementById('rt-edit-' + id).style.display    = 'none';
    document.getElementById('rt-actions-' + id).style.display = 'flex';
    document.getElementById('rt-save-' + id).style.display    = 'none';
    document.getElementById('rt-row-' + id).classList.remove('rt-editing');
}

function saveEdit(id) {
    const input   = document.getElementById('rt-input-' + id);
    const newName = input.value.trim();
    if (!newName) { input.style.borderColor = '#ef4444'; input.focus(); return; }
    input.style.borderColor = '';
    if (newName === _orig[id]) { cancelEdit(id, _orig[id]); return; }

    const btn = document.getElementById('rt-savebtn-' + id);
    btn.disabled     = true;
    btn.textContent  = 'Saving…';

    fetch(`/admin/room-types/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ name: newName })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`#rt-view-${id} .rt-name`).textContent = newName;
            _orig[id] = newName;
            cancelEdit(id, newName);
            showToast('Type renamed to "' + newName + '"');
        } else {
            alert(data.message || 'Failed to save.');
            btn.disabled    = false;
            btn.textContent = 'Save';
        }
    })
    .catch(() => {
        alert('Something went wrong.');
        btn.disabled    = false;
        btn.textContent = 'Save';
    });
}

function showToast(msg) {
    const t = document.createElement('div');
    t.className   = 'rt-toast';
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 2800);
}

document.addEventListener('keydown', function(e) {
    const el = document.activeElement;
    if (!el || !el.id.startsWith('rt-input-')) return;
    const id = el.id.replace('rt-input-', '');
    if (e.key === 'Enter')  { e.preventDefault(); saveEdit(id); }
    if (e.key === 'Escape') { cancelEdit(id, _orig[id]); }
});
</script>

@endsection