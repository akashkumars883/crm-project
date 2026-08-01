@extends('layouts.app')
@section('title', 'Create Employee')
@section('content')
<div class="container-fluid p-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <a href="{{ route('employees.index') }}" class="text-dark me-2 text-decoration-none" title="Back to Employees">
                        <i class="ti ti-arrow-left fs-3 align-middle"></i>
                    </a>
                    <h5 class="card-title mb-0 fw-bold text-primary">Add New Employee</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Personal Details -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold font-12 mb-3 border-bottom pb-2"><i class="ti ti-id me-1"></i>Personal Information</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g. Rahul Sharma" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="rahul@example.com" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="9876543210">
                                    @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="gender_id" class="form-label fw-semibold">Gender</label>
                                    <select name="gender_id" id="gender_id" class="form-select @error('gender_id') is-invalid @enderror">
                                        <option value="" selected>Select Gender (Optional)</option>
                                        @foreach($genders as $gender)
                                            <option value="{{ $gender->id }}" {{ old('gender_id') == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="blood_group_id" class="form-label fw-semibold">Blood Group</label>
                                    <select name="blood_group_id" id="blood_group_id" class="form-select @error('blood_group_id') is-invalid @enderror">
                                        <option value="" selected>Select Blood Group (Optional)</option>
                                        @foreach($bloodGroups as $bloodGroup)
                                            <option value="{{ $bloodGroup->id }}" {{ old('blood_group_id') == $bloodGroup->id ? 'selected' : '' }}>{{ $bloodGroup->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('blood_group_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="date_of_birth" class="form-label fw-semibold">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="address" class="form-label fw-semibold">Full Address</label>
                                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" placeholder="Street address, city, state, pincode">
                                    @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Employment Information -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold font-12 mb-3 border-bottom pb-2"><i class="ti ti-briefcase me-1"></i>Employment Details</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="employee_type_id" class="form-label fw-semibold">Employee Type</label>
                                    <select name="employee_type_id" id="employee_type_id" class="form-select @error('employee_type_id') is-invalid @enderror">
                                        <option value="" selected>Select Employee Type</option>
                                        @foreach($employeeTypes as $employeeType)
                                        <option value="{{ $employeeType->id }}" {{ old('employee_type_id') == $employeeType->id ? 'selected' : '' }}>{{ $employeeType->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('employee_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="department_id" class="form-label fw-semibold">Department</label>
                                    <select name="department_id" id="department_id" class="form-select @error('department_id') is-invalid @enderror">
                                        <option value="" selected>Select Department (Optional)</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label for="designation_id" class="form-label mb-0 fw-semibold">Designation</label>
                                        <a href="{{ route('designations.create') }}" target="_blank" class="text-primary small fw-semibold">+ Add Designation</a>
                                    </div>
                                    <select name="designation_id" id="designation_id" class="form-select @error('designation_id') is-invalid @enderror">
                                        <option value="" selected>Select Designation (Optional)</option>
                                        @foreach($designations as $designation)
                                            <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('designation_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="joining_date" class="form-label fw-semibold">Joining Date</label>
                                    <input type="date" name="joining_date" id="joining_date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date') }}">
                                    @error('joining_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="salary" class="form-label fw-semibold">Salary (Monthly)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₹</span>
                                        <input type="number" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary') }}" placeholder="0.00">
                                    </div>
                                    @error('salary')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Skills -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold font-12 mb-3 border-bottom pb-2"><i class="ti ti-tools me-1"></i>Skills Information</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="skill_paint_id" class="form-label fw-semibold">Skill Paint</label>
                                    <select name="skill_paint_id" id="skill_paint_id" class="form-select @error('skill_paint_id') is-invalid @enderror">
                                        <option value="" selected>Select Skill Paint (Optional)</option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ old('skill_paint_id') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('skill_paint_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="skill_polish_id" class="form-label fw-semibold">Skill Polish</label>
                                    <select name="skill_polish_id" id="skill_polish_id" class="form-select @error('skill_polish_id') is-invalid @enderror">
                                        <option value="" selected>Select Skill Polish (Optional)</option>
                                        @foreach($skills as $skill)
                                            <option value="{{ $skill->id }}" {{ old('skill_polish_id') == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('skill_polish_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Documents Upload -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold font-12 mb-3 border-bottom pb-2"><i class="ti ti-file-upload me-1"></i>Documents & Attachments</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="photograph" class="form-label fw-semibold">Photograph</label>
                                    <input type="file" name="photograph" id="photograph" class="form-control @error('photograph') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('photograph')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="pan" class="form-label fw-semibold">PAN Card Photo</label>
                                    <input type="file" name="pan" id="pan" class="form-control @error('pan') is-invalid @enderror" accept="image/jpeg,image/png">
                                    @error('pan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="aadhaar" class="form-label fw-semibold">Aadhaar Card (Photo / PDF)</label>
                                    <input type="file" name="aadhaar" id="aadhaar" class="form-control @error('aadhaar') is-invalid @enderror" accept="image/jpeg,image/png,application/pdf">
                                    @error('aadhaar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Section 5: System Login & Access Credentials -->
                        <div class="mb-4">
                            <h6 class="text-uppercase text-muted fw-bold font-12 mb-3 border-bottom pb-2"><i class="ti ti-lock me-1"></i>System Login & Access Credentials</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="user_password" class="form-label fw-semibold">Login Password <span class="text-danger">*</span></label>
                                    <input type="password" name="user_password" id="user_password" class="form-control @error('user_password') is-invalid @enderror" placeholder="Set login password (min 6 characters)">
                                    <small class="text-muted">If left blank, password will default to Phone Number or 12345678.</small>
                                    @error('user_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="role_id" class="form-label fw-semibold">System Access Role</label>
                                    <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ (old('role_id') == $role->id || strtolower($role->name) == 'employee') ? 'selected' : '' }}>
                                                {{ ucfirst($role->display_name ?? $role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="ti ti-check me-1"></i>Save Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
