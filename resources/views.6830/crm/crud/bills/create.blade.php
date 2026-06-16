@extends('layouts.app')

@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Create a new Bill</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Bill Type -->
                        <div class="mb-3">
                            <label for="bill_type_id" class="form-label">Bill Type</label>
                            <select class="form-control" id="bill_type_id" name="bill_type_id" required>
                                <option value="">Select Bill Type</option>
                                @foreach ($billTypes as $billType)
                                    <option value="{{ $billType->id }}">{{ $billType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Reference -->
                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}">
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        </div>

                        <!-- Bill Date -->
                        <div class="mb-3">
                            <label for="bill_date" class="form-label">Bill Date</label>
                            <input type="date" class="form-control" id="bill_date" name="bill_date" value="{{ old('bill_date') }}" required>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                        </div>

                        <!-- Bill Status -->
                        <div class="mb-3">
                            <label for="bill_status_id" class="form-label">Bill Status</label>
                            <select class="form-control" id="bill_status_id" name="bill_status_id" required>
                                <option value="">Select Bill Status</option>
                                @foreach ($billStatuses as $billStatus)
                                    <option value="{{ $billStatus->id }}">{{ $billStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label for="payment_method_id" class="form-label">Payment Method</label>
                            <select class="form-control" id="payment_method_id" name="payment_method_id">
                                <option value="">Select Payment Method</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Project -->
                        <div class="mb-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select class="form-control" id="project_id" name="project_id">
                                <option value="">Select Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->id }} - {{ $project->customer->lead->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Inventory -->
                        <div class="mb-3">
                            <label for="inventory_id" class="form-label">Inventory</label>
                            <select class="form-control" id="inventory_id" name="inventory_id">
                                <option value="">Select Inventory</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->id }} - {{ $inventory->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Employee -->
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id">
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Bill</button>
                        <a href="{{ route('bills.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
