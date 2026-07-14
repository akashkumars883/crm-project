@extends('layouts.app')
@section('title', 'Subscription Plans')

@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row px-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">SaaS Subscription Plans</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('superadmin.subscription_plans.create') }}" class="btn btn-primary">Create New Plan</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Plan Name</th>
                                    <th>Price (INR)</th>
                                    <th>Max Users</th>
                                    <th>Max Customers</th>
                                    <th>Max Projects</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plans as $plan)
                                <tr>
                                    <td class="fw-bold">{{ $plan->name }}</td>
                                    <td>₹{{ number_format($plan->price, 2) }}</td>
                                    <td>{{ $plan->max_users }}</td>
                                    <td>{{ $plan->max_customers }}</td>
                                    <td>{{ $plan->max_projects }}</td>
                                    <td>
                                        @if($plan->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('superadmin.subscription_plans.edit', $plan->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('superadmin.subscription_plans.destroy', $plan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Subscription Plans Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
