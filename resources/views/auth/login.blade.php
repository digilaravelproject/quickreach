<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QwickReach</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body,
        html {
            height: 100vh;
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            background: #1A1A3E;
        }

        .syne {
            font-family: 'Syne', sans-serif;
        }

        .left-panel {
            background: #1A1A3E;
            position: relative;
            overflow: hidden;
            height: 100vh;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(91, 111, 232, 0.15) 1px, transparent 1px);
            background-size: 28px 28px;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }

        .blob-1 {
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(91, 111, 232, 0.25) 0%, transparent 70%);
            top: -100px;
            left: -80px;
            animation: drift 14s ease-in-out infinite alternate;
        }

        @keyframes drift {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(30px, 20px) scale(1.08);
            }
        }

        .input-field {
            width: 100%;
            padding: 11px 16px;
            background: #F5F5FB;
            border: 1.5px solid #ECEEF9;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.25s;
            outline: none;
        }

        .input-field:focus {
            border-color: #5B6FE8;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(91, 111, 232, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 12px 28px;
            background: #1A1A3E;
            color: #fff;
            border-radius: 14px;
            font-weight: 700;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(91, 111, 232, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: #5B6FE8;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #D1D5DB;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-checkbox.checked {
            background: #1A1A3E;
            border-color: #1A1A3E;
        }

        @media (max-width: 768px) {
            .left-panel {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="flex h-screen w-screen">
        <div class="left-panel w-1/2 hidden md:flex flex-col items-center justify-center relative z-10">
            <div class="blob blob-1"></div>
            <div class="relative z-10 px-14 max-w-xl">
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-xl"
                            style="background: rgba(91,111,232,0.2); border: 1px solid rgba(91,111,232,0.4);">
                            Q</div>
                        <span class="syne text-2xl font-extrabold text-white">Qwick<span
                                style="color: #5B6FE8;">Reach</span></span>
                    </div>
                    <h1 class="syne text-5xl font-extrabold text-white leading-tight mb-4">Secure Access<br />Portal
                    </h1>
                    <p class="text-sm leading-relaxed" style="color: #7B7FA8;">Manage your QR ecosystem, track
                        analytics, and
                        handle customer inquiries in our encrypted admin environment.</p>
                </div>
            </div>
        </div>

        <div class="right-panel w-full md:w-1/2 bg-white flex items-center justify-center">
            <div class="w-full max-w-md px-8" x-data="loginForm()">

                <div class="bg-white border p-8 rounded-[32px] shadow-2xl"
                    style="border-color: #ECEEF9; box-shadow: 0 25px 50px -12px rgba(91,111,232,0.1);">
                    <div class="mb-8">
                        <h2 class="syne text-3xl font-extrabold" style="color: #1A1A3E;">Sign In</h2>
                        <p class="text-sm mt-1" style="color: #7B7FA8;">Enter your credentials to continue</p>
                    </div>

                    @if (session('status'))
                        <div
                            class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-100">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" @submit="handleSubmit">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-bold text-xs uppercase tracking-widest mb-2 ml-1"
                                style="color: #1A1A3E;">Email
                                Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus class="input-field @error('email') border-red-500 @enderror"
                                placeholder="name@company.com">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <div class="flex justify-between items-center mb-2">
                                <label class="font-bold text-xs uppercase tracking-widest ml-1 mb-0"
                                    style="color: #1A1A3E;">Password</label>
                                <a href="{{ route('password.request') }}"
                                    class="text-[11px] font-bold uppercase tracking-tighter" style="color: #7B7FA8;"
                                    onmouseover="this.style.color='#5B6FE8';"
                                    onmouseout="this.style.color='#7B7FA8';">Forgot?</a>
                            </div>
                            <div class="relative">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="input-field @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2" style="color: #7B7FA8;">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center mb-6">
                            <label class="flex items-center cursor-pointer gap-2">
                                <input type="checkbox" name="remember" class="hidden" x-model="remember">
                                <div class="custom-checkbox" :class="{ 'checked': remember }">
                                    <svg x-show="remember" class="w-3 h-3 text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-widest" style="color: #7B7FA8;">Keep
                                    me logged
                                    in</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary flex items-center justify-center gap-2"
                            :disabled="loading">
                            <span x-show="!loading">LOG IN TO DASHBOARD</span>
                            <span x-show="loading" class="flex items-center gap-2"><svg
                                    class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg> LOADING...</span>
                        </button>
                    </form>

                    <div class="mt-8 pt-6 text-center" style="border-top: 1px solid #ECEEF9;">
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: #7B7FA8;">
                            New to QwickReach?
                            <a href="{{ route('register') }}" class="underline underline-offset-4 transition-colors"
                                style="color: #5B6FE8;" onmouseover="this.style.color='#1A1A3E';"
                                onmouseout="this.style.color='#5B6FE8';">Create Account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                remember: false,
                showPassword: false,
                loading: false,
                handleSubmit() {
                    this.loading = true;
                }
            }
        }
    </script>
</body>

</html>
