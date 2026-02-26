@extends('user_layout.user')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full">

            <div
                class="bg-white/80 backdrop-blur-2xl rounded-[3.5rem] overflow-hidden border-2 border-white/80 shadow-2xl p-12 text-center">

                {{-- Icon --}}
                <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full mb-8">
                    <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>

                <h1 class="text-4xl font-black text-gray-900 mb-4">QR Tag Not Registered</h1>
                <p class="text-gray-600 text-lg font-semibold mb-8 leading-relaxed">
                    This QR tag hasn't been registered by its owner yet. The owner needs to register it first to enable
                    contact features.
                </p>

                <div class="bg-purple-50 rounded-[2rem] p-6 mb-8">
                    <p class="text-purple-900 font-bold text-sm">
                        <strong>QR Code:</strong> {{ $qrCode->qr_code }}
                    </p>
                    <p class="text-purple-700 font-semibold text-sm mt-2">
                        <strong>Category:</strong> {{ $qrCode->category->name }}
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="text-left bg-gray-50 rounded-[2rem] p-6">
                        <h3 class="font-black text-gray-900 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd" />
                            </svg>
                            Are you the owner?
                        </h3>
                        <p class="text-gray-600 font-semibold text-sm mb-4">
                            If you own this QR tag, please log in and register it to activate all features.
                        </p>
                        <a href="{{ route('login') }}"
                            class="inline-block px-8 py-3 bg-gradient-to-r from-purple-500 to-purple-700 text-white rounded-[1.5rem] font-bold hover:shadow-lg transition-all">
                            Login & Register
                        </a>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-gray-200">
                    <p class="text-gray-400 text-sm font-semibold">
                        Powered by <span class="font-black text-purple-600">QwickReach</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
