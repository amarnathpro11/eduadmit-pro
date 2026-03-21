<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Student Portal</title>
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
        .reset-container {
            width: 100%;
            max-width: 450px;
            background: var(--bg-form);
            padding: 3rem;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
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
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password 🔐</h2>
        <p>Enter your new password below to reset your student account.</p>

        @if ($errors->any())
            <div class="alert alert-danger border-0 small mb-4" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('student.password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control-custom" placeholder="Min. 8 characters" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control-custom" placeholder="Repeat password" required>
            </div>
            
            <button type="submit" class="btn-reset">Update Password</button>
        </form>
    </div>
</body>
</html>
