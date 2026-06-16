@extends('layouts.app')
@section('title', 'Create User')
@section('content')
<div class="p-3 pt-5 bg-light">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create a new user</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="roles" class="form-label">Roles</label>
                            <div class="row mb-3">
                                <div class="col">
                                    @foreach ($roles as $role)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}">
                                            <label class="form-check-label" for="inlineCheckbox{{ $role->id }}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
