@extends('layouts.app')

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
                    <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1
                                        0 00-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10
                                        11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1
                                        1 0 000-1.414z" />
                </svg>
            </span>
        </div>
    @endif

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8 max-w-3xl">
            <div class="flex justify-between items-center mb-8">
                <div class="bg-white shadow-lg rounded-lg p-4">
                    <p class="text-gray-800">Gemiddelde sterren:
                        {{ number_format($reviews->where('product_id', $product->id)->avg('rating'), 1) }} / 5.0</p>
                </div>
                <h1 class="text-3xl font-bold text-center flex-grow">{{ $reviews->where('product_id', $product->id)->count() }} Reviews over: {{ $product->name }}</h1>
                <button class="bg-yellow-500 text-white px-4 py-2 rounded-lg" onclick="openModal()">Review Toevoegen</button>
            </div>

            <div class="space-y-6">
                @foreach ($reviews as $review)
                    @if ($review->product_id == $product->id)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="h-12 w-12 bg-gray-300 rounded-full flex items-center justify-center text-xl font-bold text-white">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-xl font-semibold">{{ $review->user->name }}</h2>
                                    <p class="text-gray-500 text-sm">Gepubliceerd op
                                        {{ $review->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <p class="text-gray-800 mb-4">{{ $review->description }}</p>
                            <div class="flex items-center">
                                <span class="text-yellow-400 text-lg mr-2">⭐</span>
                                <span class="text-gray-800 font-semibold">{{ $review->rating }} / 5.0</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </body>

    <div id="review-modal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Nieuwe Review</h2>
            <form action="{{ route('reviews.store', ['product' => $product->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="review_added" value="{{ now()->format('Y-m-d H:i:s') }}">
                <label class="block mb-2">Review</label>
                <textarea name="description" class="w-full border border-gray-300 p-2 rounded mb-4" required></textarea>
                <label class="block mb-2">Beoordeling (1-5)</label>
                <input type="number" name="rating" min="1" max="5" step="0.1"
                    class="w-full border border-gray-300 p-2 rounded mb-4" required>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 px-4 py-2 rounded" onclick="closeModal()">Annuleren</button>
                    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Opslaan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('review-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('review-modal').classList.add('hidden');
        }
    </script>
@endsection
