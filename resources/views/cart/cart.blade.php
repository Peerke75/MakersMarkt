@extends('layouts.app')

@section('content')
<div class="flex justify-center mt-5">
    <div class="w-full max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="card shadow p-4">
            <h2 class="mb-4 text-center text-2xl font-bold">🛒 Jouw Winkelwagen</h2>

            @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
            @elseif(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            @if(count($cart) > 0)
            <table class="table table-hover text-center w-full">
                <thead class="thead-dark">
                    <tr>
                        <th>Product</th>
                        <th>Aantal</th>
                        <th>Prijs</th>
                        <th>Actie</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $productId => $item)
                    <tr class="product-row" data-price="{{ $item['price'] }}">
                        <td class="align-middle">{{ $item['name'] }}</td>
                        <td class="align-middle flex justify-center items-center">
                            <button type="button" class="quantity-btn px-2 py-1 bg-gray-300 rounded" data-action="decrease" data-id="{{ $productId }}">-</button>
                            <input type="number" class="quantity-input mx-2 text-center w-16" value="{{ $item['quantity'] }}" min="1">
                            <button type="button" class="quantity-btn px-2 py-1 bg-gray-300 rounded" data-action="increase" data-id="{{ $productId }}">+</button>
                        </td>
                        <td class="align-middle">€{{ number_format($item['price'], 2) }}</td>
                        <td class="align-middle">
                            <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm">❌ Verwijderen</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mt-4">
                <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Betaalmethode</label>
                        <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="ideal">iDEAL</option>
                            <option value="paypal">PayPal</option>
                            <option value="creditcard">Creditcard</option>
                            <option value="vpay">V Pay</option>
                            <option value="visa">Visa</option>
                            <option value="own_money">Eigen saldo</option>
                        </select>
                    </div>

                    @if(auth()->check())
                    <p class="text-sm text-gray-600">Beschikbaar saldo: <strong>€{{ number_format(auth()->user()->credits, 2) }}</strong></p>
                    @endif

                    <div class="text-right text-xl font-bold mt-4">
                        Totaalprijs: <span id="totalPrice"></span>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg">✅ Bestellen</button>
                </form>
            </div>
            @else
            <p class="text-center text-muted">Je winkelwagen is leeg. 🛍️</p>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        updateTotalPrice();

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('quantity-btn')) {
                const action = event.target.dataset.action;
                const productId = event.target.dataset.id;
                const input = event.target.closest('td').querySelector('.quantity-input');

                let newQuantity = parseInt(input.value);
                if (action === 'increase') {
                    newQuantity++;
                } else if (action === 'decrease' && newQuantity > 1) {
                    newQuantity--;
                }

                input.value = newQuantity;
                updateTotalPrice();

                // Update de winkelwagen via AJAX
                fetch(`/cart/update/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert("Er is iets misgegaan bij het bijwerken van de winkelwagen.");
                        }
                    });
            }
        });
    });

    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            const price = parseFloat(row.dataset.price);
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            total += price * quantity;
        });
        document.getElementById('totalPrice').innerText = '€' + total.toFixed(2);
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const paymentMethodSelect = document.getElementById("payment_method");
        const totalPriceElement = document.getElementById("totalPrice");
        const checkoutButton = document.querySelector("button[type='submit']");
        const userBalance = parseFloat("{{ auth()->user()->credits ?? 0 }}");

        function checkBalance() {
            const totalPrice = parseFloat(totalPriceElement.innerText.replace("€", ""));

            if (paymentMethodSelect.value === "own_money" && totalPrice > userBalance) {
                alert("Je hebt niet genoeg saldo om deze bestelling te plaatsen.");
                checkoutButton.disabled = true;
            } else {
                checkoutButton.disabled = false;
            }
        }

        // Controle uitvoeren bij wijziging van betalingsmethode of aantal producten
        paymentMethodSelect.addEventListener("change", checkBalance);
        document.addEventListener("input", checkBalance);

        // Controle uitvoeren bij het laden van de pagina
        checkBalance();
    });
</script>