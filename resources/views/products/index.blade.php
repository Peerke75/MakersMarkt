@extends('layouts.app')
<title>Product Zoeken</title>

@section('content')
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4 " role="alert">
            <strong class="font-bold">Succes!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                </svg>
            </span>
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z" />
                </svg>
            </span>
        </div>
    @endif

    <body class="bg-gray-100">

        <div class="container mx-auto px-4 py-8">
            <div class="relative mb-6 max-w-md mx-auto">
                <input type="text" id="product-search" placeholder="Zoek product in de catalogus..."
                    class="w-full p-3 border border-gray-300 rounded shadow focus:outline-none focus:ring-2 focus:ring-yellow-400"
                    style="background-color: #ffffff; color: #000;">

                <ul id="search-results"
                    class="absolute w-full border border-gray-300 rounded bg-white mt-1 hidden shadow-lg z-10">
                </ul>
            </div>

            <div class="flex justify-center">
                <form method="GET" action="{{ route('products') }}" class="mb-6 flex flex-wrap gap-4">
                    {{-- Categorie filter --}}
                    <select name="categorie_id" id="categorie-filter" class="px-5  border border-gray-300 rounded">
                        <option value="">Categorie</option>
                        @foreach ($categories as $categorie)
                            <option value="{{ $categorie->id }}">{{ $categorie->name }}</option>
                        @endforeach
                    </select>

                    {{-- Productietijd filter --}}
                    <select name="production_time" id="production-time-filter" class="px-4 border border-gray-300 rounded">
                        <option value="">Productietijd</option>
                        @foreach (['1-3 maanden', '4-6 maanden', '7-9 maanden', '10-12 maanden'] as $time)
                            <option value="{{ $time }}">{{ $time }}</option>
                        @endforeach
                    </select>

                    {{-- Materiaal filter --}}
                    <select name="material" id="material-filter" class="px-6 border border-gray-300 rounded">
                        <option value="">Materiaal</option>
                        @foreach (['hout', 'metaal', 'kunststof', 'glas', 'steen', 'textiel', 'leer', 'papier', 'keramiek', 'overig'] as $material)
                            <option value="{{ $material }}">{{ ucfirst($material) }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded">
                        Filter & Zoek
                    </button>
                </form>
            </div>



            <h1 class="text-3xl font-bold text-center mb-8">Catalogus</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/200/300" alt="Product Afbeelding" class="w-full h-48 object-cover"
                            loading="lazy">
                        <div class="p-4">
                            <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-lg font-bold text-gray-800">€{{ number_format($product->price, 2) }}</p>
                            </div>
                            <a href="{{ route('products.info', $product->id) }}"
                                class="block bg-gray-300 text-center py-2 px-4 rounded transition">Bekijk product</a>
                        </div>
                    </div>
                @endforeach

            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('product-search');
                    const resultsContainer = document.getElementById('search-results');

                    searchInput.addEventListener('input', function() {
                        const query = searchInput.value;

                        if (query.length >= 2) {
                            fetch(`/products/search?query=${query}`)
                                .then(response => response.json())
                                .then(data => {
                                    resultsContainer.innerHTML = '';

                                    if (data.length > 0) {
                                        resultsContainer.classList.remove('hidden');
                                        data.forEach(product => {
                                            const li = document.createElement('li');
                                            li.classList.add('p-3', 'hover:bg-yellow-200',
                                                'cursor-pointer', 'text-gray-800', 'border-b',
                                                'border-gray-200');
                                            li.innerHTML =
                                                `<span class="font-semibold">${product.name}</span> - €${parseFloat(product.price).toFixed(2)}`;

                                            li.addEventListener('click', () => {
                                                window.location.href =
                                                    `/products/${product.id}/info`;
                                            });

                                            resultsContainer.appendChild(li);
                                        });
                                    } else {
                                        resultsContainer.classList.add('hidden');
                                    }
                                });
                        } else {
                            resultsContainer.classList.add('hidden');
                        }
                    });

                    document.addEventListener('click', function(event) {
                        if (!resultsContainer.contains(event.target) && event.target !== searchInput) {
                            resultsContainer.classList.add('hidden');
                        }
                    });
                });
            </script>
        </div>
    </body>
@endsection
