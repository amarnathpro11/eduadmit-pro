<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Dashboard Summary</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 5px;
        }

        .stats-grid {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        .stat-card {
            padding: 20px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #eee;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }

        .table th {
            background-color: #f9fafb;
            color: #374151;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            border-left: 4px solid #2563eb;
            padding-left: 10px;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }

        .bg-success {
            background-color: #d1fae5;
            color: #065f46;
        }

        .bg-warning {
            background-color: #fef3c7;
            color: #92400e;
        }

        .bg-primary {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .bg-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>EduAdmit Pro</h1>
        <p>{{ $reportTitle }} - {{ $date }}</p>
    </div>

    <div class="section-title">Key Statistics</div>
    <table class="stats-grid">
        <tr>
            @if (in_array($type, ['Conversion Report', 'System Report']))
                <td class="stat-card">
                    <div class="stat-value">{{ $totalLeads }}</div>
                    <div class="stat-label">Total Leads</div>
                </td>
            @endif

            @if (in_array($type, ['Conversion Report', 'Admissions Report', 'System Report']))
                <td class="stat-card">
                    <div class="stat-value">{{ $totalApplications }}</div>
                    <div class="stat-label">Applications</div>
                </td>
                <td class="stat-card">
                    <div class="stat-value">{{ $totalEnrollments }}</div>
                    <div class="stat-label">Enrollments</div>
                </td>
            @endif

            @if (in_array($type, ['Revenue Report', 'System Report']))
                <td class="stat-card">
                    <div class="stat-value">Rs. {{ number_format($totalPayments, 2) }}</div>
                    <div class="stat-label">Total Revenue</div>
                </td>
            @endif
        </tr>
    </table>

    @if (in_array($type, ['Conversion Report', 'System Report']))
        <div class="section-title">Recent Leads (Pre-Applied)</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentLeads as $lead)
                    <tr>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone_number ?? 'N/A' }}</td>
                        <td>{{ $lead->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
                @if (count($recentLeads) === 0)
                    <tr>
                        <td colspan="4" style="text-align:center;">No leads found in this range.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif

    @if (in_array($type, ['Admissions Report', 'System Report']))
        <div class="section-title">Recent Applications</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Course</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentApplications as $app)
                    <tr>
                        <td>{{ $app->first_name }} {{ $app->last_name }}</td>
                        <td>{{ $app->course ? $app->course->name : 'N/A' }}</td>
                        <td>
                            @php
                                $badgeClass = match (strtolower($app->status)) {
                                    'approved', 'verified', 'selected', 'offer made', 'enrolled' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'rejected' => 'bg-danger',
                                    default => 'bg-primary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($app->status) }}</span>
                        </td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
                @if (count($recentApplications) === 0)
                    <tr>
                        <td colspan="4" style="text-align:center;">No applications found in this range.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif

    @if (in_array($type, ['Revenue Report']))
        <div class="section-title">Recent Payments Structure</div>
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Transaction ID</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($recentPayments as $pay)
                    <tr>
                        <td>{{ $pay->user ? $pay->user->name : 'N/A' }}</td>
                        <td>{{ $pay->transaction_id ?? 'N/A' }}</td>
                        <td>
                            @php
                                $pClass =
                                    $pay->status === 'success' || $pay->status === 'completed'
                                        ? 'bg-success'
                                        : ($pay->status === 'failed'
                                            ? 'bg-danger'
                                            : 'bg-warning');
                            @endphp
                            <span class="badge {{ $pClass }}">{{ ucfirst($pay->status) }}</span>
                        </td>
                        <td>Rs. {{ number_format($pay->amount, 2) }}</td>
                        <td>{{ $pay->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
                @if (count($recentPayments) === 0)
                    <tr>
                        <td colspan="5" style="text-align:center;">No payments found in this range.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif

    <div class="footer">
        Generated by EduAdmit Pro Admin System on {{ date('d M Y H:i:s') }}
    </div>
</body>

</html>
