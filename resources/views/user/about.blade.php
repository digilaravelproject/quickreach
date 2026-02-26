@extends('user_layout.user')

@section('content')
    <div class="p-5 space-y-10 pb-28 anim-fade-up">

        <div class="space-y-4">
            <h1 class="font-display text-4xl font-black text-indigo-900 leading-tight">
                {{ $about->main_title ?? 'About QwickReach' }}
            </h1>

            @if ($about->main_description)
                <div class="text-gray-500 text-sm leading-relaxed prose prose-sm max-w-none">
                    {!! $about->main_description !!} {{-- Editor HTML render karne ke liye !! use kiya --}}
                </div>
            @endif

            @if ($about->main_image)
                <div class="rounded-[30px] overflow-hidden shadow-2xl shadow-indigo-100 border-4 border-white">
                    <img src="{{ asset('storage/' . $about->main_image) }}" class="w-full h-56 object-cover">
                </div>
            @endif
        </div>

        <div class="bg-indigo-600 p-8 rounded-[40px] shadow-xl shadow-indigo-200 relative overflow-hidden">
            {{-- Background Decoration --}}
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>

            <h2 class="font-display text-2xl font-extrabold text-white mb-4 relative z-10">
                {{ $about->mission_title ?? 'Our Mission' }}
            </h2>

            <div class="text-indigo-50 text-xs leading-relaxed prose prose-invert prose-sm relative z-10">
                {!! $about->mission_description !!}
            </div>

            @if ($about->mission_image)
                <div class="mt-6 rounded-2xl overflow-hidden border-2 border-indigo-400">
                    <img src="{{ asset('storage/' . $about->mission_image) }}" class="w-full h-40 object-cover">
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <div class="h-1 w-12 bg-indigo-600 rounded-full"></div>
                <h2 class="font-display text-2xl font-black text-indigo-900">
                    {{ $about->story_title ?? 'Our Story' }}
                </h2>
            </div>

            @if ($about->story_image)
                <div
                    class="rounded-[35px] overflow-hidden grayscale hover:grayscale-0 transition-all duration-700 shadow-lg">
                    <img src="{{ asset('storage/' . $about->story_image) }}" class="w-full h-48 object-cover">
                </div>
            @endif

            <div
                class="text-gray-600 text-sm leading-relaxed italic border-l-4 border-indigo-200 pl-4 prose prose-sm max-w-none">
                {!! $about->story_description !!}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 pt-4">
            <div class="bg-white p-6 rounded-[30px] border border-indigo-50 text-center shadow-sm">
                <div class="text-2xl font-black text-indigo-600">12+</div>
                <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Global Presence</div>
            </div>
            <div class="bg-white p-6 rounded-[30px] border border-indigo-50 text-center shadow-sm">
                <div class="text-2xl font-black text-indigo-600">205k+</div>
                <div class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1">Happy Users</div>
            </div>
        </div>

    </div>

    <style>
        /* Editor Content Styling Fixes */
        .prose p {
            margin-bottom: 12px;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 20px;
            margin-bottom: 12px;
        }

        .prose ol {
            list-style-type: decimal;
            padding-left: 20px;
            margin-bottom: 12px;
        }

        .prose strong {
            font-weight: 800;
            color: inherit;
        }
    </style>
@endsection
