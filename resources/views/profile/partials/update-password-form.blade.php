<section class="max-w-xl">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-medium text-sm text-gray-700">
                {{ __('Current Password') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="current-password" />
            @if ($errors->updatePassword->get('current_password'))
                <p class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('current_password') }}
                </p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block font-medium text-sm text-gray-700">
                {{ __('New Password') }}
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="new-password" />
            @if ($errors->updatePassword->get('password'))
                <p class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('password') }}
                </p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm text-gray-700">
                {{ __('Confirm Password') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                   autocomplete="new-password" />
            @if ($errors->updatePassword->get('password_confirmation'))
                <p class="mt-2 text-sm text-red-600">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <!-- Primary Button -->
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
              Save
            </button>
          
            <!-- Password Updated Status Message (conditionally shown) -->
            <div 
              x-data="{ show: false }" 
              x-show="show" 
              x-transition 
              x-init="setTimeout(() => show = false, 2000)" 
              class="text-sm text-gray-600"
            >
              Saved.
            </div>
          </div>
    </form>
</section>