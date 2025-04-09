@extends('layouts.auth')

@section('title', 'Login | Billing Global')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600">
    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-8 w-full sm:w-96">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Login ke Billing Global</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Silakan masuk untuk mengakses sistem</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mt-4">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">📧</span>
                </div>
                @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Input -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                        dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    <span class="absolute inset-y-0 right-3 flex items-center text-gray-400">🔒</span>
                </div>
                @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                    <input id="remember_me" type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Lupa Password?</a>
            </div>

            <!-- Login Button -->
            <div>
                <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 transition duration-300 transform hover:scale-105">
                    Masuk
                </button>
            </div>
        </form>
    </div>
</div>
@endsection