<section class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Basic Information -->
        <div>
            <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('First Name') }}</label>
            <input id="first_name" name="first_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   value="{{ old('first_name', $user->first_name) }}" required autofocus />
            @error('first_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('Last Name') }}</label>
            <input id="last_name" name="last_name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   value="{{ old('last_name', $user->last_name) }}" required />
            @error('last_name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   value="{{ old('email', $user->email) }}" required />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Additional Fields -->
        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">{{ __('Phone Number') }}</label>
            <input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   value="{{ old('phone_number', $user->phone_number) }}" />
            @error('phone_number')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="address" class="block text-sm font-medium text-gray-700">{{ __('Address') }}</label>
            <input id="address" name="address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                   value="{{ old('address', $user->address) }}" />
            @error('address')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="gender" class="block text-sm font-medium text-gray-700">{{ __('Gender') }}</label>
            <select id="gender" name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">{{ __('Select Gender') }}</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
            </select>
            @error('gender')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Profile Photo -->
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700">{{ __('Profile Photo') }}</label>
            <input id="photo" name="photo" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/jpg,image/png" />
            @error('photo')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @if($user->photo)
                <div class="mt-2">
                    <img src="{{ Storage::url($user->photo) }}" alt="Profile Photo" class="h-20 w-20 rounded-full">
                </div>
            @endif
        </div>

        <!-- Technician Specific Fields -->
        @if($user->role == 'technician')
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('Technician Information') }}</h3>

                <div class="mt-4">
                    <label for="specialty" class="block text-sm font-medium text-gray-700">{{ __('Specialty') }}</label>
                    <input id="specialty" name="specialty" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                         value="{{ old('specialty', $user->technicianDetail->specialty ?? '') }}" required />
                    @error('specialty')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">{{ __('Location') }}</label>
                    <input id="location" name="location" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                         value="{{ old('location', $user->technicianDetail->location ?? '') }}" required />
                    @error('location')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="rate" class="block text-sm font-medium text-gray-700">{{ __('Hourly Rate') }}</label>
                    <input id="rate" name="rate" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                         value="{{ old('rate', $user->technicianDetail->rate ?? '') }}" required />
                    @error('rate')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                    <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $user->technicianDetail->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                 <!-- Category -->
                 <div>
                    <label for="category_id" class="text-sm font-medium text-gray-900 block mb-2">Category</label>
                    <select name="category_id" id="category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $technician->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <div id="availability-form" class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Your availability</label>
                    <div class="mt-2 space-y-4">
                        <div class="flex flex-col space-y-4 sm:flex-row sm:space-x-4 sm:space-y-0">
                            <select name="day" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2 flex-1">
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                
                            <input type="time" name="start_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2 flex-1">
                
                            <input type="time" name="end_time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2 flex-1">
                
                            <button type="button" onclick="addAvailability()" class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-lg sm:w-auto w-full">
                                Add
                            </button>
                        </div>
                    </div>
                
                    <div id="availability-list" class="mt-4 space-y-2">
                        <!-- Existing availabilities will be displayed here -->
                    </div>
                
                    <textarea id="availability" name="availability" class="hidden">{{ old('availability', $technician->availability ?? '[]') }}</textarea>
                </div>

                <!-- Documents -->
                <div class="mt-4">
                    <label for="certificat_path" class="block text-sm font-medium text-gray-700">{{ __('Certificate') }}</label>
                    <input id="certificat_path" name="certificat_path" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".pdf,.jpg,.png" />
                    @error('certificat_path')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="identite_path" class="block text-sm font-medium text-gray-700">{{ __('ID Document') }}</label>
                    <input id="identite_path" name="identite_path" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".pdf,.jpg,.png" />
                    @error('identite_path')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4">
            <!-- Primary Button -->
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
              Save
            </button>
            
            <!-- Status Message (conditionally shown) -->
            <div x-data="{ show: false }" 
                 x-show="show" 
                 x-transition 
                 x-init="setTimeout(() => show = false, 2000)" 
                 class="text-sm text-gray-600">
              Saved.
            </div>
          </div>
    </form>
    <script>
        // Récupérer les anciennes valeurs depuis le champ caché
        const availabilityJSON = document.getElementById('availability').value;
        let availabilities = JSON.parse(availabilityJSON);
    
        // Afficher les anciennes disponibilités au chargement de la page
        document.addEventListener('DOMContentLoaded', function () {
            updateAvailabilityList();
        });
    
        function addAvailability() {
            const day = document.querySelector('select[name="day"]').value;
            const startTime = document.querySelector('input[name="start_time"]').value;
            const endTime = document.querySelector('input[name="end_time"]').value;
    
            if (!day || !startTime || !endTime) {
                alert('Please fill in all fields.');
                return;
            }
    
            // Vérifier si la date existe déjà
            const isDuplicate = availabilities.some(avail => avail.day === day);
            if (isDuplicate) {
                alert('This day already exists in your availability. Please choose another day.');
                return;
            }
    
            // Ajouter la nouvelle disponibilité
            const availability = { day, start_time: startTime, end_time: endTime };
            availabilities.push(availability);
    
            updateAvailabilityList();
            updateAvailabilityJSON();
        }
    
        function updateAvailabilityList() {
            const list = document.getElementById('availability-list');
            list.innerHTML = availabilities.map((avail, index) => `
                <div class="flex items-center justify-between bg-gray-50 p-2 rounded-lg">
                    <span>${avail.day}: ${avail.start_time} - ${avail.end_time}</span>
                    <button type="button" onclick="removeAvailability(${index})" class="text-red-500 hover:text-red-700">
                        Remove
                    </button>
                </div>
            `).join('');
        }
    
        function removeAvailability(index) {
            availabilities.splice(index, 1);
            updateAvailabilityList();
            updateAvailabilityJSON();
        }
    
        function updateAvailabilityJSON() {
            document.getElementById('availability').value = JSON.stringify(availabilities);
        }
    </script>
</section>