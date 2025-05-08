<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\User;
use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\TechnicianDetail;
use Carbon\Carbon; // Carbon pour manipuler les dates

class BookController extends Controller
{
        public function confirmation($id)
        {
            $reservation = Reservation::with(['technician', 'payment'])->findOrFail($id);
            $payment = Paiement::where('reservation_id', $id)->first();            
            return view('book.confirmation', compact('reservation', 'payment'));
        }
  
    /**
     * Affiche le formulaire de réservation avec les disponibilités du technicien.
     */
    public function showBookingDaysForm($id)
    {
        $user = User::findOrFail($id);
        $technician = TechnicianDetail::where('user_id',$user->id)->first();
       

        // Récupérer les jours disponibles du technicien
        $availability = json_decode($technician->availability, true);

        // Retourner la vue avec les données
        return view('book.select_day', compact('technician', 'availability'));
    }
  /**
     * Stocke une nouvelle réservation.
     */

     public function storeReservation(Request $request)
     {
         // Valider les données entrantes
         $validatedData = $request->validate([
             'technician_id' => 'required|exists:users,id',
             'appointment_date' => 'required|date',
             'appointment_time' => 'required|date_format:H:i',
             'address' => 'required|string|max:255',
             'notes' => 'nullable|string|max:500',
         ]);
     
         // Combiner la date et l'heure pour créer un objet DateTime
         $appointmentDateTime = $validatedData['appointment_date'] . ' ' . $validatedData['appointment_time'];
         
         $user = User::findOrFail($validatedData['technician_id']);
         $technician = TechnicianDetail::where('user_id',$user->id)->first();
        
         try {
            
             // Créer la réservation
             $reservation = Reservation::create([
                 'client_id' => auth()->id(), // ID de l'utilisateur connecté
                 'technician_id' => $user->id,
                 'appointment_date' => $appointmentDateTime, // Date et heure combinées
                 'address' => $validatedData['address'],
                 'notes' => $validatedData['notes'],
                 'status' => 'pending', // Statut par défaut
                 'creation_date' => now(), // Date de création
             ]);
            

             // Rediriger avec un message de succès
             return redirect()->route('payments.PaymentMethod', $reservation->id)
                              ->with('success', 'Réservation créée avec succès.');
         } catch (\Exception $e) {
             // En cas d'erreur, rediriger avec un message d'erreur
             return redirect()->back()
                              ->with('error', 'Une erreur est survenue lors de la création de la réservation.')
                              ->withInput(); // Conserver les données saisies par l'utilisateur
         }
     }

    /**
     * Affiche les heures disponibles pour un jour spécifique.
     */
    public function showBookingHoursForm($id, $day)
    {
        $user = User::findOrFail($id);
        $technician = TechnicianDetail::where('user_id',$user->id)->first();
        $dayOfWeek = date('l', strtotime($day));
        $availability = json_decode($technician->availability, true);
        $availableHours = [];
    
        foreach ($availability as $slot) {
            if ($slot['day'] === $dayOfWeek) {
                $startTime = strtotime($slot['start_time']);
                $endTime = strtotime($slot['end_time']);
                
                // Handle overnight slots (end time is next day)
                if ($endTime <= $startTime) {
                    $endTime += 86400; // Add 24 hours if end time is next day
                }
    
                // Generate hourly slots
                for ($time = $startTime; $time < $endTime; $time += 3600) {
                    $formattedTime = date('H:i', $time);
                    
                    // For times that are actually next day, we need to check if they're valid
                    if ($time >= $startTime && ($time - $startTime) < 86400) {
                        $availableHours[] = $formattedTime;
                    }
                }
                break;
            }
        }
    
        // Check if date is in the past
        $today = now()->startOfDay();
        $selectedDate = \Carbon\Carbon::parse($day)->startOfDay();
    
        if ($selectedDate->lt($today)) {
            $availableHours = [];
        }
    
        // Get existing reservations for this day
        $existingReservations = Reservation::where('technician_id', $technician->user_id)
            ->whereDate('appointment_date', $selectedDate)
            ->get();
    
        $reservedHours = [];
        foreach ($existingReservations as $reservation) {
            $reservationTime = \Carbon\Carbon::parse($reservation->appointment_date);
            $reservedHours[] = $reservationTime->format('H:i');
        }
    
        return view('book.select_hours', compact('technician', 'availableHours', 'day', 'reservedHours'));
    }
  
    public function listAppointmentsTech($id)
    {
        $technician = TechnicianDetail::with('user')->where('user_id', $id)->first();
        
        $reservations = Reservation::where('technician_id', $id)
            ->orderBy('appointment_date', 'asc') 
            ->get();
    
        // Retourner la vue avec les données
        return view('book.listAppointmentsTech', compact('reservations','technician'));
    }
    public function listAppointmentsClient($id)
    {
        $client=User::find($id);
       
        $reservations = Reservation::where('client_id', $id)
            ->orderBy('appointment_date', 'asc') 
            ->get();
    
        // Retourner la vue avec les données
        return view('book.listAppointmentsClient', compact('reservations','client'));
    }
 
  
    
    public function confirmed($id)
    {
        // Récupérer la réservation
        $reservation = Reservation::findOrFail($id);
    
        // Vérifier si la réservation peut être annulée
        if ($reservation->status === 'pending') {
            $reservation->update(['status' => 'confirmed']);
            return redirect()->back()->with('success', 'Reservation confirmed successfully.');
        }
    
        return redirect()->back()->with('error', 'Reservation cannot be confirmed.');
    }
    public function completed($id)
    {
        // Récupérer la réservation
        $reservation = Reservation::findOrFail($id);
    
        // Vérifier si la réservation peut être annulée
        if ($reservation->status === 'confirmed') {
            $reservation->update(['status' => 'completed']);
            return redirect()->back()->with('success', 'Reservation completed successfully.');
        }
    
        return redirect()->back()->with('error', 'Reservation cannot be confirmed.');
    }
    
    
    public function canceled($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        if ($reservation->status === 'pending') {
            $reservation->update(['status' => 'canceled']);
            return redirect()->back()->with('success', 'Reservation canceled successfully.');
        }
    
        return redirect()->back()->with('error', 'Reservation cannot be canceled.');
    }
    
    public function reactivate($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        if ($reservation->status === 'canceled' && \Carbon\Carbon::parse($reservation->appointment_date)->isFuture()) {
            $reservation->update(['status' => 'pending']);
            return redirect()->back()->with('success', 'Reservation reactivated successfully.');
        }
    
        return redirect()->back()->with('error', 'Reservation cannot be reactivated.');
    }

}