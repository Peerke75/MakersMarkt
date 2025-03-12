@extends('layouts.guest')

@section('content')
    <div class="w-full sm:max-w-md mx-auto bg-white p-6 shadow-md rounded-lg">
        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block font-medium text-gray-700" />
                <x-text-input id="email" class="w-full mt-1 p-2 border rounded-lg" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
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

            <div class="flex justify-end">
                <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    {{ __('Reset Wachtwoord') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection