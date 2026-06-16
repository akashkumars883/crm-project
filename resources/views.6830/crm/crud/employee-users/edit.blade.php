@extends('layouts.app')
@section('title', 'Edit Employee UserInformation')
@section('content')
<div class="p-3 pt-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Employee UserInformation</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee-users.update', $employeeUser->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Select Employee</label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="{{ $employeeUser->employee->id }}">{{ $employeeUser->employee->name }}</option>
                                @foreach ($employees as $employee)
                                    @if ($employee->id !== $employeeUser->employee->id)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <!-- User Update Form -->
                        <div class="mb-3">
                            <label for="user_password" class="form-label">User Password (leave blank to keep the current password)</label>
                            <input type="password" name="user_password" id="user_password" class="form-control">
                        </div>
                        <!-- End User Update Form -->
                        <button type="submit" class="btn btn-primary">Update Employee UserInformation</button>
                        <a href="{{ route('employee-users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
