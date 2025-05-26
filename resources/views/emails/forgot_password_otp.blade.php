<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 16px;
            color: #555;
        }
        .otp {
            text-align: center;
            margin: 30px 0;
        }
        .otp span {
            font-size: 28px;
            font-weight: bold;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
        }
        .footer {
            background-color: #007bff;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .footer p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td class="header">
                <h1>Password Reset Request</h1>
            </td>
        </tr>
        <tr>
            <td class="content">
                <p>Hello,</p>
                <p>You requested to reset your password. Please use the OTP below to complete the password reset process. This OTP is valid for a limited time only.</p>
                <div class="otp">
                    <span>{{ $otp }}</span>
                </div>
                <p>If you did not request a password reset, please ignore this email or contact support if you have any questions.</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>&copy; {{ date('Y') }} , {{env('APP_NAME')}}. All Rights Reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
