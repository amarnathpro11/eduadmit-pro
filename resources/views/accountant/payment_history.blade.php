<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduFinance Portal - Payment History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
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

        .main-content {
            flex: 1;
            padding: 0 40px 40px 40px;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

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

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3b82f6;
            box-shadow: 0 0 10px rgba(59,130,246,0.5);
        }

        .panel {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 24px;
        }

        .filter-input {
            background: rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.9rem;
            color: #e2e8f0;
            font-weight: 400;
        }
        
        .filter-input::placeholder {
            color: #64748b;
        }
        
        .filter-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
        }

        .table {
            color: #e2e8f0;
        }

        .table thead th {
            border-bottom: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-bottom: 16px;
        }

        .table tbody td {
            border-bottom: 1px solid rgba(255,255,255,0.03);
            vertical-align: middle;
            padding: 16px 10px;
        }

        .table tbody tr:hover {
            background: rgba(255,255,255,0.02);
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

        .badge-success { background: rgba(16, 185, 129, 0.1); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.2); padding: 4px 8px; border-radius: 6px; font-weight:600; font-size:0.75rem; }
        .badge-warning { background: rgba(245, 158, 11, 0.1); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.2); padding: 4px 8px; border-radius: 6px; font-weight:600; font-size:0.75rem; }
        .badge-danger { background: rgba(239, 68, 68, 0.1); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.2); padding: 4px 8px; border-radius: 6px; font-weight:600; font-size:0.75rem; }

        .pagination {
            margin-bottom: 0;
        }

        .page-item.active .page-link {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .page-link {
            background: #1e293b;
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
        }

        .page-link:hover {
            background: #334155;
            border-color: rgba(255,255,255,0.2);
            color: #fff;
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

        <a href="{{ route('accountant.dashboard', ['type' => 'admission']) }}" class="nav-item">
            <i class="fa fa-file-invoice"></i> Admission Billing
        </a>
        <a href="{{ route('accountant.dashboard', ['type' => 'application']) }}" class="nav-item">
            <i class="fa fa-receipt"></i> Application Fees
        </a>
        <a href="{{ route('accountant.payment_history') }}" class="nav-item active">
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
        <!-- Top Header -->
        <div class="top-header">
            <div class="header-tabs">
                <a href="{{ route('accountant.dashboard', ['type' => 'admission']) }}" class="header-tab">Dashboard</a>
                <a href="{{ route('accountant.payment_history') }}" class="header-tab active">All History</a>
                <a href="{{ route('accountant.exportReport') }}" class="header-tab"><i class="fa fa-file-pdf text-danger me-1"></i> Export Report</a>
            </div>
            
            <div class="header-actions">
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.85rem">{{ auth()->user()->name ?? 'Accountant' }}</div>
                        <div class="text-secondary" style="font-size: 0.7rem">Accountant Portal</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Accountant') }}&background=3b82f6&color=fff" alt="User" class="user-avatar">
                </div>
            </div>
        </div>

        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: rgba(255,255,255,0.05)!important">
                <h4 class="mb-0 text-white fw-bold"><i class="fa fa-clock-rotate-left text-primary me-2"></i> Payment History</h4>
            </div>

            <form action="{{ route('accountant.payment_history') }}" method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control filter-input w-100" placeholder="Search by name, email, or TXN ID" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select filter-input w-100" style="background-color: transparent">
                        <option value="" style="color:#000;">All Fee Types</option>
                        <option value="admission" {{ request('type') == 'admission' ? 'selected' : '' }} style="color:#000;">Admission Fees</option>
                        <option value="application" {{ request('type') == 'application' ? 'selected' : '' }} style="color:#000;">Application Fees</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select filter-input w-100" style="background-color: transparent">
                        <option value="" style="color:#000;">All Statuses</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }} style="color:#000;">Success</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }} style="color:#000;">Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }} style="color:#000;">Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); border: none; padding: 10px; border-radius: 10px;">
                        <i class="fa fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-borderless table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Student</th>
                            <th>Fee Type</th>
                            <th>Amount</th>
                            <th>Mode</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td><span style="color: #94a3b8; font-family: monospace;">{{ $payment->transaction_id }}</span></td>
                            <td>
                                @if($payment->user)
                                <div class="fw-bold">{{ $payment->user->name }}</div>
                                <div style="font-size: 0.75rem; color: #64748b;">{{ $payment->user->email }}</div>
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                                @if($payment->application && $payment->application->course)
                                <div style="font-size: 0.75rem; color: #3b82f6;">{{ $payment->application->course->name }}</div>
                                @endif
                            </td>
                            <td>
                                @if($payment->payment_type == 'admission')
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 py-1 px-2">Admission</span>
                                @elseif($payment->payment_type == 'application')
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-10 py-1 px-2">Application</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 py-1 px-2">General</span>
                                @endif
                            </td>
                            <td class="fw-bold fs-6">₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span style="font-size: 0.85rem; color: #cbd5e1;">{{ strtoupper($payment->payment_mode) ?? 'ONLINE' }}</span>
                            </td>
                            <td style="font-size: 0.85rem; color: #94a3b8;">
                                {{ $payment->created_at->format('M d, Y h:i A') }}
                            </td>
                            <td>
                                @if($payment->status == 'success')
                                    <span class="badge-success"><i class="fa fa-check-circle me-1"></i>Success</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge-warning"><i class="fa fa-clock me-1"></i>Pending</span>
                                @else
                                    <span class="badge-danger"><i class="fa fa-times-circle me-1"></i>Failed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa fa-receipt fa-3x mb-3" style="opacity: 0.3;"></i>
                                <h5>No Payments Found</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-end">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
