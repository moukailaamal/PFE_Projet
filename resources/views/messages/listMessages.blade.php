@extends('layouts.app')

@section('title', 'Liste des Messages')
@section('content')
@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 

<section class="py-5">
    <div class="container mx-auto px-4 py-5">
  
      <div class="flex flex-wrap -mx-4">
  
        <div class="w-full">
  
          <h5 class="font-bold mb-3 text-center lg:text-left">Messages</h5>
  
          <div class="card bg-white rounded-lg shadow">
            <div class="card-body p-0">
  
              <ul class="list-none m-0">
                @forelse($conversations as $conversation)
                <li class="p-2 border-b hover:bg-gray-50 {{ $loop->first ? 'bg-gray-100' : '' }}">
                  <a href="{{ route('chat', $conversation->interlocutor->id) }}" class="flex justify-between">
                    <div class="flex">
                      <img src="{{ $conversation->interlocutor->photo ? asset('storage/' . $conversation->interlocutor->photo) : asset('images/default-avatar.png') }}" 
                           alt="avatar"
                           class="rounded-full self-center me-3 shadow-md" 
                           width="60"
                           height="60">
                      <div class="pt-1">
                        <p class="font-bold mb-0">{{ $conversation->interlocutor->first_name }} {{ $conversation->interlocutor->last_name }}</p>
                        <p class="text-sm text-gray-500">
                          {{ Str::limit($conversation->content, 30) }}
                        </p>
                      </div>
                    </div>
                    <div class="pt-1">
                      <p class="text-sm text-gray-500 mb-1">
                       
                        {{ $conversation->send_date->format('M j, Y g:i A') }}
                      </p>
                      @if($conversation->unread_count ?? false)
                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 float-right">
                          {{ $conversation->unread_count }}
                        </span>
                      @endif
                    </div>
                  </a>
                </li>
                @empty
                <li class="p-4 text-center text-gray-500">
                  You have not done any conversation yet.
                </li>
                @endforelse
              </ul>
  
            </div>
          </div>
  
        </div>
  
      </div>
  
    </div>
</section>

@endsection