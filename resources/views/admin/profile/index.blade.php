@extends('admin.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card dark-card mb-4 shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="avatar-placeholder me-4 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold shadow"
                        style="width: 100px; height: 100px; font-size: 2.5rem; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="mb-1 text-white fw-bold">{{ $user->name ?? 'Admin User' }}</h3>
                        <p class="text-muted mb-0">Role: {{ $user->role->name ?? 'Administrator' }}</p>
                        <p class="text-muted mb-0">Email: {{ $user->email ?? 'N/A' }}</p>
                    </div>
                </div>

                <hr class="border-secondary opacity-25 mb-4">

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control dark-input py-2" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50 small fw-bold text-uppercase">Email Address</label>
                            <input type="email" name="email" class="form-control dark-input py-2" value="{{ old('email', $user->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4 mb-2 text-white-50 small fw-bold text-uppercase">Change Password (optional)</div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-white-50 small">Current Password</label>
                            <input type="password" name="current_password" class="form-control dark-input py-2" placeholder="Enter current password">
                            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50 small">New Password</label>
                            <input type="password" name="new_password" class="form-control dark-input py-2" placeholder="Enter new password">
                            @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-white-50 small">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control dark-input py-2" placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); border: none; border-radius: 10px;">
                            <i class="fa fa-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
