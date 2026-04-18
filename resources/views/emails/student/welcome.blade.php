<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-top: 4px solid #10b981; border-radius: 8px; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #10b981; text-decoration: none; }
        .btn { display: inline-block; padding: 12px 24px; background-color: #10b981; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2); }
        .footer { text-align: center; margin-top: 40px; font-size: 13px; color: #94a3b8; }
        hr { margin: 30px 0; border: none; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ config('app.url') }}" class="logo">EduAdmit Pro</a>
        </div>
        
        <h2>Welcome to the Portal, {{ $user->name }}!</h2>
        <p>Congratulations! Your inquiry has been processed, and we've created a student account for you.</p>
        <p>You can now log in to complete your application, upload documents, and track your admission status.</p>
        
        <div style="text-align: center; margin: 40px 0;">
            <p style="margin-bottom: 20px; font-weight: 600;">To get started, please set your account password:</p>
            <a href="{{ route('student.password.reset', ['token' => $token, 'email' => $user->email]) }}" class="btn" style="color:#ffffff;">
                Set My Password
            </a>
        </div>
        
        <p>If you have any questions, feel free to reply to this email or contact your assigned counselor.</p>
        
        <p>Best Regards,<br>EduAdmit Pro Admissions Team</p>
        
        <hr>
        
        <div class="footer">
            <p>If you're having trouble clicking the "Set My Password" button, copy and paste the URL below into your web browser:</p>
            <p style="word-break: break-all; font-size: 11px;">
                {{ route('student.password.reset', ['token' => $token, 'email' => $user->email]) }}
            </p>
        </div>
    </div>
</body>
</html>
