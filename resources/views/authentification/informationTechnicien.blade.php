@extends('layouts.app')
@section('content')
<div class="mx-auto md:h-screen flex flex-col justify-center items-center px-6 pt-8 md:mt-0">
    <!-- Logo et Titre -->
    <a href="/" class="text-2xl font-semibold flex justify-center items-center mb-8 lg:mb-10">
        <img src="/images/logo.svg" class="h-10 mr-4" alt="TuniRepair  Logo">
        <span class="self-center text-2xl font-bold whitespace-nowrap">Tuni repair </span> 
    </a>

    <!-- Card -->
    <div class="bg-white shadow-lg rounded-lg md:mt-0 w-full sm:max-w-screen-sm xl:p-0">
        <div class="p-6 sm:p-8 lg:p-16 space-y-8">
            <h2 class="text-2xl lg:text-3xl font-bold text-black">
                Create a Free Account
            </h2>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form class="mt-8 space-y-6" method="POST" action="{{ route('register.information.Technicien', ['id' => $id]) }}"enctype="multipart/form-data">
            @csrf
        
         
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="remember" aria-describedby="remember" name="remember" type="checkbox" class="bg-gray-50 border-gray-300 focus:ring-3 focus:ring-cyan-200 h-4 w-4 rounded" required>
                </div>
                <div class="text-sm ml-3">
                    <label for="remember" class="font-medium text-gray-900">I accept the <a href="#" class="text-teal-500 hover:underline">Terms and Conditions</a></label>
                </div>
            </div>
            
            

            <!-- Bouton de soumission -->
            <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-base px-5 py-3 w-full sm:w-auto text-center">
               Save
            </button>
           
        </form>
        
        
        </div>
    </div>
</div>

@endsection
