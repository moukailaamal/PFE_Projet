<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;
use App\Models\Reservation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index($reservationId = null, $receiverId = null)
    {
        // Vérification des paramètres
        if ($reservationId) {
            // Mode réservation
            $reservation = Reservation::findOrFail($reservationId);
            $otherUser = auth()->id() === $reservation->client_id 
                ? $reservation->technician 
                : $reservation->client;
            
            $existingMessages = Message::where('reservation_id', $reservationId)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            // Mode conversation directe
            $reservation = null;
            $otherUser = User::findOrFail($receiverId);
            
            $existingMessages = Message::where(function($query) use ($receiverId) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $receiverId);
                })
                ->orWhere(function($query) use ($receiverId) {
                    $query->where('sender_id', $receiverId)
                          ->where('receiver_id', auth()->id());
                })
                ->whereNull('reservation_id')
                ->orderBy('created_at', 'asc')
                ->get();
        }
    
        $isFirstConversation = $existingMessages->isEmpty();
    
        return view('chat', [
            'reservation' => $reservation,
            'receiver' => $otherUser,
            'messages' => $existingMessages,
            'isFirstConversation' => $isFirstConversation,
            'isDirectChat' => is_null($reservationId)
        ]);
    }
    public function sendMessage(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'receiver_id' => [
                'required',
                'exists:users,id',
                Rule::notIn([auth()->id()]) // Empêche l'envoi à soi-même
            ],
            'reservation_id' => [
                'nullable',
                'exists:reservations,id',
                function ($attribute, $value, $fail) {
                    // Vérifie que l'utilisateur a accès à la réservation
                    if ($value && !auth()->user()->reservations()->where('id', $value)->exists()) {
                        $fail("Vous n'avez pas accès à cette réservation.");
                    }
                }
            ]
        ]);
    
        // Création du message
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'reservation_id' => $validated['reservation_id'],
            'content' => strip_tags($validated['content']), // Sécurité contre le XSS
            'send_date' => now(),
            'is_read' => false,
            'message_type' => 'text'
        ]);
    
        // Détermination du canal
        $channel = $validated['reservation_id'] 
            ? 'chat.reservation.'.$validated['reservation_id']
            : 'chat.direct.'.min(auth()->id(), $validated['receiver_id']).'-'.max(auth()->id(), $validated['receiver_id']);
    
        // Diffusion de l'événement
        broadcast(new MessageSent($message, $channel))->toOthers();
    
        // Retour de la réponse
        return response()->json([
            'status' => 'success',
            'message' => $message->load('sender'), // Charge la relation sender
            'channel' => $channel // Pour debug
        ], 201);
    }
    
    public function getMessages($reservationId)
    {
        $messages = Message::where('reservation_id', $reservationId)
                    ->with(['sender', 'receiver'])
                    ->orderBy('send_date')
                    ->get();
    
        return response()->json($messages);
    }
    
    public function markAsRead(Request $request)
{
    Message::whereIn('id', $request->message_ids)
           ->where('receiver_id', auth()->id())
           ->update(['is_read' => true]);

    return response()->json(['status' => 'success']);
}
}