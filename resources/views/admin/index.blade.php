@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Productenbeheer</h1>

        <form action="{{ route('admin.index') }}" method="GET" class="mb-8">
            <div class="flex space-x-4">
                <select name="categorie_id" class="border px-4 py-2 rounded">
                    <option value="">Selecteer categorie</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->name }}
                        </option>
                    @endforeach
                </select>

                <select name="production_time" id="production-time-filter" class="px-4 border border-gray-300 rounded">
                    <option value="">Productietijd</option>
                    @foreach (['1-3 maanden', '4-6 maanden', '7-9 maanden', '10-12 maanden'] as $time)
                        <option value="{{ $time }}">{{ $time }}</option>
                    @endforeach
                </select>

                <select name="material" id="material-filter" class="px-6 border border-gray-300 rounded">
                    <option value="">Materiaal</option>
                    @foreach (['hout', 'metaal', 'kunststof', 'glas', 'steen', 'textiel', 'leer', 'papier', 'keramiek', 'overig'] as $material)
                        <option value="{{ $material }}">{{ ucfirst($material) }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filteren</button>
            </div>
        </form>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2">Product</th>
                        <th class="border-b px-4 py-2">Categorie</th>
                        <th class="border-b px-4 py-2">Productie tijd</th>
                        <th class="border-b px-4 py-2">Materiaal</th>
                        <th class="border-b px-4 py-2">Status</th>
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
                                @if ($product->status === 'pending')
                                    <span class="text-yellow-500 font-bold">In afwachting</span>
                                @elseif($product->status === 'active')
                                    <span class="text-green-500 font-bold">Actief</span>
                                @elseif($product->status === 'inactive')
                                    <span class="text-red-500 font-bold">Inactief</span>
                                @endif
                            </td>
                            <td class="border-b px-4 py-2">
                                <!-- Status aanpassen -->
                                @if ($product->status === 'pending' || $product->status === 'inactive')
                                    <form action="{{ route('admin.products.activate', $product->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-green-500 text-white px-4 py-2 rounded">Activeren</button>
                                    </form>
                                @endif

                                @if ($product->status === 'active')
                                    <form action="{{ route('admin.products.deactivate', $product->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="bg-yellow-500 text-white px-4 py-2 rounded">Deactiveren</button>
                                    </form>
                                @endif

                                <!-- Verwijderen -->
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
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
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Ongepaste taal zoeken -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Controleer op ongepaste taal</h2>
            <form action="{{ route('admin.products.checkLanguage') }}" method="GET">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Zoek naar ongepaste taal</button>
            </form>
        </div>

        <!-- Producten met ongepaste taal tonen -->
        @if (isset($products) && count($products) > 0)
            <div class="bg-yellow-100 shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-bold mb-4">Producten met ongepaste taal</h2>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="border-b px-4 py-2">Product</th>
                            <th class="border-b px-4 py-2">Beschrijving</th>
                            <th class="border-b px-4 py-2">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td class="border-b px-4 py-2">{{ $product->name }}</td>
                                <td class="border-b px-4 py-2">
                                    {!! preg_replace(
                                        '/(' . implode('|', $badWords) . ')/i',
                                        '<span class="text-red-500 font-bold">$1</span>',
                                        $product->description,
                                    ) !!}
                                </td>
                                <td class="border-b px-4 py-2">
                                    <a href="{{ route('admin.description.edit', $product->id) }}"
                                        class="bg-yellow-500 text-white px-4 py-2 rounded">Bewerken</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-4 py-2 rounded">Verwijderen</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
@endsection
