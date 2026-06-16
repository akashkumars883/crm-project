@extends('layouts.app')
@section('title', $project->customer->lead->name)
@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="row pt-3  border border-bottom border-5 mb-4">
    <div class="col">
        <div class="card mb-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media mb-3">
                                    <div class="media-body align-self-center">
                                        <h4 class="text-primary mt-0 mb-0 font-17">{{ $project->customer->lead->name }} </h4>
                                        <p class="mb-0 font-12"><i class="fas fa-phone-square"></i> : {{ $project->customer->lead->phone }} </p>
                                        <p class="mb-0 font-12"><i class="fas fa-phone-square"></i> : {{ $project->customer->lead->email }} </p>
                                        <p class="mb-0 font-12"><i class="fas fa-home"></i> : {{ $project->customer->lead->address }}, {{ $project->customer->lead->city }}, {{ $project->customer->lead->state }} - {{ $project->customer->lead->zip }} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-12">Source : {{ $project->customer->lead->leadSource->name }} </p>
                                <p class="mb-0 font-14">Project Status : {{ $project->projectStatus ? $project->projectStatus->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <p class="mb-0 font-14">Project Type : {{ $project->projectType ? $project->projectType->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <p class="mb-0 font-14">Assigned To : {{ $project->assignedTo ? $project->assignedTo->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <hr class="hr-dashed">
                                <div class="row align-items-center">
                                    <div class="col">
                                        @if (Auth::user()->hasPermission('update-project'))
                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-primary btn-square">Update</a>
                                        @endif
                                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-primary btn-square">Back</a>
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
                                        <h4 class="mt-0 mb-0 font-15">Project Details </h4>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-12">Project Status: <span class="badge bg-primary font-13">{{ $project->projectStatus->name }}</span></p>
                                <p class="mb-0 font-12">Start Date: {{ Carbon::parse($project->start_date)->format('M, d Y') }}</p>
                                <p class="mb-0 font-12">End Date: {{ Carbon::parse($project->end_date)->format('M, d Y') }}</p>
                                <p class="mb-0 font-14">Created By : {{ $project->creator->name }} </p>
                                <p class="mb-0 font-14">Last Updated : {{ $project->updated_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Updated By : {{ $project->updater->name }} </p>
                            </div><!--end card-body-->
                        </div>  <!--end card-->
                    </div><!--end col-->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media mb-3">
                                    <div class="media-body align-self-center">
                                        <h4 class="mt-0 mb-0 font-13">Financials</h4>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-12">Total Labor: {{ $totalLabor }}</p>
                                <p class="mb-0 font-12">Total Labor Cost: {{ $totalLaborCost }}</p>
                                <p class="mb-0 font-12">Administrative Cost: {{ $administrativeCost }}</p>
                                <p class="mb-0 font-12">Total Material: {{ $totalMaterial }}</p>
                                <p class="mb-0 font-12">Total Material Cost: {{  $totalMaterialCost }}</p>
                                <p class="mb-0 font-12">Total Cost Incurred: {{ $totalCostIncurred }}</p>
                                <p class="mb-0 font-12">Result: {{ $project->administrative_cost }}</p>
                                <p class="mb-0 font-12">
                                    @if ($result['profitLossValue'] > 0)
                                        Profit: ${{ $result['profitLossValue'] }}
                                    @elseif ($result['profitLossValue'] < 0)
                                        Loss: ${{ abs($result['profitLossValue']) }}
                                    @else
                                        No Profit, No Loss
                                    @endif    
                                </p>
                                <p class="mb-0 font-12">
                                    @if ($result['profitLossPercentage'] > 0)
                                        Profit Percentage: {{ number_format($result['profitLossPercentage'], 2) }}%
                                    @elseif ($result['profitLossPercentage'] < 0)
                                        Loss Percentage: {{ number_format(abs($result['profitLossPercentage']), 2) }}%
                                    @else
                                        No Profit, No Loss
                                    @endif
                                </p>
                                {{-- <p class="mb-0 font-12">Bill Status: {{ $project->administrative_cost }}</p> --}}
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
        <div class="row justify-content-center">
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Labor</p>
                                <h3 class="my-1 font-20 fw-bold">{{  $totalLabor }}</h3>
                                <p class="mb-0 text-truncate text-muted">Working here</p>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-users font-24 align-self-center text-muted"></i>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Material Cost</p>
                                <h3 class="my-1 font-20 fw-bold">{{ $totalMaterialCost }}</h3>
                                <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>{{ $totalMaterial }}</span> Materials</p>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-layout-list font-24 align-self-center text-muted"></i>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Total Cost</p>
                                <h3 class="my-1 font-20 fw-bold">{{ $totalCostIncurred }}</h3>
                                <p class="mb-0 text-truncate text-muted">Incurred</p>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-currency-rupee font-24 align-self-center text-muted"></i>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col--> 
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                @if ($result['profitLossPercentage'] > 0)
                                    <p class="text-dark mb-0 fw-semibold">Result</p>
                                    <h3 class="my-1 font-20 text-success fw-bold">Profit</h3>
                                    <p class="mb-0 text-truncate text-muted">Good Job</p>
                                @elseif ($result['profitLossPercentage'] < 0)
                                    <p class="text-dark mb-0 fw-semibold">Result</p>
                                    <h3 class="my-1 font-20 text-danger fw-bold">Loss</h3>
                                    <p class="mb-0 text-truncate text-muted">Work Hard</p>
                                @else
                                    <p class="text-dark mb-0 fw-semibold">Result</p>
                                    <h3 class="my-1 font-20 text-dark fw-bold">No Data</h3>
                                    <p class="mb-0 text-truncate text-muted">No Profit/Loss</p>
                                @endif
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    @if ($result['profitLossPercentage'] > 0)
                                        <i class="ti ti-thumb-up font-24 align-self-center text-success"></i>
                                    @elseif ($result['profitLossPercentage'] < 0)
                                        <i class="ti ti-thumb-down font-24 align-self-center text-danger"></i>
                                    @else
                                        <i class="ti ti-clock font-24 align-self-center text-warning"></i>
                                    @endif
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col--> 
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                @if ($result['profitLossPercentage'] > 0)
                                    <p class="text-dark mb-0 fw-semibold">Total Revenue</p>
                                    <h3 class="my-1 font-20 text-success fw-bold">{{ $result['profitLossValue'] }}</h3>
                                    <p class="mb-0 text-truncate text-muted">In Ptofit</p>
                                @elseif ($result['profitLossPercentage'] < 0)
                                    <p class="text-dark mb-0 fw-semibold">Total Revenue</p>
                                    <h3 class="my-1 font-20 text-danger fw-bold">{{ abs($result['profitLossValue']) }}</h3>
                                    <p class="mb-0 text-truncate text-muted">In Loss</p>
                                @else
                                    <p class="text-dark mb-0 fw-semibold">Result</p>
                                    <h3 class="my-1 font-20 text-dark fw-bold">No Data</h3>
                                    <p class="mb-0 text-truncate text-muted">No Profit/Loss</p>
                                @endif
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    @if ($result['profitLossPercentage'] > 0)
                                        <i class="ti ti-currency-rupee font-24 align-self-center text-success"></i>
                                    @elseif ($result['profitLossPercentage'] < 0)
                                        <i class="ti ti-currency-rupee font-24 align-self-center text-danger"></i>
                                    @else
                                        <i class="ti ti-currency-rupee font-24 align-self-center text-warning"></i>
                                    @endif
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->
            <div class="col-2">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                @if ($result['profitLossPercentage'] > 0)
                                    <p class="text-dark mb-0 fw-semibold">Profit %</p>
                                    <h3 class="my-1 font-20 text-success fw-bold">{{ number_format($result['profitLossPercentage'], 2) }}</h3>
                                    <p class="mb-0 text-truncate text-muted">Percentage</p>
                                @elseif ($result['profitLossPercentage'] < 0)
                                    <p class="text-dark mb-0 fw-semibold">Loss %</p>
                                    <h3 class="my-1 text-danger font-20 fw-bold">{{ number_format(abs($result['profitLossPercentage']), 2) }}</h3>
                                    <p class="mb-0 text-truncate text-muted">Percentage</p>
                                @else
                                    <p class="text-dark mb-0 fw-semibold">Result</p>
                                    <h3 class="my-1 font-20 text-dark fw-bold">No Data</h3>
                                    <p class="mb-0 text-truncate text-muted">No Profit/Loss</p>
                                @endif
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    @if ($result['profitLossPercentage'] > 0)
                                        <i class="ti ti-percentage font-24 align-self-center text-success"></i>
                                    @elseif ($result['profitLossPercentage'] < 0)
                                        <i class="ti ti-percentage font-24 align-self-center text-danger"></i>
                                    @else
                                        <i class="ti ti-percentage font-24 align-self-center text-warning"></i>
                                    @endif
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->                               
        </div>
    </div>
</div>

<!-- Include the Kanban Board for Tasks -->
@include('crm.crud.projects.kanban')

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Payments</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#paymentModal">Add Payment</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Reference</th>
                                    <th>Status</th>
                                    <th>Method</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                                @forelse ($payments as $payment)
                                <tr>
                                    <td>{{ $payment->reference }}</td>
                                    <td>{{ $payment->paymentStatus ? $payment->paymentStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $payment->paymentMethod ? $payment->paymentMethod->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $payment->customer ? $payment->customer->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $payment->id }}">Delete</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">No Payments added for this project</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        </div> <!--end col-->
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Bills</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#billModal">Add Bill</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
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
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                                @forelse ($bills as $bill)
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
                                @empty
                                    <tr>
                                        <td colspan="3">No Bills added for this project</td>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
            <!-- Pagination links -->
            <div class="pt-3">
                {{ $bills->links('pagination::bootstrap-5') }}
            </div>
        </div> <!--end col-->
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Activities</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#activityModal">Add Activity</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Contact Method</th>
                                    <th>Action</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                                @forelse ($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->activityType ? $activity->activityType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $activity->title }}</td>
                                    {{-- <td>{{ $activity->description }}</td> --}}
                                    <td>{{ $activity->contactMethod ? $activity->contactMethod->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-sm btn-success">View</a>
                                        <a href="{{ route('activities.edit', $activity->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $activity->id }}">Delete</button>
                                    </td>
                                </tr><!--end tr-->
                                @empty
                                    <tr>
                                        <td colspan="3">No Activities found for this project.</td>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination links -->
                    <div class="">
                        {{ $activities->links('pagination::bootstrap-5') }}
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div>
</div>

<div class="container-fluid border border-bottom border-5 mb-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Attachments</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#attachmentModal">Add Images</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Project</th>
                                    <th>Images</th>
                                    <th>Actions</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                                @forelse($attachments as $attachment)
                                    <tr>
                                        <td>{{ $attachment->id }}</td>
                                        <td>{{ $attachment->attachmentType->name }}</td>
                                        <td>{{ $attachment->project->id }} - {{ $attachment->project->customer->lead->name }}</td>
                                        <td>
                                            @foreach ($attachment->images as $image)
                                                <a href="{{ (\Illuminate\Support\Str::startsWith($image, 'http') ? $image : asset('storage/' . $image)) }}" target="_blank"><span class="badge bg-secondary">{{ basename($image) }}</span></a><br>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('attachments.edit', $attachment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $attachment->id }}">Delete</button>
                                        </td>
                                    </tr><!--end tr-->
                                    @empty
                                        <tr>
                                            <td colspan="3">No Work Reports found for this Project.</td>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                    @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        {{ $attachments->links('pagination::bootstrap-5') }}
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
            <!-- Pagination links -->

        </div> <!--end col-->
    </div>
</div>

<!-- Add the Bill  Modal Markup -->
<div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="billModalLabel">Add Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'Projects.show_bill_form' content here -->
                @include('crm.crud.projects.show_bill_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Bill popup -->
<script>
    function openBillPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('billpopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Activity  Modal Markup -->
<div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="activityModalLabel">Add Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'Projects.show_activity_form' content here -->
                @include('crm.crud.projects.show_activity_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Activity popup -->
<script>
    function openActivityPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('activitypopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Attachment  Modal Markup -->
<div class="modal fade" id="attachmentModal" tabindex="-1" aria-labelledby="attachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="attachmentModalLabel">Add Attachment </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'Projects.show_attachment_form' content here -->
                @include('crm.crud.projects.show_attachment_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the attachment popup -->
<script>
    function openAttachmentPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('Attachmentpopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Payment  Modal Markup -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="paymentModalLabel">Add Payment </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'Projects.show_payment_form' content here -->
                @include('crm.crud.projects.show_payment_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Payment popup -->
<script>
    function openPaymentPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('Paymentpopup');
        popup.style.display = 'block';
    }
</script>


@foreach($payments as $payment)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmPaymentDeleteModal{{ $payment->id }}" tabindex="-1" aria-labelledby="confirmPaymentDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPaymentDeleteModal">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Payment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($activities as $activity)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmActivityDeleteModal{{ $activity->id }}" tabindex="-1" aria-labelledby="confirmActivityDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmActivityDeleteModal">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Activity?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($bills as $bill)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmBillDeleteModal{{ $bill->id }}" tabindex="-1" aria-labelledby="confirmBillDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmBillDeleteModal">Confirm Deletion</h5>
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

@foreach($attachments as $attachment)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmAttachmentDeleteModal{{ $attachment->id }}" tabindex="-1" aria-labelledby="confirmAttachmentDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmAttachmentDeleteModal">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this Work Attachment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('attachments.destroy', $attachment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
