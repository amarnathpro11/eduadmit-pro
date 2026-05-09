<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Portal | EduAdmit Pro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top, #0f172a, #020617);
            color: #fff;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
        }
        .premium-card {
            background: linear-gradient(145deg, #1e293b, #0f172a);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .premium-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #3b82f6);
        }
        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        .table {
            color: #e2e8f0;
        }
        .table th {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #94a3b8;
            font-weight: 600;
        }
        .table td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }
        .badge-paid {
            background: rgba(16, 185, 129, 0.2);
            color: #10b981;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }
        .btn-action {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="hero-title">LMS Portal</h1>
                <p class="subtitle">Learning Management System for {{ $studentUser->name ?? 'Demo Student' }}</p>
            </div>
            <a href="{{ route('parent.dashboard') }}" class="btn-action">← Back to Dashboard</a>
        </div>

        @if(session('warning'))
            <div class="alert alert-warning" style="background: rgba(245, 158, 11, 0.2); border: none; color: #f59e0b;">
                {{ session('warning') }}
            </div>
        @endif

        <div class="premium-card">
            <h4 class="fw-bold mb-4">Academic Performance</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Grade</th>
                            <th>Attendance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lmsRecords as $record)
                        <tr>
                            <td>{{ $record->subject }}</td>
                            <td>{{ $record->grade ?? 'N/A' }}</td>
                            <td>{{ $record->attendance ?? 'N/A' }}%</td>
                            <td><span class="badge-paid">{{ ucfirst($record->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Additional LMS Details -->
        <div class="row">
            <div class="col-md-6">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3">Upcoming Assignments</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><i class="fas fa-file-alt me-2 text-success"></i> Data Structures - Project 1 (Due: 3 days)</li>
                        <li class="mb-2"><i class="fas fa-file-alt me-2 text-warning"></i> Discrete Maths - Quiz 2 (Due: 5 days)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="premium-card">
                    <h5 class="fw-bold mb-3">Recent Class Recordings</h5>
                    <ul class="list-unstyled text-secondary">
                        <li class="mb-2"><i class="fas fa-video me-2 text-primary"></i> Intro to Programming - Lecture 12</li>
                        <li class="mb-2"><i class="fas fa-video me-2 text-primary"></i> Data Structures - Lecture 8</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
