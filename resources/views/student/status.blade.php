@extends('student.layout')

@section('page_title', 'Application Status')

@section('content')

    <div class="row align-items-center g-3 mb-4">
        <div class="col-12 col-md">
            <p style="color: rgba(255, 255, 255, 0.7); font-weight: 500; margin-bottom: 0; font-size: 0.9rem;">
                Application ID: <span class="fw-bold text-white">{{ $application->application_no ?? 'DRAFT' }}</span>
                <span class="d-none d-md-inline"> | </span><br class="d-md-none">
                Course: <span class="fw-bold text-white">{{ $application->course->name ?? 'Not Selected' }}</span>
            </p>
        </div>
        <div class="col-12 col-md-auto">
            <a href="{{ route('student.application.download') }}" class="btn-premium-outline w-100 d-block text-center">
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
                $uploadedCount = $documents->count();
                $totalRequired = 6;
                $isDocsStarted = $uploadedCount > 0;
                $isDocsCompleted = $uploadedCount >= $totalRequired;
                $currentStatus = $application->status;

                // Track logical progress based on DB status
                $statusMap = [
                    'draft' => 0,
                    'applied' => 1,
                    'pending' => 1,
                    'submitted_documents' => 1,
                    'verified' => 3,
                    'merit' => 4,
                    'offer_made' => 5,
                    'confirmed' => 5,
                    'enrolled' => 5,
                ];
                $dbIndex = $statusMap[$currentStatus] ?? 1;

                // Payment Status
                $isPaid = false;
                $isApplicationPaid = false;
                
                if (isset($payments)) {
                    $admissionFee = $application->course->admission_fee ?? 0;
                    $labFee = $application->course->lab_fee ?? 0;
                    $libraryFee = $application->course->library_fee ?? 0;
                    $applicationFeeExpected = $application->course->application_fee ?? 0;

                    $totalAdmissionBalance = $admissionFee + $labFee + $libraryFee;
                    
                    // Count tagged payments first
                    $paidAdm = $payments->where('payment_type', 'admission')->sum('amount');
                    $paidApp = $payments->where('payment_type', 'application')->sum('amount');
                    
                    // Handle untagged records for legacy compatibility
                    // Compare exactly against course fee amounts for this student
                    $untagged = $payments->where('payment_type', null);
                    foreach($untagged as $p) {
                        if ($p->amount == $applicationFeeExpected) {
                            $paidApp += $p->amount;
                        } elseif ($p->amount == $admissionFee || $p->amount == $totalAdmissionBalance) {
                            $paidAdm += $p->amount;
                        } elseif ($p->amount < $applicationFeeExpected + 100) {
                            // If it's roughly the application fee amount
                            $paidApp += $p->amount;
                        } else {
                            $paidAdm += $p->amount;
                        }
                    }
                    
                    $isPaid = $paidAdm >= $totalAdmissionBalance && $totalAdmissionBalance > 0;
                    $isApplicationPaid = $paidApp >= $applicationFeeExpected;
                }

                // Determine visual progress (if application fee is paid, we are at least at step 1)
                $currentIndex = max($dbIndex, ($isApplicationPaid ? 1 : 0), ($isPaid ? 5 : 0));

                $steps = [
                    [
                        'label' => $currentStatus == 'draft' ? 'Registration' : 'Submitted',
                        'sub' => $application->applied_date
                            ? \Illuminate\Support\Carbon::parse($application->applied_date)->format('M d, Y')
                            : ($currentStatus == 'draft' ? 'In Progress' : 'Pending'),
                    ],
                    [
                        'label' => 'Under Review',
                        'sub' => $dbIndex > 1 ? 'Approved' : ($isDocsCompleted ? 'Form Received' : ($currentStatus == 'draft' ? 'Awaiting Form' : 'In Progress')),
                    ],
                    [
                        'label' => 'Verified',
                        'sub' =>
                            $dbIndex >= 3 ? 'Verified' : ($isDocsCompleted ? 'Awaiting Approval' : 'Pending Uploads'),
                    ],
                    ['label' => 'Merit List', 'sub' => $dbIndex >= 4 ? 'Selected' : 'Upcoming'],
                    ['label' => 'Offer Made', 'sub' => $dbIndex >= 5 ? 'Ready' : 'Pending'],
                    ['label' => 'Enrolled', 'sub' => $isPaid ? 'Paid' : 'Finalized'],
                ];
            @endphp

            <div class="progress-tracker-wrap py-4">
                <div class="tracker-line-bg d-none d-md-block"></div>
                <div class="tracker-line-fill d-none d-md-block"
                    style="width: {{ min(100, ($currentIndex / (count($steps) - 1)) * 100) }}%"></div>

                <div
                    class="tracker-container d-flex flex-column flex-md-row justify-content-between position-relative gap-4 gap-md-0">
                    @foreach (array_values($steps) as $index => $step)
                        <div
                            class="tracker-step text-start text-md-center d-flex d-md-block align-items-center gap-3 gap-md-0">
                            <div
                                class="step-circle @if ($index < $currentIndex || ($step['label'] == 'Enrolled' && $isPaid)) completed @elseif($index == $currentIndex) active @endif flex-shrink-0">
                                @if ($index < $currentIndex || ($step['label'] == 'Enrolled' && $isPaid))
                                    <i data-lucide="check" style="width: 14px;"></i>
                                @elseif($index == $currentIndex)
                                    <i data-lucide="refresh-cw" class="spin" style="width: 14px;"></i>
                                @endif
                                @if ($index < count($steps) - 1)
                                    <div class="d-md-none vertical-line @if ($index < $currentIndex) completed @endif">
                                    </div>
                                @endif
                            </div>
                            <div class="mt-md-3">
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
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <i data-lucide="folder" style="color: #6366f1; width: 20px;"></i>
                            <h5 class="mb-0 text-white" style="font-family: 'Outfit'; font-weight: 700;">Document Center
                            </h5>
                        </div>
                        <span class="fw-semibold"
                            style="font-size: 0.85rem; color: rgba(255, 255, 255, 0.75);">{{ $documents->count() }} of 6
                            Documents</span>
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
                            @php $uploadedDoc = $documents[$doc['id']] ?? null; @endphp
                            <div class="doc-item p-3 mb-3 d-flex flex-wrap align-items-center justify-content-between gap-3"
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
                                            {{ $uploadedDoc ? 'UPLOADED ON ' . $uploadedDoc->created_at->format('M d, Y') : 'PENDING' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3 ms-auto ms-sm-0">
                                    @if ($uploadedDoc)
                                        <div class="badge bg-success bg-opacity-10 text-success px-3 py-2"
                                            style="border-radius: 10px; font-weight: 700; font-size: 0.75rem;">
                                            {{ $uploadedDoc->status == 'pending' ? 'SUBMITTED' : strtoupper($uploadedDoc->status) }}
                                        </div>
                                        <a href="{{ Storage::url($uploadedDoc->file_path) }}" target="_blank"
                                            class="icon-btn" style="width: 34px; height: 34px;">
                                            <i data-lucide="eye" style="width: 16px;"></i>
                                        </a>
                                    @else
                                        <a href="{{ route('student.documents') }}" class="btn-premium-outline py-2 px-3"
                                            style="font-size: 0.8rem;">Upload</a>
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
                    <h4 class="fw-bold mb-3" style="font-family: 'Outfit';">Next Steps</h4>
                    
                    @if (!$isApplicationPaid)
                        <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; line-height: 1.6;">Please pay the initial **Application Processing Fee** of ₹{{ number_format($application->course->application_fee, 2) }} to start your verification process.</p>
                        
                        <form action="{{ route('student.payment.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $application->course->application_fee }}">
                            <input type="hidden" name="type" value="application">
                            <button type="submit" class="btn-premium-primary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2" style="background: #ffffff; color: #6366f1;">
                                Pay Application Fee <i data-lucide="credit-card" style="width: 18px;"></i>
                            </button>
                        </form>
                    @else
                        @if ($isPaid)
                            <p style="color: rgba(16, 185, 129, 0.8); font-size: 0.9rem; line-height: 1.6;">
                                Congratulations! Your admission fee is paid and your seat is secured.
                            </p>
                            <button class="btn btn-secondary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2" disabled style="background: rgba(16, 185, 129, 0.1); border: 1px dashed rgba(16, 185, 129, 0.2); color: #10b981;">
                                <i data-lucide="check-circle" style="width: 18px;"></i> Enrollment Confirmed
                            </button>
                        @else
                            <p style="color: rgba(255, 255, 255, 0.8); font-size: 0.9rem; line-height: 1.6;">
                                {{ $currentIndex >= 5 ? 'Great news! Your offer is ready. Pay the admission fee to secure your seat.' : 'Your application fee is paid. Document verification is in progress. Offer will be triggered soon.' }}
                            </p>

                            @if ($currentIndex >= 5)
                                @php 
                                    $pendingAdmission = $totalAdmissionBalance - $paidAdm;
                                @endphp
                                <form action="{{ route('student.payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $pendingAdmission }}">
                                    <input type="hidden" name="type" value="admission">
                                    <button type="submit" class="btn-premium-primary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2" style="background: #ffffff; color: #6366f1;">
                                        Pay Admission Fee (₹{{ number_format($pendingAdmission, 2) }}) <i data-lucide="arrow-right" style="width: 18px;"></i>
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary w-100 py-3 mt-3 d-flex align-items-center justify-content-center gap-2" disabled style="background: rgba(255,255,255,0.1); border: 1px dashed rgba(255,255,255,0.2); color: rgba(255,255,255,0.4);">
                                    <i data-lucide="lock" style="width: 18px;"></i> Admission Fee
                                </button>
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="premium-card">
            <div class="text-center py-5">
                <i data-lucide="file-warning" class="mb-3 text-muted" style="width: 64px; height: 64px;"></i>
                <h4 style="font-family: 'Outfit'; font-weight: 700;">No Application Found</h4>
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
            transition: width 0.8s ease;
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
            transition: all 0.3s ease;
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
            border-color: #6366f1 !important;
            background-color: rgba(99, 102, 241, 0.02);
        }

        .vertical-line {
            position: absolute;
            top: 40px;
            left: 50%;
            width: 2px;
            height: 30px;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(-50%);
        }

        .vertical-line.completed {
            background: #6366f1;
        }

        @media (max-width: 768px) {
            .tracker-step {
                width: 100%;
            }

            .step-circle {
                margin: 0;
            }

            .vertical-line {
                height: 45px;
            }
        }
    </style>
@endsection
