@extends('layouts.app')
@section('title', 'All Customers')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row px-4">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Customers</h4>
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
                        <a href="{{ route('customers.create') }}" class="btn btn-primary">Add a New Customer</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('customers.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder5="Search Customers">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Zip</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td><a class="text-dark" href="{{ route('leads.show', $customer->lead_id) }}">{{ $customer->lead->name  ?? 'N/A' }}</a>
                                    <td>{{ $customer->lead->phone }}</td>
                                    <td>{{ $customer->lead->email }}</td>
                                    <td>{{ $customer->lead->city ?? 'N/A' }}</td>
                                    <td>{{ $customer->lead->state ?? 'N/A' }}</td>
                                    <td>{{ $customer->lead->zip ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $customer->id }}">Delete</button>
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
                {{ $customers->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($customers as $customer)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $customer->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-danger">Deleting this customer will also delete the login for this customer.</h5>
                    <br>
                    Are you sure you want to delete this Customer?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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
