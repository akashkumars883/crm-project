@extends('layouts.app')
@section('title', 'Expenses')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 mt-3">
    <h4 class="mb-0 fw-bold">Expense Management</h4>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary shadow-sm"><i class="ti ti-plus"></i> Add New Expense</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom p-3">
        <form action="{{ route('expenses.index') }}" method="GET" class="d-flex gap-2">
            <select name="status" class="form-select w-auto">
                <option value="">All Statuses</option>
                <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-light border"><i class="ti ti-filter"></i> Filter</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M, Y') }}</td>
                    <td>
                        <div class="fw-semibold">{{ $expense->user->name }}</div>
                        <small class="text-muted">{{ $expense->user->email }}</small>
                    </td>
                    <td><span class="badge bg-secondary">{{ $expense->category }}</span></td>
                    <td class="fw-bold">{{ get_setting('currency', '₹') }}{{ number_format($expense->amount, 2) }}</td>
                    <td>
                        @if($expense->status == 'Pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($expense->status == 'Approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-sm btn-outline-primary"><i class="ti ti-eye"></i> View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No expenses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-white">
        {{ $expenses->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
