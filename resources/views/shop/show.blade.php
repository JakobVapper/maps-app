@extends('layouts.shop')

@section('title', $product->name)

@section('content')
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <p class="fs-3 text-primary fw-bold">${{ number_format($product->price, 2) }}</p>
            <p>{{ $product->description }}</p>
            
            <form action="{{ route('cart.add', $product) }}" method="POST" class="my-4">
                @csrf
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-auto">
                        <label for="quantity" class="col-form-label">Quantity:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
            </form>
            
            <div class="mt-4">
                <p><strong>Availability:</strong> 
                    @if($product->stock > 0)
                        <span class="text-success"><i class="bi bi-check-circle"></i> In Stock</span>
                    @else
                        <span class="text-danger"><i class="bi bi-x-circle"></i> Out of Stock</span>
                    @endif
                </p>
            </div>
            
            <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary mt-3">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>
@endsection