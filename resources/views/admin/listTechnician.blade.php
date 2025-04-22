@extends('layouts.app')

@section('title', 'List technician ')

@section('content')
<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-6">List technician  </h1>

   
 
    @if($technicians->isEmpty())
        <p class="text-gray-500">no technician </p>
    @else
        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone number</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Certificate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Identity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($technicians as $technician)
                        <tr>
                            <!-- Technician Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $technician->first_name }} {{ $technician->last_name }}
                            </td>     
                            <!-- Phone number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $technician->phone_number }}
                            </td>
                            
                                                <!-- Certificate -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($technician->technician?->certificat_path)
                                <a href="{{ asset('storage/' . $technician->technician->certificat_path) }}" target="_blank" class="text-blue-600 underline">
                                    Voir certificat
                                </a>
                            @else
                                <span class="text-gray-500">Aucun</span>
                            @endif
                        </td>

                        <!-- Identity -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($technician->technician?->identite_path)
                                <a href="{{ asset('storage/' . $technician->technician->identite_path) }}" target="_blank" class="text-blue-600 underline">
                                    Voir identité
                                </a>
                            @else
                                <span class="text-gray-500">Aucun</span>
                            @endif
                        </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $technician->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($technician->status ?? 'inactive') }}
                                </span>
                            </td>
            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($technician->status !== 'active')
                                <form action="{{ route('technician.activateStatus', $technician->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-500 hover:text-green-700" onclick="return confirm('Are you sure you want to activate this technician?')">Activate</button>
                                </form>
                                @else
                                <form action="{{ route('technician.inactivateStatus', $technician->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to deactivate this technician?')">Deactivate</button>
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
<!-- Confirmation Script -->
<script>
    function confirmAction(message) {
        return confirm(message);
    }
    </script>
@endsection