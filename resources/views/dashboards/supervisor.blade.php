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
@endsection