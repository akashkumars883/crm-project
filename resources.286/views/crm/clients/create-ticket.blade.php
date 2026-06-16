<div class="bg-light">
    <div class="row justify-content-center">
        <div class="col-12 border">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('tickets.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ticket_category_id" class="form-label">Ticket Category</label>
                            <select class="form-control" id="ticket_category_id" name="ticket_category_id" required>
                                <option value="">Select Ticket Category</option>
                                @foreach ($ticketCategories as $ticketCategory)
                                    <option value="{{ $ticketCategory->id }}"{{ old('ticket_category_id') == $ticketCategory->id ? ' selected' : '' }}>{{ $ticketCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select class="form-control" id="priority" name="priority" required>
                                <option value="">Select Priority</option>
                                <option value="low"{{ old('priority') == 'low' ? ' selected' : '' }}>Low</option>
                                <option value="medium"{{ old('priority') == 'medium' ? ' selected' : '' }}>Medium</option>
                                <option value="high"{{ old('priority') == 'high' ? ' selected' : '' }}>High</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4">{{ old('message') }}</textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="Answered"{{ old('status') == 'Answered' ? ' selected' : '' }}>Answered</option>
                                <option value="Pending"{{ old('priority') == 'Pending' ? ' selected' : '' }}>Pending</option>
                            </select>
                        </div> --}}
                        <input type="hidden" name="status" value="Pending">
                        <!-- The customer_id field will be automatically selected since we are on the lead show page -->
                        <input type="hidden" name="client_id" value="{{ Auth::user()->id }}">
                        
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                        {{-- <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancel</a> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
