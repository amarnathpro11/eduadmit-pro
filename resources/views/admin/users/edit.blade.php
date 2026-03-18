@extends('admin.layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-white">Edit User</h3>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">Back to Users</a>
    </div>

    <div class="dashboard-card p-4">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-white">Name</label>
                    <input type="text" name="name" class="form-control bg-dark text-white border-secondary"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-white">Email</label>
                    <input type="email" name="email" class="form-control bg-dark text-white border-secondary"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label text-white">Role</label>
                    <select name="role_id" class="form-select bg-dark text-white border-secondary" required>
                        <option value="">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label text-white">Department (Optional)</label>
                    <select name="department_id" class="form-select bg-dark text-white border-secondary">
                        <option value="">All / None</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch pt-2">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive"
                        {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label text-white" for="isActive">Active Status</label>
                </div>
                @error('is_active')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">Update User</button>
            </div>
        </form>
    </div>
@endsection
