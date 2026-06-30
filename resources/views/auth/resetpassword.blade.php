<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Stayzy Hotel</title>

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
            <h2>Reset Password</h2>
            <p>Create a new password for your account</p>
        </div>

        @if (session('success'))
            <div class="stayzy-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="stayzy-alert-success" style="background:#dc4c4c;">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('resetpassword.post') }}">
            @csrf

            <div class="stayzy-field">
                <label class="stayzy-label">Password</label>

                <div class="stayzy-input-wrap">

                    <input
                        id="password"
                        type="password"
                        name="password"
                        value="{{ old('password') }}"
                        class="stayzy-input {{ $errors->has('password') ? 'has-error' : '' }}"
                        placeholder="Enter your password">

                    <button
                        type="button"
                        class="stayzy-input-icon-btn js-toggle-pw"
                        data-target="password"
                        aria-label="Show password">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>

                </div>

                @error('password')
                    <p class="stayzy-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="stayzy-field">
                <label class="stayzy-label">Confirm Password</label>

                <div class="stayzy-input-wrap">

                    <input
                        id="confirm_password"
                        type="password"
                        name="password_confirmation"
                        class="stayzy-input {{ $errors->has('password_confirmation') ? 'has-error' : '' }}"
                        placeholder="Confirm your password">

                    <button
                        type="button"
                        class="stayzy-input-icon-btn js-toggle-pw"
                        data-target="confirm_password"
                        aria-label="Show confirm password">
                        <svg class="eye-open" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg class="eye-closed" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>

                </div>

                @error('password_confirmation')
                    <p class="stayzy-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="stayzy-btn">
                Update Password
            </button>

            <div class="stayzy-meta-row">
                <span>
                    Remember your password?
                    <a href="{{ route('login') }}" class="stayzy-link">
                        Login here
                    </a>
                </span>
            </div>

        </form>

    </div>

   <script>
        document.querySelectorAll('.js-toggle-pw').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const targetId = btn.dataset.target;
                const input = document.getElementById(targetId);
                if (!input) return;

                const eyeOpen = btn.querySelector('.eye-open');
                const eyeClosed = btn.querySelector('.eye-closed');
                const isHidden = input.type === 'password';

                input.type = isHidden ? 'text' : 'password';
                eyeOpen.style.display = isHidden ? 'none' : 'block';
                eyeClosed.style.display = isHidden ? 'block' : 'none';
            });
        });
    </script>

</body>
</html>