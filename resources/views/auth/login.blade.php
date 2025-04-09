@extends('layouts.auth')

@section('title', 'Login | Billing Global')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-gray-900 dark:to-gray-800 px-4">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6 sm:p-8 w-full max-w-md transition-all duration-300">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Login ke Billing Global</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Silakan masuk untuk mengakses sistem</p>
        </div>

        <!-- Status Message -->
        @if (session('status'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md text-sm mb-4">
            {{ session('status') }}
        </div>
        @endif

        <!-- Error Message -->
        @if ($errors->has('username'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded-md text-sm mb-4">
            {{ $errors->first('username') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5" id="loginForm">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                <div class="relative">
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                        autocomplete="username"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600 pr-10">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">👤</span>
                </div>
                @error('username')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        autocomplete="current-password"
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600 pr-10">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">🔒</span>
                </div>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                    <input id="remember_me" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="mr-2">
                    Ingat saya
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Lupa Password?</a>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit" id="loginButton"
                    class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 transition duration-300 transform hover:scale-105">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Disable Button on Submit -->
<script>
    const form = document.getElementById('loginForm');
    const btn = document.getElementById('loginButton');

    form.addEventListener('submit', function() {
        btn.disabled = true;
        btn.innerText = 'Memproses...';
    });
</script>
@endsection