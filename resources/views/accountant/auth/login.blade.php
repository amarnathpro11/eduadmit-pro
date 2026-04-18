<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accountant Login | EduAdmit Pro</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: white;
        }

        .container-fluid {
            height: 100vh;
        }

        .left-panel {
            background: radial-gradient(circle, #0b1220, #020617);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }

        .brand-title {
            font-size: 42px;
            font-weight: 700;
        }

        .brand-title span {
            color: #10b981;
            /* Green color for accountant/money */
        }

        .panel-card {
            background: rgba(15, 23, 42, 0.6);
            padding: 18px;
            border-radius: 14px;
            margin-bottom: 18px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .right-panel {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 420px;
        }

        .form-control {
            background: #020617;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
        }

        .form-control:focus {
            background: #020617;
            box-shadow: none;
            border-color: #10b981;
            color: white;
        }

        .btn-success {
            background: #10b981;
            border: none;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .muted {
            color: #94a3b8;
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: #10b981;
        }

        /* Error / Success boxes */
        .login-error-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-left: 3px solid #ef4444;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            margin-bottom: 1rem;
            animation: shake 0.45s ease;
        }

        .login-error-icon {
            color: #ef4444;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .login-error-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .login-error-title {
            margin: 0;
            font-size: 0.85rem;
            font-weight: 600;
            color: #ef4444;
        }

        .login-error-msg {
            margin: 0;
            font-size: 0.82rem;
            color: #fca5a5;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .left-panel {
                display: none !important;
            }

            .right-panel {
                flex: 0 0 100%;
                width: 100%;
                padding: 2rem;
            }

            .container-fluid {
                height: auto;
                min-height: 100vh;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            {{-- Left side --}}
            <div class="col-md-6 left-panel d-flex">
                <div class="brand-title">
                    Edu<span>Admit</span> Pro
                </div>
                <div class="muted mb-4">Accountant Portal</div>

                <div class="panel-card">
                    💰 <strong>Billing & Fee Management</strong><br>
                    <span class="muted">Generate invoices and track student feed</span>
                </div>

                <div class="panel-card">
                    💳 <strong>Online Payments</strong><br>
                    <span class="muted">Verify and approve student transaction records</span>
                </div>

                <div class="panel-card">
                    📊 <strong>Financial Reports</strong><br>
                    <span class="muted">Access daily, monthly and yearly revenue stats</span>
                </div>

                <div class="panel-card">
                    🎓 <strong>Student Dues</strong><br>
                    <span class="muted">Monitor pending balances and overdue payments</span>
                </div>

            </div>
            {{-- Right side --}}
            <div class="col-md-6 right-panel">
                <div class="login-box">
                    <div class="mb-3">
                        <a href="/">← Back to role selection</a>
                    </div>

                    <h3 id="formTitle">Welcome, Accountant 👋</h3>
                    <div class="muted mb-4" id="formSubtitle">Sign in to access the Accountant dashboard
                    </div>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="login-error-box">
                            <div class="login-error-icon">
                                <i class="bi bi-shield-x fs-5"></i>
                            </div>
                            <div class="login-error-content">
                                <p class="login-error-title">Login Failed</p>
                                <p class="login-error-msg">{{ $errors->first() }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Session flash --}}
                    @if (session('error'))
                        <div class="login-error-box">
                            <div class="login-error-icon">
                                <i class="bi bi-exclamation-circle fs-5"></i>
                            </div>
                            <div class="login-error-content">
                                <p class="login-error-title">Access Denied</p>
                                <p class="login-error-msg">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form id="signinForm" action="{{ route('accountant.login.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="muted" for="email">Email Address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-2 position-relative">
                            <label class="muted">Password</label>

                            <input type="password" name="password" id="password" class="form-control pe-5" required>

                            <span id="togglePassword" class="bi bi-eye"
                                style="position:absolute; right:15px; top:38px; cursor:pointer; color:#94a3b8;">
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center gap-2">
                                <input type="checkbox" name="remember" id="remember">
                                <span class="muted">Remember me</span>
                            </div>
                            <a href="{{ route('admin.password.request') }}">Forget Password?</a>
                        </div>
                        <button class="btn btn-success w-100">Sign In &rarr;</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordField = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const isHidden = passwordField.type === "password";
            passwordField.type = isHidden ? "text" : "password";
            togglePassword.classList.toggle("bi-eye");
            togglePassword.classList.toggle("bi-eye-slash");
        });
    </script>
</body>

</html>
