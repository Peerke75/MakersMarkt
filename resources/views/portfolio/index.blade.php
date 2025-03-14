@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-center mb-6">Mijn Portfolio</h1>

    <div class="flex justify-end mb-4">
        <a href="{{ route('portfolio.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
            + Nieuw Product
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($products as $product)
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
            <div class="p-4">
                <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                <p class="text-gray-600 text-sm">{{ $product->categorie->name }} | {{ $product->material }}</p>
                <p class="text-gray-800 font-bold mt-2">€{{ number_format($product->price, 2) }}</p>

                <div class="flex justify-between items-center mt-4">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-500 hover:text-blue-600">Bewerken</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600">Verwijderen</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if ($products->isEmpty())
        <p class="text-center text-gray-500 mt-6">Je hebt nog geen producten in je portfolio.</p>
    @endif
</div>

@endsection
