@extends('Layouts.layout')

@section('content')

<h1 class="text-2xl font-bold mb-6">Offer Management</h1>

<!-- 🔥 FORM -->
<div class="bg-white p-6 rounded-2xl shadow max-w-xl border border-gray-100">

    <!-- NAME -->
    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-600">Offer Name</label>
        <input id="offerName"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
            placeholder="e.g. Breakfast Package">
    </div>

    <!-- PRICE -->
    <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-600">Price</label>
        <input id="offerPrice"
            class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
            placeholder="e.g. 500000">
    </div>

    <!-- BENEFITS -->
    <label class="block mb-2 text-sm font-medium text-gray-600">Benefits</label>

    <div class="grid grid-cols-2 gap-3 mb-5">

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="Breakfast" class="benefitCheck">
            <span>Breakfast</span>
        </label>

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="No Breakfast" class="benefitCheck">
            <span>No Breakfast</span>
        </label>

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="Free Cancellation" class="benefitCheck">
            <span>Free Cancellation</span>
        </label>

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="Non-refundable" class="benefitCheck">
            <span>Non-refundable</span>
        </label>

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="Pay at Hotel" class="benefitCheck">
            <span>Pay at Hotel</span>
        </label>

        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50">
            <input type="checkbox" value="Online Payment" class="benefitCheck">
            <span>Online Payment</span>
        </label>

    </div>

    <!-- BUTTON -->
    <button onclick="saveOffer()"
        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
        Save Offer
    </button>

</div>

<!-- 🔥 LIST -->
<h2 class="text-lg font-semibold mt-8 mb-3">Available Offers</h2>

<div id="offerList" class="grid md:grid-cols-2 gap-4"></div>


<script>

// 🔥 PRESET (BIAR LANGSUNG KELIATAN)
let offers = [
    {
        name: "Breakfast Deal",
        price: 550000,
        benefits: ["Breakfast", "Free Cancellation"]
    },
    {
        name: "Saver Package",
        price: 450000,
        benefits: ["No Breakfast", "Non-refundable", "Online Payment"]
    }
];


// 🔥 SAVE OFFER
function saveOffer() {

    let name = document.getElementById('offerName').value;
    let price = document.getElementById('offerPrice').value;

    if (!name || !price) {
        alert('Isi dulu name & price');
        return;
    }

    let selectedBenefits = [];
    document.querySelectorAll('.benefitCheck:checked').forEach(cb => {
        selectedBenefits.push(cb.value);
    });

    offers.push({
        name,
        price,
        benefits: selectedBenefits
    });

    resetForm();
    renderOffers();
}


// 🔥 RENDER OFFERS (FLOWBITE STYLE CARD)
function renderOffers() {

    let container = document.getElementById('offerList');

    container.innerHTML = offers.map(o => `

        <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5 hover:shadow-md transition">

            <div class="flex justify-between items-center mb-2">
                <h3 class="text-lg font-semibold text-gray-800">${o.name}</h3>
                <span class="text-blue-600 font-bold">
                    Rp ${Number(o.price).toLocaleString('id-ID')}
                </span>
            </div>

            <div class="flex flex-wrap gap-2 mt-3">
                ${o.benefits.map(b => `
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full">
                        ${b}
                    </span>
                `).join('')}
            </div>

        </div>

    `).join('');
}


// 🔥 RESET
function resetForm() {
    document.getElementById('offerName').value = '';
    document.getElementById('offerPrice').value = '';

    document.querySelectorAll('.benefitCheck').forEach(cb => {
        cb.checked = false;
    });
}


// INIT
renderOffers();

</script>

@endsection