<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Reservation;
use App\Models\TechnicianDetail;
use Illuminate\Http\Request;


class PaiementController extends Controller
{
    public function indexPaiement($id)
    {
        $reservation = Reservation::findOrFail($id);
        $idtechnician=$reservation->technician_id;
        $technician=TechnicianDetail::find($idtechnician);
        return view('paiements.index', compact('reservation','technician'));
    }

    public function indexPaymentMethod($id)
    {
        $reservation = Reservation::with('technician')->findOrFail($id);
        return view('paiements.payment_methode', compact('reservation'));
    }
    
    public function storePaiement(Request $request, $id)
    {
        
       
        $reservation = Reservation::findOrFail($id);
      
        $paymentData = [
            'technician_id' => $reservation->technician_id,
            'client_id' => $reservation->client_id,
            'amount' =>  $request->amount,
            'reservation_id' => $id,
            'payment_date' => now(),
            'payment_methode' => $request->payment_methode,
        ];

        if ($request->payment_methode == "cash") {
            $paymentData['status'] = 'pending';
        } else {
            $paymentData['status'] = 'paid';
       
        }

        Paiement::create($paymentData);

        // Update reservation status
        $reservation->update(['status' => 'confirmed']);

        return redirect()->route('book.confirmation', $reservation->id)
            ->with('success', 'Payment processed successfully.');
    }
}