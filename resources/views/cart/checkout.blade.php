@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
    <h1 class="mb-4">Checkout</h1>
    
    @if(session()->has('cart') && count(session('cart')) > 0)
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('order.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Complete Order</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $cart = session()->get('cart', []);
                            $total = 0;
                        @endphp
                        
                        @foreach($cart as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <span>{{ $item['name'] }}</span>
                                    <small class="text-muted d-block">Qty: {{ $item['quantity'] }}</small>
                                </div>
                                <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            </div>
                            @php
                                $total += $item['price'] * $item['quantity'];
                            @endphp
                        @endforeach
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid mt-3">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Cart
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <h3>Your cart is empty</h3>
            <p class="mb-4">You need to add items to your cart before checking out.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Browse Products
            </a>
        </div>
    @endif
@endsection