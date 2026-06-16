@extends('layouts.app')
@section('title', 'My Profile')
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

                                    <p class="mb-0 font-14">Gemder : {{ $employee->gender->name }} </p>
                                    <p class="mb-0 font-14">Blood Group : {{ $employee->bloodGroup->name }} </p>
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
                                            <p class="mb-0 font-14">Employee Type : {{ $employee->employeeType->name }} </p>
                                            <p class="mb-0 font-14">Joining Date: {{ Carbon::parse($employee->joining_date)->format('M, d Y') }}</p>
                                            <p class="mb-0 font-14">Salary : {{ $employee->salary }} </p>
                                            <p class="mb-0 font-14">Department : {{ $employee->department->name }} </p>
                                            <p class="mb-0 font-14">Designation : {{ $employee->designation->name }} </p>
                                            <p class="mb-0 font-14">Skill Paint : {{ $employee->skillPaint->name }} </p>
                                            <p class="mb-0 font-14">Skill Polish : {{ $employee->skillPolish->name }} </p>
                                            <hr class="hr-dashed">
                                            {{-- <p class="mb-0 font-14">Created at : {{ $employee->created_at->format('D, d M Y h:i A') }} by {{ $employee->creator->name }} </p> --}}
                                            {{-- <p class="mb-0 font-14">Last updated at : {{ $employee->updated_at->format('D, d M Y h:i A') }} by {{ $employee->updater->name }}</p> --}}
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

@endsection
