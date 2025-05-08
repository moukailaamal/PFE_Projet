@extends('layouts.app')

@section('title', 'Booking Confirmation')

@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 
@section('content')
<div class="container mx-auto p-4 mt-16">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h1 class="text-2xl font-bold text-white">Booking Confirmation</h1>
        </div>

        <!-- Confirmation Body -->
        <div class="p-6">
            <!-- Success Message -->
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Booking Confirmed!</p>
                <p>Your appointment has been successfully booked.</p>
            </div>

            <!-- Booking Details -->
            <div class="space-y-4">
                <!-- Appointment Date and Time -->
                <div>
                    <p class="text-gray-600">Appointment Date and Time:</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($reservation->appointment_date)->format('d/m/Y H:i') }}</p>
                </div>

                <!-- Technician -->
                <div>
                    <p class="text-gray-600">Technician:</p>
                    <p class="text-lg font-semibold">
                        {{ $reservation->technician?->first_name }} {{ $reservation->technician?->last_name }}
                    </p>
                                </div>

                <!-- Address -->
                <div>
                    <p class="text-gray-600">Address:</p>
                    <p class="text-lg font-semibold">{{ $reservation->address }}</p>
                </div>

                <!-- Status -->
                <div>
                    <p class="text-gray-600">Status:</p>
                    <p class="text-lg font-semibold capitalize">{{ $reservation->status }}</p>
                </div>

                <!-- Notes -->
                <div>
                    <p class="text-gray-600">Notes:</p>
                    <p class="text-lg font-semibold">{{ $reservation->notes ?? 'No notes provided' }}</p>
                </div>
                <!-- Payment-->
                <div>
                    <p class="text-gray-600">Paiment :</p>
                    <p class="text-lg font-semibold">{{ $payment->payment_method ?? ' ' }}</p>
                </div>

                 <!-- Payment-->
                 <div>
                    <p class="text-gray-600">amount :</p>
                    <p class="text-lg font-semibold">{{ $payment->amount ?? ' ' }}</p>
                </div>

                <!-- Creation Date -->
                <div>
                    <p class="text-gray-600">Booking Created On:</p>
                    <p class="text-lg font-semibold">{{ \Carbon\Carbon::parse($reservation->creation_date)->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-6">
                <a href="{{ route('home') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                    Return to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection