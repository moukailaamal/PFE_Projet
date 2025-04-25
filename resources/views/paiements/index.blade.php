@extends('layouts.app')
@section('title', 'Payment index')

@include('layouts.partials.navbar-dashboard')  
@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
        <div class="p-8">
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Secure Payment</h2>
                <p class="mt-2 text-sm text-gray-600">Complete your payment for {{ $technician->first_name  }}</p>
            </div>
            <form action="{{ route('payments.store',$reservation) }}" method="POST" class="space-y-6">
                @csrf             
                <input type="hidden" name="payment_method" value="online">
                <input type="hidden" name="status" value="confirm">
                <input type="hidden" name="amount" value="{{ $technician->rate }}">
               

                <!-- Amount Display -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Amount to pay:</span>
                        <span class="text-lg font-bold text-gray-800">${{ $technician->rate }}</span>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        Client: {{ Auth::user()->first_name ?? 'N/A' }}
                    </div>
                </div>

                <!-- Card Logos -->
                <div class="flex justify-center space-x-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-8">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/PayPal_Logo_Icon_2014.svg" alt="PayPal" class="h-8">
                </div>

                <!-- Card Number -->
                <div>
                    <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" name="card_number" id="card_number" 
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md py-3"
                               placeholder="4242 4242 4242 4242" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Card Details Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Expiration Date -->
                    <div>
                        <label for="expiry_date" class="block text-sm font-medium text-gray-700">Expiration Date</label>
                        <div class="mt-1">
                            <input type="text" name="expiry_date" id="expiry_date" 
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md py-3"
                                   placeholder="MM/YY" required>
                        </div>
                    </div>

                    <!-- CVV -->
                    <div>
                        <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="text" name="cvv" id="cvv" 
                                   class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md py-3"
                                   placeholder="123" required>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cardholder Name -->
                <div>
                    <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                    <div class="mt-1">
                        <input type="text" name="card_name" id="card_name" 
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md py-3"
                               placeholder="John Smith" required>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded" required>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700">I agree to the</label>
                        <a href="#" class="text-blue-600 hover:text-blue-500"> Terms and Conditions</a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Pay ${{ number_format($reservation->total_amount ?? 0, 2) }}
                    </button>
                </div>

                <!-- Security Info -->
                <div class="flex items-center justify-center text-xs text-gray-500 mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Payments are secure and encrypted
                </div>
            </form>
        </div>
    </div>
</div>
@endsection