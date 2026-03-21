<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Admin Portal</title>
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

        .reset-box {
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
    </style>
</head>

<body>
    <div class="reset-box">
        <h3 class="mb-2">Reset Password 📝</h3>
        <p class="muted mb-4">Finalize your administrator account recovery by setting a new secure password.</p>

        @if ($errors->any())
            <div class="alert alert-danger border-0 small mb-4" style="background: rgba(239, 68, 68, 0.1); color: #ef4444;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-3">
                <label class="muted mb-2">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 8 characters" required autofocus>
            </div>

            <div class="mb-4">
                <label class="muted mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
            </div>

            <button type="submit" class="btn-primary w-100">Update Password</button>
        </form>
    </div>
</body>
</html>
