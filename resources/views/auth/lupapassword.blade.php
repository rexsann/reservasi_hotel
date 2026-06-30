<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password - Stayzy Hotel</title>

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
            <h2>Forgot Password</h2>
            <p>Enter your email to receive a reset code</p>
        </div>

        <form method="POST" action="{{ route('lupapassword') }}">
            @csrf

            <div class="stayzy-field">
                <label class="stayzy-label">Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="stayzy-input {{ $errors->has('email') ? 'has-error' : '' }}"
                    placeholder="Enter your email">

                @error('email')
                    <p class="stayzy-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="stayzy-btn">
                Send Code
            </button>

            <div class="stayzy-meta-row">
                <span>
                    Remember your password?
                    <a href="/login" class="stayzy-link">
                        Login here
                    </a>
                </span>
            </div>

        </form>

    </div>

</body>
</html>