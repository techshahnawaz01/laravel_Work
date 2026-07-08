<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Login - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 to-purple-700 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">{{ config('app.name') }}</h1>
            <p class="text-gray-600 mt-2">Tenant Portal Login</p>
        </div>

        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded mb-4">
            <p class="text-sm">Please login to access your tenant dashboard.</p>
        </div>

        <form action="{{ url('/tenant/login') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition font-semibold">
                Login
            </button>
        </form>

        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Don't have an account? 
                <a href="{{ route('tenant.register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                    Register here
                </a>
            </p>
        </div>
    </div>
</body>
</html>