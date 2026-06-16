@extends('layouts.app')
@section('title', 'All Leads')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Leads</h4>
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
        <div>
            <h6>Leads By Status</h6>
        </div>
        <div class="row justify-content-center">
            @foreach($leadStatusAnalytics as $status)
                <div class="col">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="">
                                    <p class="text-dark mb-0 fw-semibold">{{ $status->name }}</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $status->leads_count }}</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> New Sessions Today</p> --}}
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            @endforeach
        </div>
    </div>

    <div class="row">
        <div>
            <h6>Leads By Source</h6>
        </div>
        <div class="row justify-content-center">
            @foreach($leadSourceAnalytics as $status)
                <div class="col">
                    <div class="card border">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="">
                                    <p class="text-dark mb-0 fw-semibold">{{ $status->name }}</p>
                                    <h3 class="my-1 font-20 fw-bold">{{ $status->leads_count }}</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> New Sessions Today</p> --}}
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('leads.create') }}" class="btn btn-primary">Add a New Lead</a>
                    </div>
                    <div class="col-md-6 mb-3 d-flex justify-content-end">
                        <form action="{{ route('leads.index') }}" method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search leads">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leads as $lead)
                                <tr>
                                    <td>{{ $lead->name }}</td>
                                    <td>{{ $lead->phone }}</td>
                                    <td>{{ $lead->email }}</td>
                                    <td>{{ $lead->leadSource->name }}</td>
                                    <td>{{ $lead->leadStatus->name }}</td>
                                    <td>{{ $lead->assignedTo ? $lead->assignedTo->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $lead->id }}">Delete</button>
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
                {{ $leads->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>

    @foreach($leads as $lead)
    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="confirmDeleteModal{{ $lead->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this lead?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('leads.destroy', $lead->id) }}" method="POST" class="d-inline">
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