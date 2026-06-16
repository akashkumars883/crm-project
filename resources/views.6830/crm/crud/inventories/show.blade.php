@extends('layouts.app')
@section('title', 'Inventory Details')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="page-title-box">
                <h4 class="page-title text-center">Inventory Details</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row justify-content-center">
        <div class="col-8 border">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <tbody>
                            <tr>
                                <td>ID</td>
                                <td>{{ $inventory->id }}</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td>{{ $inventory->inventoryType->name }}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{ $inventory->inventoryStatus->name }}</td>
                            </tr>
                            <tr>
                                <td>Project</td>
                                <td>{{ $inventory->project->id }} - {{ $inventory->project->customer->lead->name }}</td>
                            </tr>
                            <tr>
                                <td>Vendor</td>
                                <td>{{ $inventory->vendor->name }}</td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td>{{ $inventory->title }}</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>{{ $inventory->description }}</td>
                            </tr>
                            <tr>
                                <td>Cost</td>
                                <td>{{ $inventory->cost }}</td>
                            </tr>
                            <tr>
                                <td>Created At</td>
                                <td>{{ $inventory->created_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Created By</td>
                                <td>{{ $inventory->creator->name }}</td>
                            </tr>
                            <tr>
                                <td>Last Updated</td>
                                <td>{{ $inventory->updated_at->format('D, d M Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <td>Updated By</td>
                                <td>{{ $inventory->updater->name }}</td>
                            </tr>
                            </tbody>
                        </table><!--end /table-->
                    </div><!--end /tableresponsive-->
                    <div class="mt-3">
                        <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-primary">Update</a>
                        <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back to Inventories</a>
                    </div>
                </div><!--end card-body-->
            </div>
            <div class="card">
                <div class="card-title text-center">
                    <h4>Related Bills</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0 table-centered">
                            <tbody>
                                @forelse ($inventory->bills as $bill)
                                    <tr>
                                        <td>Ref #</td>
                                        <td>{{ $bill->reference }}</td>
                                    </tr>
                                    <tr>
                                        <td>Type</td>
                                        <td>{{ $bill->billType->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Amount</td>
                                        <td>{{ $bill->amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bill Date</td>
                                        <td>{{ $bill->bill_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Due Date</td>
                                        <td>{{ $bill->due_date }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>{{ $bill->billStatus->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Attachments</td>
                                        <td>
                                            @if ($bill->attachments)
                                                @foreach ($bill->attachments as $attachment)
                                                <li><a class="mb-2" href="{{ asset('storage/' . $attachment) }}" target="_blank">{{ $attachment }}</a></li>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <p>No Bills Data Found</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
