@extends('layouts.app')
@section('title', 'Add Invoice')
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Add Invoice</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="invoice_type_id" class="form-label">Invoice Type</label>
                                <select name="invoice_type_id" id="invoice_type_id" class="form-select @error('invoice_type_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select Invoice Type</option>
                                    @foreach($invoiceTypes as $invoiceType)
                                    <option value="{{ $invoiceType->id }}" {{ old('invoice_type_id') == $invoiceType->id ? 'selected' : '' }}>{{ $invoiceType->name }}</option>
                                    @endforeach
                                </select>
                                @error('invoice_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="value" class="form-label">Value</label>
                                <input type="text" name="value" id="value" value="{{ old('value') }}" class="form-control @error('value') is-invalid @enderror">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="lead_id" class="form-label">Lead</label>
                                <select name="lead_id" id="lead_id" class="form-select @error('lead_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select Lead</option>
                                    @foreach($leads as $lead)
                                    <option value="{{ $lead->id }}" {{ old('lead_id') == $lead->id ? 'selected' : '' }}>{{ $lead->id }} - {{ $lead->name }}</option>
                                    @endforeach
                                </select>
                                @error('lead_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="invoice_status_id" class="form-label">Invoice Status</label>
                                <select name="invoice_status_id" id="invoice_status_id" class="form-select @error('invoice_status_id') is-invalid @enderror">
                                    <option value="" disabled selected>Select Invoice Status</option>
                                    @foreach($invoiceStatuses as $status)
                                    <option value="{{ $status->id }}" {{ old('invoice_status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('invoice_status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attachments" class="form-label">Attachments</label>
                                <input type="file" name="attachments[]" id="attachments" class="form-control @error('attachments') is-invalid @enderror" multiple>
                                @error('attachments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
