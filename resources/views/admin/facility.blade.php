@extends('Layouts.layout')

@section('content')

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
                    <select name="room_type_id" class="field-select">
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
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

        @foreach($types as $type)

            @php
                $facilityList = $facilities->filter(
                    fn($f) => $f->room_type_id == $type->id
                );
            @endphp

            <div class="type-card">

                <div class="type-card-header">
                    <div class="type-card-header-left">
                        <span class="type-name">{{ $type->name }}</span>
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
                        <p class="empty-facilities">No facilities added for {{ $type->name }}</p>
                    @endforelse

                </div>

            </div>

        @endforeach

    </div>

</div>

<script>
setTimeout(() => {
    const s = document.getElementById('flash-success');
    const e = document.getElementById('flash-error');
    if (s) s.remove();
    if (e) e.remove();
}, 4000);
</script>

@endsection