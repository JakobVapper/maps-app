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
        
        <p class="mb-5">An email confirmation has been sent with your order details.</p>
        
        <div>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                Continue Shopping
            </a>
        </div>
    </div>
@endsection