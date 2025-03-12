@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Nieuw Product</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Naam</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Prijs</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Aantal</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" step="0.01"
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>

            <div class="">
                <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    required>{{ old('description') }}</textarea>
            </div>


            <div>
                <label for="categorie_id" class="block text-sm font-medium text-gray-700">Categorie</label>
                <select name="categorie_id" id="categorie_id"
                    class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                    <option value="">Selecteer een categorie</option>
                    @foreach (\App\Models\Categorie::all() as $category)
                        <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-all">
                    Product Toevoegen
                </button>
            </div>
        </form>
    </div>
@endsection
