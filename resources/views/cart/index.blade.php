@extends('layouts.shop')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="mb-4">Shopping Cart</h1>
    
    @if(count($cart) > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $item)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" style="width: 60px; height: 60px; object-fit: cover;" class="me-3 rounded">
                                    <span>{{ $item['name'] }}</span>
                                </div>
                            </td>
                            <td class="align-middle">${{ number_format($item['price'], 2) }}</td>
                            <td class="align-middle" style="width: 150px;">
                                <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <input type="number" name="quantities[{{ $id }}]" class="form-control" value="{{ $item['quantity'] }}" min="1">
                                        <button type="submit" class="btn btn-outline-secondary">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="align-middle">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                            <!-- Replace the existing remove form with this link -->
                            <td class="align-middle">
                                <a href="{{ route('cart.removeItem', $id) }}" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total:</td>
                            <td colspan="2" class="fw-bold">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Continue Shopping
                    </a>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-success">
                    Proceed to Checkout <i class="bi bi-arrow-right"></i>
                </a>
            </div>
    @else
        <div class="text-center py-5">
            <h3>Your cart is empty</h3>
            <p class="mb-4">Looks like you haven't added any products to your cart yet.</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                <i class="bi bi-cart-plus"></i> Browse Products
            </a>
        </div>
    @endif
@endsection