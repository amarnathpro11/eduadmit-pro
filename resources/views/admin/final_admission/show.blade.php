@extends('admin.layout.app')

@section('content')
    <style>
        .confirm-title {
            font-size: 1.7rem;
            font-weight: 800;
            color: white;
            margin-bottom: 5px;
        }

        .confirm-subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-bottom: 25px;
        }

        .btn-light-outline {
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-red-outline {
            color: #f87171;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(248, 113, 113, 0.1);
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .profile-card {
            padding: 30px 20px;
            text-align: center;
        }

        .profile-avatar-bg {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #10b981;
            background: rgba(16, 185, 129, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #10b981;
            margin: 0 auto;
            font-weight: 800;
            position: relative;
        }

        .profile-check {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #10b981;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            border: 3px solid #1e293b;
        }

        .profile-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin-top: 15px;
            margin-bottom: 2px;
        }

        .profile-id {
            color: #10b981;
            font-size: 0.8rem;
            font-family: monospace;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
            padding: 12px 0;
            font-size: 0.85rem;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.6);
        }

        .info-value {
            font-weight: 600;
            color: white;
        }

        .info-badge {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }

        .contact-card {
            padding: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
            font-size: 0.85rem;
            color: white;
            font-weight: 500;
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-icon {
            color: #10b981;
            min-width: 20px;
        }

        .checklist-card {
            padding: 25px;
        }

        .checklist-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .checklist-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            margin: 0;
        }

        .checklist-progress {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .check-item {
            background: rgba(16, 185, 129, 0.03);
            border: 1px solid rgba(16, 185, 129, 0.2);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            transition: 0.3s;
        }

        .check-icon-wrapper {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #10b981;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .check-content {
            flex: 1;
        }

        .check-title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .check-title {
            font-weight: 700;
            color: white;
            margin: 0;
            font-size: 0.95rem;
        }

        .check-status {
            color: #10b981;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .check-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .btn-view-docs {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-view-docs:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .remarks-card {
            padding: 20px 25px;
        }

        .remarks-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
            margin-bottom: 15px;
        }

        .remarks-textarea {
            width: 100%;
            height: 100px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 15px;
            color: white;
            font-size: 0.85rem;
            resize: none;
        }

        .remarks-textarea:focus {
            outline: none;
            border-color: #10b981;
            background: rgba(255, 255, 255, 0.05);
        }

        .approval-card {
            padding: 25px;
        }

        .approval-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: white;
            margin-bottom: 20px;
        }

        .approval-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .approval-label {
            font-weight: 700;
            color: white;
            font-size: 0.95rem;
            margin-bottom: 2px;
        }

        .approval-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
        }

        .form-switch .form-check-input {
            width: 2.8em;
            height: 1.4em;
            cursor: pointer;
        }

        .form-switch .form-check-input:checked {
            background-color: #10b981;
            border-color: #10b981;
        }

        .btn-approve {
            width: 100%;
            background: #10b981;
            color: #1e293b;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-approve:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-approve .fa-arrow-right {
            font-size: 1.1rem;
        }

        .approve-note {
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            margin-top: 15px;
            padding: 0 10px;
            line-height: 1.4;
        }

        .post-action-card {
            background: rgba(16, 185, 129, 0.05);
            border: 1px dashed rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .post-action-label {
            color: #10b981;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .post-action-title {
            font-weight: 700;
            color: white;
            font-size: 0.95rem;
            margin-bottom: 5px;
        }

        .post-action-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.75rem;
            line-height: 1.4;
            margin: 0;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="confirm-title">Final Admission Confirmation</h2>
            <p class="confirm-subtitle">Reviewing Application #{{ $application->application_no }} for the Academic Year
                {{ date('Y') }}-{{ date('y', strtotime('+1 year')) }}</p>
        </div>
        <div class="d-flex gap-3">
            <button type="submit" form="approval-form"
                formaction="{{ route('admin.final_admission.save', $application->id) }}" class="btn-light-outline">
                Save Progress
            </button>
            <button type="submit" form="approval-form"
                formaction="{{ route('admin.final_admission.reject', $application->id) }}" class="btn-red-outline">
                Reject Application
            </button>
        </div>
    </div>



    <form id="approval-form" action="{{ route('admin.final_admission.approve', $application->id) }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Left Column (Profile) -->
            <div class="col-lg-3">
                <div class="dark-card profile-card mb-4">
                    @php
                        $photoDoc = $application->documents->where('document_type', 'photo')->first();
                    @endphp
                    @if ($photoDoc && $photoDoc->file_path)
                        <div class="profile-avatar-bg"
                            style="background-image: url('{{ asset('storage/' . $photoDoc->file_path) }}'); background-size: cover; background-position: center; color: transparent;">
                            <div class="profile-check" style="z-index: 2; color: white;"><i class="fa fa-check"></i></div>
                        </div>
                    @else
                        <div class="profile-avatar-bg">
                            {{ substr($application->user->name ?? $application->first_name, 0, 1) }}
                            <div class="profile-check"><i class="fa fa-check"></i></div>
                        </div>
                    @endif
                    <div class="profile-name">
                        {{ $application->user->name ?? $application->first_name . ' ' . $application->last_name }}</div>
                    <div class="profile-id">Application ID: {{ $application->id }}</div>

                    <div class="info-row">
                        <span class="info-label">Course</span>
                        <span class="info-value">{{ $application->course->code ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Duration</span>
                        <span class="info-value">{{ $application->course->duration_years ?? 4 }} Years</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Category</span>
                        <span class="info-badge">MERIT-BASED</span>
                    </div>
                </div>

                <div class="dark-card contact-card">
                    <h6 class="text-white fw-bold mb-3 d-flex align-items-center gap-2" style="font-size:0.9rem;">
                        <i class="fa fa-id-card-clip text-success"></i> Contact Info
                    </h6>
                    <div class="contact-item">
                        <i class="fa fa-envelope contact-icon"></i>
                        {{ $application->user->email ?? $application->email }}
                    </div>
                    <div class="contact-item">
                        <i class="fa fa-phone contact-icon"></i>
                        {{ $application->mobile ?? ($application->user->phone ?? 'N/A') }}
                    </div>
                </div>
            </div>

            <!-- Middle Column (Checklist & Remarks) -->
            <div class="col-lg-5">
                <div class="dark-card checklist-card mb-4">
                    <div class="checklist-header">
                        <h5 class="checklist-title">Verification Checklist</h5>
                        <span class="checklist-progress">{{ $completedTasks }} OF 3 TASKS COMPLETED</span>
                    </div>

                    <div class="check-item">
                        <div class="check-icon-wrapper"><i class="fa fa-check"></i></div>
                        <div class="check-content">
                            <div class="check-title-row">
                                <h6 class="check-title">Documents Verified</h6>
                                <span class="check-status">VERIFIED</span>
                            </div>
                            <p class="check-desc">10th, 12th Grade sheets and Identity Proof have been authenticated against
                                originals.</p>
                            <a href="{{ route('admin.verification.index', ['status' => 'verified', 'app_id' => $application->id]) }}"
                                class="btn-view-docs"><i class="fa fa-eye"></i> VIEW DOCS</a>
                        </div>
                    </div>

                    <div class="check-item">
                        <div class="check-icon-wrapper"><i class="fa fa-chart-simple"></i></div>
                        <div class="check-content">
                            <div class="check-title-row">
                                <h6 class="check-title">Eligibility Criteria Met</h6>
                                <span class="check-status">PASSED</span>
                            </div>
                            <p class="check-desc">Student matches the minimum aggregate score of 60% required for
                                {{ $application->course->code }}.</p>
                        </div>
                    </div>

                    <div class="check-item">
                        <div class="check-icon-wrapper"
                            style="background: {{ $feePaid ? '#10b981' : '#f59e0b' }}; color: {{ $feePaid ? '#1e293b' : 'white' }}">
                            <i class="fa {{ $feePaid ? 'fa-wallet' : 'fa-clock' }}"></i>
                        </div>
                        <div class="check-content">
                            <div class="check-title-row">
                                <h6 class="check-title">Admission Fee Paid</h6>
                                @if ($feePaid)
                                    <span class="check-status">CONFIRMED</span>
                                @else
                                    <span class="check-status" style="color: #f59e0b;">PENDING</span>
                                @endif
                            </div>
                            @if ($feePaid)
                                <p class="check-desc">Payment has been verified. Initial seat booking fee received.</p>
                            @else
                                <p class="check-desc">Awaiting fee payment confirmation from the applicant.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="dark-card remarks-card">
                    <h5 class="remarks-title">Final Remarks / Administrative Notes</h5>
                    <textarea class="remarks-textarea" name="remarks" placeholder="Add any specific instructions for the student record...">{{ $application->admin_remarks }}</textarea>
                </div>
            </div>

            <!-- Right Column (Approval actions) -->
            <div class="col-lg-4">
                <div class="dark-card approval-card">
                    <h5 class="approval-title">Final Approval</h5>

                    <div class="approval-row">
                        <div>
                            <div class="approval-label">Issue Enrollment ID</div>
                            <div class="approval-desc">Generate system ID now</div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="issue_enrollment" checked>
                        </div>
                    </div>

                    <!-- Removed Send Welcome Kit switch exactly as requested -->

                    <button type="submit" class="btn-approve"
                        {{ $completedTasks < 3 ? 'disabled style=opacity:0.6;cursor:not-allowed;' : '' }}>
                        <span>Approve Admission</span>
                        <i class="fa fa-arrow-right"></i>
                    </button>
                    @if ($completedTasks < 3)
                        <div class="approve-note text-warning mt-2">
                            <i class="fa fa-exclamation-triangle"></i> Cannot approve until all verification tasks
                            (including fee payment) are completed.
                        </div>
                    @else
                        <div class="approve-note">
                            By clicking approve, the student will be officially enrolled in the database.
                        </div>
                    @endif
                </div>

                <div class="post-action-card">
                    <div class="post-action-label"><i class="fa fa-info-circle"></i> POST-ACTION STATE</div>
                    <div class="post-action-title">ID Generation System</div>
                    <p class="post-action-desc">The Enrollment Number will appear here after confirmation.</p>
                </div>
            </div>
        </div>
    </form>
@endsection
