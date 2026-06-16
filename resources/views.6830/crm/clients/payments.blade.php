@extends('layouts.app')
@section('title', 'My Payments')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">My Payments</h4>
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
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Method</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->reference }}</td>
                                    <td>{{ $payment->paymentStatus ? $payment->paymentStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $payment->paymentMethod ? $payment->paymentMethod->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->notes }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>
</div>
@endsection
