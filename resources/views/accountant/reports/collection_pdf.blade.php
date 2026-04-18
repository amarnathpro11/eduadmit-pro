<!DOCTYPE html>
<html>

<head>
    <title>Fee Collection Report</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .total-box {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Fee Collection Report</h2>
        <p>Date Generated: {{ date('Y-m-d H:i A') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Date</th>
                <th>TX ID</th>
                <th>Student</th>
                <th>Course</th>
                <th>Payment Mode</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($payments as $payment)
                <tr>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                    <td>{{ optional($payment->user)->name ?? 'Student' }}</td>
                    <td>{{ optional(optional($payment->application)->course)->name ?? 'Course' }}</td>
                    <td>{{ $payment->payment_mode ?? 'Online' }}</td>
                    <td>INR {{ number_format($payment->amount, 2) }}</td>
                </tr>
                @php $total += $payment->amount; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="total-box">
        Total Collection: INR {{ number_format($total, 2) }}
    </div>
</body>

</html>
