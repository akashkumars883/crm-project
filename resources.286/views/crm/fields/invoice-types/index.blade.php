@extends('layouts.app')
@section('title', 'All Invoice Types')
@section('content')
<!-- Page-Title -->
<div class="row px-4">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Invoice Types</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('invoice-types.create') }}" class="btn btn-primary">Add Invoice Type</a>
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
                            @foreach($invoiceTypes as $invoiceType)
                            <tr>
                                <td>{{ $invoiceType->name }}</td>
                                <td>
                                    <a href="{{ route('invoice-types.edit', $invoiceType->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $invoiceType->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination links -->
                <div class="pt-3">
                    {{ $invoiceTypes->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($invoiceTypes as $invoiceType)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal{{ $invoiceType->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Invoice Type?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('invoice-types.destroy', $invoiceType->id) }}" method="POST" class="d-inline">
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
