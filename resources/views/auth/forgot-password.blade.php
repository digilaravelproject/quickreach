<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — QwickReach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #1A1A3E;
            --brand-blue: #5B6FE8;
            --brand-purple: #7C6FF7;
            --brand-light: #ECEEF9;
            --brand-card: #F5F5FB;
            --text-primary: #1A1A3E;
            --text-muted: #7B7FA8;
            --white: #FFFFFF;
            --shadow: 0 8px 32px rgba(91, 111, 232, 0.15);
            --radius: 20px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--brand-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -120px;
            right: -80px;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(91, 111, 232, 0.18) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -100px;
            left: -80px;
            width: 340px;
            height: 340px;
            background: radial-gradient(circle, rgba(124, 111, 247, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        /* Card */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 44px 40px;
            width: 100%;
            max-width: 440px;
            position: relative;
            animation: slideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo h1 {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        .logo h1 span.dark {
            color: var(--brand-dark);
        }

        .logo h1 span.blue {
            color: var(--brand-blue);
        }

        /* Lock Icon Circle */
        .icon-wrap {
            width: 72px;
            height: 72px;
            background: var(--brand-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-wrap svg {
            width: 36px;
            height: 36px;
        }

        /* Heading */
        .heading {
            text-align: center;
            margin-bottom: 8px;
        }

        .heading h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .subtext {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        /* Status alert */
        .status-alert {
            background: #e8fdf0;
            border: 1.5px solid #4caf82;
            color: #2d7a56;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status-alert svg {
            flex-shrink: 0;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #E4E6F0;
            border-radius: 14px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--brand-card);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-group input:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 4px rgba(91, 111, 232, 0.12);
            background: var(--white);
        }

        .form-group input::placeholder {
            color: #b0b3cc;
        }

        /* Error */
        .error-msg {
            margin-top: 6px;
            font-size: 12.5px;
            font-weight: 700;
            color: #e05555;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--brand-dark);
            color: var(--white);
            border: none;
            border-radius: 14px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: var(--brand-blue);
            box-shadow: 0 6px 20px rgba(91, 111, 232, 0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Back to login */
        .back-link {
            text-align: center;
            margin-top: 24px;
            font-size: 13.5px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .back-link a {
            color: var(--brand-blue);
            font-weight: 800;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: var(--brand-dark);
        }

        /* Divider dots (decorative) */
        .dots {
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 28px;
        }

        .dots span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #D8DAF0;
        }

        .dots span.active {
            width: 20px;
            border-radius: 4px;
            background: var(--brand-dark);
        }
    </style>
</head>

<body>

    <div class="card">

        <!-- Logo -->
        <div class="logo">
            <h1>
                <span class="dark">Qwick</span><span class="blue">Reach</span>
            </h1>
        </div>

        <!-- Lock Icon -->
        <div class="icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="#5B6FE8" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="11" width="18" height="11" rx="3" ry="3" />
                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                <circle cx="12" cy="16" r="1.5" fill="#5B6FE8" stroke="none" />
            </svg>
        </div>

        <!-- Heading -->
        <div class="heading">
            <h2>Forgot Password?</h2>
        </div>
        <p class="subtext">
            No worries! Enter your email address and we'll<br>
            send you a secure password reset link.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-alert">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="you@example.com" required autofocus autocomplete="email" />
                </div>
                @error('email')
                    <p class="error-msg">⚠ {{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13" />
                    <polygon points="22 2 15 22 11 13 2 9 22 2" />
                </svg>
                Send Reset Link
            </button>
        </form>

        <!-- Back Link -->
        <p class="back-link">
            Remember your password?
            <a href="{{ route('login') }}">Back to Login</a>
        </p>

        <!-- Decorative dots -->
        <div class="dots">
            <span></span>
            <span class="active"></span>
            <span></span>
        </div>

    </div>

</body>

</html>
