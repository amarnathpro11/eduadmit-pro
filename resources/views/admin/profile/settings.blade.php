@extends('admin.layout.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card dark-card mb-4 shadow-sm border-0">
            <div class="card-body p-4">
                <h3 class="mb-4 text-white fw-bold"><i class="fa fa-cog me-2 text-primary"></i> System Settings</h3>
                
                <hr class="border-secondary opacity-25 mb-4">

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label text-white-50 small fw-bold text-uppercase d-block mb-3">Notification Preferences</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="emailNotif" checked>
                            <label class="form-check-label text-white" for="emailNotif">Email notifications on new applications</label>
                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="systemNotif" checked>
                            <label class="form-check-label text-white" for="systemNotif">System alerts for high-priority leads</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-white-50 small fw-bold text-uppercase d-block mb-3">Display Mode</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="theme" id="darkTheme" checked>
                            <label class="form-check-label text-white" for="darkTheme">
                                Always Dark (Recommended)
                                <div class="small text-muted">Optimized for low-light management.</div>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4 py-2" style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); border: none; border-radius: 10px;">
                            <i class="fa fa-save me-2"></i> Update Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card dark-card mb-4 shadow-sm border-0 border-start border-4 border-danger">
            <div class="card-body p-4">
                <h5 class="text-danger fw-bold mb-3">Danger Zone</h5>
                <p class="text-white-50 small mb-4">Once you delete your account, there is no going back. Please be certain.</p>
                <button class="btn btn-outline-danger btn-sm rounded-pill px-4">Delete My Account</button>
            </div>
        </div>
    </div>
</div>
@endsection
