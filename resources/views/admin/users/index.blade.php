@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white">User & Role Management</h3>
        <div>
            <a href="{{ route('admin.users.export') }}" class="btn btn-outline-light me-2 text-decoration-none">
                <i class="bi bi-download me-1"></i> Export
            </a>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary text-decoration-none">
                <i class="bi bi-plus-lg me-1"></i> Add User
            </a>
        </div>
    </div>

    {{-- ================= ROLE SUMMARY CARDS ================= --}}
    <div class="row g-4 mb-4">

        @foreach ($roles as $role)
            <div class="col-md-6 col-lg-3">
                <div class="dashboard-card p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white mb-1">{{ $role->display_name }}</h6>
                        <small class="text-muted">
                            {{ $role->description ?? 'Role access' }}
                        </small>
                    </div>
                    <div class="text-end">
                        <h3 class="fw-bold text-info">
                            {{ $role->users_count }}
                        </h3>
                        <small class="text-muted">users</small>
                    </div>
                </div>
            </div>
        @endforeach

    </div> {{-- CLOSE ROW --}}


    {{-- ================= USERS TABLE ================= --}}
    <div class="dashboard-card p-4">

        <h5 class="text-white mb-4">All Users</h5>

        <div class="table-responsive">
            <table class="table table-dark table-borderless align-middle">

                <thead>
                    <tr class="text-muted small">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Last Login</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="fw-semibold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $user->role->display_name ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $user->department->name ?? 'All' }}
                            </td>

                            <td>
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never' }}
                            </td>

                            <td>
                                @if ($user->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="btn btn-sm btn-outline-light">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
@endsection
