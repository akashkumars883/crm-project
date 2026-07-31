@extends('layouts.app')
@section('title', 'Edit Expense')
@section('content')

<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('expenses.show', $expense->id) }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Expense #{{ $expense->id }}</h5>
                </div>
                <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Date <span class="text-danger">*</span></label>
                                <input type="date" name="date" class="form-control" value="{{ $expense->date }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Amount ({{ get_setting('currency', '₹') }}) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="amount" class="form-control" value="{{ $expense->amount }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="Travel" {{ $expense->category == 'Travel' ? 'selected' : '' }}>Travel / Fuel</option>
                                    <option value="Food" {{ $expense->category == 'Food' ? 'selected' : '' }}>Meals / Food</option>
                                    <option value="Materials" {{ $expense->category == 'Materials' ? 'selected' : '' }}>Raw Materials</option>
                                    <option value="Logistics" {{ $expense->category == 'Logistics' ? 'selected' : '' }}>Shipping / Logistics</option>
                                    <option value="Other" {{ $expense->category == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            @if(Auth::user()->hasRole('super_admin|admin|manager'))
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="Pending" {{ $expense->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $expense->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $expense->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            @endif

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Update Receipt Image</label>
                                <input type="file" name="receipt" class="form-control" accept="image/*">
                                <small class="text-muted">Leave blank to keep current receipt.</small>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Description / Remarks</label>
                                <textarea name="description" class="form-control" rows="2">{{ $expense->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end p-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Are you sure you want to delete this expense?')) document.getElementById('delete-form').submit();">
                            <i class="ti ti-trash"></i> Delete
                        </button>
                        <div>
                            <a href="{{ route('expenses.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Save Changes</button>
                        </div>
                    </div>
                </form>
                
                <form id="delete-form" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-none">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
