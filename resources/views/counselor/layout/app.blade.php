<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Counselytics Portal - EduAdmit Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --bg-body: #020617;
            --bg-sidebar: #0f172a;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: rgba(255,255,255,0.08);
            --card-bg: linear-gradient(145deg, #1e293b, #0f172a);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: var(--text-main); 
            min-height: 100vh; 
            margin: 0; 
        }

        .portal-layout { display: flex; min-height: 100vh; }
        
        .sidebar { 
            width: 250px; 
            background: var(--bg-sidebar); 
            border-right: 1px solid var(--border-color); 
            padding: 24px 16px; 
            display: flex; 
            flex-direction: column; 
            position: sticky; 
            top: 0; 
            height: 100vh; 
            z-index: 100;
        }

        .brand { 
            display: flex; 
            align-items: center; 
            font-weight: 800; 
            font-size: 1.25rem; 
            color: var(--text-main); 
            text-decoration: none; 
            margin-bottom: 2.5rem; 
            padding: 0 8px; 
        }

        .brand-icon { 
            width: 30px; 
            height: 30px; 
            background: var(--primary); 
            color: white; 
            border-radius: 8px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-right: 12px;
            font-size: 14px;
        }

        .nav-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0 10px 10px;
        }

        .nav-item { 
            display: flex; 
            align-items: center; 
            padding: 10px 16px; 
            color: var(--text-muted); 
            text-decoration: none; 
            font-weight: 500; 
            border-radius: 8px; 
            margin-bottom: 4px; 
            font-size: 0.9rem;
            transition: 0.2s; 
        }

        .nav-item i { 
            margin-right: 14px; 
            font-size: 1.1rem; 
            width: 20px; 
            text-align: center; 
        }

        .nav-item:hover { 
            background: rgba(255,255,255,0.05); 
            color: var(--text-main); 
        }

        .nav-item.active { 
            background: rgba(59, 130, 246, 0.15); 
            color: var(--primary); 
            font-weight: 600;
        }

        .user-profile-bottom {
            margin-top: auto;
            display: flex;
            align-items: center;
            padding: 12px 10px;
            border-top: 1px solid var(--border-color);
        }

        .user-profile-bottom img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-profile-bottom .name {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-main);
            margin: 0;
        }

        .user-profile-bottom .role {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin: 0;
        }

        .main-content { 
            flex: 1; 
            padding: 24px 32px; 
            overflow-x: hidden; 
        }

        .top-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 24px; 
        }

        .page-title h4 {
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
            color: var(--text-main);
        }

        .page-title p {
            margin: 4px 0 0 0;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .header-actions select {
            background-color: var(--bg-sidebar) !important;
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }

        .btn-call {
            background: var(--primary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-call:hover {
            background: var(--primary-hover);
            color: white;
        }

        .bell-icon {
            width: 36px;
            height: 36px;
            background: var(--bg-sidebar);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            position: relative;
            cursor: pointer;
        }

        .bell-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 6px;
            height: 6px;
            background: #ef4444;
            border-radius: 50%;
        }

        /* Generic Card Styling */
        .white-card { 
            background: var(--card-bg); 
            border-radius: 12px; 
            padding: 24px; 
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        }
        
        /* General form dark styling */
        .form-control, .form-select {
            background-color: rgba(0,0,0,0.2) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: rgba(0,0,0,0.4) !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2) !important;
        }
        ::placeholder { color: rgba(255,255,255,0.4) !important; }

    </style>
</head>
<body>
<div class="portal-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="{{ route('counselor.dashboard') }}" class="brand">
            <div class="brand-icon"><i class="fa fa-chart-line"></i></div>
            <span>Counselytics</span>
        </a>
        
        <a href="{{ route('counselor.dashboard') }}" class="nav-item {{ request()->routeIs('counselor.dashboard') ? 'active' : '' }}">
            <i class="fa fa-border-all"></i> Dashboard
        </a>
        <a href="{{ route('counselor.leads.index') }}" class="nav-item {{ request()->routeIs('counselor.leads.*') && !request()->routeIs('counselor.leads.show') ? 'active' : '' }}">
            <i class="fa fa-users"></i> Lead Pool
        </a>
        <a href="{{ route('counselor.leads.schedule') }}" class="nav-item {{ request()->routeIs('counselor.leads.schedule') ? 'active' : '' }}">
            <i class="fa fa-calendar-check"></i> Master Schedule
        </a>

        
        <div class="user-profile-bottom mt-auto position-relative">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=3b82f6&color=fff" alt="Avatar">
            <div>
                <p class="name">{{ auth()->user()->name }}</p>
                <p class="role">Senior Counselor</p>
            </div>
            
            <form action="{{ route('counselor.logout') }}" method="POST" class="position-absolute" style="right: 10px; top: 18px;">
                @csrf
                <button type="submit" class="btn btn-link py-0 px-2 m-0 border-0 fs-5" style="color: #ef4444;"><i class="fa fa-sign-out-alt"></i></button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-header">
            <div class="page-title">
                <h4>@yield('page_title', 'Counselor Performance')</h4>
                <p>@yield('page_subtitle', 'Personal Lead Conversion Insights')</p>
            </div>
            <div class="header-actions">
                <select class="form-select form-select-sm shadow-sm" style="width: auto; font-weight: 500; font-size: 0.85rem;">
                    <option>This Month ({{ date('M Y') }})</option>
                    <option>Last Month</option>
                </select>
                @php
                    // 1. Try to find the most urgent scheduled follow-up
                    $nextTask = \App\Models\FollowUp::where('user_id', auth()->id())
                        ->where('status', 'scheduled')
                        ->orderBy('scheduled_at', 'asc')
                        ->first();
                    
                    $targetLeadId = $nextTask ? $nextTask->lead_id : null;
                    $buttonLabel = "Start Next Call";

                    // 2. If no scheduled tasks, find the freshest "New" lead assigned to them
                    if (!$targetLeadId) {
                        $newLead = \App\Models\Lead::where('assigned_to', auth()->id())
                            ->where('status', 'New')
                            ->orderBy('created_at', 'desc')
                            ->first();
                        
                        if ($newLead) {
                            $targetLeadId = $newLead->id;
                            $buttonLabel = "Contact New Lead";
                        }
                    }
                @endphp
                @if($targetLeadId)
                    <a href="{{ route('counselor.leads.show', $targetLeadId) }}" class="btn-call text-decoration-none shadow-sm transition-all">
                        <i class="fa fa-phone"></i> {{ $buttonLabel }}
                    </a>
                @else
                    <button class="btn btn-dark btn-sm rounded-3 px-3 fw-bold opacity-50 cursor-not-allowed" disabled>
                        <i class="fa fa-check-circle me-1 text-success"></i> All Caught Up
                    </button>
                @endif


                <div class="bell-icon">
                    <i class="fa fa-bell"></i>
                    <span class="bell-dot"></span>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success bg-success bg-opacity-10 border border-success border-opacity-25 text-success shadow-sm rounded-3 py-3 px-4 d-flex align-items-center gap-3">
                <i class="fa fa-check-circle fs-5"></i> <div class="fw-medium">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger bg-danger bg-opacity-10 border border-danger border-opacity-25 text-danger shadow-sm rounded-3 py-3 px-4 d-flex align-items-center gap-3">
                <i class="fa fa-exclamation-circle fs-5"></i> <div class="fw-medium">{{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>

