@extends('layouts.app')
@section('title', 'Employee Yser Account  Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Employee User Account Details for {{ $employeeUser->employee->name }}</h5>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('employee-users.edit', $employeeUser->id) }}" class="btn btn-square btn-primary">Update</a>
                        <a href="{{ route('employee-users.index') }}" class="btn btn-square btn-secondary">Back to Activity List</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Employee User Account  ID</th>
                                <td>{{ $employeeUser->id }}</td>
                            </tr>
                            <tr>
                                <th>Employee Name</th>
                                <td>{{ $employeeUser->employee->name }}</td>
                            </tr>
                            <tr>
                                <th>Employee User ID</th>
                                <td>{{ $employeeUser->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $employeeUser->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $employeeUser->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $employeeUser->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{ $employeeUser->creator->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div>
</div>
@endsection
