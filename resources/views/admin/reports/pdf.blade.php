<!DOCTYPE html>
<html>

<head>
    <title>Audit Logs Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        th {
            background: #f4f4f4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .failed {
            color: red;
            font-weight: bold;
        }

        .warning {
            color: orange;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Audit Logs Report</h2>
        <p>Generated at: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Action</th>
                <th>Resource</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->resource }}</td>
                    <td class="{{ $log->status }}">
                        {{ ucfirst($log->status) }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
