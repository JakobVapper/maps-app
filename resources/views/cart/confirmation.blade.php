@extends('layouts.shop')

@section('title', 'Order Confirmation')

@section('content')
    <div class="text-center py-5">
        <div class="mb-4">
            <span class="display-1 text-success">
                <i class="bi bi-check-circle"></i>
            </span>
        </div>
        
        <h1 class="mb-3">Thank You For Your Order!</h1>
        <p class="lead mb-4">Your order has been placed successfully.</p>
        
        @if(session('order_completed'))
            <div class="row justify-content-center mb-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h5 class="mb-0"><i class="bi bi-receipt"></i> Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Order Reference:</strong> 
                                <span>{{ session('order_completed.payment_ref') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>Transaction ID:</strong>
                                <span>{{ session('order_completed.transaction_id') }}</span>
                            </div>
                            <div>
                                <strong>Date:</strong>
                                <span>{{ session('order_completed.date') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <p class="mb-4">An email confirmation has been sent with your order details.</p>
        
        <div>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-grid-3x3-gap-fill"></i> Continue Shopping
            </a>
        </div>
    </div>
@endsection