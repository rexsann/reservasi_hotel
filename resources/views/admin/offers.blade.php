@extends('Layouts.layout')

@section('content')

@php
$allBenefits = [
    'Free Breakfast', 'Free WiFi', 'Swimming Pool Access', 'Free Parking Area',
    'Daily Housekeeping', 'Smart TV Entertainment', 'Coffee & Tea Amenities',
    '24-Hour Front Desk', 'Early Check-In','Laundry Service', 'Balcony Access','Welcome Drink', 
];
$types = [
    'Standard' => ['class' => 'standard', 'desc' => 'Affordable room for all guests'],
    'Superior' => ['class' => 'superior', 'desc' => 'Modern comfort with premium facilities'],
    'Deluxe'   => ['class' => 'deluxe',   'desc' => 'Luxurious experience with elegant touches'],
];
@endphp

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
                        <select name="room_type" class="field-select">
                            <option value="Standard">Standard</option>
                            <option value="Superior">Superior</option>
                            <option value="Deluxe">Deluxe</option>
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
        @foreach($types as $type => $meta)
        @php $offerList = $offers->where('room_type', $type); @endphp
        <div style="margin-bottom:22px;">
            <div class="type-header {{ $meta['class'] }}">
                <div>
                    <div class="type-header-name">{{ $type }}</div>
                    <div class="type-header-sub">{{ $meta['desc'] }}</div>
                </div>
                <span class="type-count-badge">{{ $offerList->count() }} offer</span>
            </div>

            @forelse($offerList as $offer)
            @php $benefits = json_decode($offer->benefits, true) ?? []; @endphp
            <div class="offer-card">
                <div class="offer-card-top">
                    <div>
                        <div class="offer-card-name">{{ $offer->name }}</div>
                    </div>
                    <div class="offer-price-pill">
                        <div class="offer-price-num">Rp {{ number_format($offer->price, 0, ',', '.') }}</div>
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
                        onclick='openEditModal(
                            {{ $offer->id }},
                            {{ $offer->price }},
                            @json($benefits)
                        )'>
                        <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </button>
                    <form action="/admin/offers/{{ $offer->id }}" method="POST" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete offer \'{{ addslashes($offer->name) }}\'?')" class="btn-delete">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="offer-empty">No offers available for {{ $type }}</div>
            @endforelse
        </div>
        @endforeach
    </div>
</div>

{{-- EDIT MODAL --}}
<div id="edit-modal" class="modal-backdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.5);" onclick="handleBackdropClick(event)">
    <div class="modal-box" style="position:relative; max-height:90vh; overflow-y:auto;" onclick="event.stopPropagation()">
        <div class="modal-header">
            <div>
                <div class="modal-title">Edit Offer</div>
                <div class="modal-title-sub">Update offer details</div>
            </div>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="field-group">
                    <label class="field-label">Price per Night</label>
                    <div class="price-wrap">
                        <span class="price-prefix">Rp</span>
                        <input type="number" id="edit-price" name="price" min="0" class="field-input">
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label" style="margin-bottom:8px;">Benefits</label>
                    <div class="benefits-grid">
                        @foreach($allBenefits as $b)
                        <label class="benefit-chip-label">
                            <input type="checkbox" name="benefits[]" value="{{ $b }}" class="edit-benefit-cb">
                            <div class="benefit-chip">{{ $b }}</div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-update">Save Changes</button>
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

    // Pindahkan modal ke body agar position:fixed tidak terpengaruh parent
    var modal = document.getElementById('edit-modal');
    document.body.appendChild(modal);

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeEditModal() {
    document.getElementById('edit-modal').style.display = 'none'; {{-- FIXED: was 'flex', should be 'none' --}}
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target.id === 'edit-modal') {
        closeEditModal();
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});
</script>

@endsection