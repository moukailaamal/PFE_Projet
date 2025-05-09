@extends('layouts.app')

@section('title', 'Chat')
@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 
@section('content')
<section class="py-5">
    <div class="container mx-auto px-4 py-5 mt-16">
  
      <div class="flex flex-wrap -mx-4">
  
        <div class="w-full md:w-1/2 lg:w-7/12 xl:w-2/3 px-4">
          
          <div id="chat-body" class="mb-4" style="height: 500px; overflow-y: auto;">
            <!-- Big centered person's profile -->
          <div class="flex flex-col items-center justify-center mb-8 p-6 bg-white rounded-xl shadow-lg">
            @php
              $receiver = App\Models\User::find($receiver_id);
            @endphp
            <img src="{{ $receiver->photo ? asset('storage/' . $receiver->photo) : asset('images/default-avatar.png') }}" 
                 alt="avatar" class="rounded-full w-24 h-24 mb-4 border-4 border-blue-100 shadow-md">
            <h3 class="text-2xl font-bold text-gray-800">{{ $receiver->first_name }} {{ $receiver->last_name }}</h3>
            <p class="text-gray-500 mt-1">{{ $receiver->role }}</p>
          </div>
            <!-- Display previous messages here -->
            @foreach($messages as $message)
              @if($message->sender_id == auth()->id())
                <!-- Message sent by current user -->
                <div class="flex justify-end mb-4">
                  <div class="card bg-white rounded-lg shadow w-fu"ll">
                    <div class="card-header flex justify-between p-3 border-b">
                      <p class="font-bold mb-0">{{ auth()->user()->first_name }}</p>
                      <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> {{ $message->send_date->format('M j, Y g:i A') }}</p>
                    </div>
                    <div class="card-body p-3">
                      <p class="mb-0">{{ $message->message }}</p>
                    </div>
                  </div>
                  <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}" alt="avatar"
                    class="rounded-full self-start ms-3 shadow-md" width="60">
                </div>
              @else
                <!-- Message received from other user -->
                <div class="flex justify-start mb-4">
                  <img src="{{ $message->sender->photo ? asset('storage/' . $message->sender->photo) : asset('images/default-avatar.png') }}" alt="avatar"
                    class="rounded-full self-start me-3 shadow-md" width="60">
                  <div class="card bg-white rounded-lg shadow flex-1">
                    <div class="card-header flex justify-between p-3 border-b">
                      <p class="font-bold mb-0">{{ $message->sender->first_name }}</p>
                      <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> {{ $message->send_date->format('M j, Y g:i A') }}</p>
                    </div>
                    <div class="card-body p-3">
                      <p class="mb-0">{{ $message->message }}</p>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
          </div>

          <div class="flex items-center mt-4">
            <input type="hidden" id="receiver_id" value="{{ $receiver_id }}"> 
            <input type="text" id="message" class="border rounded p-2 w-full" placeholder="Tapez votre message..." autocomplete="off">
            <button id="sendBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full ml-2 transition duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
              </svg>
            </button>
          </div>
        </div>
  
      </div>
    </div>
</section>

@vite('resources/js/app.js')

@if(config('broadcasting.default') === 'pusher')
<script>
    $(document).ready(function() {
        // Listen to the chat-room channel
        Echo.channel('chat-room')
            .listen('MessageSent', (e) => {
                let userId = "{{ auth()->id() }}";
                let receiverId = $('#receiver_id').val();
                
                console.log('Message received:', e); // Debug log
                
                // Only process messages relevant to this chat
                if ((e.message.sender_id == userId && e.message.receiver_id == receiverId) || 
                    (e.message.sender_id == receiverId && e.message.receiver_id == userId)) {
                    
                    let messageHtml;
                    
                    if (e.message.sender_id == userId) {
                        // Message sent by current user
                        messageHtml = `
                            <div class="flex justify-end mb-4">
                                <div class="card bg-white rounded-lg shadow w-full">
                                    <div class="card-header flex justify-between p-3 border-b">
                                        <p class="font-bold mb-0">{{ auth()->user()->first_name }}</p>
                                        <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> maintenant</p>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="mb-0">${e.message.message}</p>
                                    </div>
                                </div>
                                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}" 
                                    alt="avatar" class="rounded-full self-start ms-3 shadow-md" width="60">
                            </div>
                        `;
                    } else {
                        // Message received from other user
                        messageHtml = `
                            <div class="flex justify-start mb-4">
                                <img src="${e.sender_photo || '{{ asset('images/default-avatar.png') }}'}" alt="avatar"
                                    class="rounded-full self-start me-3 shadow-md" width="60">
                                <div class="card bg-white rounded-lg shadow flex-1">
                                    <div class="card-header flex justify-between p-3 border-b">
                                        <p class="font-bold mb-0">${e.sender_name}</p>
                                        <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> maintenant</p>
                                    </div>
                                    <div class="card-body p-3">
                                        <p class="mb-0">${e.message.message}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                    $('#chat-body').append(messageHtml);
                    
                    // Scroll to bottom of chat
                    var chatBody = document.getElementById('chat-body');
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            });
        
        // Debugging Pusher connection
        window.Echo.connector.pusher.connection.bind('state_change', (states) => {
            console.log('Pusher connection state changed:', states);
        });
        
        window.Echo.connector.pusher.connection.bind('error', (error) => {
            console.error('Pusher error:', error);
        });
    });
</script>
@endif

<script>
  $(document).ready(function(){
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      function sendMessage() {
          let message = $('#message').val();
          let receiver_id = $('#receiver_id').val();

          if (message.trim() !== "") {
              // Ajouter le message à l'interface immédiatement
              $('#chat-body').append(`
                  <div class="flex justify-end mb-4">
                      <div class="card bg-white rounded-lg shadow w-full">
                          <div class="card-header flex justify-between p-3 border-b">
                              <p class="font-bold mb-0">{{ auth()->user()->first_name }}</p>
                              <p class="text-gray-500 text-sm mb-0"><i class="far fa-clock"></i> maintenant</p>
                          </div>
                          <div class="card-body p-3">
                              <p class="mb-0">${message}</p>
                          </div>
                      </div>
                      <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}" alt="avatar"
                          class="rounded-full self-start ms-3 shadow-md" width="60">
                  </div>
              `);

              // Nettoyer le champ de message
              $("#message").val('');

              // Scroll to bottom of chat
              var chatBody = document.getElementById('chat-body');
              chatBody.scrollTop = chatBody.scrollHeight;

              // Envoyer le message via AJAX
              $.ajax({
                  url: "{{ route('send-message') }}",
                  method: 'POST',
                  data: { 
                      message,
                      receiver_id
                  },
                  success: function(response) {
                      console.log(response);
                  },
                  error: function(error) {
                      console.log(error.responseJSON);
                  }
              });
          }
      }

      $('#sendBtn').click(sendMessage);
      
      $('#message').keypress(function(e) {
          if(e.which == 13) {
              sendMessage();
          }
      });
      
      // Scroll to bottom on page load
      var chatBody = document.getElementById('chat-body');
      chatBody.scrollTop = chatBody.scrollHeight;
  });
</script>
@endsection