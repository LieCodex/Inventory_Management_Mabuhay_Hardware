<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mabuhay Hardware - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="w-full max-w-5xl bg-white shadow-lg rounded-xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

    <!-- Left Branding Section -->
    <div class="bg-green-700 text-white flex items-center justify-center p-10">
        <div>
            <h1 class="text-4xl font-bold tracking-wide">MABUHAY</h1>
            <h1 class="text-4xl font-bold tracking-wide">HARDWARE</h1>
            <p class="mt-4 text-sm opacity-80">
                Inventory & Management System
            </p>
        </div>
    </div>

    <!-- Right Login Section -->
    <div class="p-10 ">
        <div class="mb-6 flex flex-col items-center">
        <h2 class="text-2xl font-semibold mb-1 text-center">Log in to your account</h2>
        <h3 class="text-xs text-center mb-6">Welcome back! Please enter your details.</h3>
            
        </div>
        

        @if (session('status'))
            <div class="mb-4 text-green-600 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username / Email -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Email</label>
                <input type="email"
                       name="email"
                       required
                       autofocus
                       class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm mb-1">Password</label>
                <input type="password"
                       name="password"
                       required
                       class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-600">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-center mb-6">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-green-700 hover:underline">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button type="submit"
                    class="w-full bg-green-700 text-white py-2 rounded-lg hover:bg-green-800 transition">
                Sign in
            </button>

        </form>
    </div>

</div>

</body>
</html>
