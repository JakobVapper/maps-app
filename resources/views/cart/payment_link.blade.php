@extends('layouts.shop')

@section('title', 'Payment')

@section('content')
    <div class="py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="mb-0"><i class="bi bi-credit-card-2-front"></i> Complete Your Payment</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead">Your order total is <strong class="text-primary">${{ number_format($total, 2) }}</strong></p>
                        <p>Order reference: <strong>{{ $paymentRef }}</strong></p>
                        
                        <hr class="my-4">
                        
                        <form id="payment-form" class="mt-4">
                            <div class="mb-3">
                                <label for="card-element" class="form-label">Credit or Debit Card</label>
                                <div id="card-element" class="form-control p-3">
                                    <!-- Stripe Elements will be inserted here -->
                                </div>
                                <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                            </div>
                            
                            <div class="d-grid">
                                <button id="submit-button" type="submit" class="btn btn-success btn-lg">
                                    <div class="spinner-border spinner-border-sm d-none" id="spinner" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span id="button-text"><i class="bi bi-lock-fill"></i> Pay ${{ number_format($total, 2) }}</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('cart.index') }}" class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Return to cart
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Stripe JS -->
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        // Create a Stripe client
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        
        // Create an instance of Elements
        const elements = stripe.elements();
        
        // Custom styling for the card Element
        const style = {
            base: {
                color: '#ffffff',
                fontFamily: 'Poppins, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
        
        // Create the card Element
        const cardElement = elements.create('card', {style: style});
        
        // Add an instance of the card Element into the `card-element` div
        cardElement.mount('#card-element');
        
        // Handle form submission
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');
        
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            // Disable the submit button to prevent repeated clicks
            submitButton.disabled = true;
            spinner.classList.remove('d-none');
            buttonText.textContent = 'Processing...';
            
            try {
                // Create payment method
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: cardElement,
                });
                
                if (error) {
                    // Show error to customer
                    const errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                    
                    // Re-enable the submit button
                    submitButton.disabled = false;
                    spinner.classList.add('d-none');
                    buttonText.innerHTML = '<i class="bi bi-lock-fill"></i> Pay ${{ number_format($total, 2) }}';
                } else {
                    // Send paymentMethod.id to server
                    const result = await fetch('{{ route('payment.process-stripe') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_method_id: paymentMethod.id,
                            payment_ref: '{{ $paymentRef }}',
                            amount: {{ $total * 100 }} // Amount in cents
                        })
                    }).then(r => r.json());
                    
                    if (result.success) {
                        // Redirect to confirmation page
                        window.location.href = '{{ route('order.confirmation') }}';
                    } else {
                        // Display error
                        const errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error || 'An error occurred. Please try again.';
                        
                        // Re-enable the submit button
                        submitButton.disabled = false;
                        spinner.classList.add('d-none');
                        buttonText.innerHTML = '<i class="bi bi-lock-fill"></i> Pay ${{ number_format($total, 2) }}';
                    }
                }
            } catch (err) {
                console.error(err);
                // Re-enable the submit button
                submitButton.disabled = false;
                spinner.classList.add('d-none');
                buttonText.innerHTML = '<i class="bi bi-lock-fill"></i> Pay ${{ number_format($total, 2) }}';
            }
        });
    </script>
@endsection