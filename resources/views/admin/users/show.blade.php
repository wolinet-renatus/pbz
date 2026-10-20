@extends('layouts.admin')

@section('title', 'User Details - ' . $user->name)
@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></div>
        <div class="breadcrumb-item">{{ $user->name }}</div>
    </div>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-hero">
                <div class="card-header bg-primary text-white text-center py-4">
                    <div class="mb-3">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                alt="{{ $user->name }}" class="rounded-circle shadow"
                                style="width: 90px; height: 90px; object-fit: cover; border: 3px solid white;">
                        @else
                            <div class="avatar bg-white text-primary rounded-circle mx-auto d-flex align-items-center justify-content-center font-weight-bold shadow"
                                style="width: 90px; height: 90px; font-size: 32px; border: 3px solid white;">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <h4>{{ $user->name }}</h4>
                    <p class="mb-0 text-white-50">{{ $user->email }}</p>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Account ID</span>
                            <span class="font-weight-bold">#{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Role(s)</span>
                            <span>
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($user->role ?? 'User') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Status</span>
                            <span>
                                @if($user->is_approved)
                                    <span class="badge badge-success">Approved / Active</span>
                                @else
                                    <span class="badge badge-warning">Pending Approval</span>
                                @endif
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Branch / Dept</span>
                            <span class="font-weight-bold">{{ $user->department ?? $user->branch ?? 'Headquarters' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">Joined Date</span>
                            <span class="font-weight-bold">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
                        </li>
                    </ul>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">
                            <i class="fas fa-arrow-left mr-1"></i> Back
                        </a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash mr-1"></i> Delete Account
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Account Details &amp; Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Full Name</label>
                            <p class="font-weight-bold">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email Address</label>
                            <p class="font-weight-bold">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Phone Number</label>
                            <p class="font-weight-bold">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Designation / Title</label>
                            <p class="font-weight-bold">{{ $user->job_title ?? $user->designation ?? 'N/A' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Bio / Notes</label>
                            <p class="text-muted">{{ $user->bio ?? 'No bio or notes provided for this user.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
