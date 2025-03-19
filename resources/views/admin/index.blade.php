@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Productenbeheer</h1>

        <!-- Filters -->
        <form action="{{ route('admin.index') }}" method="GET" class="mb-8">
            <div class="flex space-x-4">
                <select name="categorie_id" class="border px-4 py-2 rounded">
                    <option value="">Selecteer categorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('categorie_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="production_time" placeholder="Productie tijd" class="border px-4 py-2 rounded" value="{{ request('production_time') }}">

                <input type="text" name="material" placeholder="Materiaal" class="border px-4 py-2 rounded" value="{{ request('material') }}">

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filteren</button>
            </div>
        </form>

        <!-- Productenlijst -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2">Product</th>
                        <th class="border-b px-4 py-2">Categorie</th>
                        <th class="border-b px-4 py-2">Productie tijd</th>
                        <th class="border-b px-4 py-2">Materiaal</th>
                        <th class="border-b px-4 py-2">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $product->name }}</td>
                            <td class="border-b px-4 py-2">{{ $product->categorie->name }}</td>
                            <td class="border-b px-4 py-2">{{ $product->production_time }}</td>
                            <td class="border-b px-4 py-2">{{ $product->material }}</td>
                            <td class="border-b px-4 py-2">
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold mb-4">Gebruikersbeheer</h2>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2">Naam</th>
                        <th class="border-b px-4 py-2">E-mail</th>
                        <th class="border-b px-4 py-2">Rol</th>
                        <th class="border-b px-4 py-2">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $user->name }}</td>
                            <td class="border-b px-4 py-2">{{ $user->email }}</td>
                            <td class="border-b px-4 py-2">{{ $user->role->name ?? 'Geen rol' }}</td>
                            <td class="border-b px-4 py-2">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
