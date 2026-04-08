<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Lupa Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
    
    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
        Lupa Password
    </h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500 text-sm">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="/lupapassword" class="space-y-4">
        @csrf

        <input type="text" name="nohp" placeholder="Nomor HP"
            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">

        <button class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">
            Kirim Link Reset Password
        </button>

        <div class="flex justify-between items-center text-sm text-gray-600">
            <span>Ingat password? 
            <a href="/login" class="text-blue-500 hover:underline">Masuk di sini</a>
            </span>
        </div>
    </form>

</div>
</html>