@extends('layouts.app')
<title>Product Informatie</title>
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
    @elseif (session('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative m-4" role="alert">
            <strong class="font-bold">Let op!</strong>
            <span class="block sm:inline">{{ session('warning') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-yellow-500" role="button" xmlns="http://www.w3.org/2000/svg"
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
            <h1 class="text-3xl font-bold text-center mb-8">{{ $product->name }} - Product Informatie</h1>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white shadow-lg rounded-lg p-6 relative">
                    <div class="absolute top-4 right-4">

                        <button onclick="toggleDropdown()" class="focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>

                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 bg-white border border-gray-200 rounded-md shadow-lg p-2 space-y-2">

                            <!-- Reviews -->
                            <a href="{{ route('reviews', $product->id) }}"
                                class="flex items-center w-full px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                </svg>
                                <span class="ml-2">Reviews</span>
                            </a>
                        </div>

                    </div>
                    <img ssrc="https://picsum.photos/200/300" alt="{{ $product->name }}"
                        class="w-full h-60 object-cover mb-4">
                    <h2 class="text-2xl font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-lg font-bold text-gray-800 mb-2">Prijs: €{{ number_format($product->price, 2) }}</p>
                    <p class="text-gray-600">Aantal in voorraad: {{ $product->quantity }}</p>
                    <p class="text-gray-600">Gemaakt van: {{ $product->material }}</p>
                    <p class="text-gray-600">Productcategorie: {{ $product->categorie->name }}</p>
                    <p class="text-gray-600">Productietijd: {{ $product->production_time }}</p>
                    @if ($product->link)
                        <p class="text-gray-600">Meer informatie: <a href="{{ $product->link }}"
                                class="text-blue-500 hover:underline">{{ $product->link }}</a></p>
                    @endif
                    <a href="{{ route('products.buy', $product->id) }}"
                        class="block text-center py-2 px-4 mt-4 rounded transition"
                        style="background-color:#fdd716; color:#000000;">
                        Bestellen
                    </a>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-2xl font-semibold mb-4">Productomschrijving</h3>
                    <p class="text-gray-700 mb-4">
                        {{ $product->description ?? 'Deze omschrijving is tijdelijk niet beschikbaar. Dit product biedt geweldige prestaties en betrouwbaarheid. Met een strak ontwerp en eenvoudige bediening is het een uitstekende keuze voor dagelijks gebruik.' }}
                    </p>
                    <p class="text-gray-700 mb-4">
                        Onze producten zijn ontworpen met oog voor kwaliteit en duurzaamheid. Dit model biedt hoge
                        efficiëntie en betrouwbaarheid, ideaal voor elke setting. Ontdek de toegevoegde waarde die dit
                        product kan bieden in jouw dagelijks leven!
                    </p>
                    <p class="text-gray-700 mb-4">
                        Dit product is vervaardigd uit hoogwaardige materialen en voldoet aan de strengste normen. We
                        streven ernaar om jou de beste ervaring te bieden, met een product dat zowel functioneel als
                        stijlvol is.
                    </p>
                </div>
            </div>
        </div>

        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById('dropdownMenu');
                dropdown.classList.toggle('hidden');
            }
        </script>
    </body>
@endsection
