@extends('layouts.admin')

@section('title', 'All Users')
@section('breadcrumb')
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
        <div class="breadcrumb-item">Users</div>
    </div>
@endsection

@section('main-content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <h4 class="text-dark mb-0 font-weight-bold">System Users</h4>
                            <p class="text-muted small mb-0">Unified directory of all registered system accounts and access tiers</p>
                        </div>
                        <div class="col-md-6 text-right">
                            <span class="badge badge-info p-2 font-weight-bold">Total Accounts: {{ $users->total() }}</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="users-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role(s)</th>
                                    <th>Status</th>
                                    <th>Joined Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($user->profile_photo)
                                                    <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                                        alt="{{ $user->name }}" class="mr-3 rounded-circle"
                                                        style="width: 44px; height: 44px; object-fit: cover;">
                                                @else
                                                    <div class="avatar bg-primary text-white mr-3 rounded-circle d-flex align-items-center justify-content-center font-weight-bold"
                                                        style="width: 44px; height: 44px; font-size: 15px;">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                                    <small class="text-muted">ID: #{{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->roles->count() > 0)
                                                @foreach($user->roles as $role)
                                                    <span class="badge badge-primary mr-1">{{ ucfirst($role->name) }}</span>
                                                @endforeach
                                            @else
                                                <span class="badge badge-secondary">{{ ucfirst($user->role ?? 'User') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->is_approved)
                                                <span class="badge badge-success">Approved / Active</span>
                                            @else
                                                <span class="badge badge-warning">Pending Approval</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info mr-1" title="View Profile">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete User">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
