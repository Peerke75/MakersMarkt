@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Product bewerken</h2>

    <form action="{{ route('portfolio.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-gray-700">Naam</label>
            <input type="text" name="name" value="{{ $product->name }}" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Beschrijving</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg" required>{{ $product->description }}</textarea>
        </div>

        <div>
            <label class="block text-gray-700">Categorie</label>
            <select name="categorie_id" class="w-full p-2 border border-gray-300 rounded-lg">
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $product->categorie_id == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Productietijd</label>
            <select name="production_time" class="w-full p-2 border border-gray-300 rounded-lg">
                <option {{ $product->production_time == '1-3 maanden' ? 'selected' : '' }}>1-3 maanden</option>
                <option {{ $product->production_time == '4-6 maanden' ? 'selected' : '' }}>4-6 maanden</option>
                <option {{ $product->production_time == '7-9 maanden' ? 'selected' : '' }}>7-9 maanden</option>
                <option {{ $product->production_time == '10-12 maanden' ? 'selected' : '' }}>10-12 maanden</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Materiaal</label>
            <select name="material" class="w-full p-2 border border-gray-300 rounded-lg">
                @foreach(['hout', 'metaal', 'kunststof', 'glas', 'steen', 'textiel', 'leer', 'papier', 'keramiek', 'overig'] as $material)
                    <option value="{{ $material }}" {{ $product->material == $material ? 'selected' : '' }}>
                        {{ ucfirst($material) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Prijs (€)</label>
            <input type="number" name="price" value="{{ $product->price }}" step="0.01" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Aantal</label>
            <input type="number" name="quantity" value="{{ $product->quantity }}" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Huidige Afbeelding</label>
            <img src="{{ asset('storage/' . $product->image) }}" alt="Huidige afbeelding" class="w-auto h-auto max-w-full max-h-96 object-contain">

        </div>

        <div>
            <label class="block text-gray-700">Nieuwe Afbeelding (optioneel)</label>
            <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Opslaan</button>
    </form>
</div>
@endsection
