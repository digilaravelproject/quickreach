<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ECEEF9;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background-color: #1A1A3E;
            padding: 30px;
            text-align: center;
        }

        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 40px 30px;
            color: #333333;
        }

        .email-body p {
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 16px;
        }

        .btn-reset {
            display: inline-block;
            margin: 20px 0;
            padding: 14px 32px;
            background-color: #1A1A3E;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-reset:hover {
            background-color: #5B6FE8;
        }

        .link-note {
            font-size: 13px;
            color: #888888;
            word-break: break-all;
        }

        .email-footer {
            background-color: #f9f9f9;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
            color: #aaaaaa;
            border-top: 1px solid #eeeeee;
        }

        .divider {
            border: none;
            border-top: 1px solid #eeeeee;
            margin: 24px 0;
        }
    </style>
</head>

<body>

    <div class="email-wrapper">

        <!-- Header -->
        <div class="email-header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Hello,</p>
            <p>
                We received a request to reset the password for your <strong>{{ config('app.name') }}</strong> account.
                Click the button below to set a new password.
            </p>

            <!-- Reset Button -->
            <p style="text-align: center;">
                <a href="{{ $resetUrl }}" class="btn-reset">
                    Reset Password
                </a>
            </p>

            <hr class="divider">

            <p>
                This link will expire in <strong>{{ $expireMinutes }} minutes</strong>.
            </p>

            <p>
                If you did not request a password reset, no further action is required —
                your account remains secure.
            </p>

            <hr class="divider">

            <p class="link-note">
                If the button above does not work, copy and paste the URL below into your browser:<br>
                <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

    </div>

</body>

</html>
