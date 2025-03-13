@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-lg rounded-lg">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Aantal</label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" step="0.01"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700">Materiaal</label>
                        <select name="material" id="material"
                            class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                            <option value="">Selecteer een materiaal</option>
                            <option value="hout" {{ old('material') == 'hout' ? 'selected' : '' }}>Hout</option>
                            <option value="metaal" {{ old('material') == 'metaal' ? 'selected' : '' }}>Metaal</option>
                            <option value="kunststof" {{ old('material') == 'kunststof' ? 'selected' : '' }}>Kunststof
                            </option>
                            <option value="glas" {{ old('material') == 'glas' ? 'selected' : '' }}>Glas</option>
                            <option value="steen" {{ old('material') == 'steen' ? 'selected' : '' }}>Steen</option>
                            <option value="textiel" {{ old('material') == 'textiel' ? 'selected' : '' }}>Textiel</option>
                            <option value="leer" {{ old('material') == 'leer' ? 'selected' : '' }}>Leer</option>
                            <option value="papier" {{ old('material') == 'papier' ? 'selected' : '' }}>Papier</option>
                            <option value="keramiek" {{ old('material') == 'keramiek' ? 'selected' : '' }}>Keramiek
                            </option>
                            <option value="overig" {{ old('material') == 'overig' ? 'selected' : '' }}>Overig</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="production_time" class="block text-sm font-medium text-gray-700">Productietijd</label>
                    <select name="production_time" id="production_time"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Selecteer een productietijd</option>
                        <option value="1-3 maanden" {{ old('production_time') == '1-3 maanden' ? 'selected' : '' }}>1-3
                            maanden</option>
                        <option value="4-6 maanden" {{ old('production_time') == '4-6 maanden' ? 'selected' : '' }}>4-6
                            maanden</option>
                        <option value="7-9 maanden" {{ old('production_time') == '7-9 maanden' ? 'selected' : '' }}>7-9
                            maanden</option>
                        <option value="10-12 maanden" {{ old('production_time') == '10-12 maanden' ? 'selected' : '' }}>
                            10-12 maanden</option>
                    </select>
                </div>


                <div>
                    <label for="categorie_id" class="block text-sm font-medium text-gray-700">Categorie</label>
                    <select name="categorie_id" id="categorie_id"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                        <option value="">Selecteer een categorie</option>
                        @foreach (\App\Models\Categorie::all() as $category)
                            <option value="{{ $category->id }}"
                                {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Aantal</label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" step="0.01"
                        class="mt-1 block w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
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
