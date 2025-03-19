@extends('layouts.app')

@section('content')
    <h1 class="text-3xl text-center font-semibold my-6">Mijn Bestellingen</h1>

    <!-- Bestellingen die de gebruiker heeft geplaatst (koper) -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold mb-4">Mijn Bestellingen (Koper)</h2>
        @forelse ($ordersAsBuyer as $order)
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <p class="text-lg font-medium">Bestelling #{{ $order->id }} - Status: {{ $order->status }}</p>
                <p class="text-sm text-gray-600">Koper: {{ $order->buyer->name }}</p> <!-- Koper -->
                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">Bekijk details</a>
            </div>
        @empty
            <p class="text-gray-600">Je hebt nog geen bestellingen geplaatst.</p>
        @endforelse
    </section>

    <!-- Bestellingen waarvan de gebruiker de maker is -->
    <section>
        <h2 class="text-2xl font-semibold mb-4">Inkomende Bestellingen (Maker)</h2>
        @forelse ($ordersAsMaker as $order)
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <p class="text-lg font-medium">Bestelling #{{ $order->id }} - Status: {{ $order->status }}</p>
                <p class="text-sm text-gray-600">Koper: {{ $order->buyer->name }}</p> <!-- Koper -->
                <p class="text-sm text-gray-600">Maker: {{ $order->orderLines->first()->product->maker->name }}</p> <!-- Maker -->

                <!-- Weergeef formulier voor status aanpassen als de gebruiker de maker is -->
                @if ($order->orderLines->contains(fn($line) => $line->product->maker_id == auth()->id()))
                    <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PATCH')

                        <label for="status" class="block text-sm font-medium text-gray-700">Wijzig status:</label>
                        <select name="status" id="status" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="geplaatst" {{ $order->status == 'geplaatst' ? 'selected' : '' }}>Geplaatst</option>
                            <option value="in productie" {{ $order->status == 'in productie' ? 'selected' : '' }}>In productie</option>
                            <option value="verzonden" {{ $order->status == 'verzonden' ? 'selected' : '' }}>Verzonden</option>
                            <option value="geweigerd, terugbetaling verzonden" {{ $order->status == 'geweigerd, terugbetaling verzonden' ? 'selected' : '' }}>Geweigerd, terugbetaling verzonden</option>
                        </select>

                        <textarea name="status_description" class="mt-4 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Voeg een beschrijving toe">{{ $order->status_description }}</textarea>
                        <button type="submit" class="mt-4 px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Update Status</button>
                    </form>
                @endif

                <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700 mt-2 inline-block">Bekijk details</a>
            </div>
        @empty
            <p class="text-gray-600">Er zijn geen bestellingen die jouw producten bevatten.</p>
        @endforelse
    </section>
@endsection
