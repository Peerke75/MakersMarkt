@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-6 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold text-center mb-4">💳 Krediet Opwaarderen</h1>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif

        <div class="text-center mb-6 text-gray-700">
            Huidig saldo: <strong>€{{ number_format($user->credits, 2) }}</strong>
        </div>

        <form action="{{ route('credits.add') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 font-medium mb-2">Bedrag (€)</label>
                <input type="number" id="amount" name="amount" min="5" step="5" required
                    class="border border-gray-300 rounded-lg p-2 w-full">
            </div>

            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-medium mb-2">Betaalmethode</label>
                <select id="payment_method" name="payment_method" required
                    class="border border-gray-300 rounded-lg p-2 w-full">
                    <option value="ideal">iDEAL</option>
                    <option value="paypal">PayPal</option>
                    <option value="creditcard">Creditcard</option>
                    <option value="vpay">V Pay</option>
                    <option value="visa">Visa</option>
                </select>
            </div>

            <button type="submit" class="bg-black text-yellow-400 py-2 px-4 rounded-lg w-full font-bold">
                💰 Opwaarderen
            </button>
        </form>
    </div>

    <!-- Transactiegeschiedenis -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
        <h2 class="text-xl font-bold text-center mb-4">📜 Opwaardeergeschiedenis</h2>

        @if($transactions->isEmpty())
            <p class="text-center text-gray-500">Geen transacties gevonden.</p>
        @else
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b py-2">Datum</th>
                        <th class="border-b py-2">Bedrag</th>
                        <th class="border-b py-2">Methode</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td class="border-b py-2">{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                            <td class="border-b py-2">€{{ number_format($transaction->amount, 2) }}</td>
                            <td class="border-b py-2">{{ ucfirst($transaction->payment_method) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection