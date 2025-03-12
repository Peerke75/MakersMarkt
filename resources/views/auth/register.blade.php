@extends('layouts.guest')

@section('content')
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Naam')" class="block font-medium text-gray-700" />
                <x-text-input id="name" class="w-full mt-1 p-2 border rounded-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="text-red-500 text-sm mt-1" />
            </div>

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Gebruikersnaam')" class="block font-medium text-gray-700" />
                <x-text-input id="username" class="w-full mt-1 p-2 border rounded-lg" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="text-red-500 text-sm mt-1" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block font-medium text-gray-700" />
                <x-text-input id="email" class="w-full mt-1 p-2 border rounded-lg" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Wachtwoord')" class="block font-medium text-gray-700" />
                <x-text-input id="password" class="w-full mt-1 p-2 border rounded-lg" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Bevestig Wachtwoord')" class="block font-medium text-gray-700" />
                <x-text-input id="password_confirmation" class="w-full mt-1 p-2 border rounded-lg" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="text-red-500 text-sm mt-1" />
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm text-indigo-600 hover:underline" href="{{ route('login') }}">
                    {{ __('Heeft u al een account? Login!') }}
                </a>
                <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    {{ __('Registreer') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection