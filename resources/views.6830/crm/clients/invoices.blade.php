@extends('layouts.app')
@section('title', 'My Invoices')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">My Invoices</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice id</th>
                                    <th>Invoice Type</th>
                                    <th>Invoice Status</th>
                                    <th>Value</th>
                                    <th>Attachments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->invoiceType->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->invoiceStatus->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->value }}</td>
                                    <td>
                                        @if($invoice->attachments && count($invoice->attachments) > 0)
                                            @foreach($invoice->attachments as $attachment)
                                                <a href="{{ asset('storage/' . $attachment) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">{{ $attachment }}</a>
                                            @endforeach
                                        @else
                                            No attachments
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $invoices->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>
</div>
@endsection
