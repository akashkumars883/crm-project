@extends('layouts.app')
@section('title', $lead->name)
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
                                        <h4 class="text-primary mt-0  font-24">{{ $lead->name }} </h4>
                                        <p class="mb-0 font-14"><i class="fas fa-phone-square"></i> : {{ $lead->phone }} </p>
                                        <p class="mb-0 font-14"><i class="fas fa-envelope-square"></i> : {{ $lead->email }} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-14">Source : {{ $lead->leadSource->name }} </p>
                                <p class="mb-0 font-14">Status : {{ $lead->leadStatus->name }} </p>
                                <p class="mb-0 font-14">Assigned To : {{ $lead->assignedTo ? $lead->assignedTo->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <hr class="hr-dashed">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <a href="{{ route('leads.edit', $lead->id) }}" class="btn  btn-primary btn-square">Update</a>
                                        @if ($lead->customer)
                                        @if ($lead->customer->lead_id)
                                            <a href="{{ route('customers.show', $lead->customer->id) }}" class="btn btn-square btn-success">Show Customer Record</a>
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">Convert to Customer</button>
                                        @endif
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#customerModal">Convert to Customer</button>
                                        @endif
                                        <a href="{{ route('leads.index') }}" class="btn btn-primary  btn-square">Back</a>
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
                                        <h4 class="mt-0 mb-0 font-13">Lead Notes </h4>
                                        <p class="mb-0 font-14">{{ $lead->notes }} </p>
                                    </div><!--end media body-->
                                </div> <!--end media-->
                                <p class="mb-0 font-14">Contact Method : {{ $lead->contactMethod ? $lead->contactMethod->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <p class="mb-0 font-14">Contact Language : {{ $lead->contactLanguage ? $lead->contactLanguage->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
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
                                        <p class="mb-0 font-14">Lead Age : {{ $lead->created_at->diffInDays(now()) }}  days {{ $lead->created_at->diff()->format('%hh %im') }}</p>
                                    </div><!--end media body-->
                                </div> <!--end media-->

                                <p class="mb-0 font-14">Assigned To : {{ $lead->assignedTo ? $lead->assignedTo->name ?? 'Not Assigned' : 'Not Assigned' }} </p>
                                <p class="mb-0 font-14">Lead Since : {{ $lead->created_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Created By : {{ $lead->creator->name }} </p>
                                <p class="mb-0 font-14">Last Updated : {{ $lead->updated_at->format('D, d M Y h:i A') }} </p>
                                <p class="mb-0 font-14">Updated By : {{ $lead->updater->name }} </p>
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
            <div class="card">
                <div class="card-body">
                    <div class="mb-2 d-flex justify-content-between align-items-center">
                        <div>
                            <h5>Invoices</h5>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary btn-sm mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#invoiceModal">Add Invoice</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>Invoice type</th>
                                    <th>Value</th>
                                    <th>Attachments</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Updated At</th>
                                    <th>Updated by</th>
                                    <th>Actions</th>
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
                                    <td>
                                        <a href="{{ route('invoices.show', $invoice->id) }}"><i class="las la-eye text-secondary font-16"></i></a>
                                        <a href="{{ route('invoices.edit', $invoice->id) }}"><i class="las la-pen text-secondary font-16"></i></a>
                                        <a type="button" data-bs-toggle="modal" data-bs-target="#confirmInvoiceDeleteModal{{ $invoice->id }}"><i class="las la-trash-alt text-secondary font-16"></i></a>
                                    </td>
                                </tr><!--end tr-->
                            @empty
                                <tr>
                                    <td colspan="3">No invoices found for this lead.</td>
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

<!-- Add the Invoice  Modal Markup -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="invoiceModalLabel">Create Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'leads.show_invoice_form' content here -->
                @include('crm.crud.leads.show_invoice_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Invoice popup -->
<script>
    function openInvoicePopup(event) {
        event.preventDefault();
        const popup = document.getElementById('invoicePopup');
        popup.style.display = 'block';
    }
</script>

<!-- Add the Create Customer  Modal Markup -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="customerModalLabel">Convert Lead to Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'leads.create_customer_form' content here -->
                @include('crm.crud.leads.create_customer_form')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Customer popup -->
<script>
    function openCustomerPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('CustomerPopup');
        popup.style.display = 'block';
    }
</script>

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
                @include('crm.crud.leads.show_activity_form')
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


@foreach($invoices as $invoice)
<!-- Modal for delete confirmation -->
<div class="modal fade" id="confirmInvoiceDeleteModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="confirmInvoiceDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmInvoiceDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this invoice?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

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
@endsection
