<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — QwickReach</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #1A1A3E;
            --brand-blue: #5B6FE8;
            --brand-light: #ECEEF9;
            --brand-card: #F5F5FB;
            --text-primary: #1A1A3E;
            --text-muted: #7B7FA8;
            --white: #FFFFFF;
            --shadow: 0 8px 32px rgba(91, 111, 232, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            /* No scroll at all */
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--brand-light);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Background blobs */
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

        /* Card — compact to fit screen without scroll */
        .card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 28px 36px 24px;
            width: 100%;
            max-width: 430px;
            position: relative;
            animation: slideUp 0.45s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 16px;
        }

        .logo h1 {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.5px;
        }

        .logo h1 .dark {
            color: var(--brand-dark);
        }

        .logo h1 .blue {
            color: var(--brand-blue);
        }

        /* Heading */
        .heading {
            text-align: center;
            margin-bottom: 4px;
        }

        .heading h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .subtext {
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 14px;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--text-muted);
            pointer-events: none;
        }

        .form-group input {
            width: 100%;
            padding: 12px 44px 12px 42px;
            border: 2px solid #E4E6F0;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
            background: var(--brand-card);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .form-group input:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 3px rgba(91, 111, 232, 0.12);
            background: var(--white);
        }

        .form-group input::placeholder {
            color: #b0b3cc;
        }

        /* Eye toggle */
        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            transition: color 0.2s;
            padding: 2px;
        }

        .toggle-eye:hover {
            color: var(--brand-blue);
        }

        /* Strength bar */
        .strength-bar {
            display: flex;
            gap: 4px;
            margin-top: 6px;
        }

        .strength-bar span {
            flex: 1;
            height: 3px;
            border-radius: 99px;
            background: #E4E6F0;
            transition: background 0.3s;
        }

        .strength-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 4px;
            min-height: 14px;
        }

        /* Error */
        .error-msg {
            margin-top: 5px;
            font-size: 12px;
            font-weight: 700;
            color: #e05555;
        }

        /* Divider */
        .section-divider {
            border: none;
            border-top: 1.5px dashed #E4E6F0;
            margin: 14px 0;
        }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: var(--brand-dark);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            font-weight: 800;
            letter-spacing: 0.4px;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 6px;
        }

        .btn-submit:hover {
            background: var(--brand-blue);
            box-shadow: 0 6px 20px rgba(91, 111, 232, 0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Back link */
        .back-link {
            text-align: center;
            margin-top: 16px;
            font-size: 13px;
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

        /* Dots */
        .dots {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 16px;
        }

        .dots span {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #D8DAF0;
        }

        .dots span.active {
            width: 18px;
            border-radius: 4px;
            background: var(--brand-dark);
        }
    </style>
</head>

<body>

    <div class="card">

        <!-- Logo -->
        <div class="logo">
            <h1><span class="dark">Qwick</span><span class="blue">Reach</span></h1>
        </div>

        <!-- Heading -->
        <div class="heading">
            <h2>Set New Password</h2>
        </div>
        <p class="subtext">Choose a strong password to secure your QwickReach account.</p>

        <!-- Form -->
        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <svg class="icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                        <polyline points="22,6 12,13 2,6" />
                    </svg>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                        required autofocus autocomplete="username" placeholder="you@example.com" />
                </div>
                @error('email')
                    <p class="error-msg">&#9888; {{ $message }}</p>
                @enderror
            </div>

            <hr class="section-divider">

            {{-- New Password --}}
            <div class="form-group">
                <label for="password">New Password</label>
                <div class="input-wrap">
                    <svg class="icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="3" ry="3" />
                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                    </svg>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Min. 8 characters" oninput="checkStrength(this.value)" />
                    <button type="button" class="toggle-eye" onclick="toggleVisibility('password', this)"
                        aria-label="Toggle password">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                <div class="strength-bar">
                    <span id="bar1"></span><span id="bar2"></span>
                    <span id="bar3"></span><span id="bar4"></span>
                </div>
                <div class="strength-label" id="strength-label"></div>
                @error('password')
                    <p class="error-msg">&#9888; {{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrap">
                    <svg class="icon-left" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        autocomplete="new-password" placeholder="Re-enter your password" />
                    <button type="button" class="toggle-eye" onclick="toggleVisibility('password_confirmation', this)"
                        aria-label="Toggle confirm password">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="error-msg">&#9888; {{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    <polyline points="9 12 11 14 15 10" />
                </svg>
                Reset Password
            </button>
        </form>

        <p class="back-link">
            Remember your password? <a href="{{ route('login') }}">Back to Login</a>
        </p>

        <div class="dots">
            <span></span><span></span><span class="active"></span>
        </div>

    </div>

    <script>
        function toggleVisibility(id, btn) {
            const input = document.getElementById(id);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.innerHTML = show ?
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>` :
                `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
        }

        function checkStrength(val) {
            const bars = ['bar1', 'bar2', 'bar3', 'bar4'].map(id => document.getElementById(id));
            const label = document.getElementById('strength-label');
            const colors = ['#e05555', '#f59e0b', '#3b82f6', '#22c55e'];
            const labels = ['Weak', 'Fair', 'Good', 'Strong'];

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            bars.forEach((b, i) => {
                b.style.background = i < score ? colors[score - 1] : '#E4E6F0';
            });
            label.textContent = val.length ? (labels[score - 1] || '') : '';
            label.style.color = score ? colors[score - 1] : '#7B7FA8';
        }
    </script>

</body>

</html>
