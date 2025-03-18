@extends('layouts.app')
<title>Bestellingen</title>

@section('content')

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center mb-8">Bestellingen</h1>

            @if ($orders->isEmpty())
                <p class="text-center text-gray-500">Geen bestellingen gevonden.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($orders as $order)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-4">
                            <h2 class="text-xl font-semibold mb-2">Bestelling #{{ $order->id }}</h2>
                            <p><strong>Koper:</strong> {{ $order->buyer->name }}</p>
                            <p><strong>Status:</strong> {{ $order->status }}</p>
                            <p><strong>Beschrijving:</strong> {{ $order->status_message ?? 'Geen beschrijving' }}</p>
                            <button
                                onclick="openModal({{ $order->id }}, '{{ addslashes($order->status) }}', '{{ addslashes($order->status_message ?? '') }}')"
                                class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">
                                Status Wijzigen
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </body>

    <!-- Modal -->
    <div id="statusModal" class="fixed inset-0 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Wijzig Status</h2>
            <form id="updateStatusForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="orderId" name="order_id">
                <label class="block mb-2">Status:</label>
                <select name="status" id="statusSelect" class="w-full p-2 border rounded mb-4">
                    <option value="In productie">In productie</option>
                    <option value="Verzonden">Verzonden</option>
                    <option value="Geweigerd">Geweigerd</option>
                </select>
                <label class="block mb-2">Beschrijving:</label>
                <textarea name="status_message" id="status_message" class="w-full p-2 border rounded mb-4"></textarea>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Opslaan</button>
                <button type="button" onclick="closeModal()"
                    class="bg-gray-300 text-black px-4 py-2 rounded ml-2">Annuleren</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(orderId, currentStatus, currentMessage) {
            document.getElementById('orderId').value = orderId;
            document.getElementById('updateStatusForm').action = `/orders/${orderId}/update`;

            // Selecteer de statusoptie correct
            let statusSelect = document.getElementById('statusSelect');
            statusSelect.value = currentStatus; // Directe toewijzing

            // Controleer of de optie bestaat (fallback voor inconsistenties)
            if (!statusSelect.value) {
                for (let option of statusSelect.options) {
                    if (option.value.toLowerCase() === currentStatus.toLowerCase().trim()) {
                        option.selected = true;
                        break;
                    }
                }
            }

            // Zet het statusbericht correct in de textarea
            document.getElementById('status_message').value = currentMessage || '';

            // Toon de modal
            document.getElementById('statusModal').classList.remove('hidden');
        }
    </script>

@endsection
