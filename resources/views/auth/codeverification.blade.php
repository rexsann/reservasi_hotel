<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code - Stayzy Hotel</title>

    @include('auth.partials.auth-style')
</head>

<body class="stayzy-auth">

    <div class="stayzy-glow glow-tl"></div>
    <div class="stayzy-glow glow-tr"></div>
    <div class="stayzy-glow glow-bl"></div>
    <div class="stayzy-glow glow-br"></div>

    <div class="stayzy-blob blob-1"></div>
    <div class="stayzy-blob blob-2"></div>
    <div class="stayzy-blob blob-3"></div>

    <div class="stayzy-card">

        <div class="auth-header">
            <h2>Verification Code</h2>
            <p>Enter the 6 digit code sent to your email</p>
        </div>

        @if(session('error'))
            <div class="stayzy-alert-success" style="background:#dc4c4c;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.post') }}">
            @csrf

            <div class="stayzy-field">
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    value="{{ old('otp') }}"
                    placeholder="Enter 6 digit code"
                    class="stayzy-input {{ $errors->has('otp') ? 'has-error' : '' }}"
                    style="text-align: center; letter-spacing: 6px; font-size: 18px;">

                @error('otp')
                    <p class="stayzy-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="stayzy-btn">
                Verify
            </button>

        </form>

    </div>

</body>
</html>