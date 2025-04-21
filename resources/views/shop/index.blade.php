@extends('layouts.shop')

@section('title', 'Shop Products')

@section('content')
    <h1 class="mb-4"><i class="bi bi-stars"></i> Our Products</h1>
    
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-primary fw-bold">${{ number_format($product->price, 2) }}</p>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($product->description, 100) }}</p>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shop.show', $product) }}" class="btn btn-primary">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-cart-plus"></i> Add
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection