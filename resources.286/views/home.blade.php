@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="p-4 mb-4 bg-white">
    <div class="float-start">
        <h5>Welcome, {{ Auth::user()->name }}</h5>
    </div>
    <div class="float-end">
        {{ date('d-M-y h:i: A') }}
    </div>
</div>
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- <div class="p-4 bg-light">
    <h5>Assignments</h5>

    <div class="pt-3 row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>10</h3>
                    <h6>Admins</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>10</h3>
                    <h6>Projects Assigned</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>10</h3>
                    <h6>Tickets Answered</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>10</h3>
                    <h6>Tickets Assigned   <span class="text-danger">(5 unanswered)</span>  </h6>
                </div>
            </div>
        </div>
    </div>
</div> --}}

@if (Auth::user()->hasRole('admin'))
    Admin Dashboard
@endif

@if (Auth::user()->hasRole('manager'))
    Manager Dashboard
@endif

@if (Auth::user()->hasRole('supervisor'))
    Supervisor Dashboard
@endif

@if (Auth::user()->hasRole('accounts'))
    Accounts Dashboard
@endif

@if (Auth::user()->hasRole('hr'))
    HR Dashboard
@endif

@if (Auth::user()->hasRole('employee'))
<div class="p-4 bg-light">
    <h5>Dashboard</h5>

    <div class="row">
        <div>
            <h6>Attendance By Type</h6>
        </div>
        <div class="row justify-content-center">
            @foreach($AttendanceTypeAnalytics as $status)
                <div class="col">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="">
                                    <p class="text-dark mb-0 fw-semibold">{{ $status->name }}</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $status->attendanceRecords->count() }}</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> New Sessions Today</p> --}}
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            @endforeach
        </div>
    </div>

    <div class="row">
        <div>
            <h6>Attendance By Status</h6>
        </div>
        <div class="row justify-content-center">
            @foreach($AttendanceStatusAnalytics as $status)
                <div class="col">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="">
                                    <p class="text-dark mb-0 fw-semibold">{{ $status->name }}</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $status->attendanceRecords->count() }}</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> New Sessions Today</p> --}}
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            @endforeach
        </div>
    </div>
</div>
@endif

@if (Auth::user()->hasRole('vendor'))
<div class="p-4 bg-light">
    <h5>Dashboard</h5>

    <div class="pt-3 row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3 class="">{{ $inventoriesCount }}</h3>
                    <h6 class="">Inventories</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $billsCount }}</h3>
                    <h6>Bills</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (Auth::user()->hasRole('client'))
<div class="p-4 bg-light">
    <h5>Dashboard</h5>

    <div class="pt-3 row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $invoicesCount }}</h3>
                    <h6>Invoices</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $projectsCount }}</h3>
                    <h6>Projects</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $paymentsCount }}</h3>
                    <h6>Payments</h6>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h3>{{ $ticketsCount }}</h3>
                    <h6>Tickets</h6>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
