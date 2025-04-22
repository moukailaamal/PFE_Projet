@extends('layouts.app')

@section('title', 'dashboard')
@vite('resources/js/app.js')
@section('content')
<div class="container mx-auto px-4 py-8 mt-16">
    @section('header')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <section class="py-5">
                    <div class="container mx-auto px-4 py-5">
                        <div class="flex justify-center">
                            <div class="w-full md:w-2/3 lg:w-1/2 xl:w-1/3">
                                <div class="bg-white rounded-lg shadow" id="chat1">
                                    <div class="bg-blue-500 text-white p-3 flex justify-between items-center rounded-t-lg">
                                        <i class="fas fa-angle-left"></i>
                                        <p class="mb-0 font-bold">Live chat</p>
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="p-4">
                                        <div id="chat-body">
                                          
                                        </div>
                                     
                                    
                                        <!-- Input Area -->
                                        <div class="relative">
                                            <textarea id="message" class="w-full p-2 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message" rows="4"></textarea>
                                            <input type="hidden"name="receiver_id" id="receiver_id" value="2">
                                            <div class="mt-2 text-right">
                                                <button id="sendBtn" class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>


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
            
            if(message.trim() === '') return;
            
            // Ajouter le message immédiatement
            $('#chat-body').append(`
                <div class="flex justify-end mb-4">
                    <div class="p-3 me-3 border rounded-[15px] bg-gray-100">
                        <p class="text-sm mb-0">${message}</p>
                    </div>
                    <img src="{{ asset('images/users/michael-gough.png') }}" alt="avatar 1" class="w-[45px] h-full">
                </div>
            `);
            
            // Envoyer le message
            $.ajax({
                url: "{{ route('send-message') }}",
                method: 'POST',
                data: { 
                    message,
                    receiver_id
                },
                success: function(response) {
                    $("#message").val('');
                },
                error: function(error) {
                    console.log(error.responseJSON);
                }
            });
        });
    });
</script>

@if(config('broadcasting.default') === 'pusher')
<script>
    Echo.channel('chat-room')
        .listen('MessageSent', (e) => {
            if (e.message) {
                let userId = "{{ auth()->id() }}";
                if (e.message.sender_id == userId) {
                    $('#chat-body').append(`
                        <div class="flex justify-start mb-4">
                            <img src="{{ asset('images/users/helene-engels.png') }}" alt="avatar 1" class="w-12 h-12 rounded-full">
                            <div class="p-3 ml-3 bg-blue-100/20 rounded-lg">
                                <p class="text-sm mb-0">${e.message.message}</p>
                            </div>
                        </div>
                    `);
                } else {
                    $('#chat-body').append(`
                        <div class="flex justify-end mb-4">
                            <div class="p-3 me-3 border rounded-[15px] bg-gray-100">
                                <p class="text-sm mb-0">${e.message.message}</p>
                            </div>
                            <img src="{{ asset('images/users/michael-gough.png') }}" alt="avatar 1" class="w-[45px] h-full">
                        </div>
                    `);
                }
            }
        });
</script>
@endif

@endsection