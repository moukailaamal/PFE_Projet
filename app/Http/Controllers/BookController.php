<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\TechnicienDetail;
use Carbon\Carbon; // N'oubliez pas d'importer Carbon pour manipuler les dates

class BookController extends Controller
{
    /**
     * Affiche les détails du technicien et les services disponibles.
     */
    public function BookTechnician($id)
    {
        // Récupérer le technicien
        $technician = TechnicienDetail::find($id);

        // Vérifier si le technicien existe
        if (!$technician) {
            return redirect()->back()->with('error', 'Technicien non trouvé.');
        }

        // Récupérer les services du technicien
        $services = Service::where('technician_id', $id)->get();

        // Retourner la vue avec les données
        return view('book', compact('technician', 'services'));
    }

    /**
     * Affiche le formulaire de réservation avec les disponibilités du technicien.
     */
    public function showBookingForm($id)
    {
        // Récupérer le technicien
        $technician = TechnicienDetail::findOrFail($id);

        // Récupérer les réservations non annulées
        $reservations = Reservation::where('technician_id', $id)
                                   ->where('status', '!=', 'canceled')
                                   ->get();

        // Calculer les créneaux disponibles
        $availableSlots = $this->calculateAvailableSlots($technician, $reservations);

        // Retourner la vue avec les données
        return view('booking.form', compact('technician', 'availableSlots'));
    }

    /**
     * Stocke une nouvelle réservation.
     */
    public function storeReservation(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'technician_id' => 'required|exists:techniciens_details,id',
            'appointment_date' => 'required|date',
        ]);

        // Vérifier si le créneau est disponible
        $isAvailable = $this->isSlotAvailable($request->technician_id, $request->appointment_date);

        if (!$isAvailable) {
            return back()->with('error', 'Ce créneau n\'est plus disponible.');
        }

        // Créer la réservation
        $reservation = Reservation::create([
            'client_id' => auth()->id(),
            'technician_id' => $request->technician_id,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'creation_date' => now(),
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('reservations.show', $reservation->id)
                         ->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Calcule les créneaux disponibles pour un technicien.
     */
    private function calculateAvailableSlots($technician, $reservations)
    {
        $availableSlots = [];

        // Parcourir les disponibilités du technicien
        foreach ($technician->availability as $availability) {
            $startTime = Carbon::parse($availability['start_time']);
            $endTime = Carbon::parse($availability['end_time']);

            // Générer des créneaux de 1 heure
            while ($startTime->lt($endTime)) {
                $slotEnd = $startTime->copy()->addMinutes(60);

                // Vérifier si le créneau est déjà réservé
                $isBooked = $reservations->contains(function ($reservation) use ($startTime, $slotEnd) {
                    return Carbon::parse($reservation->appointment_date)->between($startTime, $slotEnd);
                });

                // Ajouter le créneau s'il est disponible
                if (!$isBooked) {
                    $availableSlots[] = [
                        'start' => $startTime->format('Y-m-d H:i:s'),
                        'end' => $slotEnd->format('Y-m-d H:i:s'),
                    ];
                }

                // Passer au créneau suivant
                $startTime->addMinutes(60);
            }
        }

        return $availableSlots;
    }

    /**
     * Vérifie si un créneau est disponible pour un technicien.
     */
    private function isSlotAvailable($technicianId, $appointmentDate)
    {
        // Récupérer les réservations non annulées
        $reservations = Reservation::where('technician_id', $technicianId)
                                   ->where('status', '!=', 'canceled')
                                   ->get();

        // Vérifier si le créneau est déjà réservé
        foreach ($reservations as $reservation) {
            if (Carbon::parse($reservation->appointment_date)->eq(Carbon::parse($appointmentDate))) {
                return false;
            }
        }

        return true;
    }
}