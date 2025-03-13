@extends('layouts.guest')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email or Username -->
        <div>
            <x-input-label for="username" :value="__('Email of Gebruikersnaam')" class="block font-medium text-gray-700" />
            <x-text-input id="username" class="w-full mt-1 p-2 border rounded-lg" type="text" name="username"
                :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="text-red-500 text-sm mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Wachtwoord')" class="block font-medium text-gray-700" />
            <x-text-input id="password" class="w-full mt-1 p-2 border rounded-lg" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Onthoud me') }}</label>
        </div>

        <div class="flex items-center justify-between">
            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('register') }}">
                {{ __('Nog geen account? Registreer!') }}
            </a>
        </div>

        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                    {{ __('Wachtwoord vergeten?') }}
                </a>
            @endif
            <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
@endsection
