@extends('layouts.app')
@section('title', 'Vendor User Account Details')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-6">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Vendor User Account Details</h5>
                        </div>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('vendor-users.edit', $vendorUser->id) }}" class="btn btn-square btn-primary">Update</a>
                        <a href="{{ route('vendor-users.index') }}" class="btn btn-square btn-secondary">Back to Vendor User List</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>Vendor User Account ID</th>
                                <td>{{ $vendorUser->id }}</td>
                            </tr>
                            <tr>
                                <th>Vendor Name</th>
                                <td>{{ $vendorUser->vendor->name }}</td>
                            </tr>
                            <tr>
                                <th>User ID</th>
                                <td>{{ $vendorUser->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $vendorUser->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <td>{{ $vendorUser->creator->name }}</td>
                            </tr>
                            <tr>
                                <th>Updated At</th>
                                <td>{{ $vendorUser->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Updated By</th>
                                <td>{{ $vendorUser->creator->name }}</td>
                            </tr>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div>
</div>
@endsection
