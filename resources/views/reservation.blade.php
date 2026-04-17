
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-300 flex items-center justify-center min-h-screen">

    <div class="bg-gray-200 border-2 border-black rounded-3xl p-8 w-full max-w-md shadow-md">
        
        <!-- Title -->
        <h2 class="text-lg font-semibold mb-6">
            My Reservation :
        </h2>

        <!-- Form -->
        <form action="{{ route('reservation.check') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Code -->
            <div>
                <input 
                    type="text" 
                    name="code"
                    placeholder="Enter Code"
                    class="w-full px-4 py-3 rounded-full border-2 border-black bg-transparent focus:outline-none focus:ring-0"
                >
            </div>

            <!-- Email Label -->
            <div>
                <label class="block mb-2 font-medium">Email :</label>
                <input 
                    type="email" 
                    name="email"
                    placeholder="Enter Email"
                    class="w-full px-4 py-3 rounded-full border-2 border-black bg-transparent focus:outline-none focus:ring-0"
                >
            </div>

            <!-- Button -->
            <div class="flex justify-center pt-4">
                <button 
                    type="submit"
                    class="px-6 py-2 rounded-full border-2 border-black bg-gray-100 hover:bg-gray-300 transition"
                >
                    View Reservation
                </button>
            </div>

        </form>

    </div>

</body>
</html>
