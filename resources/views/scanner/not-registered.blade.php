@extends('user_layout.user')

@section('content')
    <div class="min-h-[calc(100vh-64px)] bg-[#F5F3FA] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full">

            <div
                class="bg-white/90 backdrop-blur-2xl rounded-[3.5rem] overflow-hidden border border-white shadow-2xl p-10 text-center">

                {{-- Icon --}}
                <div
                    class="inline-flex items-center justify-center w-24 h-24 bg-[#FEF9E8] rounded-full mb-8 shadow-inner border border-[#FDE89F]">
                    <svg class="w-12 h-12 text-[#F59E0B]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <h1 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Tag Not Registered</h1>
                <p class="text-gray-600 text-base font-semibold mb-8 leading-relaxed px-2">
                    This QR tag hasn't been registered by its owner yet. The owner needs to register it first to enable
                    contact features.
                </p>

                <div class="bg-[#EBE5F7] rounded-[2rem] p-6 mb-8 border border-[#d6ccf0]">
                    <p class="text-[#4B3D76] font-black text-sm uppercase tracking-widest">
                        QR Code: <span class="font-semibold">{{ $qrCode->qr_code }}</span>
                    </p>
                    <p class="text-[#4B3D76] font-black text-sm uppercase tracking-widest mt-2">
                        Category: <span class="font-semibold">{{ $qrCode->category->name }}</span>
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="text-left bg-gray-50 rounded-[2rem] p-6 border border-gray-100">
                        <h3 class="font-black text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#4B3D76]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Are you the owner?
                        </h3>
                        <p class="text-gray-500 font-semibold text-sm mb-5 leading-snug">
                            If you own this QR tag, please log in and register it to activate all features and secure your
                            belongings.
                        </p>
                        <a href="{{ route('login') }}"
                            class="flex justify-center w-full py-4 bg-[#4B3D76] text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-lg shadow-indigo-900/20 hover:bg-[#3c315e] transition-all active:scale-[0.98]">
                            Login & Register
                        </a>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-[0.15em] flex items-center gap-2">
                        Powered by <img src="{{ asset('assets/images/logos/quickreach_logo.jpeg') }}" alt="QwickReach Logo" class="qw_logo" style="height: 15px; width: auto; object-fit: contain;">
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
