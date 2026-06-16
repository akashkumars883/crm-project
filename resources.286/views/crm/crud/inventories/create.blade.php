@extends('layouts.app')
@section('title', 'Create Inventory')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6 text-center">
            <div class="page-title-box">
                <h4 class="page-title">Create a new Inventory</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-md-6 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventories.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="inventory_type_id" class="form-label">Inventory Type</label>
                            <select class="form-control" id="inventory_type_id" name="inventory_type_id" required>
                                <option value="">Select Inventory Type</option>
                                @foreach ($inventoryTypes as $inventoryType)
                                    <option value="{{ $inventoryType->id }}"{{ old('activity_type-Id') == $inventoryType->id ? ' selected' : '' }}>{{ $inventoryType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="inventory_status_id" class="form-label">Inventory Status</label>
                            <select class="form-control" id="inventory_status_id" name="inventory_status_id" required>
                                <option value="">Select Inventory Status</option>
                                @foreach ($inventoryStatuses as $inventoryStatus)
                                    <option value="{{ $inventoryStatus->id }}"{{ old('inventory_status_id') == $inventoryStatus->id ? ' selected' : '' }}>{{ $inventoryStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="vendor_id" class="form-label">Vendor </label>
                            <select class="form-control" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"{{ old('vendor_id') == $vendor->id ? ' selected' : '' }}>{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="cost" class="form-label">Cost</label>
                            <input type="text" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Inventory</button>
                        <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>.
</div>
@endsection
