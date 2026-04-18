<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduFinance Portal - Accountant Section</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #e2e8f0;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        .portal-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #0f172a 0%, #020617 100%);
            border-right: 1px solid rgba(255,255,255,0.05);
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            box-shadow: 4px 0 20px rgba(0,0,0,0.5);
            z-index: 10;
        }

        .brand {
            display: flex;
            align-items: center;
            font-weight: 800;
            font-size: 1.15rem;
            color: #ffffff;
            margin-bottom: 2.5rem;
            text-decoration: none;
            padding: 0 8px;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }
        
        .brand-text span {
            color: #3b82f6;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .nav-item i {
            margin-right: 14px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            opacity: 0.8;
        }

        .nav-item:hover {
            color: #ffffff;
            background: rgba(255,255,255,0.05);
            transform: translateX(4px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(59,130,246,0.3);
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 0 40px 40px 40px;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Top Header */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 24px 0 0 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 32px;
        }

        .header-tabs {
            display: flex;
            gap: 32px;
        }

        .header-tab {
            color: #94a3b8;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            padding-bottom: 16px;
            margin-bottom: -1px;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }

        .header-tab.active {
            color: #3b82f6;
            border-bottom-color: #3b82f6;
            font-weight: 600;
        }
        
        .header-tab:hover:not(.active) {
            color: #ffffff;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 20px;
            padding-bottom: 12px;
        }

        .bell-icon {
            color: #ffffff;
            background: rgba(255,255,255,0.05);
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            font-size: 1.1rem;
            transition: 0.2s;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .bell-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid #0f172a;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3b82f6;
            box-shadow: 0 0 10px rgba(59,130,246,0.5);
        }

        /* Metric Cards */
        .metric-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.05);
            height: 100%;
            transition: 0.3s ease;
        }
        
        .metric-card:hover {
            transform: translateY(-5px);
            border-color: rgba(59,130,246,0.3);
        }

        .metric-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .metric-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .metric-badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 6px;
        }
        
        .badge-green { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); }
        .badge-red { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); }
        .text-green { color: #34d399; font-weight: 600; font-size: 0.85rem;}

        /* Progress bar */
        .custom-progress {
            height: 8px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 4px;
            width: 100px;
            overflow: hidden;
            display: inline-block;
            margin-left: 8px;
        }
        .custom-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(59,130,246,0.5);
        }

        /* Panels */
        .panel {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .panel-header {
            padding: 24px;
        }
        
        .panel-header.border-b {
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .panel-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .panel-title i {
            color: #3b82f6;
        }

        .search-input {
            width: 100%;
            background: rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 12px 16px 12px 42px;
            font-size: 0.9rem;
            color: #e2e8f0;
            font-weight: 400;
            transition: 0.3s;
        }
        
        .search-input::placeholder {
            color: #64748b;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(0,0,0,0.3);
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1rem;
        }

        .student-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .student-item {
            display: flex;
            padding: 16px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.03);
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .student-item:hover {
            background: rgba(255,255,255,0.03);
        }

        .student-item.selected {
            background: rgba(59,130,246,0.1); 
            border-left: 4px solid #3b82f6;
            padding-left: 20px;
        }

        .student-avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 16px;
            background: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .student-info h6 {
            margin: 0 0 4px 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #ffffff;
        }

        .student-desc {
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 6px;
        }
        
        .student-pending {
            font-size: 0.85rem;
            color: #f87171;
            font-weight: 600;
        }

        .selected-badge {
            position: absolute;
            right: 24px;
            top: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #3b82f6;
            letter-spacing: 0.5px;
            background: rgba(59,130,246,0.2);
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* Billing Details Panel */
        .billing-panel {
            padding: 32px 40px;
        }

        .billing-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .billing-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 6px;
        }

        .billing-subtitle {
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .date-generated {
            text-align: right;
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #e2e8f0;
            margin-top: 6px;
            text-transform: none;
            letter-spacing: 0;
        }

        .fee-item {
            display: flex;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px dashed rgba(255,255,255,0.1);
            font-size: 0.95rem;
            color: #cbd5e1;
        }
        
        .fee-amount {
            font-weight: 600;
            color: #ffffff;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 16px;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .total-label {
            font-size: 1.15rem;
            font-weight: 700;
            color: #ffffff;
        }

        .total-amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: #60a5fa;
            text-shadow: 0 0 20px rgba(59,130,246,0.3);
        }

        .record-payment-box {
            background: rgba(0,0,0,0.2);
            border-radius: 16px;
            padding: 24px;
            margin-top: 40px;
            border: 1px solid rgba(255,255,255,0.05);
        }

        .box-title {
            font-size: 1.05rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }
        
        .box-title i {
            color: #60a5fa;
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .form-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            border: 1px solid rgba(255,255,255,0.1);
            background: #0f172a;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.9rem;
            color: #ffffff;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            background: #0f172a;
            color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
        }

        .action-buttons {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: 10px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(59,130,246,0.3);
        }

        .btn-primary i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59,130,246,0.4);
        }

        .btn-outline {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.2);
            font-weight: 600;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: 10px;
            color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        
        .btn-outline i {
            margin-right: 8px;
            color: #60a5fa;
            font-size: 1.1rem;
        }

        .compliance-alert {
            display: flex;
            align-items: flex-start;
            background: rgba(59,130,246,0.1);
            border-radius: 12px;
            padding: 16px 20px;
            margin-top: 24px;
            border: 1px solid rgba(59,130,246,0.2);
        }

        .compliance-alert i {
            color: #60a5fa;
            margin-right: 16px;
            font-size: 1.25rem;
            margin-top: 2px;
        }

        .compliance-alert-content h6 {
            color: #93c5fd;
            font-weight: 700;
            font-size: 0.85rem;
            margin: 0 0 6px 0;
        }

        .compliance-alert-content p {
            color: #bfdbfe;
            font-size: 0.75rem;
            margin: 0;
            line-height: 1.5;
        }

        .logout-btn {
            margin-top: auto;
            color: #ef4444;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-radius: 10px;
            transition: 0.2s;
            border: 1px solid rgba(239, 68, 68, 0.1);
            background: rgba(239, 68, 68, 0.05);
        }
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.3);
        }
    </style>
</head>
<body>

<div class="portal-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="brand">
            <div class="brand-icon">
                <i class="fa fa-wallet"></i>
            </div>
            <span class="brand-text">Edu<span>Admit</span> Pro</span>
        </a>

        <a href="{{ route('accountant.dashboard', ['type' => 'admission']) }}" class="nav-item {{ request('type', 'admission') == 'admission' ? 'active' : '' }}">
            <i class="fa fa-file-invoice"></i> Admission Billing
        </a>
        <a href="{{ route('accountant.dashboard', ['type' => 'application']) }}" class="nav-item {{ request('type') == 'application' ? 'active' : '' }}">
            <i class="fa fa-receipt"></i> Application Fees
        </a>
        <a href="{{ route('accountant.payment_history') }}" class="nav-item">
            <i class="fa fa-clock-rotate-left"></i> Payment History
        </a>
        <a href="#" class="nav-item">
            <i class="fa fa-clipboard-list"></i> Outstanding Dues
        </a>
        <a href="#" class="nav-item">
            <i class="fa fa-chart-pie"></i> Collections Analytics
        </a>
        
        <form action="{{ route('admin.logout') }}" method="POST" class="mt-auto">
            @csrf
            <button type="submit" class="logout-btn w-100 border-0">
                <i class="fa fa-sign-out-alt me-2"></i> Logout
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
        <div class="alert alert-dismissible fade show mx-4 mt-4 mb-2 shadow" role="alert" style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; border-radius: 10px; backdrop-filter: blur(10px);">
            <i class="fa fa-badge-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="filter: invert(1); opacity: 0.5;"></button>
        </div>
        @endif

        <!-- Top Header -->
        <div class="top-header">
            <div class="header-tabs">
                <a href="#" class="header-tab active">Billing & Receipts</a>
                <a href="{{ route('accountant.exportReport') }}" class="header-tab"><i class="fa fa-file-pdf text-danger me-1"></i> Fee Report</a>
                <a href="#" class="header-tab">Ledger</a>
            </div>
            
            <div class="header-actions">
                <a href="#" class="bell-icon">
                    <i class="fa fa-bell"></i>
                    <span class="bell-dot"></span>
                </a>
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.85rem">{{ auth()->user()->name }}</div>
                        <div class="text-secondary" style="font-size: 0.7rem">Accountant Portal</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" alt="User" class="user-avatar">
                </div>
            </div>
        </div>

        <!-- Metric Cards Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-title">TOTAL REVENUE TODAY</div>
                    <div class="metric-value">
                        ₹{{ number_format($totalRevenueToday, 0) }}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-title">PENDING PAYMENTS</div>
                    <div class="metric-value">
                        {{ $pendingPaymentsCount }} <span class="metric-badge badge-red">Action Required</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#successfulTxModal">
                    <div class="metric-title d-flex justify-content-between align-items-center">
                        SUCCESSFUL TRANSACTIONS 
                        <i class="fa fa-arrow-up-right-from-square text-secondary" style="font-size: 0.8rem"></i>
                    </div>
                    <div class="metric-value">
                        {{ $successfulTransactions }} <span class="text-green ms-1">Live</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <div class="metric-title">OUTSTANDING DUES</div>
                    <div class="metric-value" style="color: #f87171;">
                        ₹{{ number_format($outstandingDues, 0) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Panels Row -->
        <div class="row g-4" style="flex: 1;" id="billing-main-content">
            <div class="col-lg-4">
                <div class="panel">
                    <div class="panel-header border-b">
                        <div class="panel-title">
                            <i class="{{ request('type') == 'application' ? 'fa fa-user-clock' : 'fa fa-hourglass-half' }}"></i> 
                            {{ request('type') == 'application' ? 'Awaiting Application Fee' : 'Awaiting Admission Fee' }}
                        </div>
                        <div class="search-wrapper">
                            <i class="fa fa-search"></i>
                            <input type="text" class="search-input" placeholder="Search by name or ID...">
                        </div>
                    </div>
                    
                    <ul class="student-list" style="overflow-y:auto; max-height:500px;" id="studentList">
                        @forelse($awaitingPaymentStudents as $index => $student)
                        <li class="student-item {{ $index === 0 ? 'selected' : '' }}" onclick="selectStudent({{ $index }}, this)">
                            <div class="student-avatar">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=random&color=fff" class="avatar-img shadow-sm" style="border-radius:10px; width:100%; height:100%; object-fit:cover;" alt="Avatar">
                            </div>
                            <div class="student-info">
                                <h6>{{ $student->name }}</h6>
                                <div class="student-desc">{{ $student->id }} • {{ $student->course_name }}</div>
                                <div class="student-pending">Pending: ₹{{ number_format($student->pending_amount, 2) }}</div>
                            </div>
                            <div class="selected-badge" style="display: {{ $index === 0 ? 'block' : 'none' }}">SELECTED</div>
                        </li>
                        @empty
                        <li class="p-4 text-center text-secondary">
                            <i class="fa fa-folder-open fs-2 mb-3"></i><br>
                            No pending payments found.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="panel">
                    @if(count($awaitingPaymentStudents) > 0)
                    <div class="billing-panel" id="billingPanel">
                    </div>
                    @else
                    <div class="billing-panel d-flex align-items-center justify-content-center flex-column text-muted py-5 h-100" style="min-height: 400px;">
                        <i class="fa fa-receipt fa-4x mb-4 text-secondary" style="opacity: 0.3;"></i>
                        <h5>No Application Selected</h5>
                        <p class="small">Select an application from the list to view billing details.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Successful Transactions Modal -->
<div class="modal fade" id="successfulTxModal" tabindex="-1" aria-labelledby="successfulTxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background: linear-gradient(145deg, #1e293b, #0f172a); border: 1px solid rgba(255,255,255,0.1); color: #e2e8f0;">
            <div class="modal-header border-bottom border-dark">
                <h5 class="modal-title font-weight-bold text-white d-flex align-items-center" id="successfulTxModalLabel">
                    <i class="fa fa-check-circle text-success me-2"></i> Recent Successful Transactions
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-borderless mb-0" style="color: #e2e8f0;">
                        <thead style="background: rgba(0,0,0,0.3); font-size: 0.85rem; letter-spacing: 0.5px; color: #94a3b8;">
                            <tr>
                                <th class="py-3 px-4 border-0" style="background: transparent; color: #94a3b8;">TXN ID</th>
                                <th class="py-3 border-0" style="background: transparent; color: #94a3b8;">STUDENT</th>
                                <th class="py-3 border-0" style="background: transparent; color: #94a3b8;">DATE & TIME</th>
                                <th class="py-3 text-end px-4 border-0" style="background: transparent; color: #94a3b8;">AMOUNT</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 0.95rem;">
                            @forelse($recentSuccessfulPayments as $payment)
                            <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); transition: 0.2s;">
                                <td class="py-3 px-4 font-monospace text-secondary border-0" style="font-size: 0.85rem; background: transparent;">{{ $payment->transaction_id ?? 'TXN-'.$payment->id }}</td>
                                <td class="py-3 border-0" style="background: transparent;">
                                    <div class="fw-bold text-white">{{ optional($payment->user)->name ?? 'Student' }}</div>
                                    <div class="text-secondary" style="font-size: 0.75rem;">{{ optional(optional($payment->application)->course)->name ?? 'Course' }}</div>
                                </td>
                                <td class="py-3 text-secondary border-0" style="background: transparent;">{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M d, Y h:i A') : 'N/A' }}</td>
                                <td class="py-3 text-end px-4 fw-bold text-success border-0" style="background: transparent;">₹{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-5 text-center text-muted border-0" style="background: transparent;">
                                    <i class="fa fa-receipt fa-3x mb-3" style="opacity: 0.3;"></i><br>
                                    No successful transactions on record yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-top border-dark" style="background: rgba(0,0,0,0.2);">
                <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const studentsData = @json($awaitingPaymentStudents);
    
    function selectStudent(index, element) {
        document.querySelectorAll('.student-item').forEach(item => {
            item.classList.remove('selected');
            item.querySelector('.selected-badge').style.display = 'none';
        });
        element.classList.add('selected');
        element.querySelector('.selected-badge').style.display = 'block';
        renderBillingPanel(studentsData[index]);
    }

    function renderBillingPanel(student) {
        if(!student) return;
        
        const panel = document.getElementById('billingPanel');
        const formattedTotal = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.pending_amount);
        const formattedExpected = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.expected_fee);
        
        let feeListHtml = '';
        if(student.is_application) {
            feeListHtml = `
                <div class="fee-item">
                    <span>Application Processing Fee</span>
                    <span class="fee-amount">${new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.pending_amount)}</span>
                </div>
                <div class="muted mt-3 small">This fee is required for document verification and initial processing.</div>
            `;
        } else {
            const tuition = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.tuition);
            const library = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.library);
            const lab = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.lab);
            const application = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.application);
            const health = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR' }).format(student.health);
            
            feeListHtml = `
                <div class="fee-item">
                    <span>Course Fee (Admission)</span>
                    <span class="fee-amount">${tuition}</span>
                </div>
                <div class="fee-item">
                    <span>Application Processing Fee</span>
                    <span class="fee-amount">${application}</span>
                </div>
                <div class="fee-item">
                    <span>Library & E-Resources</span>
                    <span class="fee-amount">${library}</span>
                </div>
                <div class="fee-item">
                    <span>Laboratory / Tech Fee</span>
                    <span class="fee-amount">${lab}</span>
                </div>
                <div class="fee-item">
                    <span>Health & Student Services</span>
                    <span class="fee-amount">${health}</span>
                </div>
            `;
        }

        panel.innerHTML = `
            <div class="billing-header">
                <div>
                    <h4 class="billing-title">${student.is_application ? 'Application Fee' : 'Admission Billing'}</h4>
                    <div class="billing-subtitle">Student ID: ${student.id} | Course: ${student.course_name}</div>
                </div>
                <div class="date-generated">
                    DATE GENERATED
                    <div class="date-value">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</div>
                </div>
            </div>
            
            <div class="fee-list">
                ${feeListHtml}
            </div>
            
            <div class="total-row" style="padding-top: 15px; margin-top: 15px;">
                <div class="total-label" style="font-size: 1rem; color: #94a3b8;">Total ${student.is_application ? 'Payable' : 'Course Fee'}</div>
                <div class="total-amount" style="font-size: 1.25rem; color: #cbd5e1;">${formattedExpected}</div>
            </div>
            
            <div class="total-row" style="margin-top: 5px; padding-top: 15px;">
                <div class="total-label">Pending Amount</div>
                <div class="total-amount">${formattedTotal}</div>
            </div>
            
            <form action="{{ route('accountant.storePayment') }}" method="POST" id="paymentForm" onsubmit="document.getElementById('submitBtn').innerHTML = '<i class=\\'fa fa-spinner fa-spin\\'></i> Processing...'; document.getElementById('submitBtn').disabled = true;">
                @csrf
                <input type="hidden" name="user_id" value="${student.user_id}">
                <input type="hidden" name="amount" value="${student.pending_amount}">
                <input type="hidden" name="type" value="{{ request('type', 'admission') }}">
                
                <div class="record-payment-box">
                    <div class="box-title">
                        <i class="fa fa-money-bill-transfer"></i> Record Payment
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">PAYMENT MODE</label>
                            <select class="form-select" name="payment_mode">
                                <option value="Bank Transfer">Bank Transfer / NEFT</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI / Online</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">TRANSACTION ID / REFERENCE</label>
                            <input type="text" class="form-control" name="transaction_id" placeholder="Enter reference number" required>
                        </div>
                    </div>
                    
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fa fa-print"></i> Save & Generate Receipt
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="compliance-alert" style="margin-bottom: 20px;">
                <i class="fa fa-check-circle"></i>
                <div class="compliance-alert-content">
                    <h6>Accounting Policy Compliance</h6>
                    <p>Receipts generated are official documents. Ensure transaction IDs are verified against bank statements before final confirmation.</p>
                </div>
            </div>
        `;
    }

    window.onload = () => {
        if(studentsData && studentsData.length > 0) {
            renderBillingPanel(studentsData[0]);
        }
    };
</script>
</body>
</html>
