@extends('layouts.app')
@section('title', 'Create Inventory')
@section('content')
<div class="p-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('inventories.index') }}" class="text-dark me-2 text-decoration-none" title="Back">
                        <i class="ti ti-arrow-left fs-3"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold">Create New Inventory Item</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventories.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-semibold">Title / Material Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" placeholder="Item title" required>
                            </div>
                            <div class="col-md-3">
                                <label for="inventory_type_id" class="form-label fw-semibold">Inventory Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="inventory_type_id" name="inventory_type_id" required>
                                    <option value="">Select Type</option>
                                    @foreach ($inventoryTypes as $inventoryType)
                                        <option value="{{ $inventoryType->id }}"{{ old('inventory_type_id') == $inventoryType->id ? ' selected' : '' }}>{{ $inventoryType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="inventory_status_id" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="inventory_status_id" name="inventory_status_id" required>
                                    <option value="">Select Status</option>
                                    @foreach ($inventoryStatuses as $inventoryStatus)
                                        <option value="{{ $inventoryStatus->id }}"{{ old('inventory_status_id') == $inventoryStatus->id ? ' selected' : '' }}>{{ $inventoryStatus->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="cost" class="form-label fw-semibold">Cost (₹) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="cost" name="cost" value="{{ old('cost') }}" placeholder="0.00" required>
                            </div>
                            <div class="col-md-4">
                                <label for="project_id" class="form-label fw-semibold">Project</label>
                                <select class="form-select" id="project_id" name="project_id">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"{{ old('project_id') == $project->id ? ' selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="vendor_id" class="form-label fw-semibold">Vendor</label>
                                <select class="form-select" id="vendor_id" name="vendor_id">
                                    <option value="">Select Vendor</option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"{{ old('vendor_id') == $vendor->id ? ' selected' : '' }}>{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold">Description / Item Details</label>
                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Specification, quantity, unit details...">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top text-end">
                            <a href="{{ route('inventories.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check"></i> Create Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
