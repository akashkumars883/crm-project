@extends('layouts.app')
@section('title', 'My Bank Account Details')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title">My Bank Account Details</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end row -->

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p class="font-14">Bank Name: {{ $employeeBankAccount->bank_name }}</p>
                    <p class="font-14">Branch: {{ $employeeBankAccount->branch }}</p>
                    <p class="font-14">IFSC: {{ $employeeBankAccount->ifsc }}</p>
                    <p class="font-14">Account Name: {{ $employeeBankAccount->account_name }}</p>
                    <p class="font-14">Account Number: {{ $employeeBankAccount->account_number }}</p>
                    <p class="font-14">UPI: {{ $employeeBankAccount->upi }}</p>
                    <p class="font-14">PhonePe: {{ $employeeBankAccount->phonepe }}</p>
                    <p class="font-14">Google Pay: {{ $employeeBankAccount->googlepay }}</p>
                    <p class="font-14">Paytm: {{ $employeeBankAccount->paytm }}</p>
                    <!-- Other fields for bank account details -->
                    <!-- ... -->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div>
@endsection
