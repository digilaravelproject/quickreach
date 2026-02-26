@extends('user_layout.user')

@section('content')
    {{-- Pass auth status & user data to Alpine.js safely --}}
    <script>
        window.__AUTH__ = {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            loginUrl: "{{ route('login') }}",
            checkoutUrl: "{{ route('user.checkout') }}",
            @auth
            name: "{{ Auth::user()->name ?? '' }}",
            email: "{{ Auth::user()->email ?? '' }}",
            mobile: "{{ Auth::user()->mobile_number ?? '' }}"
        @endauth
        @guest
        name: '',
            email: '',
            mobile: ''
        @endguest
        };
    </script>

    <div class="p-6 pb-32 max-w-md mx-auto" x-data="checkoutFlow()" style="background-color: #F0F0FA; min-height: 100vh;">

        <!-- Toast Notification -->
        <div x-show="toast.show" x-transition.opacity.duration.300ms
            class="fixed top-5 left-1/2 -translate-x-1/2 z-50 px-6 py-4 rounded-2xl shadow-xl font-bold text-sm text-white"
            :class="toast.type === 'error' ? 'bg-red-500' : 'bg-[#5B5BDB]'" x-text="toast.message" style="display: none;">
        </div>

        <!-- Login Required Modal -->
        <div x-show="showLoginModal" x-transition.opacity style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-6"
            style="background: rgba(26, 26, 62, 0.6); backdrop-filter: blur(6px);">
            <div class="w-full max-w-sm rounded-[32px] p-8 text-center"
                style="background:#ffffff; box-shadow: 0 20px 60px rgba(90,90,180,0.2);">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-5"
                    style="background:#EAEAF8;">
                    <svg width="28" height="28" fill="none" stroke="#5B5BDB" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <h3 class="font-display font-black text-xl mb-2" style="color:#1A1A3E;">Login Required</h3>
                <p class="text-sm font-medium mb-6" style="color:#9B9BB4;">Login is required to proceed with payment. Your
                    data will be saved!.</p>

                <a :href="loginRedirectUrl()"
                    class="block w-full text-white py-4 rounded-[16px] font-black text-sm mb-3 active:scale-95 transition-all"
                    style="background-color:#1A1A3E; border-bottom: 3px solid #5B5BDB;">
                    Login to Continue
                </a>
                <button @click="showLoginModal = false"
                    class="w-full py-3 rounded-[16px] font-bold text-sm transition-all active:scale-95"
                    style="background:#EAEAF8; color:#9B9BB4;">
                    Cancel
                </button>
            </div>
        </div>

        <!-- ── STEP INDICATOR ── -->
        <div class="flex items-center justify-between mb-8 text-[10px] font-bold uppercase tracking-widest relative">
            <div class="absolute top-1/2 left-0 w-full h-0.5 -z-10 -translate-y-1/2" style="background: #DDDDF0;">
            </div>
            <div class="absolute top-1/2 left-0 h-0.5 -z-10 -translate-y-1/2 transition-all duration-300"
                style="background: #1A1A3E;" :style="'width: ' + ((step - 1) * 50) + '%'"></div>

            <span class="px-3 py-1.5 rounded-full transition-colors duration-300"
                :class="step >= 1 ? 'bg-[#1A1A3E] text-white' : 'bg-[#EAEAF8] text-[#9B9BB4]'">Cart</span>
            <span class="px-3 py-1.5 rounded-full transition-colors duration-300"
                :class="step >= 2 ? 'bg-[#1A1A3E] text-white' : 'bg-[#EAEAF8] text-[#9B9BB4]'">Shipping</span>
            <span class="px-3 py-1.5 rounded-full transition-colors duration-300"
                :class="step >= 3 ? 'bg-[#1A1A3E] text-white' : 'bg-[#EAEAF8] text-[#9B9BB4]'">Payment</span>
        </div>

        <!-- ── HEADER ── -->
        <div class="flex items-center mb-8">
            <button @click="goBack()"
                class="w-10 h-10 rounded-full flex items-center justify-center transition-transform active:scale-90"
                style="border: 1px solid #DDDDF0; background:#ffffff;">
                <svg width="20" height="20" fill="none" stroke="#1A1A3E" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h2 class="flex-1 text-center font-display font-black text-xl" style="color:#1A1A3E;" x-text="getStepTitle()">
            </h2>
            {{-- Auth Badge --}}
            @auth
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full" style="background:#EAEAF8;">
                    <div class="w-2 h-2 rounded-full bg-green-400"></div>
                    <span class="text-[10px] font-black" style="color:#1A1A3E;">{{ Auth::user()->name }}</span>
                </div>
            @endauth
            @guest
                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full" style="background:#EAEAF8;">
                    <div class="w-2 h-2 rounded-full bg-[#9B9BB4]"></div>
                    <span class="text-[10px] font-black" style="color:#9B9BB4;">Guest</span>
                </div>
            @endguest
        </div>

        <!-- ============================== -->
        <!-- STEP 1: CART                   -->
        <!-- ============================== -->
        <div x-show="step === 1" x-transition.opacity>
            <div class="space-y-4 mb-8">
                <template x-for="(item, index) in cartItems" :key="item.id">
                    <div class="flex items-center gap-4 p-4 rounded-[24px] border"
                        style="background:#EAEAF8; border-color:#DDDDF0;">
                        <!-- Image -->
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center p-2" style="background:#ffffff;">
                            <img :src="item.icon" class="w-full h-full object-contain">
                        </div>

                        <!-- Details -->
                        <div class="flex-1">
                            <h4 class="font-display font-bold text-sm" style="color:#1A1A3E;" x-text="item.name">
                            </h4>
                            <p class="text-[11px] font-black mt-1" style="color:#5B5BDB;"
                                x-text="'₹' + (item.price * item.quantity).toLocaleString()"></p>
                        </div>

                        <!-- Qty Controls -->
                        <div class="flex items-center gap-3 bg-white px-2 py-1.5 rounded-xl border border-[#DDDDF0]">
                            <button @click="decrementQty(index)"
                                class="w-6 h-6 flex items-center justify-center text-lg font-bold text-[#9B9BB4] active:scale-90">-</button>
                            <span class="font-black text-sm w-4 text-center text-[#1A1A3E]" x-text="item.quantity"></span>
                            <button @click="incrementQty(index)"
                                class="w-6 h-6 flex items-center justify-center text-lg font-bold text-[#5B5BDB] active:scale-90">+</button>
                        </div>
                    </div>
                </template>

                <!-- Empty cart message -->
                <div x-show="cartItems.length === 0"
                    class="text-center py-10 bg-[#EAEAF8] rounded-3xl border border-[#DDDDF0]">
                    <p class="font-bold text-sm" style="color:#9B9BB4;">Your cart is empty!</p>
                    <a href="{{ route('user.products') }}" class="font-black text-sm underline mt-3 inline-block"
                        style="color:#5B5BDB;">
                        Browse Products →
                    </a>
                </div>
            </div>

            <!-- Subtotal Box Step 1 -->
            <div x-show="cartItems.length > 0" class="p-5 rounded-[24px] mb-8 space-y-2"
                style="background:#EAEAF8; border: 1px solid #DDDDF0;">
                <div class="flex justify-between text-sm font-bold" style="color:#9B9BB4;">
                    <span>Subtotal</span>
                    <span x-text="'₹' + subtotal().toLocaleString()"></span>
                </div>
                <div class="flex justify-between text-lg font-display font-black pt-2"
                    style="color:#1A1A3E; border-top: 1px solid #DDDDF0;">
                    <span>Total</span>
                    <span x-text="'₹' + subtotal().toLocaleString()"></span>
                </div>
            </div>

            <button x-show="cartItems.length > 0" @click="goToShipping()"
                class="w-full text-white py-5 rounded-[20px] font-black text-sm shadow-xl active:scale-95 transition-all mb-10 uppercase tracking-widest"
                style="background-color:#1A1A3E; border-bottom: 4px solid #5B5BDB;">
                Next: Shipping Details
            </button>
        </div>

        <!-- ============================== -->
        <!-- STEP 2: SHIPPING DETAILS       -->
        <!-- ============================== -->
        <div x-show="step === 2" x-transition.opacity style="display: none;">
            <div class="space-y-4 mb-8">
                <!-- Personal Details -->
                <div class="space-y-3 p-5 rounded-[24px] border border-[#DDDDF0] bg-[#EAEAF8]">
                    <p class="text-[10px] font-black uppercase tracking-widest" style="color:#9B9BB4;">Personal Info
                    </p>
                    <input type="text" x-model="shippingData.full_name" placeholder="Full Name" required
                        class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">

                    <input type="email" x-model="shippingData.email" placeholder="Email Address" required
                        class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">

                    <input type="tel" x-model="shippingData.mobile_number" placeholder="Mobile Number (10 Digit)"
                        required pattern="[0-9]{10}"
                        class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">
                </div>

                <!-- Address Details -->
                <div class="space-y-3 p-5 rounded-[24px] border border-[#DDDDF0] bg-[#EAEAF8]">
                    <p class="text-[10px] font-black uppercase tracking-widest" style="color:#9B9BB4;">Address</p>
                    <input type="text" x-model="shippingData.address_line1" placeholder="Flat, House no., Building"
                        required class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">

                    <input type="text" x-model="shippingData.address_line2"
                        placeholder="Area, Street, Sector (Optional)"
                        class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">

                    <div class="flex gap-3">
                        <input type="text" x-model="shippingData.city" placeholder="City / Town" required
                            class="w-1/2 p-4 rounded-xl font-bold text-sm outline-none transition-all"
                            style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                            onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">

                        <input type="text" x-model="shippingData.pincode" placeholder="Pincode" required
                            pattern="[0-9]{6}" class="w-1/2 p-4 rounded-xl font-bold text-sm outline-none transition-all"
                            style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                            onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">
                    </div>

                    <input type="text" x-model="shippingData.state" placeholder="State" required
                        class="w-full p-4 rounded-xl font-bold text-sm outline-none transition-all"
                        style="background:#ffffff; border: 1.5px solid #DDDDF0; color:#1A1A3E;"
                        onfocus="this.style.borderColor='#5B5BDB'" onblur="this.style.borderColor='#DDDDF0'">
                </div>
            </div>

            {{-- Auth Notice Banner --}}
            @guest
                <div class="flex items-center gap-3 p-4 rounded-[16px] mb-5"
                    style="background:#FFF7ED; border: 1.5px solid #FED7AA;">
                    <svg width="18" height="18" fill="none" stroke="#F97316" stroke-width="2"
                        viewBox="0 0 24 24" class="shrink-0">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <p class="text-xs font-bold" style="color:#C2410C;">Login is required to proceed with payment. Your data
                        will be saved!</p>
                </div>
            @endguest

            <button @click="goToPayment()"
                class="w-full text-white py-5 rounded-[20px] font-black text-sm shadow-xl active:scale-95 transition-all mb-10 uppercase tracking-widest"
                style="background-color:#1A1A3E; border-bottom: 4px solid #5B5BDB;">
                @auth
                    Next: Payment
                @else
                    Next: Login & Pay
                @endauth
            </button>
        </div>

        <!-- ============================== -->
        <!-- STEP 3: PAYMENT                -->
        <!-- (Only reachable when logged in) -->
        <!-- ============================== -->
        <div x-show="step === 3" x-transition.opacity style="display: none;">

            {{-- Logged-in User Badge --}}
            @auth
                <div class="flex items-center gap-3 p-4 rounded-[16px] mb-5"
                    style="background:#F0FDF4; border: 1.5px solid #BBF7D0;">
                    <svg width="16" height="16" fill="none" stroke="#16A34A" stroke-width="2.5"
                        viewBox="0 0 24 24" class="shrink-0">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    <p class="text-xs font-bold" style="color:#15803D;">
                        Logged in as <strong>{{ Auth::user()->email }}</strong>
                    </p>
                </div>
            @endauth

            <!-- Shipping Address Summary -->
            <div class="p-6 rounded-[24px] mb-6 border border-[#DDDDF0] bg-[#EAEAF8]">
                <p class="text-[10px] font-black uppercase tracking-widest mb-4" style="color:#9B9BB4;">Shipping To
                </p>
                <p class="font-bold text-sm text-[#1A1A3E] mb-1" x-text="shippingData.full_name"></p>
                <p class="text-xs font-medium text-[#9B9BB4] leading-relaxed"
                    x-text="shippingData.address_line1 + ', ' + (shippingData.address_line2 ? shippingData.address_line2 + ', ' : '') + shippingData.city + ' - ' + shippingData.pincode + ', ' + shippingData.state">
                </p>
                <p class="text-xs font-bold mt-2 text-[#5B5BDB]" x-text="shippingData.mobile_number"></p>
            </div>

            <!-- Order Summary -->
            <div class="p-6 rounded-[32px] mb-8 space-y-3"
                style="background:#ffffff; border: 1px solid #DDDDF0; box-shadow: 0 10px 40px rgba(90,90,180,0.08);">
                <p class="text-[10px] font-black uppercase tracking-widest mb-2" style="color:#9B9BB4;">Order Summary
                </p>
                <div class="flex justify-between text-sm font-bold" style="color:#9B9BB4;">
                    <span>Subtotal (<span x-text="cartItems.length"></span> items)</span>
                    <span x-text="'₹' + subtotal().toLocaleString()"></span>
                </div>
                <div class="flex justify-between text-sm font-bold" style="color:#5B5BDB;">
                    <span>Shipping</span>
                    <span>FREE</span>
                </div>
                <div class="flex justify-between text-2xl font-display font-black pt-4"
                    style="color:#1A1A3E; border-top: 1px dashed #DDDDF0;">
                    <span>Total Pay</span>
                    <span x-text="'₹' + subtotal().toLocaleString()"></span>
                </div>
            </div>

            <button @click="initiateRazorpay()"
                class="w-full text-white py-5 rounded-[20px] font-black text-lg shadow-xl active:scale-95 transition-all mb-10 flex items-center justify-center gap-3"
                style="background-color:#1A1A3E; border-bottom: 4px solid #5B5BDB;">
                <span x-text="'Pay ₹' + subtotal().toLocaleString()"></span>
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5"
                    viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
            </button>
            <p class="text-center text-[10px] font-bold text-[#9B9BB4] mt-[-20px] pb-10">🔒 100% Secure Payments
                via Razorpay</p>
        </div>

    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        function checkoutFlow() {
            // ──────────────────────────────────────────────────
            // On page load: check if we returned from login
            // If so, restore saved shipping data & jump to step 3
            // ──────────────────────────────────────────────────
            const savedShipping = localStorage.getItem('qr_pending_shipping');
            const returnedFromLogin = new URLSearchParams(window.location.search).get('auth_redirect') === '1';
            const isLoggedIn = window.__AUTH__.isLoggedIn;

            let initialStep = 1;
            let restoredShipping = null;

            if (returnedFromLogin && isLoggedIn && savedShipping) {
                try {
                    restoredShipping = JSON.parse(savedShipping);
                    initialStep = 3; // Jump straight to payment
                    localStorage.removeItem('qr_pending_shipping');
                } catch (e) {}
            }

            return {
                step: initialStep,
                showLoginModal: false,
                cartItems: JSON.parse(localStorage.getItem('quickreach_cart')) || [],
                toast: {
                    show: false,
                    message: '',
                    type: 'error'
                },
                shippingData: restoredShipping || {
                    full_name: window.__AUTH__.name || '',
                    mobile_number: window.__AUTH__.mobile || '',
                    email: window.__AUTH__.email || '',
                    address_line1: '',
                    address_line2: '',
                    city: '',
                    state: '',
                    pincode: '',
                    shipping_method: 'standard'
                },

                // ── Helper Methods ──

                getStepTitle() {
                    if (this.step === 1) return 'Your Cart';
                    if (this.step === 2) return 'Shipping Info';
                    if (this.step === 3) return 'Payment';
                },

                loginRedirectUrl() {
                    // After login, redirect back to checkout with flag
                    return window.__AUTH__.loginUrl + '?redirect=' + encodeURIComponent(
                        window.__AUTH__.checkoutUrl + '?auth_redirect=1'
                    );
                },

                goBack() {
                    if (this.step > 1) {
                        this.step--;
                    } else {
                        window.location.href = "{{ route('user.products') }}";
                    }
                },

                showToast(message, type = 'error') {
                    this.toast = {
                        show: true,
                        message,
                        type
                    };
                    setTimeout(() => this.toast.show = false, 3500);
                },

                incrementQty(index) {
                    this.cartItems[index].quantity++;
                    this.saveCart();
                },

                decrementQty(index) {
                    if (this.cartItems[index].quantity > 1) {
                        this.cartItems[index].quantity--;
                    } else {
                        if (confirm('Remove this item from cart?')) {
                            this.removeItem(index);
                        }
                    }
                    this.saveCart();
                },

                removeItem(index) {
                    this.cartItems.splice(index, 1);
                    this.saveCart();
                    this.showToast('Item removed', 'error');
                },

                saveCart() {
                    localStorage.setItem('quickreach_cart', JSON.stringify(this.cartItems));
                },

                subtotal() {
                    return this.cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);
                },

                goToShipping() {
                    if (this.cartItems.length === 0) {
                        return this.showToast('Your cart is empty!', 'error');
                    }
                    this.step = 2;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                goToPayment() {
                    // ── Field Validation ──
                    const s = this.shippingData;
                    if (!s.full_name || !s.email || !s.mobile_number || !s.address_line1 || !s.city || !s.state || !s
                        .pincode) {
                        return this.showToast('Please fill all required fields!', 'error');
                    }
                    if (s.mobile_number.length < 10) {
                        return this.showToast('Please enter a valid 10-digit mobile number.', 'error');
                    }
                    if (s.pincode.length < 6) {
                        return this.showToast('Please enter a valid 6-digit pincode.', 'error');
                    }

                    // ── AUTH CHECK ──
                    // If not logged in: save data, show login modal
                    if (!window.__AUTH__.isLoggedIn) {
                        localStorage.setItem('qr_pending_shipping', JSON.stringify(this.shippingData));
                        this.showLoginModal = true;
                        return;
                    }

                    // Logged in → proceed to payment
                    this.step = 3;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                async initiateRazorpay() {
                    if (this.cartItems.length === 0) return this.showToast('Cart is empty', 'error');

                    // Double-check auth (safety net)
                    if (!window.__AUTH__.isLoggedIn) {
                        this.showLoginModal = true;
                        return;
                    }

                    try {
                        // 1. Create Order
                        const response = await fetch('{{ route('user.create.order') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                cart_items: this.cartItems,
                                shipping_data: this.shippingData,
                                amount: this.subtotal()
                            })
                        });

                        const data = await response.json();

                        if (!data.success) {
                            return this.showToast('Error: ' + data.message, 'error');
                        }

                        // 2. Open Razorpay
                        const options = {
                            "key": data.razorpay_key,
                            "amount": data.amount,
                            "currency": "INR",
                            "name": "QwickReach",
                            "description": "Smart QR Tag Purchase",
                            "order_id": data.order_id,
                            "prefill": {
                                "name": this.shippingData.full_name,
                                "email": this.shippingData.email,
                                "contact": this.shippingData.mobile_number
                            },
                            "theme": {
                                "color": "#1A1A3E"
                            },
                            "handler": async (response) => {
                                // 3. Verify Payment
                                const verifyRes = await fetch('{{ route('user.verify.payment') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        order_id: response.razorpay_order_id,
                                        payment_id: response.razorpay_payment_id,
                                        signature: response.razorpay_signature,
                                        internal_order_id: data.internal_order_id
                                    })
                                });

                                const verifyData = await verifyRes.json();
                                if (verifyData.success) {
                                    localStorage.removeItem('quickreach_cart');
                                    window.location.href = '{{ route('user.order.success') }}?order_id=' +
                                        verifyData.order_id;
                                } else {
                                    this.showToast('Payment verification failed. Please contact support.',
                                        'error');
                                }
                            }
                        };

                        const rzp = new Razorpay(options);
                        rzp.open();

                    } catch (error) {
                        console.error('Checkout Error:', error);
                        this.showToast('Something went wrong. Please try again.', 'error');
                    }
                }
            }
        }
    </script>
@endsection
