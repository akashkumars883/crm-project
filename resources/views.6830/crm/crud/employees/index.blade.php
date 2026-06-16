@extends('layouts.app')
@section('title', 'All Employees')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title px-4">Employees</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add a New Employee</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('employees.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search Employee">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Emp ID</th>
                                    <th>Emp Type</th>
                                    <th>Full Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->emp_id }}</td>
                                    <td>{{ $employee->employeeType->name }}</td>
                                    <td><img src="{{ asset('storage/' . $employee->photograph) }}" alt="" class="rounded-circle thumb-xs d-inline me-1"> {{ $employee->name }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->department->name }}</td>
                                    <td>{{ $employee->designation->name }}</td>
                                    <td>
                                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $employee->id }}">Delete</button>
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
                {{ $employees->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    @foreach($employees as $employee)
    <div class="modal fade" id="confirmDeleteModal{{ $employee->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
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
