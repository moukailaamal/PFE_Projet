@extends('layouts.app')

@section('title', 'Payment Method')

@include('layouts.partials.navbar-dashboard')  
@include('layouts.partials.sidebar') 

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-5">
                <h2 class="text-2xl font-bold text-white">Select Payment Method</h2>
                <p class="mt-1 text-blue-100">Choose how you'd like to complete your reservation</p>
            </div>
            
            <!-- Card Body -->
            <div class="px-6 py-8 sm:p-8">
             
                    
                    <div class="space-y-6">
                        <!-- Payment Options -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Available Payment Options</h3>
                            
                            <!-- Cash Payment Option -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors duration-200 mb-4">
                                <div class="flex items-center space-x-4">
                                    <input type="radio" id="cash" name="payment_method" value="cash" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div>
                                        <label for="cash" class="block text-sm font-medium text-gray-700">Cash Payment</label>
                                        <p class="text-sm text-gray-500">Pay in cash when you arrive</p>
                                    </div>
                                </div>
                                <form action="{{ route('payments.store', $reservation->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method" value="cash">
                                    <button type="submit">Select</button>
                                </form>
                            </div>
                            
                            <!-- Online Payment Option -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-blue-500 transition-colors duration-200">
                                <div class="flex items-center space-x-4">
                                    <input type="radio" id="online" name="payment_method" value="online" class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <div>
                                        <label for="online" class="block text-sm font-medium text-gray-700">Online Payment</label>
                                        <p class="text-sm text-gray-500">Pay securely with your credit card</p>
                                    </div>
                                </div>
                                <a href="{{ route('payments.index', $reservation->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                    Select
                                </a>
                            </div>
                        </div>
                        
                        
                    </div>
                
            </div>
        </div>
    </div>
</div>
@endsection