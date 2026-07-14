@extends('layouts.app')
@section('title', 'My Subscription')

@section('content')
<div class="p-3 bg-light">
    <div class="row px-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">My Subscription & Billing</h4>
            </div>
        </div>
    </div>

    @if($currentSubscription)
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-primary bg-gradient text-white">
                <div class="card-body">
                    <h5 class="card-title text-white">Current Plan: {{ $currentSubscription->plan->name }}</h5>
                    <p class="mb-0">Valid until: {{ $currentSubscription->ends_at ? $currentSubscription->ends_at->format('d M, Y') : 'Lifetime' }}</p>
                    <p class="mb-0">Limits: {{ $currentSubscription->plan->max_users }} Users, {{ $currentSubscription->plan->max_customers }} Customers</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <h5 class="mb-4">Available Plans</h5>
    <div class="row">
        @foreach($plans as $plan)
        <div class="col-md-3">
            <div class="card text-center {{ $currentSubscription && $currentSubscription->subscription_plan_id == $plan->id ? 'border-primary shadow' : '' }}">
                <div class="card-header {{ $currentSubscription && $currentSubscription->subscription_plan_id == $plan->id ? 'bg-primary text-white' : '' }}">
                    <h4 class="{{ $currentSubscription && $currentSubscription->subscription_plan_id == $plan->id ? 'text-white' : '' }}">{{ $plan->name }}</h4>
                </div>
                <div class="card-body">
                    <h2 class="mb-3">₹{{ number_format($plan->price) }}<small class="text-muted fs-6">/year</small></h2>
                    <ul class="list-unstyled text-start px-3 mb-4">
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_users }} Employees</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_customers }} Customers</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> {{ $plan->max_projects }} Projects</li>
                        <li class="mb-2"><i class="ti ti-check text-success me-2"></i> Priority Support</li>
                    </ul>
                    
                    @if($currentSubscription && $currentSubscription->subscription_plan_id == $plan->id)
                        <button class="btn btn-outline-primary w-100" disabled>Current Plan</button>
                    @else
                        <form action="{{ route('company.subscription.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="btn btn-primary w-100">Subscribe</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
