@extends('Layouts.layout')

@section('content')

@php
$allBenefits = [
    'Free Breakfast', 'Free WiFi', 'Swimming Pool Access', 'Free Parking Area',
    'Daily Housekeeping', 'Smart TV Entertainment', 'Coffee & Tea Amenities',
    '24-Hour Front Desk', 'Early Check-In','Laundry Service', 'Balcony Access','Welcome Drink', 
];
@endphp

{{-- ═══ FLASH MESSAGES ═══ --}}
@if (session('success'))
    <div id="flash-success"
         class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-5">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-success').remove()"
                class="ml-auto text-green-400 hover:text-green-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div id="flash-error"
         class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-5">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <ul class="list-none">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button onclick="document.getElementById('flash-error').remove()"
                class="ml-auto text-red-400 hover:text-red-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif

<div class="grid lg:grid-cols-3 gap-5">
    
    {{-- FORM --}}
    <div class="lg:col-span-1">
        <div class="form-panel">
            <div class="form-panel-header">
                <div class="form-panel-header-title">
                    <span class="form-panel-header-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </span>
                    Create New Offer
                </div>
                <div class="form-panel-header-sub">Create a new offer and room package</div>
            </div>
            <div class="form-panel-body">
                <form action="/admin/offers/store" method="POST">
                    @csrf
                    <div class="field-group">
                        <label class="field-label">Offer Name</label>
                        <input type="text" name="name" placeholder="e.g., Breakfast Package" class="field-input">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Room Type</label>
                        <select name="room_type_id" class="field-select">
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Price per Night</label>
                        <div class="price-wrap">
                            <span class="price-prefix">Rp</span>
                            <input type="number" name="price" placeholder="350000" min="0" class="field-input">
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label" style="margin-bottom:8px;">Benefits
                            <span style="font-weight:400;text-transform:none;letter-spacing:0;color:#94a3b8;margin-left:4px;">select included</span>
                        </label>
                        <div class="benefits-grid">
                            @foreach($allBenefits as $b)
                            <label class="benefit-chip-label">
                                <input type="checkbox" name="benefits[]" value="{{ $b }}">
                                <div class="benefit-chip">{{ $b }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn-save">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        Save Offer
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- LIST --}}
    <div class="lg:col-span-2">

        @foreach($types as $type)

            @php
                $offerList = $offers->where('room_type_id', $type->id);
            @endphp

            <div class="type-section">

                <div class="type-header">
                    <div>
                        <div class="type-header-name">{{ $type->name }}</div>
                        <div class="type-header-sub">Room Type</div>
                    </div>
                    <span class="type-count-badge">{{ $offerList->count() }} Offer</span>
                </div>

                @forelse($offerList as $offer)

                    @php
                        $benefits = json_decode($offer->benefits, true) ?? [];
                    @endphp

                    <div class="offer-card">

                        <div class="offer-card-top">
                            <div>
                                <div class="offer-card-name">{{ $offer->name }}</div>
                            </div>
                            <div class="offer-price-pill">
                                <div class="offer-price-num">Rp {{ number_format($offer->price,0,',','.') }}</div>
                                <span class="offer-price-night">per night</span>
                            </div>
                        </div>

                        @if(count($benefits))
                            <div class="offer-tags-row">
                                @foreach($benefits as $i => $b)
                                    <span class="offer-tag tag-{{ $i % 8 }}">{{ $b }}</span>
                                @endforeach
                            </div>
                        @endif

                        <div class="offer-card-actions">

                            <button
                                type="button"
                                class="btn-edit"
                                onclick='openEditModal({{ $offer->id }}, {{ $offer->price }}, @json($benefits))'>
                                Edit
                            </button>

                            <form action="/admin/offers/{{ $offer->id }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"
                                        onclick="return confirm('Delete this offer?')">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </div>

                @empty
                    <div class="offer-empty">No offers available for {{ $type->name }}</div>
                @endforelse

            </div>

        @endforeach

    </div>

</div>

{{-- EDIT MODAL --}}
<div id="edit-modal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;"
    onclick="handleBackdropClick(event)">
    <div style="background:white; border-radius:16px; padding:28px; width:100%; max-width:480px; margin:16px;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3 style="font-size:15px; font-weight:700; color:#1e293b;">Edit Offer</h3>
            <button type="button" onclick="closeEditModal()" style="color:#94a3b8; background:none; border:none; cursor:pointer; font-size:20px; line-height:1;">×</button>
        </div>

        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label class="field-label">Price per Night</label>
                <div class="price-wrap">
                    <span class="price-prefix">Rp</span>
                    <input type="number" name="price" id="edit-price" min="0" class="field-input">
                </div>
            </div>

            <div class="field-group">
                <label class="field-label" style="margin-bottom:8px;">Benefits</label>
                <div class="benefits-grid">
                    @foreach($allBenefits as $index => $b)
                    <label class="benefit-chip-label">
                        <input
                                type="checkbox"
                                name="benefits[]"
                                value="{{ $b }}"
                                {{ $index == 0 ? 'required' : '' }}>
                        <div class="benefit-chip">{{ $b }}</div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="button" onclick="closeEditModal()"
                    style="flex:1; padding:10px; border:1px solid #e2e8f0; border-radius:10px; background:white; color:#64748b; font-size:13px; cursor:pointer;">
                    Cancel
                </button>
                <button type="submit" class="btn-save" style="flex:1; margin:0;">Save Changes</button>
            </div>
        </form>

    </div>
</div>

<script>
function openEditModal(id, price, benefits) {
    document.getElementById('edit-price').value = price;
    document.querySelectorAll('.edit-benefit-cb').forEach(cb => {
        cb.checked = benefits.includes(cb.value);
    });
    document.getElementById('edit-form').action = '/admin/offers/' + id;
    var modal = document.getElementById('edit-modal');
    document.body.appendChild(modal);
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('edit-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target.id === 'edit-modal') closeEditModal();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeEditModal();
});

// Auto-dismiss flash alert setelah 4 detik
setTimeout(() => {
    const s = document.getElementById('flash-success');
    const er = document.getElementById('flash-error');
    if (s) s.remove();
    if (er) er.remove();
}, 4000);
</script>

@endsection