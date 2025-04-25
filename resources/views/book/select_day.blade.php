@extends('layouts.app')

@section('title', 'Book day now')

@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 
@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Book now</h1>

    <!-- Section pour le calendrier interactif -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Select a day from the calendar</h2>

        <!-- Calendrier interactif -->
        <div id="calendar" class="mb-6"></div>
    </div>
</div>

<!-- Intégration de FullCalendar -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth', // Vue mensuelle
        selectable: true, // Permettre la sélection de jours
        events: function(fetchInfo, successCallback, failureCallback) {
            // Récupérer la date d'aujourd'hui en UTC
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Ignorer l'heure pour ne comparer que les dates

            // Convertir les disponibilités en événements FullCalendar
            const events = [
                @foreach($availability as $slot)
                {
                    title: '{{ $slot['start_time'] }} - {{ $slot['end_time'] }}', // Plage horaire disponible
                    daysOfWeek: [getDayIndex('{{ $slot['day'] }}')], // Convertir le jour en index
                    color: '#3b82f6', // Couleur pour les jours disponibles
                },
                @endforeach
            ];

            // Filtrer les événements pour n'afficher que ceux à partir d'aujourd'hui
            const filteredEvents = events.map(event => {
                const startDate = new Date(fetchInfo.start); // Début de la période affichée
                const endDate = new Date(fetchInfo.end); // Fin de la période affichée

                // Générer les dates pour chaque jour de la semaine dans la période affichée
                const eventDates = [];
                for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                    // Convertir la date en UTC pour éviter les problèmes de fuseau horaire
                    const currentDate = new Date(d.toISOString().split('T')[0]);

                    // Vérifier si la date correspond au jour de la semaine ET est >= aujourd'hui
                    if (currentDate.getDay() === event.daysOfWeek[0] && currentDate >= today) {
                        eventDates.push(currentDate);
                    }
                }

                // Retourner les événements pour chaque date valide
                return eventDates.map(date => ({
                    title: event.title,
                    start: date.toISOString().split('T')[0], // Format YYYY-MM-DD
                    color: event.color,
                }));
            }).flat(); // Aplatir le tableau de tableaux

            successCallback(filteredEvents); // Passer les événements filtrés à FullCalendar
        },
        dateClick: function(info) {
            // Récupérer le jour de la semaine (ex: "Monday")
            const clickedDay = info.date.toLocaleDateString('en-US', { weekday: 'long' });

            // Vérifier si le jour cliqué est disponible
            const availability = @json($availability); // Convertir la disponibilité en JSON
            const isAvailable = availability.some(slot => slot.day === clickedDay);

            if (isAvailable) {
                // Rediriger vers la page de sélection des heures
                const url = '{{ route("book.hours", ["id" => $technician->id, "day" => "DAY_PLACEHOLDER"]) }}'
                    .replace('DAY_PLACEHOLDER', info.dateStr); // Remplacer le placeholder par la date
                window.location.href = url;
            } else {
                alert('No availability for this day.'); // Avertissement si le jour n'est pas disponible
            }
        }
    });
    calendar.render();
});

// Fonction pour convertir le jour de la semaine en index
function getDayIndex(day) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days.indexOf(day);
}
</script>
@endsection