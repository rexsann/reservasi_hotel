<html>

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Forget Password</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
            Forget Password
        </h2>


        <form method="POST" action="{{ route('lupapassword') }}">
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

            <div class="flex flex-col gap-2">
                <button type="submit"
                    class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600 mt-4">
                    Send Code
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