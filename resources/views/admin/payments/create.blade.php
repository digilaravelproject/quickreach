@extends('layout.app')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6 lg:p-10">
        <div class="mb-8">
            <a href="{{ route('admin.payments.index') }}"
                class="text-sm text-brand-600 font-medium flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Payments
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Create Manual Payment</h1>
        </div>

        <div class="max-w-4xl">
            <form action="{{ route('admin.payments.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Select Customer</label>
                            <select name="user_id" required
                                class="w-full rounded-xl border-gray-200 focus:ring-brand-500 focus:border-brand-500">
                                <option value="">Choose User...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">QR Category</label>
                            <select id="category_id" name="category_id" required
                                class="w-full rounded-xl border-gray-200 focus:ring-brand-500 focus:border-brand-500">
                                <option value="">Select Category...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" data-price="{{ $category->price }}">
                                        {{ $category->name }} (₹{{ $category->price }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Order ID</label>
                            <input type="text" name="order_id" value="ORD-{{ strtoupper(Str::random(8)) }}" readonly
                                class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500">
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Payment Method</label>
                            <select name="payment_method" class="w-full rounded-xl border-gray-200">
                                <option value="offline">Offline / Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="razorpay">Razorpay (Manual Entry)</option>
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Final Amount (₹)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">₹</span>
                                <input type="number" id="final_amount" name="final_amount" step="0.01" required
                                    class="w-full pl-8 rounded-xl border-gray-200 focus:ring-brand-500 focus:border-brand-500 text-lg font-bold">
                            </div>
                        </div>

                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Transaction ID / Reference
                                (Optional)</label>
                            <input type="text" name="transaction_id" placeholder="Bank ref no, Cash receipt no, etc."
                                class="w-full rounded-xl border-gray-200">
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex gap-4">
                        <button type="submit"
                            class="bg-brand-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-brand-700 transition shadow-lg shadow-brand-200">
                            Create Payment Entry
                        </button>
                        <a href="{{ route('admin.payments.index') }}"
                            class="bg-gray-100 text-gray-600 px-8 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Auto-fill price when category is selected
        document.getElementById('category_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('final_amount').value = price;
            }
        });
    </script>
@endsection
