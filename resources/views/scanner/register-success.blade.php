@extends('user_layout.user')

@section('content')
    <div class="min-h-[calc(100vh-64px)] bg-[#F5F3FA] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">

            <div
                class="bg-white/90 backdrop-blur-2xl rounded-[3.5rem] overflow-hidden border border-white shadow-2xl p-10 text-center relative">

                {{-- Decorative Background Elements --}}
                <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
                    <div class="absolute w-20 h-20 bg-[#86D657] rounded-full blur-3xl -top-6 -left-6"></div>
                    <div class="absolute w-28 h-28 bg-[#4B3D76] rounded-full blur-3xl bottom-10 -right-10"></div>
                </div>

                <div class="relative z-10">
                    {{-- Success Icon (Green Tick) --}}
                    <div
                        class="inline-flex items-center justify-center w-24 h-24 bg-[#E8F8E0] rounded-full mb-6 shadow-inner border border-[#c1edac]">
                        <svg class="w-12 h-12 text-[#86D657]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h1 class="text-3xl font-black text-gray-900 mb-2 tracking-tight">Registration Successful!</h1>

                    {{-- English Message --}}
                    <p class="text-gray-500 font-semibold mb-8 text-sm leading-relaxed px-2">
                        Your QwickReach smart tag has been successfully activated and linked to your contact details.
                    </p>

                    {{-- Tag Details Info Box --}}
                    <div
                        class="bg-[#EBE5F7] rounded-2xl p-5 mb-8 border border-[#d6ccf0] text-left flex items-center gap-4">

                        <div>
                            <p class="text-[#4B3D76] font-black text-xs uppercase tracking-widest mb-0.5">
                                Category: {{ $qrCode->category->name }}
                            </p>
                            <p class="text-gray-900 font-bold text-sm">
                                Tag ID: {{ $qrCode->qr_code }}
                            </p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-4">
                        {{-- GO TO HOME BUTTON --}}
                        <a href="{{ url('/') }}"
                            class="flex justify-center items-center gap-2 w-full py-4 bg-[#4B3D76] text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-indigo-900/20 hover:bg-[#3c315e] transition-all active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Go to Home
                        </a>


                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.15em] flex items-center gap-2">
                        Secured by <img src="{{ asset('assets/images/logos/quickreach_logo.jpeg') }}" alt="QwickReach Logo" style="height: 15px; width: auto; object-fit: contain;">
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
