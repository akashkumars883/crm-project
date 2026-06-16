@extends('layouts.app')

@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Bill Details</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">##{{ $bill->reference }}</h5>
                    <dl class="row">
                        <dt class="col-sm-4">Bill Type:</dt>
                        <dd class="col-sm-8">{{ $bill->billType->name }}</dd>

                        <dt class="col-sm-4">Reference:</dt>
                        <dd class="col-sm-8">{{ $bill->reference }}</dd>

                        <dt class="col-sm-4">Amount:</dt>
                        <dd class="col-sm-8">{{ $bill->amount }}</dd>

                        <dt class="col-sm-4">Bill Date:</dt>
                        <dd class="col-sm-8">{{ $bill->bill_date }}</dd>

                        <dt class="col-sm-4">Due Date:</dt>
                        <dd class="col-sm-8">{{ $bill->due_date }}</dd>

                        <dt class="col-sm-4">Bill Status:</dt>
                        <dd class="col-sm-8">{{ $bill->billStatus->name }}</dd>

                        <dt class="col-sm-4">Payment Method:</dt>
                        <dd class="col-sm-8">{{ $bill->paymentMethod ? $bill->paymentMethod->name : 'Not specified' }}</dd>

                        <dt class="col-sm-4">Project:</dt>
                        <dd class="col-sm-8">{{ $bill->project ? $bill->project->id . ' - ' . $bill->project->customer->lead->name : 'Not specified' }}</dd>

                        <dt class="col-sm-4">Inventory:</dt>
                        <dd class="col-sm-8">{{ $bill->inventory ? $bill->inventory->id . ' - ' . $bill->inventory->title : 'Not specified' }}</dd>

                        <dt class="col-sm-4">Employee:</dt>
                        <dd class="col-sm-8">{{ $bill->employee ? $bill->employee->name : 'Not specified' }}</dd>

                        <dt class="col-sm-4">Notes:</dt>
                        <dd class="col-sm-8">{{ $bill->notes ?: 'None' }}</dd>
                    </dl>
                    
                    @if ($bill->attachments)
                    <h5 class="mb-2">Attachments</h5>
                    
                        @foreach ($bill->attachments as $attachment)
                            <li><a class="mb-2" href="{{ asset('storage/' . $attachment) }}" target="_blank">{{ $attachment }}</a></li>
                        @endforeach
                    
                    @endif

                    <div class="mt-3">
                        <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-primary">Update</a>
                        <a href="{{ route('bills.index') }}" class="btn btn-secondary">Back to Bills</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
