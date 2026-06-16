@extends('layouts.app')
@section('title', 'Edit Designation')
@section('content')
<div class="p-3 bg-light">
    <div class="p-3 bg-light">
        <div class="row justify-content-center">
            <div class="col-6">
                <div class="page-title-box">
                    <h4 class="page-title">Edit Designation</h4>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('designations.update', $designation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Designation Name</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $designation->name) }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary">Update Designation</button>
                                <a href="{{ route('designations.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
