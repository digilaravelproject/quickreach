@extends('user_layout.user')

@section('content')
    <div class="px-4 pt-6 pb-24 max-w-md mx-auto min-h-screen" style="background-color: #F0F0FA;">

        {{-- Policy Card --}}
        <div class="rounded-2xl p-6 mb-10 shadow-xl border"
            style="background-color: #ffffff; border-color: #A3A3C2; box-shadow: 0 8px 20px rgba(26, 26, 62, 0.08);">

            {{-- Title --}}
            <h1 class="font-display font-bold text-2xl mb-2" style="color: #1A1A3E; line-height: 1.2;">
                {{ $policy->title }}
            </h1>

            {{-- Date Badge --}}
            @if ($policy->effective_date)
                <div class="inline-block px-3 py-1 rounded-lg mb-6"
                    style="background-color: #E8E8F8; border: 1px solid #D1D1E9;">
                    <p style="color: #6B6B8A; font-size: 11px; font-weight: 800; margin-bottom: 0;">
                        EFFECTIVE DATE: {{ \Carbon\Carbon::parse($policy->effective_date)->format('d M, Y') }}
                    </p>
                </div>
            @endif

            <hr style="border: 0; border-top: 1px solid #E8E8F5; margin-bottom: 20px;">

            {{-- Dynamic Content --}}
            <div class="policy-content" style="color: #4A4A6A; line-height: 1.7; font-size: 14px; font-weight: 500;">
                {!! $policy->content !!}
            </div>
        </div>

        {{-- Small Branding at bottom --}}
        <div class="text-center opacity-40">
            <p class="text-[10px] font-black uppercase tracking-[0.3em]" style="color:#9B9BB4;">
                Qwick<span style="color:#5B5BDB;">Reach</span>
            </p>
        </div>
    </div>

    <style>
        /* CKEditor content styling to match your theme */
        .policy-content h2 {
            color: #1A1A3E;
            margin-top: 24px;
            margin-bottom: 10px;
            font-size: 1.1rem;
            font-weight: 800;
        }

        .policy-content p {
            margin-bottom: 15px;
        }

        .policy-content ul,
        .policy-content ol {
            padding-left: 20px;
            margin-bottom: 20px;
            color: #5B5BDB;
            /* Bullet points color match */
        }

        .policy-content li {
            margin-bottom: 10px;
            color: #4A4A6A;
            /* Text color inside list */
        }

        .policy-content strong {
            color: #1A1A3E;
            font-weight: 700;
        }
    </style>
@endsection
