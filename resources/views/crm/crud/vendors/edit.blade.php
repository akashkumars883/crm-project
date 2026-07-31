@extends('layouts.app')
@section('title', 'Edit Vendor')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('vendors.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Edit Vendor #{{ $vendor->id }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="name" class="form-label fw-semibold">Vendor Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vendor->name) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $vendor->email) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="vendor_type_id" class="form-label fw-semibold">Vendor Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="vendor_type_id" name="vendor_type_id" required>
                                    <option value="">Select Vendor Type</option>
                                    @foreach ($vendorTypes as $vendorType)
                                        <option value="{{ $vendorType->id }}"{{ old('vendor_type_id', $vendor->vendor_type_id) == $vendorType->id ? ' selected' : '' }}>{{ $vendorType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="vendor_status_id" class="form-label fw-semibold">Vendor Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="vendor_status_id" name="vendor_status_id" required>
                                    <option value="">Select Vendor Status</option>
                                    @foreach ($vendorStatuses as $vendorStatus)
                                        <option value="{{ $vendorStatus->id }}"{{ old('vendor_status_id', $vendor->vendor_status_id) == $vendorStatus->id ? ' selected' : '' }}>{{ $vendorStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $vendor->address) }}</textarea>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('vendors.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Update Vendor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
