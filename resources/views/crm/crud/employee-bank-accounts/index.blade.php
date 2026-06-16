@extends('layouts.app')
@section('title', 'All Employee Bank Accounts')
@section('content')
<div class="p-3 bg-light">
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Employee Bank Accounts</h4>
            </div>
        </div>
    </div>

    <div class="row pt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('employee-bank-accounts.create') }}" class="btn btn-primary">Add Employee Bank Account</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('employee-bank-accounts.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads">
                            <button type="submit" class="btn btn-sm btn-primary">Search</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee Name</th>
                                    <th>Bank Name</th>
                                    <th>Branch</th>
                                    <th>IFSC</th>
                                    <th>Account Name</th>
                                    <th>Account Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeBankAccounts as $bankAccount)
                                <tr>
                                    <td>{{ $bankAccount->employee->emp_id }}</td>
                                    <td>{{ $bankAccount->employee->full_name }}</td>
                                    <td>{{ $bankAccount->bank_name }}</td>
                                    <td>{{ $bankAccount->branch }}</td>
                                    <td>{{ $bankAccount->ifsc }}</td>
                                    <td>{{ $bankAccount->account_name }}</td>
                                    <td>{{ $bankAccount->account_number }}</td>
                                    <td>
                                        <a href="{{ route('employee-bank-accounts.show', $bankAccount->id) }}" class="btn btn-sm btn-success">Show</a>
                                        <a href="{{ route('employee-bank-accounts.edit', $bankAccount->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $bankAccount->id }}">Delete</button>
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
                {{ $employeeBankAccounts->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@foreach($employeeBankAccounts as $bankAccount)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmDeleteModal{{ $bankAccount->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this employee bank account?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('employee-bank-accounts.destroy', $bankAccount->id) }}" method="POST" class="d-inline">
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
