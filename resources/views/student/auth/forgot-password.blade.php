<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --bg-deep: #0f172a;
            --bg-form: #0b0f1a;
            --accent-blue: #3b82f6;
            --text-muted: #94a3b8;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-deep);
            color: #ffffff;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .forgot-container {
            width: 100%;
            max-width: 450px;
            background: var(--bg-form);
            padding: 3rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .back-link {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: var(--accent-blue); }
        h2 { font-family: 'Outfit', sans-serif; font-weight: 700; margin-bottom: 0.5rem; }
        p { color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem; }
        .form-label { color: var(--text-muted); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-control-custom {
            background-color: #1a1f2e;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 0.85rem 1rem;
            color: #fff;
            width: 100%;
            margin-bottom: 1.5rem;
        }
        .btn-reset {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            color: white;
            font-weight: 600;
            width: 100%;
            margin-bottom: 1.5rem;
        }
        .divider { border-color: rgba(255,255,255,0.05); }
    </style>
</head>
<body>
    <div class="forgot-container">
        <a href="{{ route('student.login') }}" class="back-link">
            <i data-lucide="arrow-left" style="width: 18px;"></i>
            Back to Sign In
        </a>
        <p>No worries, we'll send you reset instructions to your registered email address.</p>

        @if (session('success'))
            <div class="alert alert-success border-0 small mb-4" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('student.password.email') }}" method="POST">
            @csrf
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control-custom" placeholder="you@example.com" required>
            <button type="submit" class="btn-reset" style="margin-bottom: 0;">Send Instructions</button>
        </form>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
