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
        {{ session('Customers') }}
    </div>
@endif

{{-- Counters --}}
<div class="p-4 bg-light">
    <div class="mb-3">
        <h5>Dashboard</h5>
    </div>
    <div class="row">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Admins</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $adminsCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Managers</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $managersCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Supervisors</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $supervisorsCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Accounts</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $accountsCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">HR</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $hrCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Employees</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $employeesCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Customers</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $customersCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Vendors</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $vendorsCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
        </div>
    </div>
</div>

<div class="p-4 bg-light">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $leadsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $leadsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $invoicesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $invoicesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $projectsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $projectsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="p-4 bg-light">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $inventoriesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $inventoriesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $paymentsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $paymentsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $billsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $billsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="p-4 bg-light">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ $ticketsByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $ticketsByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ $activitiesByMonth->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $activitiesByMonth->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    {{ $rolesChart->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $rolesChart->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('scripts')
{!! $leadsByMonth->renderChartJsLibrary() !!}
{!! $leadsByMonth->renderJs() !!}
{!! $invoicesByMonth->renderJs() !!}
{!! $projectsByMonth->renderJs() !!}
{!! $inventoriesByMonth->renderJs() !!}
{!! $paymentsByMonth->renderJs() !!}
{!! $billsByMonth->renderJs() !!}
{!! $ticketsByMonth->renderJs() !!}
{!! $activitiesByMonth->renderJs() !!}
{!! $rolesChart->renderJs() !!}
@endsection