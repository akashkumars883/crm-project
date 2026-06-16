@extends('layouts.app')
@section('title', 'Create Role')
@section('content')
<!-- Page-Title -->
<div class="row px-4">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">User Details</h4>
        </div><!--end page-title-box-->
    </div><!--end col-->
</div>
<!-- end page title end breadcrumb -->
<!-- end page title end breadcrumb -->

<div class="card">
    <div class="card-body">
        <div class="media mb-3">
            <img src="{{ Avatar::create($user->name)->toBase64() }}" alt="{{ $user->name }}"  class="me-3 thumb-lg align-self-center"/>
            <div class="media-body align-self-center">
                <h4 class="mt-0 mb-0 font-24"> {{ $user->name }}
                </h4>
                <p class="mb-0 font-16">{{ $user->email }}</p>
            </div><!--end media body-->
        </div> <!--end media-->
        <hr>
        <div>
            <p class="font-18"><strong>Roles Assigned :</strong><br>
                @foreach ($userRoles as $role)
                    {{ $role->name }}
                    @if (!$loop->last), @endif <!-- Add a comma between roles -->
                @endforeach
            </p>
            <p class="font-18"><strong>Permissions Assigned:</strong> <span class="font-12">(please note these are different from role permissions)</span><br>
                @foreach ($userPermissions as $permission)
                    {{ $permission->name }}
                    @if (!$loop->last), @endif <!-- Add a comma between permissions -->
                @endforeach
            </p>
        </div>
        <div>
            <a href="{{ route('users.edit', $user->id) }}" class="btn  btn-primary">Update</a>
            <a href="{{ route('users.index') }}" class="btn btn-dark">Back to Users</a>
        </div>
    </div><!--end card-body-->
</div>
@endsection
