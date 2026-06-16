@extends('layouts.app')
@section('title', 'All Bills')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Bills</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    {{-- Analytics --}}
    <div class="p-3 row bg-white">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart1->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart1->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart2->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart2->renderHtml() !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $chart3->options['chart_title'] }}
                </div>
                <div class="card-body">
                    {!! $chart3->renderHtml() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('bills.create') }}" class="btn btn-primary">Add a New Bill</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('bills.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search Bill">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Ref #</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Employee</th>
                                    <th>Inventory</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->reference }}</td>
                                    <td>{{ $bill->billType ? $bill->billType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->amount }}</td>
                                    <td>{{ $bill->employee ? $bill->employee->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->inventory ? $bill->inventory->id ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('D d, M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('D d, M Y') }}</td>
                                    <td>{{ $bill->billStatus ? $bill->billStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('bills.show', $bill->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('bills.edit', $bill->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $bill->id }}">Delete</button>
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
                {{ $bills->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($bills as $bill)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $bill->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this Bill?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('bills.destroy', $bill->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@section('scripts')
{!! $chart1->renderChartJsLibrary() !!}
{!! $chart1->renderJs() !!}
{!! $chart2->renderJs() !!}
{!! $chart3->renderJs() !!}
@endsection