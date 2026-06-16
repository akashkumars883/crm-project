@extends('layouts.app')
@section('title', 'All Vendor Users')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="px-4 page-title-box">
                <h4 class="page-title">Vendor Users Accounts</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('vendor-users.create') }}" class="btn btn-primary">Add Vendor User Account</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('vendor-users.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search Vendor">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Vendor Name</th>
                                    <th>Email</th>
                                    <th>User ID</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendorUsers as $vendorUser)
                                <tr>
                                    <td>{{ $vendorUser->id }}</td>
                                    <td><a class="text-dark" href="{{ route('vendors.show', $vendorUser->vendor_id) }}">{{ $vendorUser->vendor->name ?? 'N/A' }}</a></td>
                                    <td>{{ $vendorUser->vendor->email }}</td>
                                    <td>{{ $vendorUser->user_id }}</td>
                                    <td>
                                        <a href="{{ route('vendor-users.show', $vendorUser->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('vendor-users.edit', $vendorUser->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $vendorUser->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $vendorUsers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @foreach($vendorUsers as $vendorUser)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $vendorUser->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Vendor User Account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('vendor-users.destroy', $vendorUser->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
