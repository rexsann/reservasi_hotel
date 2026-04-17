<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Lupa Password</title>
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

        @if (session('success'))
        <div id="alertBox"
            class="mb-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow 
           transform -translate-y-10 opacity-0 transition-all duration-500">
            {{ session('success') }}
        </div>

        <script>
            const alertBox = document.getElementById('alertBox');

            setTimeout(() => {
                alertBox.classList.remove('-translate-y-10', 'opacity-0');
                alertBox.classList.add('translate-y-0', 'opacity-100');
            }, 100);

            setTimeout(() => {
                alertBox.classList.add('-translate-y-10', 'opacity-0');
            }, 3000);
        </script>
        @endif

        <form method="POST" action="/lupapassword" class="space-y-4">
            @csrf

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-900">Email</h5>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    class="block w-full px-3 py-3 pr-12 border border-gray-300 rounded-lg text-lg text-gray-700 
               focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex flex-col gap-2">
                <button class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600">
                    Send Reset Link
                </button>
            </div>

            <div class="flex justify-between items-center text-[15px] text-gray-600 mt-3">
                <span>
                    Remember your password?
                    <a href="/login" class="text-blue-600 font-semibold hover:underline">
                        Login here
                    </a>
                </span>
            </div>
        </form>

    </div>

</html>