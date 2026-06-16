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

@endsection
