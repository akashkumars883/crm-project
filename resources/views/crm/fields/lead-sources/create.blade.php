@extends('layouts.app')
@section('title', 'Add Lead Source')
@section('content')
<div class="p-3 bg-light">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="page-title-box">
                <h4 class="page-title">Add Lead Source</h4>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('lead-sources.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Lead Source Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary">Save Lead Source</button>
                            <a href="{{ route('lead-sources.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
