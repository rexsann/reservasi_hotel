<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
        Login
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-4">
        @csrf
        
        <div class="flex flex-col gap-1">
            <h5 class="text-lg font-bold text-left text-gray-700">Username</h5>
            <input type="text" name="username" placeholder="Masukkan username"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="flex flex-col gap-1">
            <h5 class="text-lg font-bold text-left text-gray-700">Password</h5>
            <input type="password" name="password" placeholder="Masukkan password"
                class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
            Masuk
        </button>

        <div class="flex justify-between items-center text-sm text-gray-600">
            <span>Belum punya akun? 
            <a href="/registrasi" class="text-blue-500 hover:underline">Daftar di sini</a>
            </span>
            <a href="/lupapassword" class="text-blue-500 hover:underline">Lupa password?</a>
        </div>
    </form>

</div>

</body>
</html>