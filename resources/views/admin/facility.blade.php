@extends('Layouts.layout')

@section('content')

<div class="grid lg:grid-cols-3 gap-5">

    {{-- ════ FORM ════ --}}
    <div class="lg:col-span-1">
        <div class="form-card">

            <div class="form-card-title">
                <span class="form-card-title-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                Add Facility
            </div>

            <form action="/admin/facility/store" method="POST">
                @csrf

                <div class="field-group">
                    <label class="field-label">Room Type</label>
                    <select name="type" class="field-select">
                        @foreach($rooms as $room)
                            <option value="{{ $room->type }}">{{ $room->type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field-group">
                    <label class="field-label">Facility Name</label>
                    <input
                        name="name"
                        type="text"
                        placeholder="e.g. Hair Dryer, Smart TV..."
                        class="field-input">
                </div>

                <button type="submit" class="btn-add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Facility
                </button>
            </form>

        </div>
    </div>

    {{-- ════ LIST ════ --}}
    <div class="lg:col-span-2">

        @php
            $types = ['Standard', 'Superior', 'Deluxe'];
        @endphp

        @foreach($types as $type)
            @php
                $facilityList = $facilities->filter(fn($f) => $f->room_type === $type);
            @endphp

            <div class="type-card">

                <div class="type-card-header">
                    <div class="type-card-header-left">
                        <span class="type-name">{{ $type }}</span>
                    </div>
                    <span class="type-count">{{ $facilityList->count() }} facilities</span>
                </div>

                <div>
                    @forelse($facilityList as $facility)
                        <div class="facility-row">
                            <div class="facility-row-left">
                                <span class="facility-name">{{ $facility->name }}</span>
                            </div>
                            <form action="/admin/facility/{{ $facility->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    onclick="return confirm('Delete \'{{ $facility->name }}\'?')"
                                    class="btn-delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="empty-facilities">No facilities added for {{ $type }}</p>
                    @endforelse
                </div>

            </div>
        @endforeach

    </div>

</div>

@endsection