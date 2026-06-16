@extends('layouts.app')
@section('title', $invoice->id)
@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12 m-3">
        <div class="page-title-box">
            <h4 class="page-title">Invoice #{{ $invoice->id }}</h4>
        </div>
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('invoices.index') }}" class="btn btn-primary btn-square">Go Back</a>
                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary btn-square">Edit</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Invoice ID</th>
                            <td>{{ $invoice->id }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Type</th>
                            <td>{{ $invoice->invoiceType->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Status</th>
                            <td>{{ $invoice->invoiceStatus->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Lead</th>
                            <td><a class="text-dark" href="{{ route('leads.show', $invoice->lead_id) }}">{{ $invoice->lead_id  ?? 'N/A' }} - {{ $invoice->lead->name  ?? 'N/A' }}</a></td>
                        </tr>
                        <tr>
                            <th>Value</th>
                            <td>{{ $invoice->value }}</td>
                        </tr>
                        <tr>
                            <th>Attachments</th>
                            <td>
                                @if(count($invoice->attachments) > 0)
                                    @foreach($invoice->attachments as $attachment)
                                        <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">{{ $attachment }}</a>
                                    @endforeach
                                @else
                                    No attachments
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created at</th>
                            <td>{{ $invoice->created_at->format('D, d M Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Created by</th>
                            <td>{{ $invoice->creator->name }}</td>
                        </tr>
                        <tr>
                            <th>Updated at</th>
                            <td>{{ $invoice->updated_at->format('D, d M Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th>Updated by</th>
                            <td>{{ $invoice->updater->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
