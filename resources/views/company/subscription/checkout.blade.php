@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 text-center pt-4">
                    <h3 class="card-title fw-bold text-dark mb-0">Checkout</h3>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted mb-4">You are about to upgrade your workspace to the <strong>{{ $plan->name }}</strong> plan.</p>
                    <h1 class="display-4 fw-bold text-primary mb-4">₹{{ number_format($plan->price) }}<span class="fs-4 text-muted fw-normal">/year</span></h1>
                    
                    <ul class="list-unstyled text-start w-75 mx-auto mb-4 bg-light p-3 rounded">
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_users }} Employee Users</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_customers }} Client Users</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_projects }} Active Projects</li>
                    </ul>

                    <button id="rzp-button1" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">Pay with Razorpay</button>
                    <div class="mt-3">
                        <a href="{{ route('company.subscription.index') }}" class="text-muted text-decoration-none">Cancel and return</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form action="{{ route('company.subscription.verify') }}" method="POST" id="verify-form">
    @csrf
    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
</form>

@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
var options = {
    "key": "{{ env('RAZORPAY_KEY') }}",
    "amount": "{{ $plan->price * 100 }}", 
    "currency": "INR",
    "name": "CRM Enterprise",
    "description": "Subscription for {{ $plan->name }} Plan",
    "image": "{{ asset('assets/images/logo.webp') }}",
    "order_id": "{{ $razorpayOrder['id'] }}", 
    "handler": function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.getElementById('verify-form').submit();
    },
    "prefill": {
        "name": "{{ Auth::user()->name }}",
        "email": "{{ Auth::user()->email }}",
        "contact": "{{ Auth::user()->phone ?? '' }}"
    },
    "theme": {
        "color": "#3b82f6"
    }
};
var rzp1 = new Razorpay(options);
rzp1.on('payment.failed', function (response){
        alert("Payment Failed: " + response.error.description);
});
document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
}
</script>
@endsection
