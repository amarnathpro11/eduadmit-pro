@extends('student.layout')

@section('page_title', 'Registration')

@section('content')
    <style>
        /* Direct override for the registration page */
        body,
        .main-content,
        .content-area {
            background-color: #020617 !important;
            background-image: radial-gradient(circle at top, #0f172a 0%, #020617 100%) !important;
            background-attachment: fixed !important;
            color: #ffffff !important;
        }

        .premium-card {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .form-control-premium {
            background: rgba(255, 255, 255, 0.02) !important;
            color: #ffffff !important;
        }

        .form-label-custom {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        h2,
        h4,
        h5,
        h6 {
            color: #ffffff !important;
        }
    </style>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            {{-- Section header removed as it's redundant with the top nav title --}}

            @if (session('success'))
                <div class="alert alert-success bg-success bg-opacity-10 border-success border-opacity-20 text-success mb-4"
                    style="border-radius: 12px;">
                    <i data-lucide="check-circle" class="me-2" style="width: 18px;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($counselor)
                <div class="premium-card mb-4"
                    style="background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-auto mb-3 mb-md-0">
                            <div class="user-avatar" style="width: 56px; height: 56px; font-size: 1.25rem;">
                                {{ strtoupper(substr($counselor->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="col">
                            <h6 class="text-indigo mb-1" style="color: #6366f1; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px;">Your Admission Mentor</h6>
                            <h5 class="fw-bold text-white mb-0" style="font-family: 'Outfit';">{{ $counselor->name }}</h5>
                            <p class="mb-0 text-white-50" style="font-size: 0.85rem;">For any queries: <span class="text-white fw-medium">{{ $counselor->email }}</span></p>
                        </div>
                        <div class="col-md-auto mt-3 mt-md-0">
                            <a href="mailto:{{ $counselor->email }}" class="btn-premium-outline py-2 px-3" style="font-size: 0.85rem;">
                                <i data-lucide="mail" class="me-2" style="width: 16px;"></i> Send Mail
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if (!$application || $application->status == 'draft')
                <div class="premium-card">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div
                            style="width: 42px; height: 42px; background: rgba(99, 102, 241, 0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                            <i data-lucide="edit-3" style="width: 20px;"></i>
                        </div>
                        <h4 class="mb-0 fw-bold" style="font-family: 'Outfit'; color: #ffffff;">Academic & Personal Details
                        </h4>
                    </div>

                    <form action="{{ route('student.register.details') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label-custom">First Name</label>
                                <input type="text" name="first_name"
                                    class="form-control-premium @error('first_name') is-invalid @enderror"
                                    placeholder="First name"
                                    value="{{ old('first_name', $lead ? explode(' ', $lead->name)[0] : (explode(' ', auth('student')->user()->name)[0] ?? '')) }}"
                                    required>
                                @error('first_name')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Last Name</label>
                                <input type="text" name="last_name"
                                    class="form-control-premium @error('last_name') is-invalid @enderror"
                                    placeholder="Last name"
                                    value="{{ old('last_name', $lead ? (explode(' ', $lead->name)[1] ?? '') : (explode(' ', auth('student')->user()->name)[1] ?? '')) }}"
                                    required>
                                @error('last_name')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Date of Birth</label>
                                <input type="date" name="dob"
                                    class="form-control-premium @error('dob') is-invalid @enderror"
                                    value="{{ old('dob') }}" required>
                                @error('dob')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Mobile</label>
                                <input type="text" name="mobile"
                                    class="form-control-premium @error('mobile') is-invalid @enderror"
                                    placeholder="+91 XXXXX XXXXX" value="{{ old('mobile', $lead->phone ?? '') }}" required>
                                @error('mobile')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Course You Are Applying For</label>
                                <select name="course_id"
                                    class="form-control-premium w-100 @error('course_id') is-invalid @enderror" required>
                                    <option value="">Select a course from the list...</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}"
                                            {{ old('course_id', $lead->course_interested ?? '') == $course->id ? 'selected' : '' }}>{{ $course->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Admission Category (Quota)</label>
                                <select name="quota_category_id"
                                    class="form-control-premium w-100 @error('quota_category_id') is-invalid @enderror" required>
                                    <option value="">Select Category...</option>
                                    @foreach ($quotaCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('quota_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('quota_category_id')
                                    <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-custom">Secondary (10th) Percentage</label>
                                <div class="input-group has-validation">
                                    <input type="number" step="0.1" name="tenth_percentage"
                                        class="form-control-premium @error('tenth_percentage') is-invalid @enderror"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                                        placeholder="e.g. 85.4" value="{{ old('tenth_percentage') }}" required>
                                    <span class="input-group-text bg-dark border-0 text-muted"
                                        style="border-radius: 0 12px 12px 0; border: 1px solid rgba(255,255,255,0.1) !important;">%</span>
                                    @error('tenth_percentage')
                                        <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom">Higher Secondary (12th) Percentage</label>
                                <div class="input-group has-validation">
                                    <input type="number" step="0.1" name="twelfth_percentage"
                                        class="form-control-premium @error('twelfth_percentage') is-invalid @enderror"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;"
                                        placeholder="e.g. 78.2" value="{{ old('twelfth_percentage') }}" required>
                                    <span class="input-group-text bg-dark border-0 text-muted"
                                        style="border-radius: 0 12px 12px 0; border: 1px solid rgba(255,255,255,0.1) !important;">%</span>
                                    @error('twelfth_percentage')
                                        <div class="invalid-feedback text-danger" style="font-size: 0.75rem;">
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn-premium-primary w-100 py-3">
                                    Save Application & Continue <i data-lucide="arrow-right" class="ms-2"
                                        style="width: 20px;"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="premium-card">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5 gap-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                class="flex-shrink-0"
                                style="width: 48px; height: 48px; background: rgba(99, 102, 241, 0.1); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #6366f1;">
                                <i data-lucide="clipboard-check" style="width: 24px;"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold text-white" style="font-family: 'Outfit';">Application Submitted
                                </h4>
                                <p class="text-muted mb-0" style="font-size: 0.85rem; font-weight: 500;">Review your
                                    submitted details below</p>
                            </div>
                        </div>
                        <div class="badge bg-success bg-opacity-10 text-success p-2 px-4"
                            style="border-radius: 12px; font-weight: 700; font-size: 0.8rem; letter-spacing: 0.5px;">
                            <i data-lucide="check-circle" class="me-2"
                                style="width: 14px; vertical-align: middle;"></i>{{ strtoupper(str_replace('_', ' ', $application->status)) }}
                        </div>
                    </div>

                    <div class="row g-5">
                        <div class="col-md-4">
                            <p class="form-label-custom mb-2">APPLICATION NUMBER</p>
                            <h5 class="fw-bold text-white">{{ $application->application_no ?? 'N/A' }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="form-label-custom mb-2">COURSE PREFERENCE</p>
                            <h5 class="fw-bold text-white">{{ $application->course->name ?? 'N/A' }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="form-label-custom mb-2">ACADEMIC SCORE (12th)</p>
                            <h5 class="fw-bold text-white">{{ $application->twelfth_percentage }}%</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="form-label-custom mb-2">CATEGORY / QUOTA</p>
                            <h5 class="fw-bold text-white">{{ $application->quotaCategory->name ?? 'GENERAL' }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="form-label-custom mb-2">APPLIED DATE</p>
                            <h5 class="fw-bold text-white">{{ $application->created_at->format('M d, Y') }}</h5>
                        </div>
                    </div>

                    <div
                        class="mt-5 p-4 bg-dark bg-opacity-25 border border-white border-opacity-10 rounded-4 d-flex align-items-center gap-3">
                        <div
                            style="width: 40px; height: 40px; background: rgba(255,255,255,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #6366f1; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <i data-lucide="info" style="width: 20px;"></i>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold text-white" style="font-size: 0.95rem;">What's next?</p>
                            <p class="mb-0"
                                style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.7); font-weight: 500;">Head over to
                                the <a href="{{ route('student.status') }}"
                                    class="fw-bold text-indigo text-decoration-none" style="color: #6366f1;">Application
                                    Status</a> page to upload your documents and track verification.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
