<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-6">

        <!-- Avatar -->
        <div class="flex flex-col items-center">
            <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="User"/>

            <h5 class="mb-1 text-xl font-medium text-gray-900">
                {{ auth()->user()->name ?? 'Guest' }}
            </h5>

            <span class="text-sm text-gray-500">
                {{ auth()->user()->email ?? '-' }}
            </span>
        </div>

        <!-- Info -->
        <div class="mt-6 space-y-3">

            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-semibold">{{ auth()->user()->email ?? '-' }}</p>
            </div>

            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-sm text-gray-500">Status</p>
                <p class="font-semibold text-green-600">Active</p>
            </div>

        </div>

        <!-- Button -->
        <div class="mt-6 flex justify-center">
            <a href="/logout"
                class="text-white bg-red-500 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5">
                Logout
            </a>
        </div>

    </div>

</div>

</body>
</html>