@extends('layouts.app')

@section('amount', 'Payment Details')

@section('content')
<div class="p-3 bg-light">
    <!-- Page-amount -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-amount-box">
                <h4 class="page-amount">Payment Details</h4>
            </div><!--end page-amount-box-->
        </div><!--end col-->
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Reference #</dt>
                        <dd class="col-sm-9">{{ $payment->reference }}</dd>
                        <dt class="col-sm-3">Payment Method</dt>
                        <dd class="col-sm-9">{{ $payment->paymentMethod->name }}</dd>
                        <dt class="col-sm-3">Payment Status</dt>
                        <dd class="col-sm-9">{{ $payment->paymentStatus->name }}</dd>
                        <dt class="col-sm-3">Customer</dt>
                        <dd class="col-sm-9">{{ $payment->customer ? $payment->customer->lead->name : 'N/A' }}</dd>
                        <dt class="col-sm-3">Project</dt>
                        <dd class="col-sm-9">{{ $payment->project ? $payment->project->id : 'N/A' }}</dd>
                        <dt class="col-sm-3">Amount</dt>
                        <dd class="col-sm-9">{{ $payment->amount }}</dd>
                        <dt class="col-sm-3">Notes</dt>
                        <dd class="col-sm-9">{{ $payment->notes ?: 'N/A' }}</dd>
                    </dl>
                    <div class="text-center">
                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">Edit Payment</a>
                        <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
