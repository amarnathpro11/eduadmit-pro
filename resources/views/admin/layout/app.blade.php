<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #0f172a;
            min-height: 100vh;
            padding: 25px 15px;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar h4 {
            font-weight: 800;
            margin-bottom: 20px;
            color: #ffffff;
            padding-left: 15px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 18px;
            margin: 5px 0;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.6) !important;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff !important;
            transform: translateX(5px);
        }

        .sidebar a.active {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
        }

        .sidebar hr {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 20px 0;
        }

        .main {
            flex: 1;
            padding: 0 35px 20px 35px;
            background: radial-gradient(circle at top, #0f172a, #020617);
            min-height: 100vh;
            position: relative;
            width: 100%;
            transition: all 0.3s ease;
        }

        /* Topbar Alignment Fix */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding-top: 15px;
            flex-wrap: wrap;
        }

        @media (max-width: 576px) {
            .topbar .search-container {
                display: none !important;
            }
        }

        /* Mobile Toggle */
        .sidebar-toggle {
            display: none;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            z-index: 1100;
        }

        /* Cards & Components */

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .topbar input {
            border-radius: 15px;
            padding: 14px 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .topbar input:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            border-color: #6366f1;
            outline: none;
        }

        .topbar button {
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            white-space: nowrap;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(6px);
            border-radius: 18px;
            padding: 22px;
            color: #fff;
            transition: 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .card-title {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
        }

        .dark-stat-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
        }

        .course-overlay {
            position: fixed;
            inset: 0;
            backdrop-filter: blur(8px);
            background: rgba(0, 0, 0, 0.6);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
        }

        .course-modal {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s ease;
        }

        .course-modal-content {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            padding: 35px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
            transform: scale(0.9);
            transition: 0.3s ease;
        }

        .course-modal input,
        .course-modal select {
            width: 100%;
            margin-bottom: 15px;
            padding: 12px;
            border-radius: 10px;
            border: none;
            background: #0f172a;
            color: white;
        }

        .course-modal input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #2563eb;
        }

        .btn-save-course {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            background: #2563eb;
            border: none;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-save-course:hover {
            background: #1d4ed8;
        }

        .course-overlay.active,
        .course-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .course-modal.active .course-modal-content {
            transform: scale(1);
        }

        .dark-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: .3s;
        }

        .dark-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
        }

        .dark-input {
            background: #0f172a;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
        }

        .dark-input:focus {
            background: #0f172a;
            color: white;
            border-color: #2563eb;
            box-shadow: none;
        }

        /* User Dropdown Premium Styling */
        .dropdown-menu {
            background: #ffffff !important;
            border: none !important;
            border-radius: 15px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2) !important;
            padding: 8px !important;
            min-width: 200px !important;
            margin-top: 10px !important;
        }

        .dropdown-item {
            border-radius: 10px !important;
            padding: 10px 16px !important;
            color: #334155 !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
        }

        .dropdown-item:hover {
            background: #f1f5f9 !important;
            color: #6366f1 !important;
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 10px;
            opacity: 0.7;
        }

        .dropdown-divider {
            border-color: #f1f5f9 !important;
            margin: 8px 0 !important;
        }

        .logout-btn {
            color: #1e293b !important;
            font-weight: 700 !important;
        }

        .logout-btn:hover {
            background: #fef2f2 !important;
            color: #ef4444 !important;
        }

        .user-profile-btn:hover {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
        }

        .dropdown-toggle::after {
            display: none;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -260px;
                height: 100vh;
                top: 0;
            }

            .sidebar.show {
                left: 0;
            }

            .main {
                padding: 0 15px 20px 15px;
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 1040;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 576px) {
            .topbar {
                flex-wrap: wrap;
            }
            .user-profile-btn span {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="wrapper">
        {{-- Sidebar --}}
        <div class="sidebar" id="sidebar">
            <h4 class="mb-4"><i class="fa fa-university me-2 text-primary"></i> Admin Central</h4>
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.leads.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.leads.index') ? 'active' : '' }}">
                <i class="fa fa-user"></i> Leads
            </a>
            <a href="{{ route('admin.leads.assignment') }}"
                class="nav-link-item {{ request()->routeIs('admin.leads.assignment') ? 'active' : '' }}">
                <i class="fa fa-user-plus"></i> Lead Assignment
            </a>
            <a href="{{ route('admin.follow_ups.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.follow_ups.index') ? 'active' : '' }}">
                <i class="fa fa-calendar-check"></i> Follow-ups
            </a>
            <a href="{{ route('admin.verification.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.verification.*') ? 'active' : '' }}"><i
                    class="fa fa-file-invoice"></i> Verification</a>
            <a href="{{ route('admin.departments.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}"><i
                    class="fa fa-layer-group"></i> Courses & Depts</a>
            <a href="{{ route('admin.merit_list.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.merit_list.*') ? 'active' : '' }}"><i
                    class="fa fa-medal"></i> Merit List</a>
            <a href="{{ route('admin.final_admission.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.final_admission.*') ? 'active' : '' }}"><i
                    class="fa fa-graduation-cap"></i> Final Admission</a>
            <a href="{{ route('admin.users.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"><i
                    class="fa fa-users"></i> User Management</a>
            <hr>
            <a href="{{ route('admin.rules.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.rules.*') ? 'active' : '' }}"><i
                    class="fa fa-cog"></i> Admission Rules</a>
            <a href="{{ route('admin.reports.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i
                    class="fa fa-file"></i> Reports & Logs</a>
            <a href="{{ route('admin.billing.index') }}"
                class="nav-link-item {{ request()->routeIs('admin.billing.*') ? 'active' : '' }}"><i
                    class="fa fa-wallet border-0 rounded"></i> Finance & Billing</a>

            <div style="margin-top: auto; padding-top: 20px;">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link-item w-100 border-0 bg-transparent text-start text-danger"
                        style="margin:0; padding: 12px 18px;">
                        <i class="fa fa-sign-out-alt text-danger"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        {{-- Main content --}}
        <div class="main">
            {{-- Topbar --}}
            <div class="topbar mb-4">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fa fa-bars"></i>
                </button>

                {{-- User Profile --}}
                <div class="dropdown ms-auto">
                    <a class="user-profile-btn d-flex align-items-center text-white text-decoration-none dropdown-toggle px-3 py-2 rounded-pill" 
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" 
                       style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); transition: 0.2s;">
                        <div class="avatar-placeholder me-2 d-flex align-items-center justify-content-center rounded-circle text-white fw-bold"
                            style="width: 32px; height: 32px; font-size: 0.8rem; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="fw-semibold me-1">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <i class="fa fa-chevron-down ms-1" style="font-size: 0.7rem; opacity: 0.7;"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                <i class="fa fa-user-circle"></i> Profile
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.settings') }}">
                                <i class="fa fa-cog"></i> Settings
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="fa fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            {{-- Page content --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
                    style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert"
                    style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="container-fluid px-0">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar Toggle Logic
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }

            const navLinks = document.querySelectorAll('.nav-link-item');

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (this.getAttribute('href') === '#') {
                        e.preventDefault();
                        navLinks.forEach(l => l.classList.remove('active'));
                        this.classList.add('active');
                    }
                    
                    // Close sidebar on mobile after clicking a link
                    if (window.innerWidth <= 992) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                });
            });

            // Real-time Update Simulation
            function updateBadges() {
                // This is where you would normally make an AJAX call or listen to a WebSocket
            }

            updateBadges();
            setInterval(updateBadges, 60000);
        });
    </script>
</body>

</html>
