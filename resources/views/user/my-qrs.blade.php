@extends('user_layout.user')

@section('content')
    <div class="min-h-screen bg-gray-50 pb-32">
        <div class="max-w-md mx-auto px-5 pt-8">

            {{-- ── HEADER ── --}}
            <div class="flex justify-between items-end mb-8">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Security Dashboard</p>
                    <h1 class="text-3xl font-black text-gray-900 leading-tight">My Tags</h1>
                </div>
                {{-- Add New Button --}}
                <a href="{{ route('user.products') }}"
                    class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center shadow-sm active:scale-90 transition-transform">
                    <span class="text-2xl font-bold text-[#86D657]">+</span>
                </a>
            </div>

            {{-- Alerts --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-[#86D657] text-green-800 p-4 rounded-xl shadow-sm">
                    <p class="text-xs font-bold">{{ session('success') }}</p>
                </div>
            @endif

            {{-- ── TAGS LIST ── --}}
            @if ($qrCodes->count() > 0)
                <div class="space-y-5">
                    @foreach ($qrCodes as $qr)
                        @php
                            $catName = strtolower($qr->category->name ?? 'general');
                            $icon = '🏷️';
                            if (str_contains($catName, 'car')) {
                                $icon = '🚗';
                            } elseif (str_contains($catName, 'bike')) {
                                $icon = '🏍️';
                            } elseif (str_contains($catName, 'pet')) {
                                $icon = '🐾';
                            } elseif (str_contains($catName, 'child')) {
                                $icon = '👦';
                            } elseif (str_contains($catName, 'bag')) {
                                $icon = '🎒';
                            } elseif (str_contains($catName, 'key')) {
                                $icon = '🔑';
                            }
                        @endphp

                        <div
                            class="bg-white rounded-[28px] p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all active:scale-[0.98]">
                            {{-- Top Row: Icon & Status --}}
                            <div class="flex justify-between items-start mb-4">
                                <div
                                    class="w-14 h-14 bg-gray-50 rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-gray-100">
                                    {{ $icon }}
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-block bg-green-100 text-green-700 text-[9px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">
                                        ● Active
                                    </span>
                                    <p class="text-[10px] font-bold text-gray-400 mt-2 uppercase">ID: {{ $qr->qr_code }}
                                    </p>
                                </div>
                            </div>

                            {{-- Tag Info --}}
                            <div class="mb-5">
                                <h3 class="text-xl font-black text-gray-900 leading-tight">
                                    {{ $qr->registration->full_name ?? 'My Smart Tag' }}
                                </h3>
                                <p class="text-sm font-bold text-[#86D657] mt-0.5">
                                    {{ $qr->category->name ?? 'Universal Protection' }}
                                </p>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex gap-3">
                                <button
                                    class="flex-1 py-3 bg-gray-900 text-white rounded-xl font-bold text-xs shadow-lg shadow-gray-200 active:scale-95 transition-all">
                                    Edit Details
                                </button>
                                <a href="#"
                                    class="w-12 h-12 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center border border-gray-100 active:scale-95 transition-all">
                                    <span class="text-lg">👁️</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 custom-pagination">
                    {{ $qrCodes->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-20 bg-white rounded-[40px] border-2 border-dashed border-gray-200">
                    <div class="text-6xl mb-6">🔍</div>
                    <h3 class="text-xl font-black text-gray-800 mb-2">No Tags Found</h3>
                    <p class="text-sm text-gray-400 font-medium mb-8 px-10">You haven't registered any QR tags yet. Start
                        protecting your gear!</p>
                    <a href="{{ route('user.products') }}"
                        class="px-8 py-4 bg-[#86D657] text-gray-900 font-black text-sm rounded-2xl shadow-xl shadow-green-100 hover:bg-[#77c24a] transition-all uppercase tracking-wider">
                        Buy Your First Tag
                    </a>
                </div>
            @endif

        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        /* Pagination styling fix */
        .custom-pagination nav {
            display: flex;
            justify-content: center;
        }

        .custom-pagination svg {
            width: 20px;
        }

        .custom-pagination span,
        .custom-pagination a {
            border-radius: 8px !important;
            margin: 0 2px;
        }
    </style>
@endsection
