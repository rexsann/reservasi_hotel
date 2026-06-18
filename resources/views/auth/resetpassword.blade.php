<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
            Reset Password
        </h2>

        <!--Alert Success -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!--Alert Error -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('resetpassword.post') }}">
            @csrf

            <!-- Password Field -->
            <div class="flex flex-col gap-1 mb-4">
                <h5 class="text-lg font-bold text-left text-gray-900">Password</h5>

                <div class="relative w-full">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        value="{{ old('password') }}"
                        placeholder="Enter your password"
                        class="block w-full px-3 py-3 pr-12 border rounded-lg text-lg text-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-blue-400 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}">

                    <button
                        type="button"
                        onclick="togglePassword()"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0; color: #9ca3af;">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="flex flex-col gap-1 mb-4">
                <h5 class="text-lg font-bold text-left text-gray-900">Confirm Password</h5>

                <div class="relative w-full">
                    <input
                        id="confirm_password"
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm your password"
                        class="block w-full px-3 py-3 pr-12 border rounded-lg text-lg text-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-blue-400 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}">

                    <button
                        type="button"
                        onclick="toggleConfirmPassword()"
                        style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%); background: none; border: none; cursor: pointer; padding: 0; color: #9ca3af;">

                        <!-- Eye Open -->
                        <svg id="eyeOpenConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>

                        <!-- Eye Closed -->
                        <svg id="eyeClosedConfirm" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
                        </svg>

                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

           
            <button type="submit" class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600 mt-4 font-semibold">
                Update Password
            </button>
        </form>
     

        <div class="text-center mt-6 pt-4 border-t border-gray-200">
            <p class="text-gray-600">
                Ingat password Anda? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">
                    Login di sini
                </a>
            </p>
        </div>

    </div>

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

</body>
</html>