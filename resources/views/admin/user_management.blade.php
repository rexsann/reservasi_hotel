@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-xl font-semibold text-gray-800">
            Users Management
        </h1>

        <p class="text-sm text-gray-400">
            List of registered guests
        </p>
    </div>
</div>

{{-- STAT CARDS --}}
<div class="grid grid-cols-3 gap-4 mb-6">

    {{-- TOTAL --}}
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">

        <p class="text-xs text-gray-400 mb-1">
            Total Guests
        </p>

        <p class="text-2xl font-semibold text-gray-800">
            {{ $users->count() }}
        </p>

    </div>

    {{-- EVER RESERVED --}}
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">

        <p class="text-xs text-gray-400 mb-1">
            Ever Made a Reservation
        </p>

        <p class="text-2xl font-semibold text-blue-600">
            {{ $users->where('total_reservations', '>', 0)->count() }}
        </p>

    </div>

    {{-- NO RESERVATION --}}
    <div class="bg-white rounded-xl p-4 border border-gray-100 shadow-sm">

        <p class="text-xs text-gray-400 mb-1">
            No Reservation Yet
        </p>

        <p class="text-2xl font-semibold text-gray-500">
            {{ $users->where('total_reservations', 0)->count() }}
        </p>

    </div>

</div>

{{-- SEARCH --}}
<div class="mb-4">

    <input
        type="text"
        placeholder="Search feature coming soon..."
        class="w-full max-w-sm border border-gray-200 rounded-lg px-3 py-2 text-sm bg-gray-50 text-gray-400 cursor-not-allowed"
        disabled>

</div>

{{-- TABLE --}}
<div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">

    <table class="w-full text-sm">

        <thead>

            <tr class="bg-gray-800">

                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    ID
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    Guest
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    Total Reservations
                </th>

                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                    Registered
                </th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($users as $user)

            <tr class="hover:bg-gray-50 transition">

                {{-- ID --}}
                <td class="px-6 py-4 text-xs text-gray-400 font-medium">

                    {{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}

                </td>

                {{-- USER --}}
                <td class="px-6 py-4">

                    <div class="flex items-center gap-3">

                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">

                            {{ strtoupper(substr($user->name, 0, 1)) }}

                        </div>

                        <div>

                            <p class="font-semibold text-gray-800">
                                {{ $user->name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $user->email }}
                            </p>

                        </div>

                    </div>

                </td>

                {{-- RESERVATIONS --}}
                <td class="px-6 py-4">

                    <span class="font-semibold text-gray-800">
                        {{ $user->total_reservations }}
                    </span>

                    <span class="text-xs text-gray-400 ml-1">
                        reservations
                    </span>

                </td>

                {{-- REGISTERED --}}
                <td class="px-6 py-4 text-gray-500 text-xs">

                    {{ $user->created_at->format('Y-m-d') }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="4"
                    class="px-6 py-10 text-center text-sm text-gray-400">

                    No users found

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection