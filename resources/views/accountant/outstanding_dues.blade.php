<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EduFinance Portal - Outstanding Dues</title>
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
        .portal-layout { display: flex; min-height: 100vh; }
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
            display: flex; align-items: center; font-weight: 800; font-size: 1.15rem; color: #ffffff;
            margin-bottom: 2.5rem; text-decoration: none; padding: 0 8px;
        }
        .brand-icon {
            width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center;
            margin-right: 12px; font-size: 1rem; box-shadow: 0 4px 10px rgba(59,130,246,0.3);
        }
        .brand-text span { color: #3b82f6; }
        .nav-item {
            display: flex; align-items: center; padding: 12px 16px; color: #94a3b8;
            text-decoration: none; font-weight: 500; font-size: 0.9rem; border-radius: 10px;
            margin-bottom: 8px; transition: all 0.3s ease;
        }
        .nav-item i { margin-right: 14px; font-size: 1.1rem; width: 20px; text-align: center; opacity: 0.8; }
        .nav-item:hover { color: #ffffff; background: rgba(255,255,255,0.05); transform: translateX(4px); }
        .nav-item.active { background: linear-gradient(135deg, #3b82f6, #1d4ed8); color: #ffffff; box-shadow: 0 4px 15px rgba(59,130,246,0.3); font-weight: 600; }
        
        .main-content { flex: 1; padding: 0 40px 40px 40px; overflow-x: hidden; display: flex; flex-direction: column; }
        .top-header { display: flex; justify-content: space-between; align-items: flex-end; padding: 24px 0 0 0; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 32px; }
        .header-tabs { display: flex; gap: 32px; }
        .header-tab { color: #94a3b8; text-decoration: none; font-weight: 500; font-size: 0.95rem; padding-bottom: 16px; margin-bottom: -1px; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .header-tab.active { color: #3b82f6; border-bottom-color: #3b82f6; font-weight: 600; }
        .header-actions { display: flex; align-items: center; gap: 20px; padding-bottom: 12px; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #3b82f6; box-shadow: 0 0 10px rgba(59,130,246,0.5); }
        
        .panel { background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 18px; box-shadow: 0 15px 35px rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.05); padding: 24px; }
        .panel-title { font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 24px; display: flex; align-items: center; gap: 12px; }
        .panel-title i { color: #ef4444; }

        .table-custom { color: #e2e8f0; width: 100%; border-collapse: separate; border-spacing: 0 8px; }
        .table-custom th { color: #94a3b8; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px 16px; border: none; }
        .table-custom td { padding: 16px; background: rgba(255,255,255,0.02); border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
        .table-custom tr td:first-child { border-left: 1px solid rgba(255,255,255,0.05); border-radius: 12px 0 0 12px; }
        .table-custom tr td:last-child { border-right: 1px solid rgba(255,255,255,0.05); border-radius: 0 12px 12px 0; }
        .table-custom tr:hover td { background: rgba(255,255,255,0.04); }
        
        .logout-btn { margin-top: auto; color: #ef4444; text-decoration: none; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; padding: 12px 16px; border-radius: 10px; transition: 0.2s; border: 1px solid rgba(239, 68, 68, 0.1); background: rgba(239, 68, 68, 0.05); }
        .logout-btn:hover { background: rgba(239, 68, 68, 0.15); color: #f87171; }
        .metric-card {
            background: linear-gradient(145deg, #1e293b, #0f172a); border-radius: 16px; padding: 24px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

<div class="portal-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="brand">
            <div class="brand-icon"><i class="fa fa-wallet"></i></div>
            <span class="brand-text">Edu<span>Admit</span> Pro</span>
        </a>
        <a href="{{ route('accountant.dashboard', ['type' => 'admission']) }}" class="nav-item">
            <i class="fa fa-file-invoice"></i> Admission Billing
        </a>
        <a href="{{ route('accountant.dashboard', ['type' => 'application']) }}" class="nav-item">
            <i class="fa fa-receipt"></i> Application Fees
        </a>
        <a href="{{ route('accountant.payment_history') }}" class="nav-item">
            <i class="fa fa-clock-rotate-left"></i> Payment History
        </a>
        <a href="{{ route('accountant.outstanding_dues') }}" class="nav-item active">
            <i class="fa fa-clipboard-list"></i> Outstanding Dues
        </a>
        <a href="{{ route('accountant.collections_analytics') }}" class="nav-item">
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
        <div class="top-header">
            <div class="header-tabs">
                <a href="{{ route('accountant.outstanding_dues') }}" class="header-tab active">Outstanding Dues</a>
            </div>
            <div class="header-actions">
                <div class="d-flex align-items-center">
                    <div class="text-end me-3 d-none d-md-block">
                        <div class="fw-bold text-white mb-0" style="font-size: 0.85rem">{{ auth()->user()->name }}</div>
                        <div class="text-secondary" style="font-size: 0.7rem">Accountant Portal</div>
                    </div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" class="user-avatar">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="metric-card">
                    <div class="text-secondary small fw-bold mb-2">TOTAL OUTSTANDING</div>
                    <h2 class="text-danger fw-bold mb-0">₹{{ number_format($totalOutstanding, 2) }}</h2>
                </div>
            </div>
        </div>

        <div class="panel flex-grow-1">
            <h4 class="panel-title"><i class="fa fa-exclamation-triangle"></i> Pending Payments by Students</h4>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Student & App No.</th>
                            <th>Course</th>
                            <th>Contact</th>
                            <th>Pending Application</th>
                            <th>Pending Admission</th>
                            <th class="text-end">Total Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($outstandingList as $due)
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $due->name }}</div>
                                <div class="text-secondary" style="font-size: 0.8rem;">{{ $due->application_no }}</div>
                            </td>
                            <td>{{ $due->course_name }}</td>
                            <td>{{ $due->contact }}</td>
                            <td><span class="{{ $due->pending_application > 0 ? 'text-warning' : 'text-success' }}">₹{{ number_format($due->pending_application, 2) }}</span></td>
                            <td><span class="{{ $due->pending_admission > 0 ? 'text-danger' : 'text-success' }}">₹{{ number_format($due->pending_admission, 2) }}</span></td>
                            <td class="text-end fw-bold text-danger">₹{{ number_format($due->total_pending, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i class="fa fa-check-circle fs-1 text-success mb-3"></i>
                                <h5>No Outstanding Dues!</h5>
                                <p>All active applications have completed their necessary payments.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
