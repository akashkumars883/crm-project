@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div> --}}

@if (Auth::user()->hasPermission('admin-dashboard'))
    Admin Dashboard
@endif

@if (Auth::user()->hasPermission('manager-dashboard'))
    Manager Dashboard
@endif

@if (Auth::user()->hasPermission('supervisor-dashboard'))
    Supervisor Dashboard
@endif

@if (Auth::user()->hasPermission('accounts-dashboard'))
    Accounts Dashboard
@endif

@if (Auth::user()->hasPermission('hr-dashboard'))
    HR Dashboard
@endif

@if (Auth::user()->hasPermission('employee-dashboard'))
    Employee Dashboard
@endif

@if (Auth::user()->hasPermission('vendor-dashboard'))
    Vendor Dashboard
@endif

@if (Auth::user()->hasPermission('client-dashboard'))
    Client Dashboard
@endif
@endsection
