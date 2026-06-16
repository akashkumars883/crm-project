<div class="bg-light">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('bills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Bill Type -->
                        <div class="mb-3">
                            <label for="bill_type_id" class="form-label">Bill Type</label>
                            <select class="form-control" id="bill_type_id" name="bill_type_id" required>
                                <option value="">Select Bill Type</option>
                                @foreach ($billTypes as $billType)
                                    <option value="{{ $billType->id }}">{{ $billType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Reference -->
                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference" name="reference" value="{{ old('reference') }}">
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount') }}" required>
                        </div>

                        <!-- Bill Date -->
                        <div class="mb-3">
                            <label for="bill_date" class="form-label">Bill Date</label>
                            <input type="date" class="form-control" id="bill_date" name="bill_date" value="{{ old('bill_date') }}" required>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                        </div>

                        <!-- Bill Status -->
                        <div class="mb-3">
                            <label for="bill_status_id" class="form-label">Bill Status</label>
                            <select class="form-control" id="bill_status_id" name="bill_status_id" required>
                                <option value="">Select Bill Status</option>
                                @foreach ($billStatuses as $billStatus)
                                    <option value="{{ $billStatus->id }}">{{ $billStatus->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="4">{{ old('notes') }}</textarea>
                        </div>

                        <!-- Attachments -->
                        <div class="mb-3">
                            <label for="attachments" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Bill</button>
                        {{-- <a href="{{ route('bills.index') }}" class="btn btn-secondary">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
