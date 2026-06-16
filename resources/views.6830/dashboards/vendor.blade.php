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
                                <p class="text-dark mb-0 fw-semibold">Inventories</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $inventoriesCount }}</h3>
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
                                <p class="text-dark mb-0 fw-semibold">Bills</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $billsCount }}</h3>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
        </div>
    </div>
</div>
@endsection
