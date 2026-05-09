<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Registration | EduAdmit Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }
        .login-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 20px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        .login-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }
        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
        }
        .logo span {
            color: #3b82f6;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            color: #fff;
            padding: 12px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: #3b82f6;
            color: #fff;
            box-shadow: none;
        }
        .btn-action {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
            color: white;
        }
        .section-title {
            font-size: 0.9rem;
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">EduAdmit<span>Pro</span></div>
        <h4 class="text-center mb-4 fw-bold">Parent Registration</h4>
        
        <form action="{{ route('parent.register.submit') }}" method="POST">
            @csrf
            
            <!-- Parent Details Section -->
            <div class="section-title">Parent Details</div>
            <div class="mb-3">
                <label class="text-secondary mb-2">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="text-secondary mb-2">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="text-secondary mb-2">Password</label>
                <input type="password" name="password" class="form-control" required>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label class="text-secondary mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <!-- Student Mapping Section -->
            <div class="section-title">Student Mapping</div>
            <div class="mb-3">
                <label class="text-secondary mb-2">Mapped Student's Email</label>
                <input type="email" name="student_email" class="form-control" value="{{ old('student_email') }}" required>
                <small class="text-secondary d-block mt-1">Enter the email your ward used to register.</small>
                @error('student_email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-4">
                <label class="text-secondary mb-2">Mapped Student's Password</label>
                <input type="password" name="student_password" class="form-control" required>
                <small class="text-secondary d-block mt-1">For security, enter your ward's password to verify mapping.</small>
                @error('student_password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-action">Register & Map Account</button>
        </form>
        
        <div class="text-center mt-4">
            <a href="{{ route('parent.login') }}" class="text-primary text-decoration-none small d-block mb-2">Already have an account? Login</a>
            <a href="{{ route('portals') }}" class="text-secondary text-decoration-none small">← Back to Portals</a>
        </div>
    </div>
</body>
</html>
