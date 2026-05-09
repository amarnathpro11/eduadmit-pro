<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: 4px solid #22c55e;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #22c55e;
            text-decoration: none;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #22c55e;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(34, 197, 94, 0.2);
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
            color: #94a3b8;
        }

        hr {
            margin: 30px 0;
            border: none;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">EduAdmit Pro | Counselytics</a>
        </div>

        <h2>Hello, Counselor!</h2>
        <p>You are receiving this email because we received a password reset request for your counselor account.</p>

        <div style="text-align: center; margin: 40px 0;">
            <a href="{{ route('counselor.password.reset', ['token' => $token, 'email' => $email]) }}" class="btn"
                style="color:#ffffff;">
                Reset Password
            </a>
        </div>

        <p>This password reset link will expire in 60 minutes.</p>
        <p>If you did not request a password reset, no further action is required.</p>

        <p>Regards,<br>EduAdmit Pro Team</p>

        <hr>

        <div class="footer">
            <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into
                your web browser:</p>
            <p style="word-break: break-all; font-size: 11px;">
                {{ route('counselor.password.reset', ['token' => $token, 'email' => $email]) }}
            </p>
        </div>
    </div>
</body>

</html>
