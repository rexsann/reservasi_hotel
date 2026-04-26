@extends('Layouts.layout')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Guest List</h1>
</div>

<div id="userTable"></div>

<script>

// 🔥 DUMMY DATA (SIMULASI TAMU HOTEL)
let users = [
    { id: 1, name: 'Moonlight', email: 'moon@gmail.com' },
    { id: 2, name: 'Sunshine', email: 'shine@gmail.com' },
    { id: 3, name: 'Facha', email: 'chacha@gmail.com' },
];

// 🔥 RENDER TABLE
function renderUsers() {

    let html = `
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                </tr>
            </thead>

            <tbody>
    `;

    users.forEach(user => {
        html += `
        <tr class="border-t hover:bg-gray-50 transition">
            <td class="p-3 text-gray-400">${String(user.id).padStart(3, '0')}</td>
            <td class="p-3 font-medium text-gray-700">${user.name}</td>
            <td class="p-3 text-gray-600">${user.email}</td>
        </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    </div>
    `;

    document.getElementById('userTable').innerHTML = html;
}

// INIT
renderUsers();

</script>

@endsection