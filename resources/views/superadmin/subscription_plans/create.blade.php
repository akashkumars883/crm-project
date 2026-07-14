@extends('layouts.app')
@section('title', 'Create Subscription Plan')

@section('content')
<div class="p-3 bg-light">
    <div class="row px-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Create Subscription Plan</h4>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('superadmin.subscription_plans.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Pro Plan">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price (Monthly/Yearly in INR)</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required placeholder="e.g. 4999.00">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="max_users" class="form-label">Max Users (Employees)</label>
                                <input type="number" class="form-control @error('max_users') is-invalid @enderror" id="max_users" name="max_users" value="{{ old('max_users', 5) }}" required>
                                @error('max_users')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="max_customers" class="form-label">Max Customers</label>
                                <input type="number" class="form-control @error('max_customers') is-invalid @enderror" id="max_customers" name="max_customers" value="{{ old('max_customers', 50) }}" required>
                                @error('max_customers')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="max_projects" class="form-label">Max Projects</label>
                                <input type="number" class="form-control @error('max_projects') is-invalid @enderror" id="max_projects" name="max_projects" value="{{ old('max_projects', 10) }}" required>
                                @error('max_projects')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3 form-check form-switch form-switch-success">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">Plan is Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Plan</button>
                        <a href="{{ route('superadmin.subscription_plans.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
