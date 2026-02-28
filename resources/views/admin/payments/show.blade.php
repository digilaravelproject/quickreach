@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            {{-- ── HEADER ── --}}
            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.payments.index') }}" class="btn-outline"
                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">
                            Order: {{ $payment->order_number }}
                        </h1>
                        <p style="font-size: 10px; color: var(--text3); margin: 2px 0 0; font-weight: 700;">
                            Created {{ $payment->created_at->format('d M Y, h:i A') }}
                        </p>
                    </div>
                </div>

                {{-- Payment Method Badge --}}
                @if ($payment->payment_method === 'cod')
                    <span
                        style="padding: 5px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; background: #FFF7ED; color: #C2410C; border: 1px solid #FED7AA;">
                        Cash on Delivery
                    </span>
                @else
                    <span
                        style="padding: 5px 14px; border-radius: 10px; font-size: 10px; font-weight: 800; background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE;">
                        Online Payment
                    </span>
                @endif
            </div>

            @if (session('success'))
                <div
                    style="margin-bottom: 12px; padding: 14px 20px; border-radius: 12px; background: #DCFCE7; border: 1px solid #BBF7D0; font-weight: 700; font-size: 13px; color: #15803D;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    style="margin-bottom: 12px; padding: 14px 20px; border-radius: 12px; background: #FEE2E2; border: 1px solid #FECACA; font-weight: 700; font-size: 13px; color: #DC2626;">
                    ❌ {{ session('error') }}
                </div>
            @endif

            <div class="anim delay-1">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">

                    <div style="display: flex; flex-direction: column; gap: 15px; grid-column: span 2;">

                        {{-- ── Transaction Details ── --}}
                        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                            <div
                                style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                Transaction Details
                            </div>
                            <div style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                                <div>
                                    <p
                                        style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 4px;">
                                        {{ $payment->payment_method === 'cod' ? 'Payment Type' : 'Payment ID' }}
                                    </p>
                                    <p
                                        style="font-family: monospace; font-size: 13px; color: var(--text); word-break: break-all;">
                                        {{ $payment->razorpay_payment_id ?? ($payment->payment_method === 'cod' ? 'Cash on Delivery' : 'N/A') }}
                                    </p>
                                </div>
                                <div>
                                    <p
                                        style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 4px;">
                                        Amount</p>
                                    <p style="font-size: 20px; font-weight: 900; color: var(--text);">
                                        ₹{{ number_format($payment->total_amount, 2) }}</p>
                                </div>
                                <div>
                                    <p
                                        style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 4px;">
                                        Payment Status</p>
                                    @if ($payment->payment_status === 'completed')
                                        <span
                                            style="display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;">
                                            Completed
                                        </span>
                                    @else
                                        <span
                                            style="display: inline-block; padding: 4px 12px; border-radius: 8px; font-size: 10px; font-weight: 800; background: #FEF9C3; color: #854D0E; border: 1px solid #FDE68A;">
                                            Pending
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- COD Pending → Mark as Completed Banner --}}
                            @if ($payment->payment_method === 'cod' && $payment->payment_status === 'pending')
                                <div
                                    style="margin: 0 20px 20px; padding: 14px 18px; border-radius: 12px; background: #FFF7ED; border: 1px solid #FED7AA; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
                                    <div>
                                        <p style="font-size: 11px; font-weight: 800; color: #C2410C; margin-bottom: 3px;">
                                            Payment Pending</p>
                                        <p style="font-size: 11px; color: #92400E;">The customer will pay on delivery. Mark
                                            as completed once payment is collected.</p>
                                    </div>
                                    <form method="POST" action="{{ route('admin.payments.mark-paid', $payment->id) }}"
                                        onsubmit="return confirm('Mark this order as completed and assign QR codes?')">
                                        @csrf
                                        <button type="submit"
                                            style="padding: 9px 18px; border-radius: 10px; background: #F97316; color: white; border: none; font-weight: 800; font-size: 12px; cursor: pointer; white-space: nowrap;">
                                            Mark as Completed
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if ($payment->paid_at)
                                <div style="padding: 0 20px 20px;">
                                    <p
                                        style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 4px;">
                                        Payment Received At</p>
                                    <p style="font-size: 13px; font-weight: 700; color: #16a34a;">
                                        {{ $payment->paid_at->format('d M Y, h:i A') }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- ── Order Items ── --}}
                        @if ($payment->items->count() > 0)
                            <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                                <div
                                    style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                    Order Items
                                </div>
                                @foreach ($payment->items as $item)
                                    <div
                                        style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
                                        <div>
                                            <p style="font-weight: 800; font-size: 14px; color: var(--text);">
                                                {{ $item->category->name ?? 'N/A' }}</p>
                                            <p style="font-size: 10px; color: var(--text3);">
                                                Qty: {{ $item->quantity }} &times; ₹{{ number_format($item->price, 0) }}
                                            </p>
                                        </div>
                                        <p style="font-weight: 900; font-size: 15px; color: var(--text);">
                                            ₹{{ number_format($item->subtotal, 0) }}</p>
                                    </div>
                                @endforeach
                                <div
                                    style="padding: 15px 20px; display: flex; justify-content: flex-end; align-items: center; gap: 20px; background: var(--card2);">
                                    <p
                                        style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                                        Total</p>
                                    <p style="font-size: 20px; font-weight: 900; color: var(--text);">
                                        ₹{{ number_format($payment->total_amount, 0) }}</p>
                                </div>
                            </div>
                        @endif

                        {{-- ── Linked QR Codes ── --}}
                        @if ($payment->qrCodes->count() > 0)
                            <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                                <div
                                    style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                    Assigned QR Tags ({{ $payment->qrCodes->count() }})
                                </div>
                                @foreach ($payment->qrCodes as $qr)
                                    <div
                                        style="padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border);">
                                        <div>
                                            <p
                                                style="font-weight: 800; font-size: 13px; color: var(--text); font-family: monospace;">
                                                {{ $qr->qr_code }}</p>
                                            <p style="font-size: 10px; color: var(--text3);">
                                                {{ $qr->category->name ?? 'N/A' }}</p>
                                        </div>
                                        <span
                                            style="padding: 3px 10px; border-radius: 8px; font-size: 9px; font-weight: 800; background: var(--card2); border: 1px solid var(--border); color: var(--text3);">
                                            {{ ucfirst($qr->status) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($payment->payment_status === 'pending')
                            <div class="card"
                                style="padding: 20px; border: 1px dashed var(--border); text-align: center; color: var(--text3);">
                                <p style="font-size: 13px; font-weight: 700;">QR tags will be assigned once payment is
                                    marked as completed.</p>
                            </div>
                        @endif

                    </div>

                    {{-- ── RIGHT SIDEBAR ── --}}
                    <div style="display: flex; flex-direction: column; gap: 15px;">

                        {{-- Customer --}}
                        <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px;">
                                Customer</p>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 10px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 18px; flex-shrink: 0;">
                                    {{ substr($payment->user->name ?? ($payment->shipping_data['full_name'] ?? 'G'), 0, 1) }}
                                </div>
                                <div style="min-width: 0;">
                                    <p
                                        style="font-weight: 800; font-size: 14px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $payment->user->name ?? ($payment->shipping_data['full_name'] ?? 'Guest') }}
                                    </p>
                                    <p style="font-size: 11px; color: var(--text3);">
                                        {{ $payment->user->email ?? ($payment->shipping_data['email'] ?? ($payment->shipping_data['mobile_number'] ?? '—')) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        @if (!empty($payment->shipping_data))
                            @php
                                $shipping = is_array($payment->shipping_data)
                                    ? $payment->shipping_data
                                    : json_decode($payment->shipping_data, true);
                                $fields = [
                                    'full_name' => 'Name',
                                    'email' => 'Email',
                                    'mobile_number' => 'Phone',
                                    'address_line1' => 'Address',
                                    'address_line2' => 'Area',
                                    'city' => 'City',
                                    'pincode' => 'Pincode',
                                    'state' => 'State',
                                ];
                            @endphp
                            <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                                <p
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 12px;">
                                    Shipping Address</p>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    @foreach ($fields as $key => $label)
                                        @if (!empty($shipping[$key]))
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                                                <span
                                                    style="font-size: 9px; color: var(--text3); font-weight: 800; text-transform: uppercase; flex-shrink: 0;">{{ $label }}</span>
                                                <span
                                                    style="font-size: 11px; color: var(--text); font-weight: 600; text-align: right;">{{ $shipping[$key] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Timestamps --}}
                        <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 10px;">
                                Timestamps</p>
                            <p style="font-size: 11px; color: var(--text2); margin-bottom: 6px;">Created:
                                {{ $payment->created_at->format('d M Y, h:i A') }}</p>
                            <p style="font-size: 11px; color: var(--text2); margin-bottom: 6px;">Updated:
                                {{ $payment->updated_at->format('d M Y, h:i A') }}</p>
                            @if ($payment->paid_at)
                                <p style="font-size: 11px; color: #16a34a; font-weight: 700;">Paid:
                                    {{ $payment->paid_at->format('d M Y, h:i A') }}</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            <div style="height: 40px;"></div>
        </div>
    </div>
@endsection
