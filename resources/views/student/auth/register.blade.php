<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration | EduAdmit Pro</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
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
            --accent-green: #10b981;
            --text-muted: #94a3b8;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-deep);
            color: #ffffff;
            margin: 0;
            overflow: hidden;
        }

        .register-container {
            height: 100vh;
            display: flex;
        }

        /* Left Side */
        .left-panel {
            flex: 0 0 55%;
            padding: 3.5rem;
            position: relative;
            background: linear-gradient(135deg, #0f172a 0%, #171717 100%);
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
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            z-index: 0;
        }

        .brand-section {
            position: relative;
            z-index: 1;
            margin-bottom: 4rem;
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .brand-title span {
            color: var(--accent-green);
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
            border-color: rgba(16, 185, 129, 0.5);
            background: rgba(16, 185, 129, 0.1);
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
            color: var(--accent-green);
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
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #ffffff;
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
            margin-bottom: 1.5rem;
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
            margin-bottom: 1.25rem;
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
            border-color: var(--accent-green);
            outline: none;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .form-control-custom::placeholder {
            color: #4b5563;
        }

        .btn-register {
            background: linear-gradient(90deg, #10b981 0%, #059669 100%);
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
            margin-top: 1rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .left-panel { display: none; }
            .right-panel { flex: 0 0 100%; padding: 2rem; }
        }
    </style>
</head>
<body>

<div class="register-container">
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="brand-section">
            <h1 class="brand-title">EduAdmit<br><span>Pro</span></h1>
            <p class="brand-subtitle">Student Registration</p>
        </div>

        <div class="features-list">
            <div class="feature-card active">
                <div class="feature-icon">
                    <i data-lucide="user-plus"></i>
                </div>
                <div class="feature-info">
                    <h5>Quick Account</h5>
                    <p>Start your application process in seconds</p>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i data-lucide="check-circle"></i>
                </div>
                <div class="feature-info">
                    <h5>Instant Confirmation</h5>
                    <p>Receive immediate updates on your status</p>
                </div>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i data-lucide="shield-check"></i>
                </div>
                <div class="feature-info">
                    <h5>Secure Platform</h5>
                    <p>Your documents and payments are always safe</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <a href="{{ route('student.login') }}" class="back-link">
            <i data-lucide="arrow-left" style="width: 18px;"></i>
            Back to login
        </a>

        <div class="welcome-head">
            <h2>Create Account 🚀</h2>
            <p>Join EduAdmit Pro and begin your journey</p>
        </div>

        <form method="POST" action="{{ route('student.register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <div class="input-group-custom">
                    <i data-lucide="user" style="width: 20px;"></i>
                    <input type="text" name="name" class="form-control-custom" placeholder="John Doe" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <i data-lucide="mail" style="width: 20px;"></i>
                    <input type="email" name="email" class="form-control-custom" placeholder="john@example.com" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <i data-lucide="lock" style="width: 20px;"></i>
                    <input type="password" name="password" class="form-control-custom" placeholder="Min. 8 characters" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <div class="input-group-custom">
                    <i data-lucide="shield-check" style="width: 20px;"></i>
                    <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Register Now &rarr;
            </button>
        </form>

        <div class="text-center mt-4">
            <p style="color: var(--text-muted); font-size: 0.9rem;">
                Already have an account? <a href="{{ route('student.login') }}" style="color: var(--accent-green); text-decoration: none;">Sign in instead</a>
            </p>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons
    lucide.createIcons();
</script>

</body>
</html>