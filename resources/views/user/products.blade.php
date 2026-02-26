@extends('user_layout.user')
@section('content')
    <div class="px-4 pt-6 pb-24 max-w-md mx-auto min-h-screen" style="background-color: #F0F0FA;">

        {{-- ── HERO SWIPER ── --}}
        <div class="swiper heroSwiper mb-8 rounded-2xl overflow-hidden shadow-xl"
            style="height: 205px; width: 100%; position: relative;">
            <div class="swiper-wrapper" style="display: flex;">
                @forelse ($sliders as $slider)
                    <div class="swiper-slide relative w-full h-full flex-shrink-0">
                        <div class="absolute inset-0">
                            <img src="{{ asset('storage/' . $slider->image_path) }}" class="w-full h-full object-cover"
                                style="object-position: center 20%; display: block;" alt="Banner"
                                onerror="this.src='https://placehold.co/600x400?text=QwickReach+Banner'">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent">
                            </div>
                        </div>
                        @if ($slider->link)
                            <div class="relative p-6 flex flex-col justify-end h-full z-10">
                                <a href="{{ $slider->link }}"
                                    class="inline-block w-fit text-white text-[11px] font-black px-6 py-2.5 rounded-full shadow-2xl active:scale-95 transition-all"
                                    style="background-color: #1A1A3E; border: 1px solid rgba(255,255,255,0.2);">
                                    SHOP NOW
                                </a>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="swiper-slide flex items-center justify-center" style="background:#E8E8F8;">
                        <p class="font-bold uppercase text-[10px] tracking-widest" style="color:#9B9BB4;">Promotion
                            Banners</p>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
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
                {{-- Changed to a lighter, softer border color and 1px width --}}
                <div class="product-card rounded-2xl overflow-hidden border transition-all active:scale-[0.97]"
                    data-category="{{ strtolower($category->name) }}"
                    style="background-color:#ffffff; border-color:#A3A3C2; box-shadow: 0 8px 20px rgba(26, 26, 62, 0.08);"
                    onclick="window.location.href='{{ route('user.category', $category->id) }}'">

                    {{-- Image Area --}}
                    <div class="relative h-40 border-b" style="background-color:#F8F8FA; border-color:#A3A3C2;">
                        <img src="{{ asset($category->icon ?? 'images/bag-qr.png') }}" class="w-full h-full object-cover"
                            onerror="this.src='https://placehold.co/200x200?text=Product'">

                        {{-- Add button --}}
                        <button
                            onclick="event.stopPropagation(); addToCart({{ $category->id }}, '{{ addslashes($category->name) }}', {{ $category->price }}, '{{ asset($category->icon ?? 'images/bag-qr.png') }}')"
                            class="absolute bottom-2 right-2 w-9 h-9 text-white rounded-full shadow-xl flex items-center justify-center font-bold transition-transform active:scale-75"
                            style="background-color:#1A1A3E; border: 2px solid #ffffff;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="3"
                                viewBox="0 0 24 24">
                                <path d="M12 5v14m-7-7h14" stroke-linecap="round" />
                            </svg>
                        </button>
                    </div>

                    {{-- Info Area --}}
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

        .product-card {
            transition: all 0.3s ease;
        }

        .product-card.hidden-card {
            display: none;
        }
    </style>

    <script>
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

            // Redirect immediately to checkout (Cart Page Step 1)
            window.location.href = "{{ route('user.checkout') }}";
        }
    </script>
@endsection
