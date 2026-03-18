@extends('student.layout')

@section('page_title', 'Application Status')

@section('content')
    <div class="row align-items-center mb-3">
        <div class="col">
            <p style="color: rgba(255, 255, 255, 0.7); font-weight: 500; margin-bottom: 0;">Application ID: <span
                    class="fw-bold text-white">{{ $application->application_no }}</span> | Course: <span
                    class="fw-bold text-white">{{ $application->course->name ?? 'Not Selected' }}</span></p>
        </div>
        <div class="col-auto">
            <a href="{{ route('student.application.download') }}" class="btn-premium-outline">
                <i data-lucide="download" class="me-2" style="width: 18px;"></i>
                Download Summary
            </a>
        </div>
    </div>

    @if ($application)
        <div class="premium-card mb-4">
            <div class="d-flex align-items-center gap-2 mb-4">
                <i data-lucide="bar-chart-3" style="color: #6366f1; width: 20px;"></i>
                <h5 class="mb-0 text-white" style="font-family: 'Outfit'; font-weight: 700;">Application Journey</h5>
            </div>

            <!-- Progress Tracker -->
            @php
                // Dynamic Logic for steps
                $uploadedCount = $documents->count();
                $totalRequired = 6;
                $isDocsStarted = $uploadedCount > 0;
                $isDocsCompleted = $uploadedCount >= $totalRequired;

                $currentStatus = $application->status;

                $statusMap = [
                    'draft' => 0,
                    'applied' => 1,
                    'pending' => 1,
                    'submitted_documents' => 1,
                    'verified' => 2,
                    'merit' => 3,
                    'offer_made' => 5, // 5 makes 'Offer Made' (index 4) checked, and 'Enrolled' (index 5) spinning
                    'confirmed' => 6, // 6 makes everything checked
                    'enrolled' => 6,
                ];

                $currentIndex = $statusMap[$currentStatus] ?? 1;

                // If documents are being uploaded but not finished, stay on 'Under Review' with a progress sub-label
                if ($currentIndex == 1 && $isDocsStarted && !$isDocsCompleted) {
                    $currentIndex = 1; // Stay here
                } elseif ($currentIndex == 1 && $isDocsCompleted) {
                    $currentIndex = 2; // Move to Verified step once all done
                }

                $isPaid = false;
                if (isset($payments)) {
                    $admissionFee = $application->course->admission_fee ?? 45000;
                    $labFee = 100;
                    $totalBalance = $admissionFee + $labFee;
                    $isPaid = $payments->where('status', 'success')->sum('amount') >= $totalBalance;
                }

                $steps = [
                    'Registered' => [
                        'label' => 'Submitted',
                        'sub' => $application->applied_date
                            ? \Illuminate\Support\Carbon::parse($application->applied_date)->format('M d, Y')
                            : 'Pending',
                    ],
                    'Applied' => [
                        'label' => 'Under Review',
                        'sub' => $isDocsCompleted
                            ? 'Form Approved'
                            : ($isDocsStarted
                                ? $uploadedCount . ' of ' . $totalRequired . ' Uploaded'
                                : 'In Progress'),
                    ],
                    'Docs' => [
                        'label' => 'Verified',
                        'sub' => $isDocsCompleted ? 'Awaiting Approval' : 'Pending Uploads',
                    ],
                    'Merit' => ['label' => 'Merit List', 'sub' => $currentIndex >= 4 ? 'Selected' : 'Upcoming'],
                    'Confirm' => ['label' => 'Offer Made', 'sub' => $currentIndex >= 5 ? 'Approved' : 'Pending'],
                    'Enrolled' => [
                        'label' => 'Enrolled',
                        'sub' => $isPaid ? 'Paid' : ($currentIndex >= 6 ? 'Finalized' : 'Payment Pend.'),
                    ],
                ];
            @endphp

            <div class="progress-tracker-wrap py-4">
                <div class="tracker-line-bg"></div>
                <div class="tracker-line-fill" style="width: {{ min(100, ($currentIndex / (count($steps) - 1)) * 100) }}%">
                </div>

                <div class="d-flex justify-content-between position-relative">
                    @foreach (array_values($steps) as $index => $step)
                        <div class="tracker-step text-center">
                            <div
                                class="step-circle @if ($index < $currentIndex || ($step['label'] == 'Enrolled' && $isPaid)) completed @elseif($index == $currentIndex) active @endif">
                                @if ($index < $currentIndex || ($step['label'] == 'Enrolled' && $isPaid))
                                    <i data-lucide="check" style="width: 14px;"></i>
                                @elseif($index == $currentIndex)
                                    <i data-lucide="refresh-cw" class="spin" style="width: 14px;"></i>
                                @endif
                            </div>
                            <div class="mt-3">
                                <div class="step-label"
                                    style="font-size: 0.85rem; font-weight: 700; color: {{ $index <= $currentIndex ? '#ffffff' : 'rgba(255, 255, 255, 0.7)' }};">
                                    {{ $step['label'] }}
                                </div>
                                <div
                                    style="font-size: 0.7rem; font-weight: 700; color: {{ $index <= $currentIndex ? 'rgba(255,255,255,0.7)' : 'rgba(255,255,255,0.5)' }};">
                                    {{ $step['sub'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Documents Status -->
            <div class="col-lg-8">
                <div class="premium-card h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="folder" style="color: #6366f1; width: 20px;"></i>
                            <h5 class="mb-0 text-white" style="font-family: 'Outfit'; font-weight: 700;">Document Center
                            </h5>
                        </div>
                        <span class="fw-semibold"
                            style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75);">{{ $documents->count() }} of 6
                            Documents Uploaded</span>
                    </div>

                    <div class="document-list">
                        @php
                            $documentTypes = [
                                [
                                    'id' => '10th',
                                    'name' => '10th Marksheet',
                                    'icon' => 'file-text',
                                    'color' => '#3b82f6',
                                ],
                                [
                                    'id' => '12th',
                                    'name' => '12th Certificate',
                                    'icon' => 'file-text',
                                    'color' => '#f59e0b',
                                ],
                                [
                                    'id' => 'tc',
                                    'name' => 'Transfer Certificate',
                                    'icon' => 'file-minus',
                                    'color' => '#ef4444',
                                ],
                                [
                                    'id' => 'id',
                                    'name' => 'ID Proof (Aadhaar)',
                                    'icon' => 'user-check',
                                    'color' => '#8b5cf6',
                                ],
                                ['id' => 'photo', 'name' => 'Passport Photo', 'icon' => 'image', 'color' => '#06b6d4'],
                                [
                                    'id' => 'income',
                                    'name' => 'Income Certificate',
                                    'icon' => 'wallet',
                                    'color' => '#ec4899',
                                ],
                            ];
                        @endphp
                        @foreach ($documentTypes as $doc)
                            @php
                                $uploadedDoc = $documents[$doc['id']] ?? null;
                            @endphp
                            <div class="doc-item p-3 mb-3 d-flex align-items-center justify-content-between"
                                style="border: 1px solid var(--border-color); border-radius: 16px; transition: all 0.2s;">
                                <div class="d-flex align-items-center gap-3">
                                    <div
                                        style="width: 42px; height: 42px; background-color: {{ $doc['color'] }}15; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: {{ $doc['color'] }};">
                                        <i data-lucide="{{ $doc['icon'] }}" style="width: 20px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-white" style="font-size: 0.95rem;">{{ $doc['name'] }}
                                        </h6>
                                        <p class="mb-0"
                                            style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.5); font-weight: 600;">
                                            {{ $uploadedDoc ? 'UPLOADED ON ' . $uploadedDoc->created_at->format('M d, Y') : 'PENDING UPLOAD' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($uploadedDoc)
                                        <div class="badge bg-success bg-opacity-10 text-success px-3 py-2"
                                            style="border-radius: 10px; font-weight: 700; font-size: 0.75rem;">
                                            <i data-lucide="check" class="me-1" style="width: 14px;"></i>
                                            {{ $uploadedDoc->status == 'pending' ? 'SUBMITTED' : strtoupper($uploadedDoc->status) }}
                                        </div>
                                        <a href="{{ Storage::url($uploadedDoc->file_path) }}" target="_blank"
                                            class="icon-btn" style="width: 34px; height: 34px;">
                                            <i data-lucide="eye" style="width: 16px;"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('student.documents') }}" class="btn-premium-outline py-2 px-3"
                                            style="font-size: 0.8rem;">Upload Now</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Info -->
            <div class="col-lg-4">
                <div class="premium-card text-white h-auto mb-4"
                    style="background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                    <div
                        style="width: 48px; height: 48px; background-color: rgba(255, 255, 255, 0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; color: #ffffff; margin-bottom: 2rem;">
                        <i data-lucide="sparkles" style="width: 24px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3" style="font-family: 'Outfit';">Almost There!</h4>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; line-height: 1.6;">Your admission offer
                        will be triggered as soon as document verification is complete. Please ensure all documents are
                        clear and readable.</p>

                    @php
                        $isOfferMade = $currentIndex >= 4;
                    @endphp

                    @if ($isOfferMade)
                        <a href="{{ route('student.payment') }}"
                            class="btn-premium-primary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2"
                            style="background: #ffffff; color: #6366f1;">
                            Proceed to Fee Payment <i data-lucide="arrow-right" style="width: 18px;"></i>
                        </a>
                    @else
                        <button
                            class="btn btn-secondary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2"
                            disabled
                            style="background: rgba(255,255,255,0.1); border: 1px dashed rgba(255,255,255,0.2); color: rgba(255,255,255,0.4); cursor: not-allowed;">
                            <i data-lucide="lock" style="width: 18px;"></i> Proceed to Fee Payment
                        </button>
                    @endif
                    <p class="text-center mt-3 mb-0" style="font-size: 0.7rem; text-secondary; font-weight: 600;">
                        {{ $isOfferMade ? 'ADMISSION OFFER ACTIVE' : 'BUTTON ACTIVATES UPON OFFER' }}</p>
                </div>


            </div>
        </div>
    @else
        <div class="premium-card">
            <div class="text-center py-5">
                <i data-lucide="file-warning" class="mb-3 text-muted" style="width: 64px; height: 64px;"></i>
                <h4 style="font-family: 'Outfit'; font-weight: 700;">No Application Found</h4>
                <p class="text-muted">Please complete the registration form first to track your status.</p>
                <a href="{{ route('student.dashboard') }}" class="btn-premium-primary px-5 py-3 mt-3">Go to Dashboard</a>
            </div>
        </div>
    @endif

    <style>
        .progress-tracker-wrap {
            position: relative;
        }

        .tracker-line-bg {
            position: absolute;
            top: 21px;
            left: 3rem;
            right: 3rem;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            z-index: 0;
        }

        .tracker-line-fill {
            position: absolute;
            top: 21px;
            left: 3rem;
            height: 4px;
            background: linear-gradient(90deg, #6366f1, #4338ca);
            border-radius: 10px;
            z-index: 1;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-circle {
            width: 42px;
            height: 42px;
            background-color: #0f172a;
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            color: rgba(255, 255, 255, 0.4);
        }

        .step-circle.active {
            border-color: #6366f1;
            color: #6366f1;
            background-color: #0f172a;
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
        }

        .step-circle.completed {
            background-color: #6366f1;
            border-color: #6366f1;
            color: white;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.4);
        }

        .spin {
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .doc-item:hover {
            border-color: var(--accent-green) !important;
            background-color: rgba(16, 185, 129, 0.02);
        }
    </style>
@endsection
