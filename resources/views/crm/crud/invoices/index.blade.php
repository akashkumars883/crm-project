@extends('layouts.app')
@section('title', 'Tax Invoices')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Tax Invoices</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary"><i class="ti ti-plus"></i> New Invoice</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('invoices.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search invoice / customer" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Date</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                <tr>
                                    <td><a href="{{ route('invoices.show', $invoice->id) }}" class="text-primary fw-bold">{{ $invoice->invoice_number ?? 'INV-'.$invoice->id }}</a></td>
                                    <td>{{ $invoice->invoice_date ? $invoice->invoice_date->format('d-M-Y') : 'N/A' }}</td>
                                    <td>
                                        {{ $invoice->bill_to_name }}<br>
                                        <small class="text-muted">{{ optional($invoice->lead)->name ?? '' }}</small>
                                    </td>
                                    <td>{{ $invoice->items->count() }} items</td>
                                    <td class="fw-bold">₹{{ number_format($invoice->balance_due, 0) }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($invoice->invoiceStatus->name ?? 'pending');
                                            $cls = 'badge bg-warning text-dark';
                                            if(str_contains($status,'paid')) $cls = 'badge bg-success';
                                            elseif(str_contains($status,'overdue')) $cls = 'badge bg-danger';
                                        @endphp
                                        <span class="{{ $cls }}">{{ $invoice->invoiceStatus->name ?? 'Pending' }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del{{ $invoice->id }}">Delete</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <h5 class="text-muted">No invoices yet</h5>
                                        <p>Create your first tax invoice to get started</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="pt-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@foreach($invoices as $invoice)
<div class="modal fade" id="del{{ $invoice->id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"><h5>Confirm Delete</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body">Delete invoice <strong>{{ $invoice->invoice_number }}</strong>?</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-danger">Delete</button></form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
