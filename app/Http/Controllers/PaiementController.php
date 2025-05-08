<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\TechnicianDetail;
use Illuminate\Foundation\Auth\User;


class PaiementController extends Controller
{
    public function indexPaiement($id)
    {
        $reservation = Reservation::findOrFail($id);
        $idtechnician=$reservation->technician_id;
        $technician = TechnicianDetail::where('user_id', $idtechnician)->first();
        return view('paiements.index', compact('reservation','technician'));
    }

    public function indexPaymentMethod($id)
    {
        $reservation = Reservation::with('technician')->findOrFail($id);
        return view('paiements.payment_methode', compact('reservation'));
    }
    
    public function storePaiement(Request $request, $id)
    {
       
        // Find the reservation
        $reservation = Reservation::findOrFail($id);
       
        
        // Get technician details - use first() instead of get() since we need a single record
        $user = User::findOrFail($reservation->technician_id);
        $technician = TechnicianDetail::where('user_id',$user->id)->first();
   
    
        // Prepare payment data
        $paymentData = [
            'technician_id' => $reservation->technician_id,
            'client_id' => $reservation->client_id,
            'amount' => $technician->price, 
            'reservation_id' => $reservation->id,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method == "cash" ? 'pending' : 'paid'
        ];
    
        // Create payment record
        Paiement::create($paymentData);
    
        // Update reservation status
        $reservation->update(['status' => 'confirmed']);
    
        return redirect()->route('book.confirmation', $reservation->id)
            ->with('success', 'Payment processed successfully.');
    }
}