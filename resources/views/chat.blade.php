@extends('layouts.app')

@section('content')
<div id="chat-container" 
    @isset($reservation) data-reservation-id="{{ $reservation->id }}" @endisset
    data-current-user-id="{{ auth()->id() }}"
    data-receiver-id="{{ $receiver->id }}"
    class="flex flex-col h-screen">

   <!-- En-tête -->
   <div class="bg-gray-800 text-white p-4">
       @isset($reservation)
           <h2 class="text-xl font-bold">Chat: Réservation #{{ $reservation->id }}</h2>
       @else
           <h2 class="text-xl font-bold">Discussion avec {{ $receiver->name }}</h2>
       @endisset
   </div>

   <!-- Messages -->
   <div id="messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-gray-50">
       @foreach($messages as $message)
           @include('partials.message', ['message' => $message])
       @endforeach
   </div>

   <!-- Formulaire -->
   <form id="message-form" class="p-4 border-t bg-white">
       @isset($reservation)
           <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
       @endisset
       <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
       
       <div class="flex gap-2">
           <input type="text" name="content" placeholder="Écrivez votre message..."
                  class="flex-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
           
           <button type="submit" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
               Envoyer
           </button>
       </div>
   </form>
</div>
@endsection