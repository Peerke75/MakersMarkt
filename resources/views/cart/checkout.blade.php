@extends('layouts.app')

<title>Bestelling Bevestigen</title>

@section('content')
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Bestelling Bevestigen</h1>

        <!-- Toon de producten in de winkelwagen -->
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
            @foreach ($cart->items as $cartItem)
                <div class="mb-4">
                    <img src="{{ $cartItem->product->image_url ?? 'https://picsum.photos/200/300' }}" alt="{{ $cartItem->product->name }}" class="w-full h-48 object-cover mb-4">
                    <h2 class="text-2xl font-semibold mb-2">{{ $cartItem->product->name }}</h2>
                    <p class="text-lg text-gray-800 mb-4">Prijs per stuk: €{{ number_format($cartItem->price, 2) }}</p>
                    <p class="text-md text-gray-600 mb-4">Aantal: {{ $cartItem->quantity }}</p>
                    <p class="text-md text-gray-600 mb-4">Totaal voor dit product: €{{ number_format($cartItem->price * $cartItem->quantity, 2) }}</p>
                </div>
            @endforeach

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                <!-- Betalingsmethode en totaal -->
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-2">Betalen met:</h2>
                        <div class="mb-4">
                            <label for="payment_method" class="block text-gray-700 font-medium mb-2">Betaalmethode:</label>
                            <select name="payment_method" id="payment_method"
                                class="border border-gray-300 rounded-lg p-2 w-full">
                                <option value="ideal">iDeal</option>
                                <option value="paypal">PayPal</option>
                                <option value="creditcard">Creditcard</option>
                                <option value="v-pay">V-Pay</option>
                                <option value="apple-pay">Apple Pay</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-xl font-semibold mb-2">Totale kosten:</h2>
                        <p class="text-lg font-semibold text-gray-800 mb-4">
                            Totaal: €{{ number_format($cart->items->sum(fn($item) => $item->price * $item->quantity), 2) }}
                        </p>
                        <button type="submit" class="block text-center py-2 px-4 rounded transition w-full"
                            style="background-color:#000000; color:#fdd716;">
                            Bestellen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
@endsection