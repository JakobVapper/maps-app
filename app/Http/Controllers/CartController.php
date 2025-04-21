<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = session()->get('cart', []);
        $quantity = (int) $request->quantity;
        
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'quantity' => $quantity
            ];
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'numeric|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        foreach ($request->quantities as $id => $quantity) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = (int) $quantity;
            }
        }
        
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    public function removeItem($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }
    
    public function checkout()
    {
        return redirect()->route('payment');
    }
    
    public function processOrder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255'
        ]);
        
        session()->forget('cart');
        return redirect()->route('order.confirmation');
    }

    public function payment()
    {
        $cart = session()->get('cart', []);
        if (count($cart) == 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        return view('cart.payment');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);
        
        session()->put('customer', $request->only([
            'first_name', 'last_name', 'email', 'phone', 'address'
        ]));
        
        $paymentRef = 'PAY-' . strtoupper(substr(md5(uniqid()), 0, 10));
        session()->put('payment_ref', $paymentRef);
        
        return view('cart.payment_link', [
            'paymentRef' => $paymentRef,
            'total' => collect(session('cart'))->sum(function($item) {
                return $item['price'] * $item['quantity'];
            })
        ]);
    }

    public function processStripePayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'payment_ref' => 'required|string',
            'amount' => 'required|numeric|min:1'
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $customer = session()->get('customer', []);
            
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'description' => 'Order ' . $request->payment_ref,
                'receipt_email' => $customer['email'] ?? null,
                'return_url' => route('order.confirmation'),
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never'
                ]
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $this->completeOrder($request->payment_ref, $paymentIntent->id);
                
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Payment requires additional actions. Please try again.'
                ]);
            }
        } catch (ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function completeOrder($paymentRef, $transactionId)
    {
        session()->forget('cart');
    
        session()->put('order_completed', [
            'payment_ref' => $paymentRef,
            'transaction_id' => $transactionId,
            'date' => now()->format('Y-m-d H:i:s')
        ]);
        
        return true;
    }
    
    public function confirmation()
    {
        return view('cart.confirmation');
    }
}