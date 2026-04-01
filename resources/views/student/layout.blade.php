<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal | EduAdmit Pro</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg-body: radial-gradient(circle at top, #0f172a 0%, #020617 100%);
            --bg-card: rgba(255, 255, 255, 0.05);
            --bg-sidebar: #0f172a;
            --accent-primary: #6366f1;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --text-main: #ffffff;
            --text-muted: rgba(255, 255, 255, 0.6);
            --border-color: rgba(255, 255, 255, 0.1);
            --sidebar-width: 280px;
        }

        html,
        body {
            background-color: #020617 !important;
            background-image: var(--bg-body) !important;
            background-attachment: fixed !important;
            color: var(--text-main) !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Force Select/Input Visibility */
        select,
        input,
        textarea {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: #ffffff !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
            opacity: 1;
        }

        ::-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.4) !important;
        }

        option {
            background-color: #0f172a !important;
            color: #ffffff !important;
        }
    </style>

    <style>
        /* Component Styles */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--bg-sidebar);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
            z-index: 1050;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 3rem;
            text-decoration: none;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .sidebar-btn-logout {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            width: 100%;
            padding: 0.75rem;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: auto;
            margin-bottom: 1rem;
            transition: all 0.2s;
        }

        .sidebar-btn-logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .menu-label {
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            margin-bottom: 1.25rem;
            display: block;
            padding-left: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: var(--text-muted);
            text-decoration: none;
            padding: 0.85rem 1rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
            font-weight: 500;
        }

        .nav-link i {
            width: 20px;
            height: 20px;
            stroke-width: 2px;
        }

        .nav-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            font-weight: 600;
        }

        /* Main Content & Top Nav */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            min-height: 100vh;
            background: transparent !important;
            transition: all 0.3s ease;
        }

        .top-nav {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            background-color: transparent;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .page-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: #ffffff;
            margin: 0;
        }

        .top-nav-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.6rem 1rem 0.6rem 2.8rem;
            color: #ffffff;
            width: 300px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .search-input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #6366f1;
        }

        .search-container i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.4);
            pointer-events: none;
            width: 18px;
        }

        .icon-btn {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.6);
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: all 0.2s;
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 8px;
            right: 8px;
            border: 2px solid white;
        }

        .user-profile-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.4rem 0.5rem 0.4rem 1rem;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .user-profile-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: #ffffff;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #ffffff;
            font-size: 0.85rem;
        }

        .content-area {
            padding: 0 2.5rem 2.5rem 2.5rem;
            background: transparent !important;
        }

        /* Generic Card Styling */
        .premium-card {
            background-color: var(--bg-card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .premium-card:hover {
            border-color: rgba(99, 102, 241, 0.3);
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.5);
        }

        .section-header {
            font-family: 'Outfit', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #ffffff;
        }

        /* Form Styling */
        .form-label-custom {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.6rem;
        }

        .form-control-premium {
            background-color: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            color: #ffffff;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-control-premium:focus {
            background-color: rgba(255, 255, 255, 0.06);
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle-btn {
            display: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 1040;
        }

        @media (max-width: 992px) {
            .sidebar {
                left: calc(var(--sidebar-width) * -1);
            }
            .sidebar.active {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-toggle-btn {
                display: flex;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .search-input {
                width: 150px;
            }
            .top-nav {
                padding: 0 1.5rem;
            }
            .content-area {
                padding: 0 1.5rem 1.5rem 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .search-container {
                display: none;
            }
            .page-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body
    style="background-color: #020617 !important; background-image: radial-gradient(circle at top, #0f172a 0%, #020617 100%) !important; background-attachment: fixed !important; min-height: 100vh;">

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="sidebar" id="sidebar">
        <a href="{{ route('student.dashboard') }}" class="sidebar-brand">
            <div class="brand-logo">
                <i data-lucide="graduation-cap"></i>
            </div>
            <span class="brand-name">EduAdmit</span>
        </a>

        <form method="POST" action="{{ route('student.logout') }}">
            @csrf
            <button class="sidebar-btn-logout">
                <i data-lucide="power" style="width: 16px;"></i>
                Logout
            </button>
        </form>

        <span class="menu-label">My Application</span>
        <a href="{{ route('student.dashboard') }}"
            class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
            <i data-lucide="file-text"></i>
            Registration
        </a>
        <a href="{{ route('student.status') }}"
            class="nav-link {{ request()->routeIs('student.status') ? 'active' : '' }}">
            <i data-lucide="refresh-cw"></i>
            Status
        </a>
        <a href="{{ route('student.documents') }}"
            class="nav-link {{ request()->routeIs('student.documents') ? 'active' : '' }}">
            <i data-lucide="paperclip"></i>
            Documents
        </a>

        <div class="mt-4">
            <span class="menu-label">Payments</span>
            <a href="{{ route('student.payment') }}"
                class="nav-link {{ request()->routeIs('student.payment') ? 'active' : '' }}">
                <i data-lucide="credit-card"></i>
                Fee Payment
            </a>
            <a href="{{ route('student.receipts') }}"
                class="nav-link {{ request()->routeIs('student.receipts') ? 'active' : '' }}">
                <i data-lucide="file-down"></i>
                Receipts
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="top-nav">
            <div class="d-flex align-items-center">
                <button class="sidebar-toggle-btn" id="sidebarToggle">
                    <i data-lucide="menu"></i>
                </button>
                <h2 class="page-title">@yield('page_title', 'Dashboard')</h2>
            </div>

            <div class="top-nav-right">
                <form id="quickSearchForm" action="{{ route('student.status') }}" method="GET"
                    class="search-container">
                    <i data-lucide="search"></i>
                    <input type="text" id="quickSearchInput" name="search" class="search-input"
                        placeholder="Search...">
                </form>

                <div class="user-profile-btn">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::guard('student')->user()->name, 0, 1)) }}
                    </div>
                    <div class="d-none d-md-block">
                        <div class="user-name">{{ Auth::guard('student')->user()->name }}</div>
                    </div>
                    <i data-lucide="chevron-down" style="width: 16px; color: var(--text-muted);"></i>
                </div>
            </div>
        </div>

        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Responsive Sidebar Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
            });
        }

        // Close sidebar on link click (mobile)
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 992) {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                }
            });
        });

        // Smart Search / Quick Navigation Logic
        document.getElementById('quickSearchForm').addEventListener('submit', function(e) {
            const query = document.getElementById('quickSearchInput').value.toLowerCase().trim();

            const routes = {
                'payment': ['payment', 'fee', 'pay', 'transaction'],
                'receipts': ['receipt', 'bill', 'receipts', 'invoice'],
                'documents': ['document', 'upload', 'id', 'photo', 'marksheet', 'upload', 'doc'],
                'status': ['status', 'track', 'progress', 'journey'],
                'dashboard': ['register', 'profile', 'personal', 'details', 'application', 'edit', 'home']
            };

            const urlMap = {
                'payment': "{{ route('student.payment') }}",
                'receipts': "{{ route('student.receipts') }}",
                'documents': "{{ route('student.documents') }}",
                'status': "{{ route('student.status') }}",
                'dashboard': "{{ route('student.dashboard') }}"
            };

            for (const [route, keywords] of Object.entries(routes)) {
                if (keywords.some(k => query.includes(k))) {
                    e.preventDefault();
                    window.location.href = urlMap[route];
                    return;
                }
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
