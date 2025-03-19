@extends('layouts.app')

@section('content')
    <form action="{{ route('admin.description.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold mb-6">Product bewerken</h2>
            <div>
                <label class="block text-gray-700">Naam</label>
                <input type="text" name="name" value="{{ $product->name }}"
                    class="w-full p-2 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-gray-700">Beschrijving</label>
                <textarea name="description" class="w-full p-2 border border-gray-300 rounded-lg" required>{{ $product->description }}</textarea>
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Opslaan</button>
    </form>
    </div>
@endsection
