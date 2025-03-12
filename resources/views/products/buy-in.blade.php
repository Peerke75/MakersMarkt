@extends('layouts.app')
<title>Bestelling Bevestigen</title>
@section('content')
    <body class="bg-gray-100">

        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center mb-8">Bestelling Bevestigen</h1>

            <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
                <img src="https://picsum.photos/200/300" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-4">
                <h2 class="text-2xl font-semibold mb-2">{{ $product->name }}</h2>
                <p class="text-lg text-gray-800 mb-4">Prijs per stuk: €{{ number_format($product->price, 2) }}</p>

                <form  method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="mb-4">
                        <label for="quantity" class="block text-gray-700 font-medium mb-2">Aantal:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                            class="border border-gray-300 rounded-lg p-2 w-full" oninput="updateTotal()">
                    </div>

                    <p class="text-lg font-semibold text-gray-800 mb-4">
                        Totaal: <span id="totalAmount">€{{ number_format($product->price, 2) }}</span>
                    </p>

                    <button type="submit" class="block text-center py-2 px-4 rounded transition w-full"
                        style="background-color:#000000; color:#fdd716;">
                        Bestelling Bevestigen
                    </button>
                </form>

            </div>
        </div>
        <script>
            function updateTotal() {
                const price = {{ $product->price }};
                const quantity = document.getElementById('quantity').value;
                const total = price * quantity;
                document.getElementById('totalAmount').innerText = '€' + total.toFixed(2);
            }
        </script>
    </body>
@endsection
