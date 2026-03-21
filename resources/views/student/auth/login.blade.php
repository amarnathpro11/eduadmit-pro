<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login | EduAdmit Pro</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;700&display=swap"
        rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg-deep: #0f172a;
            --bg-card: #1e293b;
            --bg-form: #0b0f1a;
            --accent-pink: #ec4899;
            --accent-blue: #3b82f6;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-deep);
            color: #ffffff;
            margin: 0;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Left Side */
        .left-panel {
            flex: 0 0 55%;
            padding: 3.5rem;
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -10%;
            left: -10%;
            width: 50%;
            height: 50%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .brand-section {
            position: relative;
            z-index: 1;
            margin-bottom: 4rem;
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2.5rem, 8vw, 3.5rem);
            font-weight: 700;
            line-height: 1.1;
            margin-bottom: 0.25rem;
        }

        .brand-title span {
            color: var(--accent-blue);
        }

        .brand-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            letter-spacing: 1px;
        }

        .features-list {
            position: relative;
            z-index: 1;
            max-width: 500px;
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .feature-card.active {
            border-color: rgba(139, 92, 246, 0.5);
            background: rgba(139, 92, 246, 0.1);
        }

        .feature-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.25rem;
            color: var(--accent-blue);
        }

        .feature-info h5 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .feature-info p {
            margin: 0;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        /* Right Side */
        .right-panel {
            flex: 0 0 45%;
            background-color: var(--bg-form);
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 3rem;
            transition: all 0.2s;
        }

        .back-link:hover {
            color: var(--accent-blue);
            transform: translateX(-4px);
        }

        .welcome-head h2 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.25rem;
        }

        .welcome-head p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-label {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        .form-control-custom {
            background-color: #1a1f2e;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.75rem 1rem 0.75rem 3rem;
            font-size: 0.9rem;
            color: #ffffff;
            width: 100%;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            background-color: #1e293b;
            border-color: var(--accent-blue);
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-control-custom::placeholder {
            color: #4b5563;
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 0;
            height: 100%;
            width: 3rem;
            color: var(--text-muted);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
            z-index: 10;
        }

        .password-toggle:hover {
            color: var(--accent-blue);
        }

        .form-control-custom {
            padding-right: 3.5rem;
        }

        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .btn-signin {
            background: linear-gradient(90deg, #ec4899 0%, #d946ef 100%);
            border: none;
            border-radius: 10px;
            padding: 0.85rem;
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-signin:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(236, 72, 153, 0.4);
        }

        .forgot-pass {
            color: var(--accent-blue);
            text-decoration: none;
            font-size: 0.9rem;
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
            animation: shake 0.45s ease;
        }

        .login-success-box {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: rgba(16, 185, 129, 0.08);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-left: 3px solid #10b981;
            border-radius: 10px;
            padding: 0.85rem 1rem;
        }

        .login-error-icon {
            color: #ef4444;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .login-success-icon {
            color: #10b981;
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

        @keyframes shake {
            0%   { transform: translateX(0); }
            20%  { transform: translateX(-8px); }
            40%  { transform: translateX(8px); }
            60%  { transform: translateX(-5px); }
            80%  { transform: translateX(5px); }
            100% { transform: translateX(0); }
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                flex: 0 0 100%;
                padding: 2rem;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- Left Panel -->
        <div class="left-panel">
            <div class="brand-section">
                <h1 class="brand-title">EduAdmit<br><span>Pro</span></h1>
                <p class="brand-subtitle">Student Portal</p>
            </div>

            <div class="features-list">
                <div class="feature-card active">
                    <div class="feature-icon">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <div class="feature-info">
                        <h5>Student</h5>
                        <p>Application & payment portal</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="refresh-cw"></i>
                    </div>
                    <div class="feature-info">
                        <h5>Application Status</h5>
                        <p>Track every step from applied to confirmed</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="paperclip"></i>
                    </div>
                    <div class="feature-info">
                        <h5>Document Upload</h5>
                        <p>Upload & manage your required documents</p>
                    </div>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="credit-card"></i>
                    </div>
                    <div class="feature-info">
                        <h5>Fee Payment</h5>
                        <p>Pay fees securely via UPI, card or bank transfer</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel">
            <a href="/" class="back-link">
                <i data-lucide="arrow-left" style="width: 18px;"></i>
                Back to role selection
            </a>

            <div class="welcome-head">
                <h2>Welcome, Student 👋</h2>
                <p>Sign in to track your admission application</p>
            </div>

            @if ($errors->any())
                <div class="login-error-box mb-4" id="loginErrorBox">
                    <div class="login-error-icon">
                        <i data-lucide="shield-x" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="login-error-content">
                        <p class="login-error-title">Login Failed</p>
                        <p class="login-error-msg">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="login-error-box mb-4">
                    <div class="login-error-icon">
                        <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="login-error-content">
                        <p class="login-error-title">Access Denied</p>
                        <p class="login-error-msg">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="login-success-box mb-4">
                    <div class="login-success-icon">
                        <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div class="login-error-content">
                        <p class="login-error-title" style="color:#10b981;">Success</p>
                        <p class="login-error-msg">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('student.login') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Email</label>
                    <div class="input-group-custom">
                        <i data-lucide="mail" style="width: 20px;"></i>
                        <input type="email" name="email" class="form-control-custom" placeholder="Enter your email"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group-custom">
                        <i data-lucide="lock" style="width: 20px;"></i>
                        <input type="password" name="password" id="password" class="form-control-custom"
                            placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" data-toggle-for="password">
                            <i data-lucide="eye" style="width: 20px;"></i>
                        </button>
                    </div>
                </div>

                <div class="form-footer">
                    <label class="remember-me">
                        <input type="checkbox" class="form-check-input"
                            style="background-color: #1a1f2e; border-color: rgba(255,255,255,0.2);">
                        Remember me
                    </label>
                    <a href="{{ route('student.password.request') }}" class="forgot-pass">Forgot password?</a>
                </div>

                <button type="submit" class="btn-signin">
                    Sign In &rarr;
                </button>
            </form>

            <div class="text-center mt-4">
                <p style="color: var(--text-muted); font-size: 0.9rem;">
                    Don't have an account? <a href="{{ route('student.register') }}"
                        style="color: var(--accent-blue); text-decoration: none;">Create one now</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Password visibility toggle logic
        document.querySelectorAll('.password-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const inputId = button.getAttribute('data-toggle-for');
                const input = document.getElementById(inputId);

                if (input.type === 'password') {
                    input.type = 'text';
                    button.innerHTML = '<i data-lucide="eye-off" style="width: 20px;"></i>';
                } else {
                    input.type = 'password';
                    button.innerHTML = '<i data-lucide="eye" style="width: 20px;"></i>';
                }
                lucide.createIcons();
            });
        });
    </script>

</body>

</html>
