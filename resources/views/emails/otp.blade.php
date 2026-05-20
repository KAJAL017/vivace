<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: #ffffff;
            text-align: center;
            padding: 30px 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
            text-align: center;
        }
        .email-body h2 {
            color: #2c3e50;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .email-body p {
            color: #555555;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .otp-box {
            background-color: #f8f9fa;
            border: 2px dashed #2c3e50;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 8px;
            margin: 10px 0;
        }
        .otp-validity {
            color: #e74c3c;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
        }
        .email-footer {
            background-color: #f8f9fa;
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-size: 14px;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #f39c12;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
        }
        .warning-box p {
            margin: 0;
            color: #856404;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔐 Vivace Collections</h1>
        </div>
        
        <div class="email-body">
            <h2>Hello, {{ $userName }}!</h2>
            <p>You requested to login to your account. Please use the OTP below to complete your login:</p>
            
            <div class="otp-box">
                <p style="margin: 0; color: #7f8c8d; font-size: 14px; font-weight: 600;">Your One-Time Password</p>
                <div class="otp-code">{{ $otp }}</div>
                <p class="otp-validity">⏰ Valid for 10 minutes only</p>
            </div>
            
            <div class="warning-box">
                <p><strong>⚠️ Security Notice:</strong></p>
                <p>• Never share this OTP with anyone</p>
                <p>• Vivace Collections will never ask for your OTP</p>
                <p>• If you didn't request this, please ignore this email</p>
            </div>
            
            <p style="margin-top: 30px; color: #7f8c8d; font-size: 14px;">
                This is an automated email. Please do not reply to this message.
            </p>
        </div>
        
        <div class="email-footer">
            <p><strong>Vivace Collections</strong></p>
            <p>Lively Trends for Lively People</p>
            <p>© {{ date('Y') }} Vivace Collections. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
