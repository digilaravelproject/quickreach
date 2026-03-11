@extends('user_layout.user')
@section('content')
    <div class="px-4 pt-6 pb-24 max-w-md mx-auto min-h-screen" style="background-color: #F0F0FA;">

        {{-- ── HERO SWIPER (ORIGINAL) ── --}}
        <div class="swiper heroSwiper mb-8 rounded-2xl overflow-hidden shadow-xl">
            <div class="swiper-wrapper">
                @forelse ($sliders as $slider)
                    <div class="swiper-slide relative">
                        <img src="{{ asset('storage/' . $slider->image_path) }}" alt="Banner"
                            class="w-full banner-img object-contain"
                            onerror="this.src='https://placehold.co/600x400?text=QwickReach+Banner'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        @if ($slider->link)
                            <div class="absolute bottom-5 left-5">
                                <a href="{{ $slider->link }}"
                                    class="text-white text-[11px] font-black px-6 py-2 rounded-full"
                                    style="background:#1A1A3E;">
                                    SHOP NOW
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="swiper-slide flex items-center justify-center bg-[#E8E8F8] banner-img">
                        <p class="font-bold text-[10px] text-[#9B9BB4] uppercase tracking-widest">
                            Promotion Banners
                        </p>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>
        {{-- ── HOW IT WORKS SECTION ── --}}
        <div class="mb-10 rounded-3xl overflow-hidden">
            <div class="relative p-6"
                style="background: radial-gradient(ellipse at top, #D4C2FF 0%, #C0AAFF 40%, #B8A0F8 100%);">

                {{-- Sparkle decorations --}}
                <div class="sparkle-dot" style="top:8%; left:4%;"></div>
                <div class="sparkle-dot" style="top:15%; right:6%;"></div>
                <div class="sparkle-dot sm" style="top:40%; left:2%;"></div>
                <div class="sparkle-dot" style="bottom:20%; right:4%;"></div>
                <div class="sparkle-dot sm" style="bottom:10%; left:30%;"></div>

                <h3 class="font-display text-xl font-black text-center mb-8 relative" style="color:#1A1A3E; z-index:1;">
                    How QwickReach Works
                </h3>

                <div class="relative" style="z-index:1;">
                    {{-- Dotted connecting line --}}
                    <div class="absolute"
                        style="top:18px; left:calc(12.5% + 4px); right:calc(12.5% + 4px); height:2px; background: repeating-linear-gradient(to right, rgba(255,255,255,0.8) 0, rgba(255,255,255,0.8) 6px, transparent 6px, transparent 12px);">
                    </div>

                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($howItWorks as $step)
                            <div class="flex flex-col items-center text-center">
                                {{-- Numbered circle --}}
                                <div class="w-9 h-9 rounded-full flex items-center justify-center font-black text-sm text-white mb-3 shadow-lg relative"
                                    style="background:#6B47D6; border:3px solid rgba(255,255,255,0.9); z-index:2;">
                                    {{ $step->step_order }}
                                </div>
                                {{-- White image card --}}
                                <div class="w-full rounded-2xl bg-white shadow-md mb-2 flex items-center justify-center overflow-hidden"
                                    style="aspect-ratio:1/1; padding:10px; border:1px solid rgba(255,255,255,0.8);">
                                    <img src="{{ asset('storage/' . $step->image_path) }}"
                                        class="w-full h-full object-contain">
                                </div>
                                {{-- Title --}}
                                <p class="text-[10px] font-bold leading-snug" style="color:#1A1A3E;">
                                    {{ $step->title }}
                                </p>
                                @if (!empty($step->description))
                                    <p class="text-[9px] mt-0.5 leading-tight" style="color:#4A3A7A; opacity:0.85;">
                                        {{ $step->description }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        {{-- ── CATEGORIES CHIPS ── --}}
        <div class="flex gap-3 overflow-x-auto no-scrollbar mb-6 pb-2">
            <button onclick="filterCat(this, 'all')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-md whitespace-nowrap transition-all"
                style="background-color:#1A1A3E; color:#ffffff; border: 1px solid #1A1A3E;">
                All Tags
            </button>
            <button onclick="filterCat(this, 'car')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                🚗 Car
            </button>
            <button onclick="filterCat(this, 'bike')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                🏍️ Bike
            </button>
            <button onclick="filterCat(this, 'bag')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                👜 Bag
            </button>
            <button onclick="filterCat(this, 'pet')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                🐾 Pet
            </button>
            <button onclick="filterCat(this, 'children')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                👶 Children
            </button>
            <button onclick="filterCat(this, 'combo')"
                class="cat-chip px-5 py-2.5 rounded-xl text-[11px] font-bold shadow-sm whitespace-nowrap transition-all"
                style="background-color:#ffffff; color:#6B6B8A; border: 1px solid #E8E8F5;">
                🎁 Combo
            </button>
        </div>



        {{-- ── CATEGORIES HEADING ── --}}
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-display text-lg font-bold" style="color:#1A1A3E;">Categories</h3>
            <a href="#" class="text-xs font-bold" style="color:#5B5BDB;">See all →</a>
        </div>

        {{-- ── PRODUCT GRID ── --}}
        <div class="grid grid-cols-2 gap-4 mb-10" id="productGrid">
            @foreach ($categories as $index => $category)
                <div class="product-card rounded-2xl overflow-hidden border transition-all active:scale-[0.97]"
                    data-category="{{ strtolower($category->name) }}"
                    style="background-color:#ffffff; border-color:#A3A3C2; box-shadow: 0 8px 20px rgba(26, 26, 62, 0.08);"
                    onclick="window.location.href='{{ route('user.category', $category->id) }}'">

                    <div class="relative h-40 border-b" style="background-color:#F8F8FA; border-color:#A3A3C2;">
                        <img src="{{ asset($category->icon ?? 'images/bag-qr.png') }}" class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/200x200?text=Product'">
                        <button
                            onclick="event.stopPropagation(); addToCart({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->price }}, '{{ asset($category->icon ?? 'images/bag-qr.png') }}')"
                            class="absolute bottom-2 right-2 w-9 h-9 text-white rounded-full shadow-xl flex items-center justify-center font-bold transition-transform active:scale-75"
                            style="background-color:#1A1A3E; border: 2px solid #ffffff;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="9" cy="21" r="1"></circle>
                                <circle cx="20" cy="21" r="1"></circle>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M1 1h4l2.68 12.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-3">
                        <h4 class="font-display font-bold text-[15px] mb-0.5 leading-tight" style="color:#1A1A3E;">
                            {{ $category->name }}
                        </h4>
                        <p class="text-[9px] font-bold uppercase tracking-tight mb-2" style="color:#9B9BB4;">
                            Security Tag
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="font-black text-[15px]"
                                style="color:#1A1A3E;">₹{{ number_format($category->price, 0) }}</span>
                            @if ($category->in_stock)
                                <span class="text-[8px] font-bold px-1.5 py-0.5 rounded-md"
                                    style="background:#E8F5E9; color:#2E7D32; border: 1px solid #C8E6C9;">IN STOCK</span>
                            @else
                                <span class="text-[8px] font-bold px-1.5 py-0.5 rounded-md"
                                    style="background:#FFEBEE; color:#C62828; border: 1px solid #FFCDD2;">OUT OF
                                    STOCK</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- ── WHERE TO USE SECTION ── --}}
        <div class="mb-8">
            <h3 class="font-display text-lg font-bold mb-4" style="color:#1A1A3E;">Where Can You Use QwickReach?</h3>
            <div class="grid grid-cols-2 gap-3">
                @foreach ($useCases as $uc)
                    <div class="p-4 rounded-2xl border"
                        style="background:#ffffff; border-color:#E8E8F5; box-shadow: 0 2px 12px rgba(91,91,219,0.07);">
                        <div class="flex items-center gap-2 mb-2">
                            <img src="{{ asset('storage/' . $uc->icon_image) }}" class="w-6 h-6 object-contain">
                            <h4 class="font-black text-sm" style="color:#1A1A3E;">{{ $uc->title }}</h4>
                        </div>
                        <p class="text-[11px] leading-relaxed" style="color:#6B6B8A;">{{ $uc->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ── EVERYDAY EMERGENCIES SECTION ── --}}
        <div class="mb-8">
            <div class="p-6 rounded-3xl" style="background:#FFF0EE;">
                <h3 class="text-2xl font-black mb-1" style="color:#7B1010;">Everyday Emergencies</h3>
                <p class="text-sm font-medium mb-6" style="color:#B03030;">Because safety should never depend on luck.</p>

                @foreach ($emergencies as $em)
                    @php
                        $cleaned = str_replace(['<br>', '<br/>', '<br />', '</p>', '</li>'], "\n", $em->description);
                        $cleaned = strip_tags($cleaned);
                        $lines = array_filter(
                            array_map(function ($line) {
                                return trim(ltrim(trim($line), '•·-*'));
                            }, explode("\n", $cleaned)),
                        );
                        $lines = array_filter($lines, function ($line) {
                            return !empty($line) &&
                                stripos($line, 'because safety') === false &&
                                stripos($line, 'depend on luck') === false &&
                                strlen($line) > 2;
                        });
                    @endphp
                    @foreach ($lines as $line)
                        <div class="flex items-center gap-4 mb-4 last:mb-0">
                            <span class="flex-shrink-0 w-[10px] h-[10px] rounded-full" style="background:#FF5252;"></span>
                            <span class="text-[15px] font-medium" style="color:#1A1A1A;">{{ $line }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>


        {{-- ── BRANDING ── --}}
        <div class="text-center py-6 opacity-40">
            <p class="text-[10px] font-black uppercase tracking-[0.3em]" style="color:#9B9BB4;">
                Qwick<span style="color:#5B5BDB;">Reach</span>
            </p>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ── Swiper (ORIGINAL styles) ── */
        .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: #ffffff !important;
            width: 16px;
            border-radius: 4px;
        }

        .swiper-pagination {
            bottom: 10px !important;
        }

        .heroSwiper {
            width: 100%;
        }

        .banner-img {
            width: 100%;
            height: 205px;
            object-fit: contain;
        }

        @media (min-width: 768px) {
            .banner-img {
                width: 100%;
                height: auto;
                max-height: 420px;
                object-fit: contain;
            }
        }

        /* ── Products ── */
        .product-card {
            transition: all 0.3s ease;
        }

        .product-card.hidden-card {
            display: none;
        }

        /* ── How It Works sparkles ── */
        .sparkle-dot {
            position: absolute;
            width: 12px;
            height: 12px;
            background: white;
            opacity: 0.55;
            clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
        }

        .sparkle-dot.sm {
            width: 7px;
            height: 7px;
            opacity: 0.4;
        }
    </style>

    <script>
        /* ── ORIGINAL Swiper init ── */
        document.addEventListener('DOMContentLoaded', () => {
            new Swiper('.heroSwiper', {
                loop: true,
                speed: 800,
                parallax: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
            });
        });

        /* ── ORIGINAL filter logic ── */
        const filterKeywords = {
            'all': [],
            'car': ['car', 'cars'],
            'bike': ['bike', 'bikes', 'bicycle', 'cycle'],
            'bag': ['bag', 'bags', 'backpack'],
            'pet': ['pet', 'pets', 'dog', 'cat', 'animal'],
            'children': ['children', 'child', 'kids', 'kid', 'baby'],
            'combo': ['combo', 'combos', 'bundle', 'pack'],
        };

        function filterCat(btn, cat) {
            document.querySelectorAll('.cat-chip').forEach(b => {
                b.style.backgroundColor = '#ffffff';
                b.style.color = '#6B6B8A';
                b.style.borderColor = '#E8E8F5';
                b.classList.remove('shadow-md');
                b.classList.add('shadow-sm');
            });
            btn.style.backgroundColor = '#1A1A3E';
            btn.style.color = '#ffffff';
            btn.style.borderColor = '#1A1A3E';
            btn.classList.remove('shadow-sm');
            btn.classList.add('shadow-md');

            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                if (cat === 'all') {
                    card.classList.remove('hidden-card');
                    return;
                }
                const cardName = (card.getAttribute('data-category') || '').toLowerCase();
                const keywords = filterKeywords[cat] || [cat];
                const matched = keywords.some(keyword => cardName.includes(keyword));
                if (matched) {
                    card.classList.remove('hidden-card');
                } else {
                    card.classList.add('hidden-card');
                }
            });
        }

        /* ── ORIGINAL addToCart ── */
        function addToCart(id, name, price, icon) {
            let cart = JSON.parse(localStorage.getItem('quickreach_cart')) || [];
            const existingIndex = cart.findIndex(item => item.id === id);
            if (existingIndex !== -1) {
                cart[existingIndex].quantity += 1;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    icon: icon,
                    quantity: 1
                });
            }
            localStorage.setItem('quickreach_cart', JSON.stringify(cart));
            window.location.href = "{{ route('user.checkout') }}";
        }
    </script>
@endsection
