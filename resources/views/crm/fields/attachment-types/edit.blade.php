@extends('layouts.app')
@section('title', 'Edit Attachment Type')
@section('content')
<div class="p-3 bg-light">
    <div class="p-3 bg-light">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="page-title-box">
                    <h4 class="page-title">Edit Attachment Type</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('attachment-types.update', $attachmentType->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Attachment Type Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $attachmentType->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Update Attachment Type</button>
                                <a href="{{ route('attachment-types.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
