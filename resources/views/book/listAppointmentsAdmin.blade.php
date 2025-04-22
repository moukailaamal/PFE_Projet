@extends('layouts.app')

@section('title', 'All Appointments')

@section('content')
<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-6">All Appointments</h1>

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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
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

                            <!-- Technician -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->technician->first_name }} {{ $reservation->technician->last_name }}
                            </td>

                            <!-- Adresse -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservation->address }}
                            </td>

                            <!-- Statut -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full 
                                    {{ 
                                        $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                        ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800') 
                                    }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                <a href="{{ route('book.listAppointmentsTech', $reservation->technician->id) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    View Technician
                                </a>
                                <a href="{{ route('book.listAppointmentsClient', $reservation->client->id) }}" 
                                   class="text-blue-500 hover:text-blue-700">
                                    View Client
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection