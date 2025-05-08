@extends('layouts.app')

@section('title', 'List technician')

@include('layouts.partials.navbar-dashboard')  

@include('layouts.partials.sidebar') 
@section('content')


<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-6">List technician</h1>

    @if($technicians->isEmpty())
        <p class="text-gray-500">No technician found</p>
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
                                        View certificate
                                    </a>
                                @else
                                    <span class="text-gray-500">None</span>
                                @endif
                            </td>

                            <!-- Identity -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($technician->technician?->identite_path)
                                    <a href="{{ asset('storage/' . $technician->technician->identite_path) }}" target="_blank" class="text-blue-600 underline">
                                        View ID
                                    </a>
                                @else
                                    <span class="text-gray-500">None</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $statusClass = $statusClasses[$technician->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 text-sm font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($technician->status) }}
                                </span>
                            </td>
            
                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <form action="{{ route('technician.updateStatus', $technician->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    @if($technician->status !== 'active')
                                        <input type="hidden" name="action" value="activate">
                                        <button type="submit" class="text-green-500 hover:text-green-700" onclick="return confirm('Are you sure you want to activate this technician?')">
                                            Activate
                                        </button>
                                    @else
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to reject this technician?')">
                                            Reject
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection