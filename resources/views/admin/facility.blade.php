@extends('Layouts.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Facility Management</h1>

<div class="grid md:grid-cols-2 gap-6">

    <!-- 🔥 FORM -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="font-semibold mb-4">Add Facility</h2>

        <div class="flex gap-2 mb-4">
            <input id="facilityInput"
                class="border p-2 rounded w-full focus:ring-2 focus:ring-blue-400"
                placeholder="Enter facility (e.g: Hair Dryer)">

            <button onclick="addFacility()"
                class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700 transition">
                Add
            </button>
        </div>

        <p class="text-sm text-gray-400">
            Example: WiFi, AC, TV, Breakfast, Hair Dryer
        </p>

    </div>


    <!-- 🔥 LIST -->
    <div class="bg-white p-6 rounded-2xl shadow">

        <h2 class="font-semibold mb-4">Facility List</h2>

        <div id="facilityList" class="space-y-2"></div>

    </div>

</div>


<script>

// 🔥 STATE (UI ONLY)
let facilities = [
    'WiFi',
    'AC',
    'TV',
    'Breakfast'
];


// 🔥 RENDER
function renderFacilities() {

    let container = document.getElementById('facilityList');

    if (facilities.length === 0) {
        container.innerHTML = `
            <div class="text-gray-400 text-center">No facilities yet</div>
        `;
        return;
    }

    container.innerHTML = facilities.map((f, i) => `
        <div class="flex justify-between items-center border p-3 rounded-lg hover:bg-gray-50">

            <div class="flex items-center gap-2">
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded">
                    ${f}
                </span>
            </div>

            <button onclick="deleteFacility(${i})"
                class="text-red-500 text-sm hover:underline">
                Delete
            </button>

        </div>
    `).join('');
}


// 🔥 ADD
function addFacility() {
    let val = document.getElementById('facilityInput').value.trim();

    if (!val) return;

    // biar ga double
    if (facilities.includes(val)) {
        alert('Facility already exists');
        return;
    }

    facilities.push(val);

    document.getElementById('facilityInput').value = '';

    renderFacilities();
}


// 🔥 DELETE
function deleteFacility(index) {
    facilities.splice(index, 1);
    renderFacilities();
}


// INIT
renderFacilities();

</script>

@endsection