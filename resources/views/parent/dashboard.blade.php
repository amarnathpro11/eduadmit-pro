<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Portal | EduAdmit Pro</title>
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
            overflow-x: hidden;
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
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .subtitle {
            color: #94a3b8;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .stat-title {
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
        }

        .progress {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            height: 10px;
        }

        .progress-bar {
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
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

        .badge-pending {
            background: rgba(245, 158, 11, 0.2);
            color: #f59e0b;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .badge-verified {
            background: rgba(59, 130, 246, 0.2);
            color: #3b82f6;
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
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo {
            font-weight: 700;
            font-size: 1.5rem;
            color: #fff;
        }

        .logo span {
            color: #3b82f6;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <!-- Top Nav -->
        <div class="top-nav">
            <div class="logo">EduAdmit<span>Pro</span></div>
            <div>
                <span class="text-secondary me-3">Welcome, Parent</span>
                <form action="{{ route('parent.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm rounded-pill">Logout</button>
                </form>
            </div>
        </div>

        <!-- Header -->
        <h1 class="hero-title">Parent Dashboard</h1>
        <p class="subtitle">Monitor your ward's admission progress and financial status.</p>

        <!-- Student Summary -->
        <div class="premium-card">
            <div class="row align-items: center;">
                <div class="col-md-6">
                    <h3 class="fw-bold mb-2">{{ $student['name'] }}</h3>
                    <p class="text-secondary mb-0">ID: {{ $student['id'] }} | Course: {{ $student['course'] }}</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <span class="badge-verified">{{ $student['status'] }}</span>
                </div>
            </div>
            
            <div class="mt-4">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Admission Progress</span>
                    <span>{{ $student['progress'] }}%</span>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{ $student['progress'] }}%" aria-valuenow="{{ $student['progress'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Applications Table -->
            <div class="col-md-6">
                <div class="premium-card">
                    <h4 class="fw-bold mb-4">Active Applications</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>App ID</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                <tr>
                                    <td>{{ $app['id'] }}</td>
                                    <td>{{ $app['course'] }}</td>
                                    <td><span class="badge-verified">{{ $app['status'] }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="col-md-6">
                <div class="premium-card">
                    <h4 class="fw-bold mb-4">Recent Payments</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $pay)
                                <tr>
                                    <td>{{ $pay['type'] }}</td>
                                    <td>${{ number_format($pay['amount']) }}</td>
                                    <td>
                                        <span class="{{ $pay['status'] == 'Paid' ? 'badge-paid' : 'badge-pending' }}">
                                            {{ $pay['status'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <button class="btn-action">Pay Pending Fees</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- LMS Quick Access Dynamic Simulation -->
        <div class="premium-card mt-4">
            <h4 class="fw-bold mb-4">Learning Management System (LMS)</h4>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-title">Enrolled Courses</div>
                        <div class="stat-value">3</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-title">Overall Attendance</div>
                        <div class="stat-value">92%</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card">
                        <div class="stat-title">Current GPA</div>
                        <div class="stat-value">3.8</div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive mt-3">
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
            
            <div class="text-end mt-3">
                <a href="{{ route('parent.lms') }}" class="btn-action text-decoration-none">Go to LMS Portal</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
