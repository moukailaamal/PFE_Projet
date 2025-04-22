<?php

namespace App\Http\Controllers;

use Exception;  
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function indexListMessage()
    {
        $auth_id = auth()->id();
        
        // Récupérer les derniers messages avec chaque interlocuteur
        $conversations = Message::select('*')
            ->whereIn('id', function($query) use ($auth_id) {
                $query->select(DB::raw('MAX(id)'))
                    ->from('messages')
                    ->where(function($q) use ($auth_id) {
                        $q->where('sender_id', $auth_id)
                          ->orWhere('receiver_id', $auth_id);
                    })
                    ->groupBy(DB::raw('
                        CASE 
                            WHEN sender_id = '.$auth_id.' THEN receiver_id
                            ELSE sender_id
                        END'));
            })
            ->with(['sender', 'receiver'])
            ->orderBy('send_date', 'desc')
            ->get()
            ->map(function($message) use ($auth_id) {
                // Déterminer qui est l'interlocuteur
                $message->interlocutor = ($message->sender_id == $auth_id) 
                    ? $message->receiver 
                    : $message->sender;
                return $message;
            });
        
        return view('listMessages', ['conversations' => $conversations]);
    }
    public function indexMessage($id) {
        $auth_id = Auth()->id();
    
        $messages = Message::where(function($query) use ($auth_id, $id) {
                // Messages où l'utilisateur connecté est l'expéditeur et l'autre utilisateur est le destinataire
                $query->where('sender_id', $auth_id)
                      ->where('receiver_id', $id);
            })
            ->orWhere(function($query) use ($auth_id, $id) {
                // Messages où l'utilisateur connecté est le destinataire et l'autre utilisateur est l'expéditeur
                $query->where('sender_id', $id)
                      ->where('receiver_id', $auth_id);
            })
            ->orderBy('send_date', 'desc')
            ->get();
    
        return view('chat', compact('messages'));
    }
    
    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'receiver_id' => 'required|exists:users,id'
            ]);
    
            $msg = Message::create([
                'message' => $request->message,
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
            ]);
    
            if ($msg) {
                MessageSent::dispatch($msg);
                return response()->json(['msg' => 'message send successfully', 'le message' => $msg->message]);
            }
        } catch (Exception $ex) {
            return response()->json([
                'error' => "Something went wrong: " . $ex->getMessage()
            ]);
        }
    }
}
