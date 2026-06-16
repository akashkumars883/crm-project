@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Employee</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="employee_type_id" class="form-label">Employee Type</label>
                            <select name="employee_type_id" id="employee_type_id" class="form-control @error('employee_type_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Employee Type</option>
                                @foreach($employeeTypes as $employeeType)
                                    <option value="{{ $employeeType->id }}" {{ old('employee_type_id', $employee->employee_type_id) == $employeeType->id ? 'selected' : '' }}>{{ $employeeType->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $employee->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}" required>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="gender_id" class="form-label">Gender</label>
                            <select name="gender_id" id="gender_id" class="form-control @error('gender_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Gender</option>
                                @foreach($genders as $gender)
                                    <option value="{{ $gender->id }}" {{ old('gender_id', $employee->gender_id) == $gender->id ? 'selected' : '' }}>{{ $gender->name }}</option>
                                @endforeach
                            </select>
                            @error('gender_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="blood_group_id" class="form-label">Blood Group</label>
                            <select name="blood_group_id" id="blood_group_id" class="form-control @error('blood_group_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Blood Group</option>
                                @foreach($bloodGroups as $bloodGroup)
                                    <option value="{{ $bloodGroup->id }}" {{ old('blood_group_id', $employee->blood_group_id) == $bloodGroup->id ? 'selected' : '' }}>{{ $bloodGroup->name }}</option>
                                @endforeach
                            </select>
                            @error('blood_group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $employee->date_of_birth) }}" required>
                            @error('date_of_birth')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $employee->address) }}" required>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" name="joining_date" id="joining_date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date', $employee->joining_date) }}" required>
                            @error('joining_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="department_id" class="form-label">Department</label>
                            <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="designation_id" class="form-label">Designation</label>
                            <select name="designation_id" id="designation_id" class="form-control @error('designation_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" {{ old('designation_id', $employee->designation_id) == $designation->id ? 'selected' : '' }}>{{ $designation->name }}</option>
                                @endforeach
                            </select>
                            @error('designation_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="skill_paint_id" class="form-label">Skill Paint</label>
                            <select name="skill_paint_id" id="skill_paint_id" class="form-control @error('skill_paint_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Skill Paint</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ old('skill_paint_id', $employee->skill_paint_id) == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                            @error('skill_paint_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="skill_polish_id" class="form-label">Skill Polish</label>
                            <select name="skill_polish_id" id="skill_polish_id" class="form-control @error('skill_polish_id') is-invalid @enderror" required>
                                <option value="" disabled>Select Skill Polish</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}" {{ old('skill_polish_id', $employee->skill_polish_id) == $skill->id ? 'selected' : '' }}>{{ $skill->name }}</option>
                                @endforeach
                            </select>
                            @error('skill_polish_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" name="salary" id="salary" class="form-control @error('salary') is-invalid @enderror" value="{{ old('salary', $employee->salary) }}" required>
                            @error('salary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="photograph" class="form-label">Photograph</label>
                            <input type="file" name="photograph" id="photograph" class="form-control @error('photograph') is-invalid @enderror" accept="image/jpeg,image/png">
                            @error('photograph')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($employee->photograph)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $employee->photograph) }}" alt="Photograph" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="pan" class="form-label">PAN</label>
                            <input type="file" name="pan" id="pan" class="form-control @error('pan') is-invalid @enderror" accept="image/jpeg,image/png">
                            @error('pan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($employee->pan)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $employee->pan) }}" alt="PAN Card" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="aadhaar" class="form-label">Aadhaar</label>
                            <input type="file" name="aadhaar" id="aadhaar" class="form-control @error('aadhaar') is-invalid @enderror" accept="image/jpeg,image/png,application/pdf">
                            @error('aadhaar')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($employee->aadhaar)
                                <div class="mt-2">
                                    @if (pathinfo($employee->aadhaar, PATHINFO_EXTENSION) === 'pdf')
                                        <a href="{{ asset('storage/' . $employee->aadhaar) }}" target="_blank">View Aadhaar (PDF)</a>
                                    @else
                                        <img src="{{ asset('storage/' . $employee->aadhaar) }}" alt="Aadhaar" class="img-thumbnail" style="max-width: 200px;">
                                    @endif
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Update Employee</button>
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
