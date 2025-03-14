@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Bestelling #{{ $order->id }} Bevestigd</h1>

    <div class="bg-white shadow-lg rounded-lg p-6 max-w-lg mx-auto">
        <h2 class="text-xl font-semibold mb-2">Bestelde producten:</h2>
        @foreach ($order->orderLines as $line)
            <p>{{ $line->product->name }} (x{{ $line->quantity }}) - €{{ number_format($line->product->price * $line->quantity, 2) }}</p>
        @endforeach

        <p class="text-lg font-semibold text-gray-800 mt-4">Totale kosten: €{{ number_format($order->orderLines->sum(fn($line) => $line->product->price * $line->quantity), 2) }}</p>

        <a href="{{ route('dashboard') }}" class="mt-4 block text-center py-2 px-4 rounded transition w-full"
           style="background-color:#000000; color:#fdd716;">
            Terug naar Home
        </a>
    </div>
</div>
@endsection