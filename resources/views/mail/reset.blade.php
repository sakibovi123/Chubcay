<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #51545e;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            padding: 20px;
            background-color: #f4f4f7;
            display: flex;
            justify-content: center;
        }
        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            max-width: 600px;
            width: 100%;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eaeaea;
        }
        .email-header h1 {
            margin: 0;
            color: #333333;
            font-size: 24px;
        }
        .email-body {
            padding-top: 20px;
            padding-bottom: 20px;
            text-align: center;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 20px;
        }
        .email-button {
            display: inline-block;
            padding: 12px 24px;
            color: #ffffff;
            background-color: #007bff;
            border-radius: 4px;
            text-decoration: none;
            font-size: 16px;
        }
        .email-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
            font-size: 12px;
            color: #6b6e76;
        }
        .email-footer p {
            margin: 0;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="email-header">
                <h1>Password Reset Request</h1>
            </div>
            <div class="email-body">
                <p>Hello,</p>
                <p>Here is your password reset link. Click the button below to reset your password:</p>
                <a href="{{ $link }}" class="email-button">Reset Password</a>
                {{-- <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p> --}}
                <p>Thank you,</p>
                <p>The Chubcay Team</p>
            </div>
            <div class="email-footer">
                <p>&copy; Chubcay. All rights reserved.</p>
                {{-- <p><a href="{{ $contactUsLink }}">Contact Us</a> | <a href="{{ $privacyPolicyLink }}">Privacy Policy</a></p> --}}
            </div>
        </div>
    </div>
</body>
</html>
