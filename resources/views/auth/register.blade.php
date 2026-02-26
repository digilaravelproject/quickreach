<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - QwickReach</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background-color: #ECEEF9;
        }

        .brand-shadow {
            box-shadow: 0 25px 50px -12px rgba(91, 111, 232, 0.1);
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ loading: false }">

        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center mb-8">
            <h2 class="text-4xl font-black tracking-tight" style="color: #1A1A3E;">Qwick<span
                    style="color: #5B6FE8;">Reach</span></h2>
            <p class="mt-2 text-sm font-bold text-gray-400 uppercase tracking-[0.2em]">Start your journey with us</p>
        </div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-10 px-8 rounded-[40px] border brand-shadow" style="border-color: #ECEEF9;">

                <form action="{{ route('register') }}" method="POST" @submit="loading = true">
                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1">Full
                                Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl outline-none text-sm font-bold transition-all"
                                style="color: #1A1A3E;"
                                onfocus="this.style.outline='none'; this.style.boxShadow='0 0 0 2px #5B6FE8';"
                                onblur="this.style.boxShadow='none';" placeholder="John Doe">
                            @if ($errors->has('name'))
                                <span
                                    class="text-[10px] text-red-500 font-bold ml-2 mt-1">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1">Email
                                Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl outline-none text-sm font-bold transition-all"
                                style="color: #1A1A3E;" onfocus="this.style.boxShadow='0 0 0 2px #5B6FE8';"
                                onblur="this.style.boxShadow='none';" placeholder="name@example.com">
                            @if ($errors->has('email'))
                                <span
                                    class="text-[10px] text-red-500 font-bold ml-2 mt-1">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div>
                            <label
                                class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1">Phone
                                Number</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl outline-none text-sm font-bold transition-all"
                                style="color: #1A1A3E;" onfocus="this.style.boxShadow='0 0 0 2px #5B6FE8';"
                                onblur="this.style.boxShadow='none';" placeholder="+91 00000 00000">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1">Password</label>
                                <input type="password" name="password" required
                                    class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl outline-none text-sm font-bold transition-all"
                                    style="color: #1A1A3E;" onfocus="this.style.boxShadow='0 0 0 2px #5B6FE8';"
                                    onblur="this.style.boxShadow='none';">
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2 mb-1">Confirm</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full px-5 py-4 bg-gray-50 border-none rounded-2xl outline-none text-sm font-bold transition-all"
                                    style="color: #1A1A3E;" onfocus="this.style.boxShadow='0 0 0 2px #5B6FE8';"
                                    onblur="this.style.boxShadow='none';">
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <span
                                class="text-[10px] text-red-500 font-bold ml-2 mt-1">{{ $errors->first('password') }}</span>
                        @endif

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center items-center py-5 px-4 text-white text-xs font-black rounded-3xl focus:outline-none transition-all active:scale-95 disabled:opacity-70"
                                style="background-color: #1A1A3E; box-shadow: 0 10px 25px -5px rgba(91, 111, 232, 0.3);"
                                onmouseover="this.style.backgroundColor='#5B6FE8';"
                                onmouseout="this.style.backgroundColor='#1A1A3E';" :disabled="loading">
                                <span x-show="!loading" class="tracking-widest uppercase">Create My Account</span>
                                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                                    <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    PROCESSING...
                                </span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-100"></div>
                    </div>
                    <div class="relative flex justify-center text-[10px] font-black uppercase tracking-widest">
                        <span class="bg-white px-4 text-gray-300">Social Sign Up</span>
                    </div>
                </div>

                <a href="{{ route('google.login') }}"
                    class="w-full inline-flex justify-center items-center py-4 bg-white border border-gray-100 rounded-2xl shadow-sm text-sm font-bold text-gray-700 hover:bg-gray-50 transition-all active:scale-95">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="w-5 h-5 mr-3"
                        alt="Google">
                    <span>Google Account</span>
                </a>
            </div>

            <p class="mt-8 text-center text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                Already member?
                <a href="{{ route('login') }}" class="underline underline-offset-8 ml-1" style="color: #5B6FE8;"
                    onmouseover="this.style.color='#1A1A3E';" onmouseout="this.style.color='#5B6FE8';">Log In</a>
            </p>
        </div>
    </div>

</body>

</html>
