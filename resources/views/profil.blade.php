<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
        Profil Pengguna
    </h2>

    <!-- FOTO -->
    <div class="flex justify-center mb-6">
        <img src="https://ui-avatars.com/api/?name={{ $user->name }}"
            class="w-24 h-24 rounded-full shadow-md">
    </div>

    <!-- DATA -->
    <div class="space-y-4">

        <div>
            <h5 class="text-sm text-gray-500">Nama</h5>
            <p class="text-lg font-semibold text-gray-700">
                {{ $user->name }}
            </p>
        </div>

        <div>
            <h5 class="text-sm text-gray-500">Email</h5>
            <p class="text-lg font-semibold text-gray-700">
                {{ $user->email }}
            </p>
        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-6 flex flex-col gap-3">
        <a href="/home"
            class="w-full text-center bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
            Kembali ke Home
        </a>

        <a href="/login"
            class="w-full text-center bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">
            Logout
        </a>
    </div>

</div>

</body>
</html>