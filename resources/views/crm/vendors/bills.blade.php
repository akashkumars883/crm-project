@extends('layouts.app')
@section('title', 'All Bills')
@section('content')
<div class="p-3 bg-light">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box px-3">
                <h4 class="page-title">Bills</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <!-- end page title end breadcrumb -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn mt-2 mb-2 btn-primary  mt-0 mb-3" data-bs-toggle="modal" data-bs-target="#billModal">Request Bill</button>
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
                                    <th>Inventory</th>
                                    <th>Bill Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Notes</th>
                                    <th>Arrachments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->reference }}</td>
                                    <td>{{ $bill->billType ? $bill->billType->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->amount }}</td>
                                    <td>{{ $bill->inventory ? $bill->inventory->title ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('D d, M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($bill->due_date)->format('D d, M Y') }}</td>
                                    <td>{{ $bill->billStatus ? $bill->billStatus->name ?? 'Not Assigned' : 'Not Assigned' }}</td>
                                    <td>{{ $bill->notes }}</td>
                                    <td>
                                        @if($bill->attachments && count($bill->attachments) > 0)
                                            @foreach($bill->attachments as $attachment)
                                                <a href="{{ (\Illuminate\Support\Str::startsWith($attachment, 'http') ? $attachment : asset('storage/' . $attachment)) }}" target="_blank" class="badge bg-primary text-decoration-none me-1">{{ $attachment }}</a>
                                            @endforeach
                                        @else
                                            No attachments
                                        @endif
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
</div>

<!-- Add the Create Bill  Modal Markup -->
<div class="modal fade" id="billModal" tabindex="-1" aria-labelledby="billModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="billModalLabel">Request Bill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Include the 'form' content here -->
                @include('crm.vendors.request-bill')
            </div>
        </div>
    </div>
</div>

<!-- Add the JavaScript to handle the Create Bill popup -->
<script>
    function openBillPopup(event) {
        event.preventDefault();
        const popup = document.getElementById('BillPopup');
        popup.style.display = 'block';
    }
</script>
@endsection
