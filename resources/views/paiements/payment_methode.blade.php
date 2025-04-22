@extends('layouts.app')

@section('title', 'Payment Method')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Select Payment Method</h4>
                </div>
                
                <div class="card-body">
                    <form action="" method="POST">
                        @csrf
                        
                        <p class="lead mb-4">How would you like to pay for your reservation?</p>
                        
                        <div class="form-group">
                            <label class="font-weight-bold">Payment Options</label>
                            <div class="mt-3">
                                <div class="custom-control custom-radio mb-3">
                                    <input type="radio" id="cash" name="payment_method" value="cash" class="custom-control-input">
                                    <label class="custom-control-label d-flex align-items-center" for="cash">
                                        <span>Cash Payment</span>
                                        <a href="{{ route('payments.store', $reservation->id) }}" class="btn btn-outline-primary btn-sm ml-3">Select</a>
                                    </label>
                                </div>
                                
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="online" name="payment_method" value="online" class="custom-control-input">
                                    <label class="custom-control-label d-flex align-items-center" for="online">
                                        <span>Online Payment</span>
                                        <a href="{{ route('payments.index', $reservation->id) }}" class="btn btn-outline-primary btn-sm ml-3">Select</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">Confirm Payment Method</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection