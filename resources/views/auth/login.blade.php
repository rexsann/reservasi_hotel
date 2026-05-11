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

        @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
        @endif

        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-900">Email</h5>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    class="w-full px-3 py-3 border text-lg rounded-lg focus:ring-2 focus:ring-blue-400 {{ $errors->has('email') ? 'border-red-500' : '' }}">
                @error('email')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-900">Password</h5>
                <div class="relative w-full">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full px-3 py-3 border text-lg rounded-lg focus:ring-2 focus:ring-blue-400 {{ $errors->has('password') ? 'border-red-500' : '' }}">
                    <button type="button" onclick="togglePassword()"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0; color: #9ca3af;">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600">
                Sign In
            </button>


            <div class="flex justify-between items-center text-[14.5px] text-gray-600">
                <span>Don't have an account? <a href="/registrasi" class="text-blue-600 font-semibold hover:underline">Sign up</a></span>
                <a href="/lupapassword" class="text-blue-600 font-semibold hover:underline">Forgot password?</a>
            </div>
        </form>
    </div>

</body>

<script>
    function togglePassword() {
        const input = document.getElementById("password");
        const eyeOpen = document.getElementById("eyeOpen");
        const eyeClosed = document.getElementById("eyeClosed");
        if (input.type === "password") {
            input.type = "text";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "block";
        } else {
            input.type = "password";
            eyeOpen.style.display = "block";
            eyeClosed.style.display = "none";
        }
    }

    function toggleConfirmPassword() {
        const input = document.getElementById("confirm_password");
        const eyeOpen = document.getElementById("eyeOpenConfirm");
        const eyeClosed = document.getElementById("eyeClosedConfirm");
        if (input.type === "password") {
            input.type = "text";
            eyeOpen.style.display = "none";
            eyeClosed.style.display = "block";
        } else {
            input.type = "password";
            eyeOpen.style.display = "block";
            eyeClosed.style.display = "none";
        }
    }
</script>

</html>