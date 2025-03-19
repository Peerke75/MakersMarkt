@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl text-center font-bold mb-4">Ongeverifieerde Accounts</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="user-list">
        @foreach($users as $user)
        <div class="bg-white p-4 rounded-lg shadow-md user-card" data-id="{{ $user->id }}">
            <div class="flex justify-between">
                <h2 class="text-lg font-semibold">{{ $user->name }}</h2>
                <span class="text-gray-500">Rol: {{ $user->role->name }}</span>
            </div>
            <p class="text-sm text-gray-600">{{ $user->email }}</p>
            <p class="text-sm text-gray-700 mt-2">{{ $user->bio }}</p>
            <div class="mt-4 flex justify-end">
                <button class="verify-btn bg-green-500 text-white px-4 py-2 mr-3 rounded">✓</button>
                <button class="reject-btn bg-red-500 text-white px-4 py-2 rounded">✗</button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.verify-btn').forEach(button => {
            button.addEventListener('click', function () {
                let userCard = this.closest('.user-card');
                let userId = userCard.dataset.id;

                fetch(`/user/${userId}/verify`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          userCard.remove(); // Verwijder kaart uit lijst
                      }
                  });
            });
        });

        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                let userCard = this.closest('.user-card');
                let userId = userCard.dataset.id;

                fetch(`/user/${userId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          alert('Account blijft ongeverifieerd.');
                      }
                  });
            });
        });
    });
</script>
@endsection
