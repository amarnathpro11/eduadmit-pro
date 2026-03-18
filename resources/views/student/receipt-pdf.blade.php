<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 30px;
        }

        .receipt-container {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 20px;
        }

        .brand {
            display: table-cell;
            vertical-align: middle;
        }

        .brand-title {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .brand-subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .receipt-info {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
        }

        .receipt-title {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .receipt-no {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        /* Two Column Layout */
        .info-section {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }

        .info-block {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }

        .info-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 15px;
            color: #111827;
            font-weight: 600;
            margin: 0 0 15px 0;
            line-height: 1.4;
        }

        /* Payment Table */
        .payment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }

        .payment-table th {
            background-color: #f9fafb;
            color: #4b5563;
            font-size: 13px;
            text-transform: uppercase;
            padding: 15px;
            text-align: left;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }

        .payment-table td {
            padding: 20px 15px;
            border-bottom: 1px solid #f3f4f6;
            color: #1f2937;
            font-size: 15px;
        }

        .payment-table .text-right {
            text-align: right;
        }

        .total-row td {
            font-weight: bold;
            font-size: 18px;
            color: #111827;
            border-top: 2px solid #e5e7eb;
            border-bottom: 2px solid #e5e7eb;
            background-color: #f9fafb;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            background-color: #d1fae5;
            color: #065f46;
            border-radius: 50px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            border-top: 1px solid #f3f4f6;
            padding-top: 20px;
            margin-top: 40px;
        }
    </style>
</head>

<body>

    <div class="receipt-container">

        <!-- Header -->
        <div class="header">
            <div class="brand">
                <h1 class="brand-title">EduAdmit Pro</h1>
                <div class="brand-subtitle">Official Payment Receipt</div>
            </div>
            <div class="receipt-info">
                <h2 class="receipt-title">RECEIPT</h2>
                <p class="receipt-no">#REC-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                <div style="margin-top: 10px;">
                    <span class="status-badge">Payment Successful</span>
                </div>
            </div>
        </div>

        <!-- Student & Transaction Details -->
        <div class="info-section">
            <div class="info-block" style="padding-right: 20px;">
                <div class="info-label">Billed To</div>
                <div class="info-value">
                    {{ $user->name }}<br>
                    <span style="font-weight: normal; color: #4b5563;">{{ $user->email }}</span><br>
                    @if ($application)
                        <span style="font-weight: normal; color: #4b5563;">App No:
                            {{ $application->application_no }}</span>
                    @endif
                </div>
            </div>

            <div class="info-block" style="text-align: right;">
                <div class="info-label">Payment Details</div>
                <div class="info-value">
                    <span style="font-weight: normal; color: #6b7280; font-size: 13px;">Transaction Date:</span><br>
                    {{ \Carbon\Carbon::parse($payment->created_at)->timezone('Asia/Kolkata')->format('M d, Y, h:i A') }}
                </div>
                <div class="info-value">
                    <span style="font-weight: normal; color: #6b7280; font-size: 13px;">Transaction
                        Reference:</span><br>
                    {{ $payment->transaction_id ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Payment Breakdown table -->
        <table class="payment-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div style="font-weight: bold; color: #111827;">Admission / Course Fee</div>
                        @if ($application && $application->course)
                            <div style="font-size: 13px; color: #6b7280; margin-top: 4px;">
                                {{ $application->course->name }}</div>
                        @endif
                    </td>
                    <td class="text-right" style="font-weight: 500;">
                        Rs. {{ number_format($payment->amount, 2) }}
                    </td>
                </tr>
                <tr class="total-row">
                    <td style="text-align: right; padding-right: 20px;">Total Amount Paid</td>
                    <td class="text-right" style="color: #4f46e5;">Rs. {{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Footer terms -->
        <div class="footer">
            <p style="margin: 0 0 5px 0;">This is a computer-generated receipt and does not require a physical
                signature.</p>
            <p style="margin: 0;">If you have any questions concerning this receipt, please contact the administration
                office.</p>
        </div>

    </div>

</body>

</html>
