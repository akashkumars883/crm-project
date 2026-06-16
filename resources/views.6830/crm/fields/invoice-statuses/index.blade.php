@extends('layouts.app')
@section('title', 'All Invoice Statuses')
@section('content')
<!-- Page-Title -->
<div class="row px-4">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Invoice Statuses</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('invoice-statuses.create') }}" class="btn btn-primary">Add Invoice Statuses</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoiceStatuses as $invoiceStatus)
                            <tr>
                                <td>{{ $invoiceStatus->name }}</td>
                                <td>
                                    <a href="{{ route('invoice-statuses.edit', $invoiceStatus->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $invoiceStatus->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="pt-3">
                    {{ $invoiceStatuses->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($invoiceStatuses as $invoiceStatus)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal{{ $invoiceStatus->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Invoice Status?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('invoice-statuses.destroy', $invoiceStatus->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
