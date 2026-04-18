<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Counselytics Portal - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            display: flex;
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .login-left {
            padding: 48px;
            width: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .login-right {
            width: 50%;
            background: #22c55e;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
        }

        .login-right::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(0, 0, 0, 0.2));
        }

        .login-right-content {
            position: relative;
            z-index: 2;
        }

        .brand {
            display: flex;
            align-items: center;
            font-weight: 800;
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 2rem;
            justify-content: center;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: #22c55e;
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 14px;
        }

        .form-control {
            background: rgba(0, 0, 0, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
            padding: 12px 16px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #22c55e !important;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1) !important;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .btn-login {
            background: #22c55e;
            color: white;
            font-weight: 700;
            padding: 12px;
            border-radius: 10px;
            border: none;
            width: 100%;
            transition: 0.2s;
        }

        .btn-login:hover {
            background: #16a34a;
            color: white;
        }

        .back-btn {
            position: absolute;
            top: 24px;
            left: 24px;
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
        }

        .back-btn:hover {
            color: #ffffff;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 d-flex justify-content-center">
                <div class="login-wrapper">
                    <div class="login-left">
                        <a href="{{ route('home') }}" class="back-btn"><i class="fa fa-arrow-left"></i> Section
                            Selection</a>

                        <div class="brand mt-4">
                            <div class="brand-icon"><i class="fa fa-chart-line"></i></div>
                            <span>Counselytics</span>
                        </div>

                        <div class="text-center mb-4">
                            <h4 class="fw-bold mb-1">Welcome Back</h4>
                            <p class="text-muted small">Sign in to manage your pipeline</p>
                        </div>

                        @if (session('error'))
                            <div
                                class="alert alert-danger border border-danger border-opacity-25 bg-danger bg-opacity-10 text-danger small rounded-3 fw-medium">
                                <i class="fa fa-exclamation-circle me-1"></i> {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div
                                class="alert alert-danger border border-danger border-opacity-25 bg-danger bg-opacity-10 text-danger small rounded-3 fw-medium">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('counselor.login.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-login shadow-sm">Log In as Counselor</button>
                        </form>
                    </div>
                    <!-- Promotional Splash Right Side -->
                    <div class="login-right d-none d-md-flex">
                        <div class="login-right-content">
                            <div
                                style="background: rgba(255,255,255,0.2); width: 64px; height: 64px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 24px;">
                                🏆
                            </div>
                            <h2 class="fw-bold mb-3">Powering Admissions.</h2>
                            <p style="font-size: 1.1rem; opacity: 0.9;">Manage your leads, track conversion funnels, log
                                timelines, and hit your admission targets effortlessly using real data.</p>

                            <div class="mt-5 p-3 rounded-3"
                                style="background: rgba(0,0,0,0.15); border: 1px solid rgba(255,255,255,0.1);">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-quote-left fs-3 me-3 opacity-50"></i>
                                    <p class="mb-0 fst-italic small">"The new task dashboard absolutely changed our
                                        team's workflow."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
