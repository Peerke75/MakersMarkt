@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto p-6">
        <h1 class="text-3xl font-semibold mb-4">Bestelling #{{ $order->id }}</h1>
        <p class="text-lg font-medium mb-2">Status: <span class="font-normal">{{ $order->status }}</span></p>
        <p class="text-sm text-gray-600 mb-6">Beschrijving: {{ $order->status_description }}</p>

        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Bestelde Producten:</h2>
            @foreach ($order->orderLines as $line)
                <p class="mb-2">{{ $line->product->name }} (x{{ $line->quantity }}) - €{{ number_format($line->product->price * $line->quantity, 2) }}</p>
            @endforeach
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Maker Informatie:</h3>
            @foreach ($order->orderLines as $line)
                @if ($line->product->maker_id)
                    <p class="mb-2"><strong>Maker:</strong> {{ $line->product->maker->name }} is eigenaar van {{ $line->product->name}} </p>
                @endif
            @endforeach
        </div>

        @if(auth()->id() === $line->product->maker_id)
            <form action="{{ route('orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div class="space-y-2">
                    <label for="status" class="block text-sm font-medium text-gray-700">Wijzig status:</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="geplaatst" {{ $order->status == 'geplaatst' ? 'selected' : '' }}>Geplaatst</option>
                        <option value="in productie" {{ $order->status == 'in productie' ? 'selected' : '' }}>In productie</option>
                        <option value="verzonden" {{ $order->status == 'verzonden' ? 'selected' : '' }}>Verzonden</option>
                        <option value="geweigerd, terugbetaling verzonden" {{ $order->status == 'geweigerd, terugbetaling verzonden' ? 'selected' : '' }}>Geweigerd, terugbetaling verzonden</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="status_description" class="block text-sm font-medium text-gray-700">Beschrijving:</label>
                    <textarea name="status_description" id="status_description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Voeg een beschrijving toe">{{ $order->status_description }}</textarea>
                </div>

                <button type="submit" class="w-full py-2 px-6 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Update Status</button>
            </form>
        @endif
    </div>
@endsection