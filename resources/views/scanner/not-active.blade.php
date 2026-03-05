@extends('user_layout.user')

@section('content')
    <div class="min-h-[80vh] flex items-center justify-center p-6 bg-[#F5F3FA]">
        <div class="max-w-md w-full text-center">

            {{-- ── VISUAL ICON ── --}}
            <div class="relative mb-8">
                <div
                    class="w-24 h-24 bg-white rounded-3xl shadow-xl flex items-center justify-center mx-auto border border-gray-100 animate-bounce-slow">
                    <span class="text-5xl">🏷️</span>
                </div>
                <div
                    class="absolute -bottom-2 right-1/2 translate-x-12 w-8 h-8 bg-yellow-400 rounded-full border-4 border-[#F5F3FA] flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    !
                </div>
            </div>

            {{-- ── CONTENT ── --}}
            <h1 class="text-3xl font-black text-gray-900 mb-3 leading-tight">Tag Not Activated</h1>
            <p class="text-gray-500 font-medium mb-8 px-4">
                This QwickReach smart tag is currently **available** and has not been registered by any owner yet.
            </p>

            {{-- ── STATUS BOX ── --}}
            <div class="bg-white rounded-[28px] p-6 mb-8 border border-white shadow-lg inline-block w-full">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Current Status</p>
                <span class="text-[#4B3D76] font-black text-xl">Available for Purchase</span>
            </div>

            {{-- ── ACTION BUTTONS ── --}}
            <div class="space-y-4">
                <a href="{{ route('user.products') }}"
                    class="block w-full bg-[#4B3D76] text-white text-sm font-black py-5 rounded-2xl shadow-lg shadow-indigo-900/20 hover:bg-[#3c315e] active:scale-[0.96] transition-all uppercase tracking-wider border-b-4 border-[#31274f]">
                    Buy This Tag Now
                </a>

                <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">
                    Already own this? <a href="{{ route('login') }}"
                        class="text-[#4B3D76] underline hover:text-[#3c315e]">Login to register</a>
                </p>
            </div>

            {{-- ── FOOTER BRAND ── --}}
            <div class="mt-16 opacity-40 flex justify-center">
                <p class="font-sans text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] flex items-center gap-2">
                    <img src="{{ asset('assets/images/logos/quickreach_logo.jpeg') }}" alt="QwickReach Logo" class="qw_logo" style="height: 15px; width: auto; object-fit: contain;">
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
