@extends('layouts.guest')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email or Username -->
        <div>
<<<<<<< Updated upstream
            <x-input-label for="username" :value="__('Email of Gebruikersnaam')" class="block font-medium text-gray-700" />
            <x-text-input id="username" class="w-full mt-1 p-2 border rounded-lg" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="text-red-500 text-sm mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Wachtwoord')" class="block font-medium text-gray-700" />
            <x-text-input id="password" class="w-full mt-1 p-2 border rounded-lg" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Onthoud me') }}</label>
=======
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
>>>>>>> Stashed changes
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('register') }}">
                {{ __('Nog geen account? Registreer!') }}
            </a>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
<<<<<<< Updated upstream
                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Wachtwoord vergeten?') }}
=======
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
>>>>>>> Stashed changes
                </a>
            @endif
            <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
@endsection