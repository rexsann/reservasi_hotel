<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Login</title>
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

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-700">Email</h5>
                <input type="email" name="email" placeholder="Enter your email"
                    class="w-full px-3 py-3 border text-lg  rounded-lg focus:ring-2 focus:ring-blue-400 text-gray-700">
            </div>

<div class="flex flex-col gap-1">
    <h5 class="text-lg font-bold text-left text-gray-900">Password</h5>

    <!-- Wrapper jadi border -->
    <div class="flex items-center border rounded-lg px-3 focus-within:ring-2 focus-within:ring-blue-400">

        <input id="password" type="password" name="password" placeholder="Enter your password"
            class="w-full py-3 text-lg text-gray-700 outline-none">

        <!-- Icon Mata -->
        <button type="button" onclick="togglePassword()" class="text-gray-500">
            👀
        </button>

    </div>
</div>

            <button class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600">
                Sign In
            </button>


            <div class="flex justify-between items-center text-[15px] text-gray-600">
                <span>Dont have an account?
                    <a href="/registrasi" class="text-blue-500 hover:underline">Sign up here</a>
                </span>
                <a href="/lupapassword" class="text-blue-500 hover:underline">Forgot password?</a>
            </div>
        </form>
    </div>

</body>

</html>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const icon = document.getElementById("eyeIcon");

        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "🙈";
        } else {
            input.type = "password";
            icon.textContent = "👀";
        }
    }
</script>