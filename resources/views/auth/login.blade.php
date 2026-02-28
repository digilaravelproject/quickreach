<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - QwickReach</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine JS is loaded here -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,700;1,800&display=swap"
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
            background: #000000;
        }

        .left-panel {
            background: #000000;
            position: relative;
            overflow: hidden;
            height: 100vh;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(138, 43, 226, 0.15) 1px, transparent 1px);
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
            background: radial-gradient(circle, rgba(138, 43, 226, 0.25) 0%, transparent 70%);
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
            padding: 12px 16px;
            background: #F4F4F5;
            border: 1.5px solid #E4E4E7;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.25s;
            outline: none;
            color: #000000;
        }

        .input-field::placeholder {
            color: #A1A1AA;
        }

        .input-field:focus {
            border-color: #8A2BE2;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(138, 43, 226, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 12px 28px;
            background: #000000;
            border-radius: 14px;
            font-weight: 700;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: none;
        }

        /* Enforcing white color for the text inside button */
        .btn-primary span {
            color: #ffffff !important;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            background: #8A2BE2;
            box-shadow: 0 6px 20px rgba(138, 43, 226, 0.3);
        }

        .btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #D1D5DB;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .custom-checkbox.checked {
            background: #000000;
            border-color: #000000;
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
                    <div class="mb-6">
                        <span class="text-[2.5rem] font-extrabold italic tracking-tight text-white">Qwick<span
                                style="color: #8A2BE2;">Reach</span></span>
                    </div>
                    <h1 class="text-5xl font-bold text-white leading-tight mb-4">Secure Access<br />Portal
                    </h1>
                    <p class="text-sm leading-relaxed" style="color: #A1A1AA;">Manage your QR ecosystem, track
                        analytics, and
                        handle customer inquiries in our encrypted admin environment.</p>
                </div>
            </div>
        </div>

        <div class="right-panel w-full md:w-1/2 bg-white flex items-center justify-center relative overflow-y-auto">

            <!-- ALPINE STATE DIRECTLY HERE - ROCK SOLID -->
            <div class="w-full max-w-md px-8 py-10" x-data="{ showPassword: false, loading: false, remember: false }">

                <div class="bg-white border p-8 rounded-[32px] shadow-2xl relative"
                    style="border-color: #E4E4E7; box-shadow: 0 25px 50px -12px rgba(138, 43, 226, 0.1);">

                    <!-- Mobile Logo (Shows only on mobile view) -->
                    <div class="md:hidden mb-6 text-center">
                        <span class="text-[2rem] font-extrabold italic tracking-tight"
                            style="color: #000000;">Qwick<span style="color: #8A2BE2;">Reach</span></span>
                    </div>

                    <!-- Centered Header -->
                    <div class="mb-8 text-center">
                        <h2 class="text-3xl font-bold" style="color: #000000;">Sign In</h2>
                        <p class="text-sm mt-2" style="color: #71717A;">Enter your credentials to continue</p>
                    </div>

                    @if (session('status'))
                        <div
                            class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-lg border border-green-100">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" x-on:submit="loading = true">
                        @csrf

                        <!-- Email Input -->
                        <div class="mb-5">
                            <label class="block font-bold text-xs uppercase tracking-widest mb-2 ml-1"
                                style="color: #000000;">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus class="input-field @error('email') border-red-500 @enderror"
                                placeholder="name@company.com">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="font-bold text-xs uppercase tracking-widest ml-1 mb-0"
                                    style="color: #000000;">Password</label>
                                <a href="{{ route('password.request') }}"
                                    class="text-[11px] font-bold uppercase tracking-tighter transition-colors duration-200"
                                    style="color: #71717A;" onmouseover="this.style.color='#8A2BE2';"
                                    onmouseout="this.style.color='#71717A';">Forgot?</a>
                            </div>

                            <!-- Bulletproof Relative Container for Input + Icon -->
                            <div class="relative w-full">
                                <input :type="showPassword ? 'text' : 'password'" name="password" required
                                    class="input-field pr-12 w-full @error('password') border-red-500 @enderror"
                                    placeholder="••••••••">

                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 px-4 flex items-center justify-center text-gray-500 hover:text-[#8A2BE2] focus:outline-none z-10 cursor-pointer">

                                    <!-- Open Eye -->
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>

                                    <!-- Closed Eye -->
                                    <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>

                                </button>
                            </div>
                        </div>

                        <!-- Keep Me Logged In -->
                        <div class="flex items-center mb-8">
                            <label class="flex items-center cursor-pointer gap-2 group">
                                <input type="checkbox" name="remember" class="hidden" x-model="remember">
                                <div class="custom-checkbox group-hover:border-purple-600"
                                    :class="{ 'checked': remember }">
                                    <svg x-show="remember" style="display: none;" class="w-3 h-3 text-white"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span class="text-xs font-bold uppercase tracking-widest" style="color: #71717A;">Keep
                                    me logged in</span>
                            </label>
                        </div>

                        <!-- Submit Button FIXED -->
                        <button type="submit" class="btn-primary" :disabled="loading">
                            <span x-show="!loading" class="font-bold tracking-wide">LOG IN TO DASHBOARD</span>

                            <!-- Spinner shown only on loading -->
                            <span x-show="loading" style="display: none;"
                                class="flex items-center gap-2 font-bold tracking-wide">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                LOADING...
                            </span>
                        </button>
                    </form>

                    <div class="mt-8 pt-6 text-center" style="border-top: 1px solid #E4E4E7;">
                        <p class="text-xs font-bold uppercase tracking-widest" style="color: #71717A;">
                            New to QwickReach?
                            <a href="{{ route('register') }}" class="underline underline-offset-4 transition-colors"
                                style="color: #8A2BE2;" onmouseover="this.style.color='#000000';"
                                onmouseout="this.style.color='#8A2BE2';">Create Account</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
