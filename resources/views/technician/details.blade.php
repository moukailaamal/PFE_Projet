@extends('layouts.app')

@section('title', 'Technician Details')

@section('content')
<div class="pt-6 px-4">
    <div class="w-full grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4 mt-16">
        <!-- Card for Technician Details -->
        <div class="2xl:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-shrink-0">
                    <span class="text-2xl sm:text-3xl leading-none font-bold text-gray-900">Technician Details</span>
                    <h3 class="text-base font-normal text-gray-500">Complete Information</h3>
                </div>
                <div class="flex items-center justify-end flex-1 text-gray-500 text-base font-bold">
                    <span class="mr-2">Status :</span>
                    <span class="text-green-500">{{ $user->status }}</span>
                </div>
            </div>
            <div class="bg-white shadow-xl rounded-lg p-6">
                <div class="flex items-center space-x-6 mb-6">
                    <!-- Profile Photo -->
                    <div class="flex-shrink-0">
                        <img class="h-50 w-64 rounded-lg object-cover shadow-md" 
                          src="{{ asset('storage/' . $technician->user->photo) }}"
                          
                             alt="Profile Photo">
                    </div>
                    <div>
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
                        <div class="mt-4 space-y-2">
                            <a href="#">
                                <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                                    <!-- SVG Icon -->
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <!-- Button Text -->
                                    <span>Book now</span>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-lg font-semibold text-gray-700">Experience</p>
                    <div class="mt-4 space-y-2">
                        <p><strong>Years of experience :</strong> 5 years</p>
                        <p><strong>Last employer :</strong> TechCorp</p>
                        <p><strong>Specialty :</strong> {{ $technician->specialty }}</p>
                        <p><strong>Rate :</strong> {{ $technician->rate }}$</p>
                    </div>
                </div>
                <div class="mt-6">
                    <p class="text-lg font-semibold text-gray-700">Availability</p>
                    <div class="mt-4 space-y-2">
                        <p><strong>Daily work:</strong> {{ $technician->availability }}</p>
                        <p><strong>Working Hours :</strong> {{ $technician->working_hours }}</p>
                    </div>
                </div>
            </div>

            <!-- Section to contact the technician -->
            <div class="mt-6 bg-white shadow-xl rounded-lg p-6">
                <p class="text-lg font-semibold text-gray-700">Contact the Technician</p>
                <form method="POST" action="#" class="mt-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Your message</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Write your message here..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Send
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Section to leave a review -->
          <!-- Section to leave a review -->
<div class="mt-6 bg-white shadow-xl rounded-lg p-6">
    <p class="text-lg font-semibold text-gray-700">Leave a review</p>
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
                <input type="hidden" name="technician_id" value="{{ $technician->id }}">
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
</div>
        </div>

        <!-- Additional Information Section -->
        <div class="2xl:col-span-1">
            <div class="bg-white shadow-xl rounded-lg p-6">
                <p class="text-lg font-semibold text-gray-700">Comments and Reviews</p>
                <div class="mt-4 space-y-4">
                    @foreach ($avis as $av)
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full shadow-md" src="{{ asset('storage/' . $av->client->photo) }}" alt="User Avatar">
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ $av->client->first_name }} {{ $av->client->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $av->comment }}</p>
                            <div class="flex items-center mt-1">
                                <span class="text-yellow-500">★★★★☆</span>
                                <span class="ml-2 text-sm text-gray-700">{{ $av->rating }}/5</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script to handle star rating -->
<script>
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
</script>
@endsection