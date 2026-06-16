@extends('layouts.app')
@section('title', 'All Employee Users')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="px-4 page-title-box">
                <h4 class="page-title">Employee Users Accounts</h4>
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
                        <a href="{{ route('employee-users.create') }}" class="btn btn-primary">Add Employee User Account</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('employee-users.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder5="Search Employee">
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
                                    <th>Emp ID</th>
                                    <th>Employee Name</th>
                                    <th>Email</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeUsers as $employeeUser)
                                <tr>
                                    <td>{{ $employeeUser->id }}</td>
                                    <td>{{ $employeeUser->employee->emp_id }}</td>
                                    <td><a class="text-dark" href="{{ route('employees.show', $employeeUser->employee_id) }}">{{ $employeeUser->employee->name  ?? 'N/A' }}</a>
                                        <td>{{ $employeeUser->user->email }}</td>
                                        <td>{{ $employeeUser->user->name }}</td>
                                    <td>
                                        <a href="{{ route('employee-users.show', $employeeUser->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('employee-users.edit', $employeeUser->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $employeeUser->id }}">Delete</button>
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
                {{ $employeeUsers->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($employeeUsers as $employeeUser)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $employeeUser->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Employee User Account?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('employee-users.destroy', $employeeUser->id) }}" method="POST" class="d-inline">
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
