@extends('layouts.guest')

@section('content')
<div class="mb-4 text-sm text-gray-600 text-center">
    {{ __('
            Bedankt voor uw aanmelding! Voordat u begint, kunt u uw e-mailadres verifiëren door op de link te klikken die we u zojuist hebben gemaild? Als u de e-mail niet hebt ontvangen, sturen we u graag een andere.') }}
</div>

@if (session('status') == 'verification-link-sent')
<div class="mb-4 font-medium text-sm text-green-600 text-center">
    {{ __('Er is een nieuwe verificatielink verzonden naar het e-mailadres dat u tijdens de registratie hebt opgegeven.') }}
</div>
@endif

<div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
        @csrf
        <x-primary-button class="w-full sm:w-auto">
            {{ __('Verificatie-e-mail opnieuw verzenden') }}
        </x-primary-button>
    </form>

<<<<<<< Updated upstream
    <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
        @csrf
        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 w-full sm:w-auto">
            {{ __('Log Uit') }}
        </button>
    </form>
</div>
@endsection
=======
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
>>>>>>> Stashed changes
