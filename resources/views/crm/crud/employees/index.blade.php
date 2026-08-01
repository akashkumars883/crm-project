@extends('layouts.app')
@section('title', 'Employee Directory')
@section('content')

<div class="container-fluid p-3 p-md-4">
    <!-- Header Hero Banner -->
    <div class="card shadow-sm border-0 rounded-0 mb-4">
        <div class="card-header border-0 rounded-0 bg-primary bg-gradient py-3 px-4 text-white d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-users fs-2"></i>
                <div>
                    <h5 class="fw-bold text-white mb-0">Employee Directory</h5>
                    <small class="text-white-50 font-12">Manage staff profiles, system login accounts, and designations</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('employees.create') }}" class="btn btn-light btn-sm px-3 py-1.5 font-13 fw-semibold rounded-0 text-nowrap d-inline-flex align-items-center" style="width: auto !important;">
                    <i class="ti ti-user-plus me-1.5"></i> Add Employee
                </a>
            </div>
        </div>

        <div class="card-body p-4 bg-white rounded-0">
            <!-- Search & Filter Bar -->
            <form action="{{ route('employees.index') }}" method="GET" class="card bg-light border-0 rounded-0 p-3 mb-4">
                <div class="row g-2 align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text rounded-0 bg-white"><i class="ti ti-search"></i></span>
                            <input type="text" name="search" class="form-control rounded-0 font-13" placeholder="Search by name, ID, phone, email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 d-flex align-items-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 px-3 py-1.5 font-13 text-nowrap" style="width: auto !important;"><i class="ti ti-search me-1"></i> Search</button>
                        @if(request('search'))
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm rounded-0 px-3 py-1.5 font-13 text-nowrap" style="width: auto !important;">Clear</a>
                        @endif
                    </div>
                </div>
            </form>

            <!-- Employees Directory Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3 text-nowrap" style="min-width: 100px;">Emp ID</th>
                            <th class="text-nowrap" style="min-width: 250px;">Employee Name</th>
                            <th class="text-nowrap" style="min-width: 150px;">Designation & Department</th>
                            <th class="text-nowrap" style="min-width: 130px;">Type</th>
                            <th class="text-nowrap" style="min-width: 180px;">Contact Info</th>
                            <th class="pe-3 text-end text-nowrap" style="min-width: 220px; width: 220px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td class="ps-3 text-nowrap">
                                    <span class="badge bg-light text-dark border rounded-0 font-12 fw-bold px-2 py-1">
                                        {{ $employee->emp_id }}
                                    </span>
                                </td>

                                <td class="text-nowrap">
                                    <div class="d-flex align-items-center gap-2.5">
                                        @if ($employee->photograph)
                                            <img src="{{ (\Illuminate\Support\Str::startsWith($employee->photograph, 'http') ? $employee->photograph : asset('storage/' . $employee->photograph)) }}" alt="{{ $employee->name }}" class="rounded-circle border flex-shrink-0" style="width: 40px; height: 40px; min-width: 40px; min-height: 40px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary-subtle text-primary border flex-shrink-0 d-flex align-items-center justify-content-center fw-bold font-13 shadow-sm" style="width: 40px; height: 40px; min-width: 40px; min-height: 40px;">
                                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <a href="{{ route('employees.show', $employee->id) }}" class="fw-bold text-dark font-14 text-decoration-none d-block hover-primary">{{ $employee->name }}</a>
                                            <small class="text-muted font-11"><i class="ti ti-mail me-1"></i>{{ $employee->email }}</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="text-nowrap">
                                    <small class="d-block text-dark fw-semibold font-12">{{ optional($employee->designation)->name ?? 'General Staff' }}</small>
                                    <small class="text-muted font-11">{{ optional($employee->department)->name ?? 'Operations' }}</small>
                                </td>

                                <td class="text-nowrap">
                                    <span class="badge bg-info-subtle text-info border border-info-subtle rounded-0 font-12 px-2 py-1">
                                        {{ optional($employee->employeeType)->name ?? 'Full Time' }}
                                    </span>
                                </td>

                                <td class="text-nowrap font-12 text-muted">
                                    <div><i class="ti ti-phone me-1 text-secondary"></i>{{ $employee->phone ?: 'N/A' }}</div>
                                </td>

                                <td class="pe-3 text-end text-nowrap">
                                    <div class="d-inline-flex align-items-center gap-1.5 justify-content-end" style="width: auto !important;">
                                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-sm btn-outline-info font-12 rounded-0 px-2.5 py-1 text-nowrap" style="width: auto !important;" title="View Profile">
                                            <i class="ti ti-eye me-1"></i> Show
                                        </a>
                                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-outline-primary font-12 rounded-0 px-2.5 py-1 text-nowrap" style="width: auto !important;" title="Edit Employee">
                                            <i class="ti ti-pencil me-1"></i> Edit
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger font-12 rounded-0 px-2.5 py-1 text-nowrap" style="width: auto !important;" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $employee->id }}" title="Delete Employee">
                                            <i class="ti ti-trash me-1"></i> Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No employees found in directory.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($employees->hasPages())
                <div class="pt-3 border-top">
                    {{ $employees->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Delete Confirmation Modals -->
@foreach($employees as $employee)
    <div class="modal fade" id="confirmDeleteModal{{ $employee->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-0">
                <div class="modal-header bg-danger text-white rounded-0">
                    <h5 class="modal-title fw-bold font-15"><i class="ti ti-alert-triangle me-2"></i>Delete Employee</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 rounded-0">
                    <p class="mb-1 font-14">Are you sure you want to delete employee <strong>{{ $employee->name }}</strong> (ID: {{ $employee->emp_id }})?</p>
                    <small class="text-muted font-12">This action will also delete linked user credentials permanently.</small>
                </div>
                <div class="modal-footer border-top rounded-0">
                    <button type="button" class="btn btn-secondary btn-sm px-3 py-1.5 rounded-0 text-nowrap" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm px-4 py-1.5 rounded-0 text-nowrap"><i class="ti ti-trash me-1"></i> Confirm Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@endsection
