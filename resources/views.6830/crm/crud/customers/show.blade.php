@extends('layouts.app')
@section('title', $customer->lead->name)
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
                                        <h4 class="text-primary mt-0 font-24">{{ $customer->lead->name }} </h4>
                                        <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $customer->lead->phone }} </p>
                                        <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $customer->lead->email }} </p>
                                        <p class="mb-0 font-14"><i class="fas fa-home"></i> : {{ $customer->lead->address }}, {{ $customer->city }}, {{ $customer->state }} - {{ $customer->zip_code }} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                {{-- <p class="mb-0 font-12">Type : {{ $customer->customerType->name }} </p> --}}
                                {{-- <p class="mb-0 font-12">Company : {{ $customer->company_name ?? '-' }} </p> --}}
                                <p class="mb-0 font-14">Source : {{ $customer->lead->leadSource->name }} </p>
                                <hr class="hr-dashed">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary btn-square">Update</a>
                                        <a href="{{ route('leads.show', $customer->lead_id) }}" class="btn btn-success btn-square">View Lead</a>
                                        <a href="{{ route('customers.index') }}" class="btn btn-primary btn-square">Back</a>
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
                                        <p class="mb-0 font-14">Contact Method : {{ $customer->lead->contactMethod->name ?? ($customer->lead->contactMethod->name ?? 'Not Assigned') }}</p>
                                        <p class="mb-0 font-14">Contact Language : {{ $customer->lead->contactLanguage->name ?? ($customer->lead->contactLanguage>name ?? 'Not Assigned') }}</p>
                                        <p class="mb-0 font-14">Lead Notes : {{ $customer->lead->notes ?? '-' }} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-14">Lead Since : {{ $customer->lead->created_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Customer Since : {{ $customer->created_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Created By : {{ $customer->creator->name }} </p>
                                <p class="mb-0 font-14">Last Updated : {{ $customer->updated_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Updated By : {{ $customer->updater->name }} </p>
                            </div><!--end card-body-->
                        </div>  <!--end card-->
                    </div><!--end col-->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="media mb-3">
                                    <div class="media-body align-self-center">
                                        <h4 class="mt-0 mb-0 font-13">Statistics </h4>
                                        <p class="mb-0 font-14">Contacted 13 times </p>
                                        <p class="mb-0 font-14">Lead Age : {{ $customer->lead->created_at->diffInDays(now()) }}  days</p>
                                        <p class="mb-0 font-14">Conversion Age : {{ $customer->created_at->diffInDays(now()) }}  days</p>
                                        <p class="mb-0 font-14">Lead Status : {{ $customer->lead->leadStatus->name }}  since {{ $customer->lead->leadStatus->updated_at->diffInDays(now()) }}  days</p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-14">Assigned To : {{ $customer->lead->assignedTo->name ?? ($customer->lead->assignedTo->name ?? 'Not Assigned') }}</p>
                                <p class="mb-0 font-14">Since : {{ $customer->lead->assignedTo ? $customer->lead->assignedTo->created_at->diffInDays(now()) ?? 'Not Assigned' : 'Not Assigned' }} days </p>
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
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body">
                    <h5>Customer Invoices</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Invoice Type</th>
                                    <th>Value</th>
                                    <th>Attachments</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Updated At</th>
                                    <th>Updated by</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ $invoice->invoiceType->name ?? 'N/A' }}</td>
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
                                    <td>{{ $invoice->invoiceStatus->name ?? 'N/A' }}</td>
                                    <td>{{ $invoice->created_at->format('D, d M Y') }}</td>
                                    <td>{{ $invoice->creator->name }}</td>
                                    <td>{{ $invoice->updated_at->format('D, d M Y') }}</td>
                                    <td>{{ $invoice->updater->name }}</td>
                                </tr><!--end tr-->
                            @empty
                                <tr>
                                    <td colspan="3">No Invoices found for this Customer.</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        {{ $invoices->links('pagination::bootstrap-5') }}
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
                            <h5>Customer Projects</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#projectModal">Create Project</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Customer</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $project->id }}</td>
                                    <td>{{ $project->projectType ? $project->projectType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->projectStatys ? $project->projectStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->customer ? $project->customer->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('D d, M Y') ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $project->start_date ? \Carbon\Carbon::parse($project->end_date)->format('D d, M Y') ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>
                                        <a href="{{ route('projects.show', $project->id) }}"><i class="las la-eye text-secondary font-16"></i></a>
                                        <a href="{{ route('projects.edit', $project->id) }}"><i class="las la-pen text-secondary font-16"></i></a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#confirmProjectDeleteModal{{ $project->id }}"><i class="las la-trash-alt text-secondary font-16"></i></a>
                                    </td>
                                </tr><!--end tr-->
                            @empty
                                <tr>
                                    <td colspan="3">No Projects found for this Customer. Create a Project</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        {{ $projects->links('pagination::bootstrap-5') }}
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
                            <h5>Customer Payments</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#paymentModal">Create Payment</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ref #</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>amount</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Updated At</th>
                                    <th>Updated by</th>
                                    <th>Actions</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->reference }}</td>
                                    <td>{{ $payment->paymentMethod->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->paymentStatus->name ?? 'N/A' }}</td>
                                    <td>{{ $payment->amount }}</td>
                                    <td>{{ $payment->created_at->format('D, d M Y') }}</td>
                                    <td>{{ $payment->creator->name }}</td>
                                    <td>{{ $payment->updated_at->format('D, d M Y') }}</td>
                                    <td>{{ $payment->updater->name }}</td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment->id) }}"><i class="las la-eye text-secondary font-16"></i></a>
                                        <a href="{{ route('payments.edit', $payment->id) }}"><i class="las la-pen text-secondary font-16"></i></a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#confirmPaymentDeleteModal{{ $payment->id }}"><i class="las la-trash-alt text-secondary font-16"></i></a>
                                    </td>
                                </tr><!--end tr-->
                            @empty
                                <tr>
                                    <td colspan="3">No Payments found for this Customer. Create a Project</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        {{ $payments->links('pagination::bootstrap-5') }}
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
                            <h5>Customer Activities</h5>
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
                                    <th>Method</th>
                                    <th>title</th>
                                    <th>Description</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Updated At</th>
                                    <th>Updated by</th>
                                    <th>Actions</th>
                                </tr><!--end tr-->
                            </thead>

                            <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->contactMethod->name }}</td>
                                    <td>{{ $activity->title }}</td>
                                    <td>{{ $activity->description }}</td>
                                    <td>{{ $activity->created_at->format('D, d M Y h:i A') }}</td>
                                    <td>{{ $activity->creator->name }}</td>
                                    <td>{{ $activity->updated_at->format('D, d M Y h:i A') }}</td>
                                    <td>{{ $activity->updater->name }}</td>
                                    <td>
                                        <a href="{{ route('activities.show', $activity->id) }}"><i class="las la-eye text-secondary font-16"></i></a>
                                        <a href="{{ route('activities.edit', $activity->id) }}"><i class="las la-pen text-secondary font-16"></i></a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#confirmActivityDeleteModal{{ $activity->id }}"><i class="las la-trash-alt text-secondary font-16"></i></a>
                                    </td>
                                </tr><!--end tr-->
                            @empty
                                <tr>
                                    <td colspan="3">No Activities found for this lead.</td>
                                    <!-- Add more columns as needed -->
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="">
                        {{ $activities->links('pagination::bootstrap-5') }}
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div>
</div>

<!-- Add the CreateActivity  Modal Markup -->
<div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="activityModalLabel">Create Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'leads.show_activity_form' content here -->
                @include('crm.crud.customers.show_activity_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Activity popup -->
<script>
    function openActivityPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('ActivityPopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Create Project  Modal Markup -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="projectModalLabel">Create Project for this {{ $customer->lead->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'customers.show_project_form' content here -->
                @include('crm.crud.customers.show_project_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Project popup -->
<script>
    function openProjectPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('ProjectPopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Create Payment  Modal Markup -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="paymentModalLabel">Create Payment for this {{ $customer->lead->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'customers.show_payment_form' content here -->
                @include('crm.crud.customers.show_payment_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Payment popup -->
<script>
    function openPaymentPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('PaymentPopup');
        popup.style.display = 'block';
    }
</script>

@foreach ($activities as $activity)
<div class="modal fade" id="confirmActivityDeleteModal{{ $activity->id }}" tabindex="-1" aria-labelledby="confirmActivityDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmActivityDeleteModal">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this activity?
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

@foreach($projects as $project)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmProjectDeleteModal{{ $project->id }}" tabindex="-1" aria-labelledby="confirmProjectDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmProjectDeleteModal">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this project?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@foreach($payments as $payment)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmPaymentDeleteModal{{ $payment->id }}" tabindex="-1" aria-labelledby="confirmPaymentDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmPOaymentDeleteModal">Confirm Deletion</h5>
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
@endsection
