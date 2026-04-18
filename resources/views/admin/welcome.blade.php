<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduAdmit Pro</title>
     <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font (optional but nice) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background:radial-gradient(circle at top,#0f172a, #020617);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .hero-title{
            font-size:clamp(32px, 8vw, 48px);
            font-weight: 700;
        }
        .hero-title span{
            color: #3b82f6;
        }
        .subtitle{
            color: #94a3b8;
            margin-top: 10px;
        }
        .role-card{
            text-decoration: none;
            color:white;
        }
        .card-box{
            background: linear-gradient(145deg, #0b1220, #050b18);
            border-radius: 18px;
            padding: 30px;
            transition: 0.3s ease;
            border: 1px solid rgba(255,255,255,0.05);
            height: 100%;
        }
        .card-box:hover {
            transform: translateY(-5px);
            border-color: rgba(59,130,246,0.5);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }
           .role-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .role-title {
            font-size: 20px;
            font-weight: 600;
        }

        .role-desc {
            font-size: 14px;
            color: #94a3b8;
        }


    </style>

</head>
<body>
    <div class="container">

    <!-- Header -->
    <div class="text-center mb-5">
        <div class="hero-title">
            Edu<span>Admit</span> Pro
        </div>
        <div class="subtitle">
            Select your role to continue
        </div>
    </div>

    <!-- Role Grid -->
    <div class="row g-4">

        <!-- Admin -->
        <div class="col-md-6">
            <a href="{{ route('admin.login') }}" class="role-card">
                <div class="card-box text-center">
                    <div class="role-icon">🏛</div>
                    <div class="role-title">Admin</div>
                    <div class="role-desc">Manage system, users & analytics</div>
                </div>
            </a>
        </div>

        <!-- Counselor -->
        <div class="col-md-6">
            <a href="{{ route('counselor.login') }}" class="role-card">
                <div class="card-box text-center">
                    <div class="role-icon">💬</div>
                    <div class="role-title">Counselor</div>
                    <div class="role-desc">Manage leads & student counseling</div>
                </div>
            </a>
        </div>

        <!-- Accountant -->
        <div class="col-md-6">
            <a href="{{ route('accountant.login') }}" class="role-card">
                <div class="card-box text-center">
                    <div class="role-icon">💰</div>
                    <div class="role-title">Accountant</div>
                    <div class="role-desc">Fee management & payment reports</div>
                </div>
            </a>
        </div>

        <!-- Student -->
        <div class="col-md-6">
            <a href="{{ route('student.login') }}" class="role-card">
                <div class="card-box text-center">
                    <div class="role-icon">🎓</div>
                    <div class="role-title">Student</div>
                    <div class="role-desc">Track application, docs & payments</div>
                </div>
            </a>
        </div>

    </div>

</div>

</body>
</html>