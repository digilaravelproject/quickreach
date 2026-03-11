@extends('user_layout.user')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center p-6 bg-[#F5F3FA]">
        <div class="max-w-md w-full text-center">

            {{-- ── VISUAL ICON ── --}}
            <div class="relative mb-8">
                <div
                    class="w-24 h-24 bg-white rounded-3xl shadow-xl flex items-center justify-center mx-auto border border-gray-100 animate-bounce-slow">
                    <span class="text-5xl">⚠️</span>
                </div>
                <div
                    class="absolute -bottom-2 right-1/2 translate-x-12 w-8 h-8 bg-orange-400 rounded-full border-4 border-[#F5F3FA] flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    !
                </div>
            </div>

            {{-- ── CONTENT ── --}}
            <h1 class="text-3xl font-black text-gray-900 mb-3 leading-tight">QR Code Inactive</h1>
            <p class="text-gray-500 font-medium mb-8 px-4">
                This QR code is currently inactive for safety purposes.
            </p>

            {{-- ── STATUS BOX ── --}}
            <div class="bg-white rounded-[28px] p-6 mb-8 border border-white shadow-lg inline-block w-full">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Current Status</p>
                <span class="text-orange-500 font-black text-xl">Inactive</span>
            </div>

            {{-- ── SUPPORT INFO ── --}}
            <div class="bg-white rounded-[28px] p-6 mb-8 border border-gray-100 shadow-lg w-full space-y-3">
                <p class="text-xs text-gray-400 font-semibold">
                    If you believe this is an error or need assistance, please contact QwickReach support for further help.
                </p>
                <a href="mailto:support@qwickreach.in"
                    class="flex items-center justify-center gap-2 text-sm font-bold text-[#4B3D76] hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    support@qwickreach.in
                </a>
                <a href="https://www.qwickreach.in" target="_blank"
                    class="flex items-center justify-center gap-2 text-sm font-bold text-[#4B3D76] hover:underline">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" />
                    </svg>
                    www.qwickreach.in
                </a>
            </div>

            {{-- ── FOOTER BRAND ── --}}
            <div class="mt-16 opacity-40 flex justify-center">
                <p
                    class="font-sans text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] flex items-center gap-2">
                    <img src="{{ asset('assets/images/logos/quickreach_logo.jpeg') }}" alt="QwickReach Logo" class="qw_logo"
                        style="height: 15px; width: auto; object-fit: contain;">
                    Security
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
    </style>
@endsection
