<?php
namespace App\Http\Controllers;

use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->input('message');
        $reservationId = $request->input('reservation_id');

        // Diffuser l'événement
        broadcast(new MessageSent($message, $reservationId))->toOthers();

        return response()->json(['status' => 'Message envoyé !']);
    }
}