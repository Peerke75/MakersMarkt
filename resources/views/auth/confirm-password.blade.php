@extends('layouts.guest')

@section('content')
    <div class="mb-4 text-sm text-gray-600 text-center">
        {{ __('Dit is een beveiligd gedeelte van de applicatie. Bevestig uw wachtwoord voordat u verdergaat.') }}
    </div>

    <div class="w-full sm:max-w-md mx-auto bg-white p-6 shadow-md rounded-lg">
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Wachtwoord')" class="block font-medium text-gray-700" />
                <x-text-input id="password" class="w-full mt-1 p-2 border rounded-lg" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="text-red-500 text-sm mt-1" />
            </div>

            <div class="flex justify-end">
                <x-primary-button class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    {{ __('Bevestig') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection