<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
        Registrasi
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/registrasi" class="space-y-4">
        @csrf

        <input type="text" name="name" placeholder="Nama"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

        <input type="email" name="email" placeholder="Email"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

        <input type="password" name="password" placeholder="Password"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
            Daftar
        </button>
    </form>

</div>

</body>
</html>