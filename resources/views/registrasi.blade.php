<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <title>Registration</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-2xl font-bold text-center mb-6 text-gray-100">
            Registration
        </h2>

        @if (session('success'))
        <div id="alertBox"
            class="fixed top-0 left-1/2 transform -translate-x-1/2 -translate-y-full 
               bg-green-500 text-white px-6 py-3 rounded-b-xl shadow-lg 
               transition-all duration-500 z-50">
            {{ session('success') }}
        </div>

        <script>
            const alertBox = document.getElementById('alertBox');

            // Muncul (slide turun)
            setTimeout(() => {
                alertBox.classList.remove('-translate-y-full');
                alertBox.classList.add('translate-y-0');
            }, 100);

            // Hilang lagi
            setTimeout(() => {
                alertBox.classList.add('-translate-y-full');
            }, 3000);
        </script>
        @endif

        @if (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
        @endif


        <form method="POST" action="/registrasi" class="space-y-4">
            @csrf

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-100">Name</h5>
                <input type="text" name="name" placeholder="Enter your name"
                    class="w-full px-3 py-3 border text-lg  rounded-lg focus:ring-2 focus:ring-blue-400 text-gray-700">
            </div>

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-700">Email</h5>
                <input type="email" name="email" placeholder="Enter your email"
                    class="w-full px-3 py-3 border text-lg  rounded-lg focus:ring-2 focus:ring-blue-400 text-gray-700">
            </div>

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-700">Password</h5>
                <input type="password" name="password" placeholder="Enter your password"
                    class="w-full px-3 py-3 border text-lg  rounded-lg focus:ring-2 focus:ring-blue-400 text-gray-700">
            </div>

            <div class="flex flex-col gap-1">
                <h5 class="text-lg font-bold text-left text-gray-700">Confirm Password</h5>

                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                    class="w-full px-3 py-3 border text-lg  rounded-lg focus:ring-2 focus:ring-blue-400 text-gray-700">
            </div>

            <div class="flex flex-col gap-1">
                <button class="w-full bg-blue-500 text-white py-2 text-lg rounded-lg hover:bg-blue-600">
                    Sign Up
                </button>
            </div>
        </form>


        <div class="flex justify-between items-center text-[15px] text-gray-600 mt-3">
            <span>
                Already have an account?
                <a href="/login" class="text-blue-600 font-semibold hover:underline">
                    Login here
                </a>
            </span>
        </div>

    </div>

</body>

</html>