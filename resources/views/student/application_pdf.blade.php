<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Application Summary - {{ $application->application_no }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 40px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #6366f1;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #6366f1;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 15px;
            color: #1e293b;
            border-left: 4px solid #6366f1;
            padding-left: 10px;
        }

        .info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .info-label {
            width: 30%;
            font-weight: bold;
            color: #64748b;
            padding: 8px 0;
            font-size: 13px;
        }

        .info-value {
            width: 70%;
            padding: 8px 0;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f1f5f9;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            text-align: left;
            background-color: #f8fafc;
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            color: #64748b;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">EDUADMIT PRO</div>
        <div style="font-size: 14px; color: #64748b;">Official Admission Application Summary</div>
    </div>

    <table class="info-grid">
        <tr>
            <td class="info-label">Application Number</td>
            <td class="info-value"><strong style="color: #6366f1;">{{ $application->application_no }}</strong></td>
        </tr>
        <tr>
            <td class="info-label">Application Status</td>
            <td class="info-value">
                <span class="status-badge"
                    style="background-color: {{ $application->status == 'enrolled' ? '#dcfce7' : '#fef9c3' }}; color: {{ $application->status == 'enrolled' ? '#15803d' : '#854d0e' }};">
                    {{ str_replace('_', ' ', $application->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <td class="info-label">Submission Date</td>
            <td class="info-value">{{ $application->created_at->format('d M, Y h:i A') }}</td>
        </tr>
        @if ($counselor)
        <tr>
            <td class="info-label">Assigned Counselor</td>
            <td class="info-value"><strong>{{ $counselor->name }}</strong> ({{ $counselor->email }})</td>
        </tr>
        @endif
    </table>

    <div class="section-title">Personal Details</div>
    <table class="info-grid">
        <tr>
            <td class="info-label">Full Name</td>
            <td class="info-value">{{ $application->first_name }} {{ $application->last_name }}</td>
        </tr>
        <tr>
            <td class="info-label">Email Address</td>
            <td class="info-value">{{ $user->email }}</td>
        </tr>
        <tr>
            <td class="info-label">Mobile Number</td>
            <td class="info-value">{{ $application->mobile }}</td>
        </tr>
        <tr>
            <td class="info-label">Date of Birth</td>
            <td class="info-value">{{ \Carbon\Carbon::parse($application->dob)->format('d M, Y') }}</td>
        </tr>
    </table>

    <div class="section-title">Academic Preference</div>
    <table class="info-grid">
        <tr>
            <td class="info-label">Selected Course</td>
            <td class="info-value"><strong>{{ $application->course->name ?? 'N/A' }}</strong></td>
        </tr>
        <tr>
            <td class="info-label">Department</td>
            <td class="info-value">{{ $application->course->department->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="info-label">10th Percentage</td>
            <td class="info-value">{{ $application->tenth_percentage }}%</td>
        </tr>
        <tr>
            <td class="info-label">12th Percentage</td>
            <td class="info-value">{{ $application->twelfth_percentage }}%</td>
        </tr>
    </table>

    <div class="section-title">Document Verfication Status</div>
    <table class="table">
        <thead>
            <tr>
                <th>Document Type</th>
                <th>Status</th>
                <th>Upload Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documents as $doc)
                <tr>
                    <td>{{ strtoupper($doc->document_type) }} Marksheet/ID</td>
                    <td>{{ ucfirst($doc->status) }}</td>
                    <td>{{ $doc->created_at->format('d M, Y') }}</td>
                </tr>
            @endforeach
            @if ($documents->isEmpty())
                <tr>
                    <td colspan="3" style="text-align: center; color: #94a3b8;">No documents uploaded yet</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if ($payments->isNotEmpty())
        <div class="section-title">Payment History</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $pay)
                    <tr>
                        <td>{{ $pay->transaction_id }}</td>
                        <td>Rs. {{ number_format($pay->amount, 2) }}</td>
                        <td>{{ $pay->created_at->format('d M, Y') }}</td>
                        <td style="color: #15803d; font-weight: bold;">{{ ucfirst($pay->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>This is a computer-generated summary for EduAdmit Pro. No signature required.</p>
        <p>&copy; {{ date('Y') }} EduAdmit Pro Admission Portal. All Rights Reserved.</p>
    </div>
</body>

</html>
