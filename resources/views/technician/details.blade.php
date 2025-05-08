@extends('layouts.app')

@section('title', 'Technician Details')

@include('layouts.partials.navbar-dashboard')  
@section('content')
<div class="w-full grid grid-cols-1 xl:grid-cols-4 gap-4 mt-16">
    <!-- Main Section (Technician Details) -->
    <div class="xl:col-span-3">
        <div class="flex flex-col md:flex-row items-center justify-between mb-4">
            <div class="flex-shrink-0 text-center md:text-left">
                <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Technician Details</span>
                <h3 class="text-base font-normal text-gray-500">Complete Information</h3>
            </div>
            <div class="flex items-center justify-end flex-1 text-gray-500 text-base font-bold mt-4 md:mt-0">
                <span class="mr-2">Status :</span>
                <span class="text-green-500">{{ $user->status }}</span>
            </div>
        </div>
        <div class="bg-white shadow-xl rounded-lg p-6">
            <div class="flex flex-col md:flex-row items-center space-x-0 md:space-x-6 mb-6">
                <!-- Profile Photo -->
                <div class="flex-shrink-0 mb-4 md:mb-0">
                    <img class="h-50 w-64 rounded-lg object-cover shadow-md" 
                      src="{{ asset('storage/' . $technician->user->photo) }}"
                         alt="Profile Photo">
                </div>
                <div class="text-center md:text-left">
                    <p class="text-xl font-semibold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                    <p class="text-sm text-gray-500">Senior Technician</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold text-gray-700">Personal Information</p>
                    <div class="mt-4 space-y-2">
                        <p><strong>Email :</strong> {{ $user->email }}</p>
                        <p><strong>Phone number :</strong> {{ $user->phone_number }}</p>
                        <p><strong>Location :</strong> {{ $technician->location }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-lg font-semibold text-gray-700">Skills</p>
                    <div class="mt-4 space-y-2">
                        @if ($technician->description)
                            @foreach (explode(',', $technician->description) as $skill)
                                <div class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mr-2 mb-2">
                                    {{ trim($skill) }}
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No skills added yet.</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-lg font-semibold text-gray-700">Services</p>
                        <div class="mt-4 space-y-2">
                            @foreach ($services as $service)
                                <div class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mr-2 mb-2">
                                    {{ $service->title }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        @auth
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            
                        <a href="{{ route('book.days', $user->id) }}">
                            <button type="button" class="flex-1 flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <span>Book now</span>
                            </button>
                        </a>
                           
                       
                        <a href="{{ route('chat', $technician->user->id) }}">
                            <button type="button" class="flex-1 flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                <input type="hidden" value="{{ $technician->id }}" id="receiver_id">
                                <span>Send message</span>
                            </button>
                        </a>
                        @else
                        <button data-modal-toggle="auth-modal" type="button" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Pay and Book now </span>
                        </button>
                        <button data-modal-toggle="auth-modal" type="button" class="flex-1 flex items-center justify-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-3 px-4 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            
                            <span>Send message</span>
                        </button>
                      
                        @endauth
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-lg font-semibold text-gray-700">Experience</p>
                <div class="mt-4 space-y-2">
                    <p><strong>Specialty :</strong> {{ $technician->specialty }}</p>
                    <p><strong>price for each service :</strong> {{ $technician->price }}$</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-lg font-semibold text-gray-700">Availability</p>
                <div class="mt-4 space-y-2">
                    @if (empty($technician->availability))
                        <p class="text-gray-500">No availability set.</p>
                    @else
                        @foreach ($technician->availability as $availability)
                            <p>
                                <strong>{{ $availability['day'] }}:</strong>
                                {{ $availability['start_time'] }} - {{ $availability['end_time'] }}
                            </p>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        

        <!-- Section to leave a review -->
        <div class="mt-6 bg-white shadow-xl rounded-lg p-6">
            <p class="text-lg font-semibold text-gray-700">Leave a review</p>
            @auth               
            <form method="POST" action="{{ route('store.review') }}" class="mt-4">
                @csrf
                <div class="space-y-4">
                    <!-- Star Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rating</label>
                        <div class="flex items-center space-x-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" class="text-gray-300 hover:text-yellow-500 focus:outline-none" data-rating="{{ $i }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" value="0">
                        <input type="hidden" name="client_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="technician_id" value="{{ $technician->user_id }}">
                    </div>
                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                        <textarea id="comment" name="comment" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Write your review here..."></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Submit the review
                        </button>
                    </div>
                </div>
            </form>
            @else
            <div class="mt-4 p-4 bg-gray-50 rounded-lg text-center">
                <p class="text-gray-700 mb-4">You need to be logged in to leave a review</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors">
                        Login
                    </a>
                    <a href="{{ route('registerClient') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Subscribe
                    </a>
                </div>
            </div>
            @endauth
        </div>
    </div>

  
   <!-- Comments and Reviews Section -->
   <div class="xl:col-span-1">
    <div class="bg-white shadow-xl rounded-lg p-6">
        <p class="text-lg font-semibold text-gray-700">Comments and Reviews</p>
        <div class="mt-4 space-y-4">
            @foreach ($avis as $av)
            <div class="flex items-start group relative" data-avis-id="{{ $av->id }}">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full shadow-md" src="{{ asset('storage/' . $av->client->photo) }}" alt="User Avatar">
                </div>
                <div class="ml-4 flex-1">
                    <!-- Display mode -->
                    <div id="display-mode-{{ $av->id }}">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $av->client->first_name }} {{ $av->client->last_name }}</p>
                                <p class="text-sm text-gray-500" id="comment-text-{{ $av->id }}">{{ $av->comment }}</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-yellow-500" id="rating-display-{{ $av->id }}">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $av->rating) ★ @else ☆ @endif
                                        @endfor
                                    </span>
                                    <span class="ml-2 text-sm text-gray-700">{{ $av->rating }}/5</span>
                                </div>
                            </div>
                            <div class="flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                @if(auth()->check() && auth()->user()->id == $av->client_id)
                                    <button onclick="enableEdit({{ $av->id }})" 
                                        class="text-blue-600 hover:text-blue-800 text-sm p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                @endif
                                
                                @if(auth()->check() && (auth()->user()->id == $av->client_id || auth()->user()->id == $av->technician_id))
                                    <form method="POST" action="{{ route('delete.review', $av->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this review?')" class="text-red-600 hover:text-red-800 text-sm p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">{{ $av->review_date->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Edit mode (hidden by default) -->
                    <div id="edit-mode-{{ $av->id }}" class="hidden">
                        <form method="POST" action="{{ route('update.review', $av->id) }}" class="space-y-3">
                            @csrf
                            @method('PUT')
                            <textarea id="edit-comment-{{ $av->id }}" 
                                      name="comment"
                                      class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:shadow-outline"
                                      rows="3">{{ $av->comment }}</textarea>
                            
                            <div class="flex items-center">
                                <span class="mr-2 text-gray-700">Rating:</span>
                                <div class="rating-stars flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="star text-2xl cursor-pointer" 
                                              data-rating="{{ $i }}" 
                                              data-avis-id="{{ $av->id }}"
                                              onmouseover="highlightStars(this, {{ $av->id }})"
                                              onmouseout="resetStars({{ $av->id }})"
                                              onclick="setRating({{ $i }}, {{ $av->id }})">
                                            {{ $i <= $av->rating ? '★' : '☆' }}
                                        </span>
                                    @endfor
                                    <input type="hidden" name="rating" id="rating-input-{{ $av->id }}" value="{{ $av->rating }}">
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-2 mt-2">
                                <button type="button" 
                                        onclick="cancelEdit({{ $av->id }})" 
                                        class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
<div id="auth-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow-lg w-96 p-6">
        <!-- Changé data-modal-toggle en data-modal-hide -->
        <button type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600" data-modal-hide="auth-modal">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <p class="mb-4"> you have to connect.</p>
        
        <div class="flex justify-end space-x-2">
            <!-- Changé data-modal-toggle en data-modal-hide -->
            <button type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2" data-modal-hide="auth-modal">Cancel</button>
            <a href="{{ route('login') }}" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-4 py-2">Login</a>
        </div>
    </div>
</div>

<!-- Script to handle star rating -->
<script>
 function enableEdit(avisId) {
        // Hide display mode
        document.getElementById(`display-mode-${avisId}`).style.display = 'none';
        // Show edit mode
        document.getElementById(`edit-mode-${avisId}`).classList.remove('hidden');
        // Focus on the textarea
        document.getElementById(`edit-comment-${avisId}`).focus();
    }

    function cancelEdit(avisId) {
        // Show display mode
        document.getElementById(`display-mode-${avisId}`).style.display = 'block';
        // Hide edit mode
        document.getElementById(`edit-mode-${avisId}`).classList.add('hidden');
    }

    function highlightStars(starElement, avisId) {
        const rating = parseInt(starElement.getAttribute('data-rating'));
        const stars = document.querySelectorAll(`.star[data-avis-id="${avisId}"]`);
        
        stars.forEach((star, index) => {
            if (index < rating) {
                star.textContent = '★';
                star.classList.add('text-yellow-500');
            } else {
                star.textContent = '☆';
                star.classList.remove('text-yellow-500');
            }
        });
    }

    function resetStars(avisId) {
        const currentRating = parseInt(document.getElementById(`rating-input-${avisId}`).value);
        const stars = document.querySelectorAll(`.star[data-avis-id="${avisId}"]`);
        
        stars.forEach((star, index) => {
            if (index < currentRating) {
                star.textContent = '★';
                star.classList.add('text-yellow-500');
            } else {
                star.textContent = '☆';
                star.classList.remove('text-yellow-500');
            }
        });
    }

    function setRating(rating, avisId) {
        document.getElementById(`rating-input-${avisId}`).value = rating;
        resetStars(avisId); // This will now show the selected rating
    }
    // Original star rating for new reviews
    document.querySelectorAll('[data-rating]').forEach(button => {
        button.addEventListener('click', () => {
            const rating = button.getAttribute('data-rating');
            document.getElementById('rating').value = rating;
            document.querySelectorAll('[data-rating]').forEach(star => {
                if (star.getAttribute('data-rating') <= rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-500');
                } else {
                    star.classList.remove('text-yellow-500');
                    star.classList.add('text-gray-300');
                }
            });
        });
    });

    // Delete confirmation
    function confirmDelete(avisId) {
        if (confirm('Are you sure you want to delete this review?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/avis/${avisId}`;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = document.querySelector('meta[name="csrf-token"]').content;
            form.appendChild(csrf);
            
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = 'DELETE';
            form.appendChild(method);
            
            document.body.appendChild(form);
            form.submit();
        }
        return false;
    }

    // Auth modal handling
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('auth-modal');
        const openButtons = document.querySelectorAll('[data-modal-toggle="auth-modal"]');
        const closeButtons = document.querySelectorAll('[data-modal-hide="auth-modal"]');

        openButtons.forEach(button => {
            button.addEventListener('click', () => {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            });
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.setAttribute('aria-hidden', 'true');
            }
        });
    });
</script>
@endsection