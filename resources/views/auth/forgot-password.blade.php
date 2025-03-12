@extends('layouts.guest')

@section('content')
    <div class="text-center mb-4 text-sm text-gray-600">
        {{ __('
            Wachtwoord vergeten? Geen probleem. Laat ons gewoon uw e-mailadres weten en we sturen u een link om uw wachtwoord te resetten, zodat u een nieuw wachtwoord kunt kiezen.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full sm:max-w-md mx-auto bg-white p-6 shadow-md rounded-lg">
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

<<<<<<< Updated upstream
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block font-medium text-gray-700" />
                <x-text-input id="email" class="w-full mt-1 p-2 border rounded-lg" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="text-red-500 text-sm mt-1" />
            </div>
=======
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
>>>>>>> Stashed changes

            <div class="flex justify-end">
                <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    {{ __('Email Wachtwoord Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection