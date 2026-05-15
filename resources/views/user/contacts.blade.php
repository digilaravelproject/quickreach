@extends('user_layout.user')

@section('content')
    <div class="p-5 space-y-6 pb-28 anim-fade-up">

        {{-- Page Header --}}
        <div class="space-y-1">
            <h1 class="font-display text-4xl font-black text-indigo-900 leading-tight">
                Contact Us
            </h1>
            <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest">We're here to help</p>
        </div>

        {{-- Contact Info Cards --}}
        <div class="space-y-3">

            @if ($contact->email)
                <a href="mailto:{{ $contact->email }}"
                    class="flex items-center gap-4 bg-white p-4 rounded-[20px] border border-indigo-50 shadow-sm active:scale-95 transition-transform">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 flex items-center justify-center text-xl flex-shrink-0">
                        📧
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Email</div>
                        <div class="text-sm font-bold text-indigo-900">{{ $contact->email }}</div>
                    </div>
                    <div class="ml-auto text-gray-300">›</div>
                </a>
            @endif

            @if ($contact->phone)
                <a href="tel:{{ $contact->phone }}"
                    class="flex items-center gap-4 bg-white p-4 rounded-[20px] border border-indigo-50 shadow-sm active:scale-95 transition-transform">
                    <div class="w-11 h-11 rounded-2xl bg-green-50 flex items-center justify-center text-xl flex-shrink-0">
                        📞
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Phone</div>
                        <div class="text-sm font-bold text-indigo-900">{{ $contact->phone }}</div>
                    </div>
                    <div class="ml-auto text-gray-300">›</div>
                </a>
            @endif

            @if ($contact->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $contact->whatsapp) }}" target="_blank"
                    class="flex items-center gap-4 bg-white p-4 rounded-[20px] border border-indigo-50 shadow-sm active:scale-95 transition-transform">
                    <div class="w-11 h-11 rounded-2xl bg-green-50 flex items-center justify-center text-xl flex-shrink-0">
                        💬
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">WhatsApp</div>
                        <div class="text-sm font-bold text-indigo-900">{{ $contact->whatsapp }}</div>
                    </div>
                    <div class="ml-auto text-gray-300">›</div>
                </a>
            @endif

            @if ($contact->address)
                <div class="flex items-start gap-4 bg-white p-4 rounded-[20px] border border-indigo-50 shadow-sm">
                    <div class="w-11 h-11 rounded-2xl bg-orange-50 flex items-center justify-center text-xl flex-shrink-0">
                        📍
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-0.5">Address</div>
                        <div class="text-sm font-bold text-indigo-900">{{ $contact->address }}</div>
                    </div>
                </div>
            @endif

            @if ($contact->support_hours)
                <div class="flex items-center gap-4 bg-indigo-600 p-4 rounded-[20px] shadow-sm shadow-indigo-200">
                    <div class="w-11 h-11 rounded-2xl bg-white/20 flex items-center justify-center text-xl flex-shrink-0">
                        🕐
                    </div>
                    <div>
                        <div class="text-[9px] font-black text-indigo-200 uppercase tracking-widest mb-0.5">Support Hours
                        </div>
                        <div class="text-sm font-bold text-white">{{ $contact->support_hours }}</div>
                    </div>
                </div>
            @endif

        </div>

        {{-- Social Media Section --}}
        @php
            $socials = [
                'instagram' => [
                    'label' => 'Instagram',
                    'emoji' => '📸',
                    'color' => 'bg-pink-50',
                    'text' => 'text-pink-600',
                ],
                'facebook' => [
                    'label' => 'Facebook',
                    'emoji' => '📘',
                    'color' => 'bg-blue-50',
                    'text' => 'text-blue-600',
                ],
                'twitter' => [
                    'label' => 'Twitter / X',
                    'emoji' => '🐦',
                    'color' => 'bg-sky-50',
                    'text' => 'text-sky-600',
                ],
                'youtube' => ['label' => 'YouTube', 'emoji' => '▶️', 'color' => 'bg-red-50', 'text' => 'text-red-600'],
                'linkedin' => [
                    'label' => 'LinkedIn',
                    'emoji' => '💼',
                    'color' => 'bg-blue-50',
                    'text' => 'text-blue-700',
                ],
                'website' => [
                    'label' => 'Website',
                    'emoji' => '🌐',
                    'color' => 'bg-indigo-50',
                    'text' => 'text-indigo-600',
                ],
            ];

            $hasSocials = collect($socials)->keys()->filter(fn($key) => !empty($contact->$key))->isNotEmpty();
        @endphp

        @if ($hasSocials)
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="h-1 w-8 bg-indigo-600 rounded-full"></div>
                    <h2 class="font-display text-lg font-black text-indigo-900">Find Us Online</h2>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach ($socials as $key => $meta)
                        @if (!empty($contact->$key))
                            <a href="{{ $contact->$key }}" target="_blank"
                                class="flex flex-col items-center gap-2 bg-white p-4 rounded-[20px] border border-indigo-50 shadow-sm active:scale-95 transition-transform text-center">
                                <div
                                    class="w-12 h-12 rounded-2xl {{ $meta['color'] }} flex items-center justify-center text-2xl">
                                    {{ $meta['emoji'] }}
                                </div>
                                <span class="text-[10px] font-black {{ $meta['text'] }} uppercase tracking-wide">
                                    {{ $meta['label'] }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <style>
        .anim-fade-up {
            animation: fadeUp 0.4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
