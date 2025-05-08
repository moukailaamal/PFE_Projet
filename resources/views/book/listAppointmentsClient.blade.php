@extends('layouts.app')

@section('title', 'My Appointments')

@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 
@section('content')
<div class="container mx-auto p-4 mt-16">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Appointments</h1>
        <p class="text-lg text-gray-600 mt-2">
            Welcome, <span class="font-semibold">{{ $client->first_name }} {{ $client->last_name }}</span>
        </p>
    </div>

    <!-- Appointments Table -->
    @if($reservations->isEmpty())
        <p class="text-gray-500 text-center py-6">No appointments found.</p>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Appointment date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Date & Time -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($reservation->appointment_date)->format('d/m/Y H:i') }}
                            </td>

                            <!-- Client -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reservation->client->first_name }} {{ $reservation->client->last_name }}
                            </td>

                            <!-- Address -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $reservation->address }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                            <!-- Actions -->
                           
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                
                                    @if($reservation->status === 'pending')
                                        <!-- Cancel Reservation Form -->
                                        <form action="{{ route('book.cancel', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to cancel this reservation?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-red-500 hover:text-red-700 ml-3">Cancel</button>
                                        </form>
                                    @elseif($reservation->status === 'canceled' && \Carbon\Carbon::parse($reservation->appointment_date)->isFuture())
                                        <!-- Reactivate Reservation Form -->
                                        <form action="{{ route('book.reactivate', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to reactivate this reservation?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-green-500 hover:text-green-700 ml-3">Reactivate</button>
                                        </form>
                                    @elseif($reservation->status === 'confirmed')
                                        <!-- Mark as Completed Form -->
                                        <form action="{{ route('book.completed', $reservation->id) }}" method="POST" class="inline" onsubmit="return confirmAction('Are you sure you want to mark this reservation as completed?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-green-500 hover:text-green-700 ml-3">Mark as Completed</button>
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