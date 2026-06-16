@extends('layouts.app')
@section('title', $vendor->name)
@section('content')
<div class="row pt-3 border border-bottom border-5 mb-4">
    <div class="col">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media mb-3">
                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mt-0 font-24">{{ $vendor->name }} </h4>
                                        <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $vendor->phone }} </p>
                                        <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $vendor->email }} </p>
                                        <p class="mb-0 font-14"><i class="fas fa-home"></i> : {{ $vendor->address }}</p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-14">Vendor Type: {{ $vendor->vendorType->name }}</p>
                                <p class="mb-0 font-14">Vendor Status: {{ $vendor->vendorStatus->name }}</p>
                                <hr class="hr-dashed">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-primary btn-square">Update</a>
                                        <a href="{{ route('vendors.index') }}" class="btn btn-primary btn-square">Back</a>
                                    </div><!--end col-->
                                </div>  <!--end row-->
                            </div><!--end card-body-->
                        </div>  <!--end card-->
                    </div><!--end col-->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media mb-3">
                                    <div class="media-body align-self-center">
                                        <p class="mb-0 font-14">Created: {{ $vendor->created_at->format('D, d M Y h:i A') }} </p>
                                        <p class="mb-0 font-14">Created By: {{ $vendor->creator->name}} </p>
                                        <p class="mb-0 font-14">Last Updated: {{ $vendor->updated_at->format('D, d M Y h:i A') }} </p>
                                        <p class="mb-0 font-14">Updated By: {{ $vendor->updater->name}} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <!-- Add more details or fields as needed -->
                            </div><!--end card-body-->
                        </div>  <!--end card-->
                    </div><!--end col-->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Bills</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ref #</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Inventory</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->reference }}</td>
                                    <td>{{ $bill->billType ? $bill->billType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->amount }}</td>
                                    <td>{{ $bill->inventory ? $bill->inventory->id ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('D d, M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('D d, M Y') }}</td>
                                    <td>{{ $bill->billStatus ? $bill->billStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $bills->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Inventories</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Vendor</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->inventoryType ? $inventory->inventoryType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $inventory->inventoryStatus ? $inventory->inventoryStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $inventory->vendor ? $inventory->vendor->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $inventory->title }}</td>
                                    <td>{{ $inventory->description }}</td>
                                    <td>{{ $inventory->cost }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-3">
                        {{ $inventories->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
