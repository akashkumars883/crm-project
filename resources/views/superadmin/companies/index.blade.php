@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Registered Companies (SaaS Tenants)</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Plan</th>
                                <th>Users Count</th>
                                <th>Status</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr>
                                <td>{{ $company->id }}</td>
                                <td><strong>{{ $company->name }}</strong></td>
                                <td>{{ $company->email }}</td>
                                <td>{{ $company->phone ?? 'N/A' }}</td>
                                <td><span class="badge bg-primary text-uppercase">{{ $company->plan }}</span></td>
                                <td>{{ $company->users_count }}</td>
                                <td>
                                    @if($company->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Blocked</span>
                                    @endif
                                </td>
                                <td>{{ $company->created_at->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('superadmin.companies.toggle', $company->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($company->status === 'active')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Block this company? They will not be able to log in.')">Block</button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Activate this company?')">Activate</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No companies registered yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
