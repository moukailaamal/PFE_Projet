@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-6">My Appointments</h1>

    <!-- Informations du technicien -->
    <div class="mb-6">
        <p class="text-lg text-gray-700">
            My name : <span class="font-semibold">{{ $admin->first_name }} {{ $admin->last_name }}</span>
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
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="" class="text-blue-500 hover:text-blue-700">View Details</a>
                                @if($reservation->status === 'pending')
                                    <form action="" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Cancel</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection