@extends('user_layout.user')
@section('content')
    <div class="px-6 pt-6 pb-40 max-w-md mx-auto min-h-screen relative" style="background-color: #F0F0FA;"
        x-data="{ qty: 1, price: {{ $category->price }} }">

        {{-- ── BACK BUTTON ── --}}
        <div class="flex items-center mb-6">
            <a href="{{ route('user.products') }}"
                class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm active:scale-90 transition-transform"
                style="background:#ffffff; border: 1px solid #DDDDF0;">
                <span class="text-xl font-bold" style="color:#1A1A3E;">←</span>
            </a>
        </div>

        {{-- ── PRODUCT IMAGE ── --}}
        <div class="rounded-[40px] p-8 mb-8 shadow-inner flex justify-center items-center overflow-hidden h-72"
            style="background:#EAEAF8;">
            <img src="{{ asset($category->icon) }}"
                class="w-full h-full object-contain drop-shadow-2xl transition-transform duration-500 hover:scale-105"
                onerror="this.src='https://placehold.co/400x400?text=QR+Tag'">
        </div>

        {{-- ── PRODUCT INFO ── --}}
        <div class="mb-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <p class="text-[10px] font-bold uppercase tracking-widest mb-1" style="color:#5B5BDB;">Security Tag</p>
                    <h1 class="font-display text-3xl font-black leading-tight" style="color:#1A1A3E;">{{ $category->name }}
                    </h1>
                </div>
                <div class="px-3 py-1 rounded-lg" style="background:#EAEAF8;">
                    <span class="font-bold text-sm" style="color:#5B5BDB;">★ 4.8</span>
                </div>
            </div>
            <div class="flex items-center gap-2 mb-6">
                <span class="text-xs font-bold" style="color:#9B9BB4;">Over 200+ active scans this month</span>
            </div>
        </div>

        {{-- ── PRICE & QUANTITY ── --}}
        <div class="flex justify-between items-center mb-8 p-4 rounded-2xl border"
            style="background:#EAEAF8; border-color:#DDDDF0;">
            <div>
                <p class="text-xs font-bold uppercase mb-0.5" style="color:#9B9BB4;">Total Price</p>
                <p class="font-display text-2xl font-black" style="color:#1A1A3E;">₹<span
                        x-text="(price * qty).toLocaleString()"></span></p>
            </div>

            <div class="flex items-center gap-5 px-4 py-2 rounded-xl shadow-sm border"
                style="background:#ffffff; border-color:#DDDDF0;">
                <button @click="qty > 1 ? qty-- : ''"
                    class="w-8 h-8 flex items-center justify-center text-xl font-bold transition-colors"
                    style="color:#9B9BB4;">-</button>
                <span class="font-black text-lg w-4 text-center" style="color:#1A1A3E;" x-text="qty"></span>
                <button @click="qty++" class="w-8 h-8 flex items-center justify-center text-xl font-bold transition-colors"
                    style="color:#5B5BDB;">+</button>
            </div>
        </div>

        {{-- ── DESCRIPTION ── --}}
        <div class="mb-10">
            <h3 class="font-display font-bold mb-2 pl-3" style="color:#1A1A3E; border-left: 4px solid #5B5BDB;">Description
            </h3>
            <p class="text-sm leading-relaxed font-medium" style="color:#9B9BB4;">
                {{ $category->description ?? 'Secure your belongings with this high-quality smart QR tag.' }}
            </p>
        </div>

        {{-- ── CHECKOUT BUTTON (Floating above Nav Bar) ── --}}
        <div class="fixed bottom-24 left-0 right-0 px-6 max-w-md mx-auto z-[999]">
            <button @click="addToCart(true, qty)"
                class="w-full text-white text-[15px] font-black py-4 rounded-2xl shadow-2xl active:scale-[0.95] transition-all uppercase tracking-wider"
                style="background:#1A1A3E; border-bottom: 4px solid #5B5BDB;">
                Proceed to Checkout
            </button>
        </div>
    </div>

    <style>
        /* Ensure the fixed button doesn't look weird on super small screens */
        @media (max-height: 650px) {
            .fixed {
                position: relative !important;
                bottom: 0 !important;
                margin-top: 20px;
            }

            .pb-40 {
                padding-bottom: 20px !important;
            }
        }
    </style>

    <script>
        function addToCart(checkout, qty) {
            let cart = JSON.parse(localStorage.getItem('quickreach_cart')) || [];
            const itemId = {{ $category->id }};
            const existingIndex = cart.findIndex(item => item.id === itemId);

            if (existingIndex !== -1) {
                cart[existingIndex].quantity += qty;
            } else {
                cart.push({
                    id: itemId,
                    name: '{{ $category->name }}',
                    price: {{ $category->price }},
                    icon: '{{ asset($category->icon) }}',
                    quantity: qty
                });
            }

            localStorage.setItem('quickreach_cart', JSON.stringify(cart));
            if (checkout) {
                window.location.href = "{{ route('user.checkout') }}";
            }
        }
    </script>
@endsection
