@extends('layouts.app')

@section('title', 'Book hour now')

@include('layouts.partials.navbar-dashboard')  
@section('content')
<div class="container mx-auto p-4 mt-16">
    <h1 class="text-2xl font-bold mb-4 text-center">Select an Available Hour</h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- En-tête du calendrier -->
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
            <h2 class="text-xl font-semibold text-white">Available Hours for {{ $day }}</h2>
        </div>

        <!-- Conteneur pour les heures disponibles -->
        <div id="available-hours" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6">
            @foreach($availableHours as $hour)
                @php
                    $isReserved = in_array($hour, $reservedHours);
                @endphp
                <div class="border border-gray-200 rounded-lg shadow-sm transition-shadow duration-200 cursor-pointer {{ $isReserved ? 'bg-gray-200 cursor-not-allowed' : 'bg-white hover:shadow-md' }}"
                     @if(!$isReserved) onclick="selectHour('{{ $day }}', '{{ $hour }}')" @endif>
                    <div class="p-4 text-center">
                        <p class="text-lg font-medium {{ $isReserved ? 'text-gray-500' : 'text-blue-600' }}">
                            {{ $hour }} - {{ date('H:i', strtotime($hour) + 3600) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $isReserved ? 'Reserved' : 'Click to book' }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Message si aucune heure n'est disponible -->
        @if(count($availableHours) === 0)
            <div class="p-6">
                <p class="text-gray-500 text-center">No available hours for this day.</p>
            </div>
        @endif
    </div>
</div>

<!-- Formulaire caché pour la réservation -->
<form id="booking-form" action="{{ route('book.store') }}" method="POST" class="hidden">
    @csrf

    <input type="hidden" name="technician_id" value="{{ $technician->user_id }}" id="technician_id">
        <input type="hidden" name="appointment_date" id="appointment-date">
    <input type="hidden" name="appointment_time" id="appointment-time">
    <input type="hidden" name="address" id="address">
    <input type="hidden" name="notes" id="notes">
</form>

<!-- Modale de confirmation -->
<div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 w-11/12 max-w-md">
        <h3 class="text-xl font-semibold mb-4">Confirm Booking</h3>
        <p id="modal-message" class="text-gray-700 mb-6">Do you want to book the slot on <span id="modal-date"></span> at <span id="modal-time"></span>?</p>

        <!-- Ajout des champs pour l'adresse et les notes -->
        <div class="mb-4">
            <label for="modal-address" class="block text-sm font-medium text-gray-700">Address</label>
            <input type="text" id="modal-address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
            <p id="address-error" class="text-red-500 text-sm mt-1 hidden">Please enter an address.</p>
        </div>
        <div class="mb-4">
            <label for="modal-notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
            <textarea id="modal-notes" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
        </div>

        <div class="flex justify-end space-x-4">
            <button onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
            <button onclick="submitBooking()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Confirm</button>
        </div>
    </div>
</div>

<script>
// Constantes pour les éléments DOM
const confirmationModal = document.getElementById('confirmation-modal');
const modalDate = document.getElementById('modal-date');
const modalTime = document.getElementById('modal-time');
const modalAddress = document.getElementById('modal-address');
const modalNotes = document.getElementById('modal-notes');
const addressError = document.getElementById('address-error');
const bookingForm = document.getElementById('booking-form');
const appointmentDate = document.getElementById('appointment-date');
const appointmentTime = document.getElementById('appointment-time');
const addressInput = document.getElementById('address');
const notesInput = document.getElementById('notes');

let selectedDay = '';
let selectedHour = '';

function selectHour(day, hour) {
    // Stocker la date et l'heure sélectionnées
    selectedDay = day;
    selectedHour = hour;

    // Afficher la modale
    modalDate.textContent = day;
    modalTime.textContent = hour;
    confirmationModal.classList.remove('hidden');
}

function closeModal() {
    // Cacher la modale et réinitialiser les champs
    confirmationModal.classList.add('hidden');
    modalAddress.value = '';
    modalNotes.value = '';
    addressError.classList.add('hidden');
}

function submitBooking() {
    // Récupérer les valeurs de l'adresse et des notes
    const address = modalAddress.value.trim();
    const notes = modalNotes.value.trim();

    // Valider l'adresse
    if (!address) {
        addressError.classList.remove('hidden');
        return;
    }

    // Remplir le formulaire avec les données
    appointmentDate.value = selectedDay;
    appointmentTime.value = selectedHour;
    addressInput.value = address;
    notesInput.value = notes;

    // Soumettre le formulaire
    bookingForm.submit();
}
</script>
@endsection