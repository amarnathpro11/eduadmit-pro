<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Admin Portal</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: #020617;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }

        .forgot-box {
            width: 420px;
            background: rgba(15, 23, 42, 0.6);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .form-control {
            background: #020617;
            box-shadow: none;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: white;
            height: 48px;
            border-radius: 10px;
        }

        .form-control:focus {
            background: #020617;
            box-shadow: none;
            border-color: #3b82f6;
            color: white;
        }

        .btn-primary {
            background: #3b82f6;
            border: none;
            height: 48px;
            border-radius: 10px;
            font-weight: 600;
        }

        .muted { color: #94a3b8; font-size: 14px; }
        a { text-decoration: none; color: #3b82f6; font-size: 14px; }

        .divider hr { border-color: rgba(255,255,255,0.1); }
    </style>
</head>

<body>
    <div class="forgot-box">
        <div class="mb-4">
            <a href="{{ route('admin.login') }}">← Back to Login</a>
        </div>
        <h3>Recover Account 🔒</h3>
        <p class="muted mb-4">Enter your registered email address to receive password recovery instructions.</p>

        @if (session('success'))
            <div class="alert alert-success border-0 small mb-4" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger border-0 small mb-4" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="muted mb-2">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@example.com" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>
    </div>
</body>

</html>
