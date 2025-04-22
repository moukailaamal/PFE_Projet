@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-6">My Appointments</h1>

    <!-- Informations du technicien -->
    <div class="mb-6">
        <p class="text-lg text-gray-700">
            @if($technician && $technician->user)
            Technician: <span class="font-semibold">{{ $technician->user->first_name }} {{ $technician->user->last_name }}</span>
        @else
            <span class="text-red-500">Technician not found</span>
        @endif
        
        </p>
    </div>

    <!-- Liste des rendez-vous -->
    @if($reservations->isEmpty())
        <p class="text-gray-500">No appointments found.</p>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        <tr>
                            <!-- Date et heure -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($reservation->appointment_date)->format('d/m/Y H:i') }}
                            </td>

                            <!-- Client -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->client->first_name }} {{ $reservation->client->last_name }}
                            </td>

                            <!-- Adresse -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->address }}
                            </td>

                            <!-- Statut -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                            
                                @if($reservation->status === 'pending')
                                    <!-- Confirm Reservation Form -->
                                    <form action="{{ route('book.confirmed', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to confirm this reservation?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700 ml-3">Confirm</button>
                                    </form>
                            
                                    <!-- Cancel Reservation Form -->
                                    <form action="{{ route('book.cancel', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to cancel this reservation?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-3">Cancel</button>
                                    </form>
                                @elseif($reservation->status === 'confirmed')
                                    <!-- Mark as Completed Form -->
                                    <form action="{{ route('book.completed', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to mark this reservation as completed?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700 ml-3">Mark as Completed</button>
                                    </form>
                            
                                    <!-- Optional: Reschedule Form -->
                                    <a href="{{ route('book.days', $technician->id) }}" class="text-yellow-500 hover:text-yellow-700 ml-3">Reschedule</a>
                                @elseif($reservation->status === 'canceled' && \Carbon\Carbon::parse($reservation->appointment_date)->isFuture())
                                    <!-- Reactivate Reservation Form -->
                                    <form action="{{ route('book.reactivate', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to reactivate this reservation?');">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-500 hover:text-green-700 ml-3">Reactivate</button>
                                    </form>
                                @elseif($reservation->status === 'completed')
                                    <!-- Show Completed Status -->
                                    <span class="text-green-500 ml-3">{{ ucfirst($reservation->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<!-- Confirmation Script -->
<script>
    function confirmAction(message) {
        return confirm(message);
    }
    </script>
@endsection