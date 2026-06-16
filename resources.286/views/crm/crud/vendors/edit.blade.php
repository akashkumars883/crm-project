@extends('layouts.app')
@section('title', 'Edit Vendor')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Edit Vendor</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="vendor_type_id" class="form-label">Vendor Type</label>
                            <select class="form-control" id="vendor_type_id" name="vendor_type_id" required>
                                <option value="">Select Vendor Type</option>
                                @foreach ($vendorTypes as $vendorType)
                                    <option value="{{ $vendorType->id }}"{{ old('vendor_type_id', $vendor->vendor_type_id) == $vendorType->id ? ' selected' : '' }}>{{ $vendorType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="vendor_status_id" class="form-label">Vendor Status</label>
                            <select class="form-control" id="vendor_status_id" name="vendor_status_id" required>
                                <option value="">Select Vendor Status</option>
                                @foreach ($vendorStatuses as $vendorStatus)
                                    <option value="{{ $vendorStatus->id }}"{{ old('vendor_status_id', $vendor->vendor_status_id) == $vendorStatus->id ? ' selected' : '' }}>{{ $vendorStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $vendor->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $vendor->phone) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $vendor->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="4">{{ old('address', $vendor->address) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Vendor</button>
                        <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
