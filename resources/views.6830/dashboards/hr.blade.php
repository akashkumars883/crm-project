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
<div class="p-3 row bg-white">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $employeeByYearChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $employeeByYearChart->renderHtml() !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $employeeByMonthChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $employeeByMonthChart->renderHtml() !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $employeeByDayChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $employeeByDayChart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

<div class="p-3 row bg-white">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $attendanceByDayChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $attendanceByDayChart->renderHtml() !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $attendanceByTypeChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $attendanceByTypeChart->renderHtml() !!}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                {{ $attendanceByStatusChart->options['chart_title'] }}
            </div>
            <div class="card-body">
                {!! $attendanceByStatusChart->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{!! $employeeByYearChart->renderChartJsLibrary() !!}
{!! $employeeByYearChart->renderJs() !!}
{!! $employeeByMonthChart->renderJs() !!}
{!! $employeeByDayChart->renderJs() !!}
{!! $attendanceByDayChart->renderJs() !!}
{!! $attendanceByTypeChart->renderJs() !!}
{!! $attendanceByStatusChart->renderJs() !!}

@endsection
