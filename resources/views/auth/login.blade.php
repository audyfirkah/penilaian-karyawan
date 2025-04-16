<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        @if(session('error'))
            <p class="text-red-500 text-center mb-4">{{ session('error') }}</p>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-gray-600 mb-1">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full p-3 pl-10 border rounded-lg focus:ring focus:ring-blue-300"
                        placeholder="masukkan email..." required>
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                        <i class="fas fa-envelope"></i>
                    </span>
                </div>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-gray-600 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="w-full p-3 pl-10 border rounded-lg focus:ring focus:ring-blue-300"
                        placeholder="masukkan password..." required>
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-500">
                        <i class="fas fa-lock"></i>
                    </span>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-200 ease-in-out">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
