@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-white">Add New User</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">Back to Users</a>
    </div>

    <div class="dashboard-card p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-white small opacity-75">Full Name</label>
                    <input type="text" name="name" class="form-control bg-dark text-white border-white border-opacity-10 py-2"
                        placeholder="Enter full name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-white small opacity-75">Email Address</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-white border-opacity-10 py-2"
                        placeholder="user@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-white small opacity-75">Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-white border-white border-opacity-10 py-2"
                        placeholder="Create a strong password" required>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-white small opacity-75">Role</label>
                    <select name="role_id" class="form-select bg-dark text-white border-white border-opacity-10 py-2" required>
                        <option value="">Select a role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }} ({{ ucfirst($role->name) }})
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label text-white small opacity-75">Department (Optional)</label>
                    <select name="department_id" class="form-select bg-dark text-white border-white border-opacity-10 py-2">
                        <option value="">All Departments</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted mt-1 d-block">Select "All" for Administrators</small>
                    @error('department_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="text-end pt-3 border-top border-white border-opacity-10">
                <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold">
                    <i class="bi bi-person-plus me-2"></i> Create User
                </button>
            </div>
        </form>
    </div>
@endsection
