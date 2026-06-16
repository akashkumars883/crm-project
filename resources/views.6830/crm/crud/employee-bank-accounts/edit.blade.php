@extends('layouts.app')
@section('title', 'Edit Employee Bank Account')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title">Edit Employee Bank Account</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employee-bank-accounts.update', $employeeBankAccount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="emp_id" class="form-label">Employee ID</label>
                            <select name="emp_id" id="emp_id" class="form-select @error('emp_id') is-invalid @enderror">
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ $employee->id === $employeeBankAccount->emp_id ? 'selected' : '' }}>{{ $employee->emp_id }} - {{ $employee->full_name }}</option>
                                @endforeach
                            </select>
                            @error('emp_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" name="bank_name" id="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ $employeeBankAccount->bank_name }}" placeholder="Enter bank name">
                            @error('bank_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="branch" class="form-label">Branch</label>
                            <input type="text" name="branch" id="branch" class="form-control @error('branch') is-invalid @enderror" value="{{ $employeeBankAccount->branch }}" placeholder="Enter branch">
                            @error('branch')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ifsc" class="form-label">IFSC</label>
                            <input type="text" name="ifsc" id="ifsc" class="form-control @error('ifsc') is-invalid @enderror" value="{{ $employeeBankAccount->ifsc }}" placeholder="Enter IFSC">
                            @error('ifsc')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="account_name" class="form-label">Account Name</label>
                            <input type="text" name="account_name" id="account_name" class="form-control @error('account_name') is-invalid @enderror" value="{{ $employeeBankAccount->account_name }}" placeholder="Enter account name">
                            @error('account_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="account_number" class="form-label">Account Number</label>
                            <input type="text" name="account_number" id="account_number" class="form-control @error('account_number') is-invalid @enderror" value="{{ $employeeBankAccount->account_number }}" placeholder="Enter account number">
                            @error('account_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="upi" class="form-label">UPI</label>
                            <input type="text" name="upi" id="upi" class="form-control @error('upi') is-invalid @enderror" value="{{ $employeeBankAccount->upi }}" placeholder="Enter UPI">
                            @error('upi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phonepe" class="form-label">PhonePe</label>
                            <input type="text" name="phonepe" id="phonepe" class="form-control @error('phonepe') is-invalid @enderror" value="{{ $employeeBankAccount->phonepe }}" placeholder="Enter PhonePe">
                            @error('phonepe')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="googlepay" class="form-label">Google Pay</label>
                            <input type="text" name="googlepay" id="googlepay" class="form-control @error('googlepay') is-invalid @enderror" value="{{ $employeeBankAccount->googlepay }}" placeholder="Enter Google Pay">
                            @error('googlepay')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="paytm" class="form-label">Paytm</label>
                            <input type="text" name="paytm" id="paytm" class="form-control @error('paytm') is-invalid @enderror" value="{{ $employeeBankAccount->paytm }}" placeholder="Enter Paytm">
                            @error('paytm')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('employee-bank-accounts.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div>
@endsection
