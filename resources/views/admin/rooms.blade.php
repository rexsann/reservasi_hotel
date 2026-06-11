@extends('Layouts.layout')

@section('content')

    @php
        $grouped = $rooms->groupBy(fn($room) => $room->roomType?->name ?? 'Unknown');
    @endphp

    @forelse($grouped as $typeName => $typeRooms)
        <div class="room-type-card">

            <div class="room-type-header">
                <div>
                    <h2 class="room-type-title">{{ $typeName }}</h2>
                    <span class="room-type-floor">· Floor {{ $loop->iteration }}</span>
                    <p class="room-type-price">
                        Rp {{ number_format($typeRooms->min('offer.price') ?? 0, 0, ',', '.') }}
                        – Rp {{ number_format($typeRooms->max('offer.price') ?? 0, 0, ',', '.') }} / night
                    </p>
                </div>

                <div class="room-type-stats">
                    <span class="summary-badge sb-available">
                        {{ $typeRooms->filter(fn($r) => strtolower(trim($r->status)) == 'available')->count() }} Available
                    </span>
                    <span class="summary-badge sb-occupied">
                        {{ $typeRooms->filter(fn($r) => strtolower(trim($r->status)) == 'occupied')->count() }} Occupied
                    </span>
                    <span class="summary-badge sb-maintenance">
                        {{ $typeRooms->filter(fn($r) => strtolower(trim($r->status)) == 'maintenance')->count() }} Maintenance
                    </span>
                </div>
            </div>

            {{-- Facilities — tidak berubah --}}
           @php
    $facilityList = \App\Models\Facility::where(
        'room_type_id',
        $typeRooms->first()?->room_type_id
    )->get();
@endphp

            @if ($facilityList->count())
                <div class="facilities-row">
                    <span class="facilities-label">Facilities:</span>
                    @foreach ($facilityList as $facility)
                        <span class="facility-tag facility-tag-{{ $loop->index % 8 }}">{{ $facility->name }}</span>
                    @endforeach
                </div>
            @endif

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
                    <tbody>
                        @forelse($typeRooms as $room)
                            <tr>
                                <td class="td-id">{{ $room->id }}</td>
                                <td class="td-room">{{ $room->room_name }}</td>
                                <td>{{ $room->offer?->name }}</td>
                                <td class="td-price">Rp {{ number_format($room->offer?->price ?? 0, 0, ',', '.') }}</td>
                                <td class="td-c">
                                    @php $status = strtolower(trim($room->status)); @endphp
                                    @if ($status == 'available')
                                        <span class="status-badge s-available">
                                            <span class="status-dot"></span> Available
                                        </span>
                                    @elseif ($status == 'occupied')
                                        <span class="status-badge s-occupied">
                                            <span class="status-dot"></span> Occupied
                                        </span>
                                    @else
                                        <span class="status-badge s-maintenance">
                                            <span class="status-dot"></span> Maintenance
                                        </span>
                                    @endif
                                </td>
                                <td class="td-c">
                                    {{-- ✅ Kirim room_type_id dan nama tipe ke modal --}}
                                    <button
                                        onclick='openEditModal(
                                            @json($room->id),
                                            @json($room->offer?->name ?? ""),
                                            @json($room->room_type_id ?? ""),
                                            @json($room->status)
                                        )'
                                        class="btn-edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10z"/>
                                        </svg>
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">No rooms available for this type</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    @empty
        @if(isset($types) && $types->count())
            <div class="text-center text-gray-400 py-8 text-sm">
                Belum ada kamar. Tipe yang tersedia:
                @foreach($types as $t)
                    <span class="inline-block bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full mx-1">{{ $t->name }}</span>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-400 py-16">No rooms available</div>
        @endif
    @endforelse

    {{-- ===== EDIT MODAL — tidak ada perubahan ===== --}}
    <div id="editModal">
        <div class="modal-card">

            <h2 class="modal-title">
                <span class="modal-title-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10z"/>
                    </svg>
                </span>
                Edit Room
            </h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-field">
                    <label class="modal-label" for="editOffer">Offer</label>
                    <select name="offer_id" id="editOffer" class="modal-select">
                    @foreach ($offers as $offer)
                        <option value="{{ $offer->id }}" data-type-id="{{ $offer->room_type_id }}">
                            {{ $offer->name }} — Rp {{ number_format($offer->price, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                </div>

                <div class="modal-field">
                    <label class="modal-label" for="editStatus">Status</label>
                    <select name="status" id="editStatus" class="modal-select">
                        <option value="Available">Available</option>
                        <option value="Occupied">Occupied</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                <hr class="modal-divider">

                <div class="modal-actions">
                    <button type="button" onclick="closeEditModal()" class="btn-cancel">Cancel</button>
                    <button type="submit" class="btn-save">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4.5a.5.5 0 0 0-.146-.354l-3-3A.5.5 0 0 0 11.5 1H2zm3 4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5zm5 8H6v-3h4v3z"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
function openEditModal(id, currentOfferId, roomTypeId, currentStatus) {
    const modal        = document.getElementById('editModal');
    const form         = document.getElementById('editForm');
    const offerSelect  = document.getElementById('editOffer');
    const statusSelect = document.getElementById('editStatus');

    if (modal.parentElement !== document.body) {
        document.body.appendChild(modal);
    }

    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    form.action = "{{ url('/admin/rooms') }}/" + id;
    statusSelect.value = currentStatus.trim();

    let firstVisible  = null;
    let foundSelected = false;

    Array.from(offerSelect.options).forEach(option => {
        // filter berdasarkan room_type_id (integer match)
        const isMatch = parseInt(option.dataset.typeId) === parseInt(roomTypeId);

        option.hidden   = !isMatch;
        option.selected = false;

        if (isMatch) {
            if (!firstVisible) firstVisible = option;
            if (parseInt(option.value) === parseInt(currentOfferId)) {
                option.selected = true;
                foundSelected   = true;
            }
        }
    });

    if (!foundSelected && firstVisible) {
        firstVisible.selected = true;
    }
}

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }

        document.getElementById('editModal').addEventListener('click', function (e) {
            if (e.target === this) closeEditModal();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeEditModal();
        });
    </script>

@endsection