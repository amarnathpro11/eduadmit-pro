<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { background: #1e293b; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { padding: 30px; }
        .footer { text-align: center; font-size: 12px; color: #999; padding: 20px; }
        .btn { display: inline-block; padding: 10px 20px; background: #3b82f6; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>
        <div class="content">
            <p>Hello <strong>{{ $lead->name }}</strong>,</p>
            <p>{{ $customMessage }}</p>
            <p>If you have any further questions about our <strong>{{ $lead->course->name ?? 'available courses' }}</strong>, please don't hesitate to reach out to us.</p>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/') }}" class="btn">Visit Website</a>
            </div>
            <p>Best Regards,<br>The Admission Team</p>
        </div>
        <div class="footer">
            <p>You received this email because you made an inquiry on our website.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
