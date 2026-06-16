@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
<div class="p-3 pt-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Customer and User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="lead_id" class="form-label">Select Lead</label>
                            <select name="lead_id" id="lead_id" class="form-select" required>
                                <option value="{{ $customer->lead->id }}">{{ $customer->lead->name }}</option>
                                @foreach ($leads as $lead)
                                    @if ($lead->id !== $customer->lead->id)
                                        <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!-- User Update Form -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label">User Password (leave blank to keep the current password)</label>
                            <input type="password" name="user_password" id="user_password" class="form-control">
                        </div>
                        <!-- End User Update Form -->
                        <button type="submit" class="btn btn-primary">Update Customer and User</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
