@extends('layouts.app')

@section('amount', 'Create Payment')

@section('content')
<div class="p-3 bg-light">
    <!-- Page-amount -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-amount-box">
                <h4 class="page-amount">Create a new Payment</h4>
            </div><!--end page-amount-box-->
        </div><!--end col-->
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference #</label>
                            <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}">
                        </div>
                        <div class="mb-3">
                            <label for="payment_method_id" class="form-label">Payment Method</label>
                            <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                                <option value="">Select Payment Method</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status_id" class="form-label">Payment Status</label>
                            <select class="form-control" id="payment_status_id" name="payment_status_id" required>
                                <option value="">Select Payment Status</option>
                                @foreach ($paymentStatuses as $paymentStatus)
                                    <option value="{{ $paymentStatus->id }}">{{ $paymentStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select class="form-control" id="customer_id" name="customer_id">
                                <option value="">Select a Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->lead->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-control" id="project_id" name="project_id">
                                <option value="">Select a Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->id }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Payment</button>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
