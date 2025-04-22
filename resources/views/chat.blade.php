@extends('layouts.app')

@section('title', 'Chat')

@section('content')
<section class="py-5">
    <div class="container mx-auto px-4 py-5 mt-16">
  
      <div class="flex flex-wrap -mx-4">
  
        <div class="w-full md:w-1/2 lg:w-5/12 xl:w-1/3 px-4 mb-4 md:mb-0">
          <h5 class="font-bold mb-3 text-center lg:text-left">Member</h5>

          <div class="card bg-white rounded-lg shadow">
            <div class="card-body p-0">
              <ul class="list-none m-0">
                @foreach ($receivedMessages->unique('sender_id') as $message)
                <li class="p-2 border-b bg-gray-100">
                  <a href="#!" id="openMessage" class="flex justify-between">
                    <div class="flex">
                      <img src="{{ $message->sender && $message->sender->photo ? asset('storage/' . $message->sender->photo) : asset('images/default-avatar.png') }}" 
                           alt="avatar"
                           class="rounded-full self-center me-3 shadow-md" width="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">
                          {{ $message->sender->first_name ?? 'Inconnu' }} {{ $message->sender->last_name ?? '' }}
                        </p>
                        <p class="text-sm text-gray-500">
                          {{ $message->message }}
                        </p>
                      </div>
                    </div>
                    <div class="pt-1 text-right">
                      <p class="text-sm text-gray-500 mb-1">
                        {{ \Carbon\Carbon::parse($message->send_date)->diffForHumans() }}
                      </p>
                      @if (!$message->is_read)
                      <span class="bg-red-600 text-white text-xs px-2 py-1 rounded float-right">1</span>
                      @endif
                    </div>
                  </a>
                </li>
              @endforeach
              
              </ul>
            </div>
          </div>
        </div>
        
        <div class="w-full md:w-1/2 lg:w-7/12 xl:w-2/3 px-4">
          <div id="chat-body" class="mb-4"></div>

          <!-- Champs nécessaires pour AJAX -->
          <input type="hidden" id="receiver_id" value="{{ $receiver_id }}"> 
          <input type="text" id="message" class="border rounded p-2 w-full mb-2" placeholder="Tapez votre message...">

          <button id="sendBtn" type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-full float-end transition duration-200">Send</button>
        </div>
  
      </div>
    </div>
</section>

@vite('resources/js/app.js')

@if(config('broadcasting.default') === 'pusher')
<script>
    Echo.channel('chat-room')
        .listen('MessageSent', (e) => {
            if (e.message != null) {
                let userId = "{{ auth()->id() }}";

                if (e.message.sender_id == userId) {
                    $('#chat-body').append(`
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
                          <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('images/default-avatar.png') }}" alt="avatar"
                            class="rounded-full self-start ms-3 shadow-md" width="60">
                        </div>
                    `);
                } else {
                    $('#chat-body').append(`
                        <div class="flex justify-start mb-4">
                          <img src="${e.sender_photo}" alt="avatar"
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
                    `);
                }
            }
            console.log(e.message.message);
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

      $('#sendBtn').click(function(){
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
      });
  });
</script>
@endsection
