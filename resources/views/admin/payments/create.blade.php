@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 12px !important;">

            {{-- ── PAGE HEADER ── --}}
            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.payments.index') }}" class="btn-outline"
                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; color: var(--text);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Create Manual Payment
                        </h1>
                        <p style="font-size: 10px; color: var(--text3); margin: 2px 0 0; font-weight: 700;">
                            Generate a new offline or manual order
                        </p>
                    </div>
                </div>
            </div>

            {{-- ── FORM AREA ── --}}
            <div class="card"
                style="padding: 25px; border-radius: var(--radius); border: 1px solid var(--border); max-width: 1000px;">
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">

                        {{-- Select Customer --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Select Customer <span style="color: #dc2626;">*</span>
                            </label>
                            <select id="user_id" name="user_id" required
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 13px; color: var(--text); font-weight: 600; outline: none; appearance: auto;">
                                <option value="">Choose User...</option>
                                <option value="other">Other (Manual Entry)</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Manual Customer Name (Hidden initially) --}}
                        <div id="manual_customer_wrapper" style="display: none;">
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Customer Name <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="text" id="customer_name" name="customer_name" placeholder="Enter full name"
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 13px; color: var(--text); font-weight: 600; outline: none;">
                        </div>

                        {{-- QR Category --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                QR Category (In Stock) <span style="color: #dc2626;">*</span>
                            </label>
                            <select id="category_id" name="category_id" required
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 13px; color: var(--text); font-weight: 600; outline: none; appearance: auto;">
                                <option value="">Select Category...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" data-price="{{ $category->price }}">
                                        {{ $category->name }} (₹{{ $category->price }} | Stock:
                                        {{ $category->available_qr_codes_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Quantity <span style="color: #dc2626;">*</span>
                            </label>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" step="1" required
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 16px; color: var(--text); font-weight: 600; outline: none;">
                        </div>

                        {{-- Order ID --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Order ID
                            </label>
                            <input type="text" name="order_id" value="ORD-{{ strtoupper(Str::random(8)) }}" readonly
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); padding: 0 15px; font-size: 13px; color: var(--text3); font-weight: 600; outline: none; opacity: 0.8; cursor: not-allowed;">
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Payment Method <span style="color: #dc2626;">*</span>
                            </label>
                            <select name="payment_method" required
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 13px; color: var(--text); font-weight: 600; outline: none; appearance: auto;">
                                <option value="offline">Offline / Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="razorpay">Razorpay (Manual Entry)</option>
                            </select>
                        </div>

                        {{-- Final Amount --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Final Amount <span style="color: #dc2626;">*</span>
                            </label>
                            <div style="position: relative;">
                                <span
                                    style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text3); font-weight: 800; font-size: 14px;">₹</span>
                                <input type="number" id="final_amount" name="final_amount" step="0.01" required
                                    style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px 0 32px; font-size: 16px; color: var(--text); font-weight: 800; outline: none;">
                            </div>
                        </div>

                        {{-- Transaction ID --}}
                        <div>
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 8px; display: block;">
                                Transaction ID / Reference
                            </label>
                            <input type="text" name="transaction_id" placeholder="Bank ref no, Cash receipt no, etc."
                                style="width: 100%; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 15px; font-size: 13px; color: var(--text); font-weight: 600; outline: none;">
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div
                        style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border); display: flex; gap: 10px; align-items: center;">
                        <button type="submit"
                            style="display: inline-flex; align-items: center; justify-content: center; height: 42px; padding: 0 24px; background: var(--text); color: var(--bg); border: none; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer;">
                            Create Payment
                        </button>
                        <a href="{{ route('admin.payments.index') }}"
                            style="display: inline-flex; align-items: center; justify-content: center; height: 42px; padding: 0 24px; background: var(--card2); color: var(--text); border: 1px solid var(--border); border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; text-decoration: none;">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <div style="height: 40px;"></div>
        </div>
    </div>

    <script>
        // Calculate final amount based on category price and quantity
        function updateTotalAmount() {
            const categorySelect = document.getElementById('category_id');
            const quantityInput = document.getElementById('quantity');
            const finalAmountInput = document.getElementById('final_amount');
            
            if (categorySelect.selectedIndex > 0) {
                const selectedOption = categorySelect.options[categorySelect.selectedIndex];
                const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
                const quantity = parseInt(quantityInput.value) || 1;
                
                finalAmountInput.value = (price * quantity).toFixed(2);
            } else {
                finalAmountInput.value = '';
            }
        }

        document.getElementById('category_id').addEventListener('change', updateTotalAmount);
        document.getElementById('quantity').addEventListener('input', updateTotalAmount);

        // Toggle Manual Customer Name field
        document.getElementById('user_id').addEventListener('change', function() {
            const wrapper = document.getElementById('manual_customer_wrapper');
            const input = document.getElementById('customer_name');
            if (this.value === 'other') {
                wrapper.style.display = 'block';
                input.required = true;
            } else {
                wrapper.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        });
    </script>
@endsection
