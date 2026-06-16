@extends('layouts.app')
@section('title', $employee->full_name)
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="p-3 bg-light">
    <div class="row">
        <div class="col">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <div class="media-body align-self-center">
                                            @if ($employee->photograph)
                                                <img src="{{ (\Illuminate\Support\Str::startsWith($employee->photograph, 'http') ? $employee->photograph : asset('storage/' . $employee->photograph)) }}" alt="Employee Photograph" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                            @else
                                                <p>No Photograph Uploaded</p>
                                            @endif
                                        </div><!--end media body-->
                                    </div> <!--end media-->

                                    <hr class="hr-dashed">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary btn-square">Update</a>
                                            <a href="{{ route('employees.index') }}" class="btn btn-dark btn-square">Back</a>
                                        </div><!--end col-->
                                    </div>  <!--end row-->
                                    <div class="row align-items-center mt-3">
                                        <div class="col">
                                            @if ($employee->employeeUser)
                                                @if ($employee->employeeUser->employee_id)
                                                    <a href="{{ route('employee-users.show', $employee->employeeUser->id) }}" class="btn btn-square btn-success">Employes Login Info</a>
                                                @else
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeAccountModal">Create Login Access</button>
                                                @endif
                                                @else
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeAccountModal">Create Login Access</button>
                                            @endif
                                        </div>
                                    </div>
                                </div><!--end card-body-->
                            </div>  <!--end card-->
                        </div><!--end col-->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <div class="media-body align-self-center">
                                            <h4 class="text-primary mt-0 font-24">{{ $employee->name }} </h4>
                                            <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $employee->phone }} </p>
                                            <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $employee->email }} </p>
                                            <p class="mb-0 font-14"><i class="fas fa-home"></i> : {{ $employee->address }}, {{ $employee->city }}, {{ $employee->state }} - {{ $employee->zip_code }} </p>
                                        </div><!--end media body-->
                                    </div> <!--end media-->

                                    <p class="mb-0 font-14">Gender : {{ optional($employee->gender)->name }}</p>
                                    <p class="mb-0 font-14">Blood Group : {{ optional($employee->bloodGroup)->name }} </p>
                                    <p class="mb-0 font-14">Date of Birth: {{ Carbon::parse($employee->date_of_birth)->format('M, d Y') }}</p>
                                    <p class="mb-0 font-14">Age: {{ Carbon::parse($employee->date_of_birth)->age }} years</p>
                                    <hr class="hr-dashed">
                                    <p class="mb-0 font-14">Documents</p>
                                    @if ($employee->pan)
                                    <a href="{{ (\Illuminate\Support\Str::startsWith($employee->pan, 'http') ? $employee->pan : asset('storage/' . $employee->pan)) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">PAN</a>
                                    @else
                                        No PAN Uploaded
                                    @endif
                                    @if ($employee->aadhaar)
                                        <a href="{{ (\Illuminate\Support\Str::startsWith($employee->aadhaar, 'http') ? $employee->aadhaar : asset('storage/' . $employee->aadhaar)) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">Aadhaar</a>
                                    @else
                                        No Aadhaar Uploaded
                                    @endif
                                </div><!--end card-body-->
                            </div>  <!--end card-->
                        </div><!--end col-->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <div class="media-body align-self-center">
                                            <p class="mb-0 font-14">Employee ID : {{ $employee->emp_id }} </p>
                                            <p class="mb-0 font-14">Employee Type : {{ optional($employee->employeeType)->name }} </p>
                                            <p class="mb-0 font-14">Joining Date: {{ Carbon::parse($employee->joining_date)->format('M, d Y') }}</p>
                                            <p class="mb-0 font-14">Salary : {{ $employee->salary }} </p>
                                            <p class="mb-0 font-14">Department : {{ optional($employee->department)->name }} </p>
                                            <p class="mb-0 font-14">Designation : {{ optional($employee->designation)->name }} </p>
                                            <p class="mb-0 font-14">Skill Paint : {{ optional($employee->skillPaint)->name }} </p>
                                            <p class="mb-0 font-14">Skill Polish : {{ optional($employee->skillPolish)->name }} </p>
                                            <hr class="hr-dashed">
                                            <p class="mb-0 font-14">Created at : {{ $employee->created_at->format('D, d M Y h:i A') }} by {{ $employee->creator->name }} </p>
                                            <p class="mb-0 font-14">Last updated at : {{ $employee->updated_at->format('D, d M Y h:i A') }} by {{ $employee->updater->name }}</p>
                                        </div><!--end media body-->
                                    </div> <!--end media-->
                                </div><!--end card-body-->
                            </div>  <!--end card-->
                        </div><!--end col-->
                        <div class="col-lg-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="media mb-3">
                                        <div class="media-body align-self-center">
                                            <h4 class="mt-0 mb-0 font-13">Banking Information </h4>
                                            @if($employee->employeeBankAccount)
                                                <p class="mb-0 font-14">Bank Name : {{ $employee->employeeBankAccount->bank_name }}  days</p>
                                                <p class="mb-0 font-14">Branch : {{ $employee->employeeBankAccount->branch }}  days</p>
                                                <p class="mb-0 font-14">IFSC : {{ $employee->employeeBankAccount->ifsc }}</p>
                                                <p class="mb-0 font-14">Account Name : {{ $employee->employeeBankAccount->account_name }}</p>
                                                <p class="mb-0 font-14">Account Number : {{ $employee->employeeBankAccount->account_number }}</p>
                                                <p class="mb-0 font-14">UPI : {{ $employee->employeeBankAccount->upi }}</p>
                                                <p class="mb-0 font-14">Phonepe : {{ $employee->employeeBankAccount->phonepe }}</p>
                                                <p class="mb-0 font-14">Googlepay : {{ $employee->employeeBankAccount->googlepay }}</p>
                                                <p class="mb-0 font-14">Paytm : {{ $employee->employeeBankAccount->paytm }}</p>
                                            @else
                                                <p class="mb-0 font-14">No bank account details available for this employee</p>
                                                <button type="button" class="btn btn-primary  btn-square btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#bankModal">Add Bank Account</button>
                                                {{-- <a class="btn btn-primary  btn-square btn-sm mt-2" href="">Add Bank Account</a> --}}
                                            @endif
                                        </div><!--end media body-->
                                    </div> <!--end media-->

                                    {{-- <p class="mb-0 font-14">Assigned To : {{ $customer->lead->assignedTo->name }} </p> --}}
                                    {{-- <p class="mb-0 font-14">Since : {{ $customer->lead->assignedTo->created_at->diffInDays(now()) }} days </p> --}}
                                </div><!--end card-body-->
                            </div>  <!--end card-->
                        </div><!--end col-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Attendance Records</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Employee</th>
                                    <th>Project ID</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendanceRecords as $attendanceRecord)
                                <tr>
                                    <td>{{ $attendanceRecord->employee->emp_id }}</td>
                                    <td>{{ $attendanceRecord->employee->full_name }}</td>
                                    <td>{{ $attendanceRecord->project_id }} - {{ $attendanceRecord->project->customer->lead->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($attendanceRecord->date)->format('D d, M Y') }}</td>
                                    <td>{{ $attendanceRecord->attendanceType->name }}</td>
                                    <td>{{ $attendanceRecord->attendanceStatus->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $attendanceRecords->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Bills</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ref #</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Employee</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->reference }}</td>
                                    <td>{{ $bill->billType ? $bill->billType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->amount }}</td>
                                    <td>{{ $bill->employee ? $bill->employee->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('D d, M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('D d, M Y') }}</td>
                                    <td>{{ $bill->billStatus ? $bill->billStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $bills->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add the Create Customer  Modal Markup -->
<div class="modal fade" id="bankModal" tabindex="-1" aria-labelledby="bankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="bankModalLabel">Add Bank Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'crm.crud.employees.create_bank_account_form content here -->
                @include('crm.crud.employees.create_bank_account_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Bank popup -->
<script>
    function openBankPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('BankPopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Create Employee Account  Modal Markup -->
<div class="modal fade" id="employeeAccountModal" tabindex="-1" aria-labelledby="employeeAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="employeeAccountModalLabel">Create Employee Login Access</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the ' content here -->
                @include('crm.crud.employees.create_employee_user_account_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Employee Login Access popup -->
<script>
    function openEmployeeAccountPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('EmployeeAccountPopup');
        popup.style.display = 'block';
    }
</script>
@endsection
