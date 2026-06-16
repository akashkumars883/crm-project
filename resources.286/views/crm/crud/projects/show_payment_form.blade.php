<div class="bg-light">
    <div class="row justify-content-center">
        <div class="col-md-12 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference #</label>
                            <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}">
                        </div>
                        <div class="mb-3">
                            <label for="payment_method_id" class="form-label">Payment Method</label>
                            <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                                <option value="">Select Payment Method</option>
                                @foreach ($paymentMethods as $paymentMethod)
                                    <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status_id" class="form-label">Payment Status</label>
                            <select class="form-control" id="payment_status_id" name="payment_status_id" required>
                                <option value="">Select Payment Status</option>
                                @foreach ($paymentStatuses as $paymentStatus)
                                    <option value="{{ $paymentStatus->id }}">{{ $paymentStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- The customer_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="customer_id" value="{{ $project->customer->id }}">
                        
                        <!-- The project_id field will be automatically selected since we are on the Project show page -->
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Payment</button>
                        {{-- <a href="{{ route('payments.index') }}" class="btn btn-secondary">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
