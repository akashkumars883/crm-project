@extends('layouts.app')
@section('title', 'Expense Details')
@section('content')

<div class="row justify-content-center mt-4">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 fw-bold">Expense Details</h4>
            <div>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary"><i class="ti ti-arrow-left"></i> Back</a>
                @if(Auth::user()->hasRole('super_admin|admin|manager'))
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning"><i class="ti ti-pencil"></i> Edit / Update Status</a>
                @endif
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Employee Name</small>
                        <strong class="fs-5">{{ $expense->user->name }}</strong>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <small class="text-muted d-block">Status</small>
                        @if($expense->status == 'Pending')
                            <span class="badge bg-warning text-dark fs-6">Pending</span>
                        @elseif($expense->status == 'Approved')
                            <span class="badge bg-success fs-6">Approved</span>
                        @else
                            <span class="badge bg-danger fs-6">Rejected</span>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <small class="text-muted d-block">Date</small>
                        <strong>{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Amount</small>
                        <strong class="text-primary fs-5">{{ get_setting('currency', '₹') }}{{ number_format($expense->amount, 2) }}</strong>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted d-block">Category</small>
                        <strong>{{ $expense->category }}</strong>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block">Description</small>
                        <p class="mb-0">{{ $expense->description ?? 'No description provided.' }}</p>
                    </div>
                </div>

                @if($expense->receipt_path)
                <hr class="my-4">
                <div class="text-center">
                    <small class="text-muted d-block mb-3 text-start">Receipt Image</small>
                    <img src="{{ (\Illuminate\Support\Str::startsWith($expense->receipt_path, 'http') ? $expense->receipt_path : asset('storage/' . $expense->receipt_path)) }}" alt="Receipt" class="img-fluid rounded border" style="max-height: 500px;">
                    <div class="mt-3">
                        <a href="{{ (\Illuminate\Support\Str::startsWith($expense->receipt_path, 'http') ? $expense->receipt_path : asset('storage/' . $expense->receipt_path)) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="ti ti-external-link"></i> View Full Image</a>
                    </div>
                </div>
                @endif
            </div>
            @if(Auth::user()->hasRole('super_admin|admin|manager') && $expense->status == 'Pending')
            <div class="card-footer bg-light p-3 d-flex justify-content-end gap-2">
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="date" value="{{ $expense->date }}">
                    <input type="hidden" name="amount" value="{{ $expense->amount }}">
                    <input type="hidden" name="category" value="{{ $expense->category }}">
                    <input type="hidden" name="status" value="Rejected">
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Reject this expense?')">Reject</button>
                </form>
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="date" value="{{ $expense->date }}">
                    <input type="hidden" name="amount" value="{{ $expense->amount }}">
                    <input type="hidden" name="category" value="{{ $expense->category }}">
                    <input type="hidden" name="status" value="Approved">
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this expense?')"><i class="ti ti-check"></i> Approve</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
