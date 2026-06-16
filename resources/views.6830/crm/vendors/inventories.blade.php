@extends('layouts.app')
@section('title', 'Inventories')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="page-title">Inventories</h4>
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
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
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
                                    <td>{{ $inventory->title }}</td>
                                    <td>{{ $inventory->description }}</td>
                                    <td>{{ $inventory->cost }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $inventories->links('pagination::bootstrap-5') }}
            </div>>
        </div>
    </div>
</div>
@endsection
