<html>
<head>
    @vite(['resources/css/app.css'])
    <title>Verification Code</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

    <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">
        Verification Code
    </h2>

    @if(session('error'))
        <div class="text-red-500 text-sm mb-3">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.post') }}">
        @csrf

        <div>
        <input type="text" name="otp" maxlength="6" pattern="[0-9]{6}" value="{{ old('otp') }}"
            placeholder="Enter 6 digit code"
            class="w-full px-3 py-3 border rounded-lg text-center text-lg tracking-widest">
        @error('otp')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
        </div>

        <button type="submit"
            class="w-full mt-4 bg-blue-500 text-white py-2 rounded-lg">
            Verify
        </button>
    </form>

</div>

</body>
</html>