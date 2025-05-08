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
        try {
            // Find the reservation
            $reservation = Reservation::findOrFail($id);
            
            // Get user and technician details
            $user = User::findOrFail($reservation->technician_id); // Changed from $reservation->technician
            $technician = TechnicianDetail::where('user_id', $user->id)->firstOrFail();
    
            // Validate payment method
            $validatedData = $request->validate([
                'payment_method' => 'required|in:cash,card,online',
            ]);
    
            // Prepare payment data
            $paymentData = [
                'technician_id' => $reservation->technician_id,
                'client_id' => $reservation->client_id,
                'amount' => $technician->price, 
                'reservation_id' => $reservation->id,
                'payment_date' => now(),
                'payment_method' => $validatedData['payment_method'],
                'status' => $validatedData['payment_method'] == "cash" ? 'pending' : 'paid'
            ];
    
            // Create payment record
            $payment = Paiement::create($paymentData);
    
            // Update reservation status
            if($payment->payment_method=="online"){
            $reservation->update(['status' => 'confirmed']);
            }
            return redirect()->route('book.confirmation', $reservation->id)
                ->with('success', 'Payment processed successfully.');
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()
                ->with('error', 'Reservation or technician not found.')
                ->withInput();
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Payment processing error: ' . $e->getMessage(), [
                'exception' => $e,
                'reservation_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'An error occurred while processing your payment. Please try again.')
                ->withInput();
        }
    }
}