@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Nieuw product toevoegen</h2>

    <form action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-gray-700">Naam</label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Beschrijving</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg" required></textarea>
        </div>

        <div>
            <label class="block text-gray-700">Categorie</label>
            <select name="categorie_id" class="w-full p-2 border border-gray-300 rounded-lg">
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Productietijd</label>
            <select name="production_time" class="w-full p-2 border border-gray-300 rounded-lg">
                <option>1-3 maanden</option>
                <option>4-6 maanden</option>
                <option>7-9 maanden</option>
                <option>10-12 maanden</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Materiaal</label>
            <select name="material" class="w-full p-2 border border-gray-300 rounded-lg">
                <option>hout</option>
                <option>metaal</option>
                <option>kunststof</option>
                <option>glas</option>
                <option>steen</option>
                <option>textiel</option>
                <option>leer</option>
                <option>papier</option>
                <option>keramiek</option>
                <option>overig</option>
            </select>
        </div>

        <div>
            <label class="block text-gray-700">Prijs (€)</label>
            <input type="number" name="price" step="0.01" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Aantal</label>
            <input type="number" name="quantity" class="w-full p-2 border border-gray-300 rounded-lg" required>
        </div>

        <div>
            <label class="block text-gray-700">Afbeelding</label>
            <input type="file" name="image" class="w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Toevoegen</button>
    </form>
</div>
@endsection
