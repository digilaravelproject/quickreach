@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

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
                    <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Order:
                        {{ $payment->order_number }}</h1>
                </div>

                @if ($payment->payment_status === 'completed')
                    <button onclick="document.getElementById('refundModal').style.display='flex'" class="btn-outline"
                        style="color: var(--red); border-color: var(--red); padding: 6px 15px; border-radius: 10px; font-weight: 800; font-size: 10px;">
                        REFUND
                    </button>
                @endif
            </div>

            <div class="anim delay-1">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">

                    <div style="display: flex; flex-direction: column; gap: 15px; grid-column: span 2;">

                        {{-- Transaction Details --}}
                        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                            <div
                                style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                Transaction Details</div>
                            <div style="padding: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <p
                                        style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 4px;">
                                        Payment ID</p>
                                    <p
                                        style="font-family: monospace; font-size: 13px; color: var(--text); word-break: break-all;">
                                        {{ $payment->payment_id ?? 'N/A' }}</p>
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
                                        Status</p>
                                    <span
                                        class="badge {{ $payment->payment_status == 'completed' ? 'badge-paid' : 'badge-pending' }}"
                                        style="font-size: 9px;">{{ $payment->payment_status }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Linked QR Codes --}}
                        @if ($payment->qrCodes->count() > 0)
                            <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                                <div
                                    style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                    Linked Tags</div>
                                @foreach ($payment->qrCodes as $qr)
                                    <div
                                        style="padding: 15px 20px; display: flex; justify-content: space-between; border-bottom: 1px solid var(--border);">
                                        <div>
                                            <p style="font-weight: 800; font-size: 14px; color: var(--text);">
                                                {{ $qr->qr_code }}</p>
                                            <p style="font-size: 10px; color: var(--text3);">
                                                {{ $qr->category->name ?? 'Category' }}</p>
                                        </div>
                                        <span class="badge"
                                            style="background: var(--card2); font-size: 9px;">{{ $qr->status }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        {{-- Customer Card --}}
                        <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px;">
                                Customer</p>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 40px; height: 40px; border-radius: 10px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 900;">
                                    {{ substr($payment->user->name ?? ($payment->shipping_data['full_name'] ?? 'G'), 0, 1) }}
                                </div>
                                <div style="min-width: 0;">
                                    <p
                                        style="font-weight: 800; font-size: 14px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $payment->user->name ?? ($payment->shipping_data['full_name'] ?? 'Guest') }}</p>
                                    <p style="font-size: 11px; color: var(--text3);">
                                        {{ $payment->user->email ?? ($payment->shipping_data['email'] ?? ($payment->shipping_data['mobile_number'] ?? '')) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Shipping Details Card --}}
                        @if (!empty($payment->shipping_data))
                            <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                                <p
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 12px;">
                                    Shipping Address</p>
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    @php
                                        $shipping = is_array($payment->shipping_data)
                                            ? $payment->shipping_data
                                            : json_decode($payment->shipping_data, true);
                                        $fields = [
                                            'full_name' => 'Name',
                                            'email' => 'Email',
                                            'mobile_number' => 'Phone',
                                            'address_line1' => 'Address',
                                            'city' => 'City',
                                            'pincode' => 'Pincode',
                                        ];
                                    @endphp
                                    @foreach ($fields as $key => $label)
                                        @if (!empty($shipping[$key]))
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                                                <span
                                                    style="font-size: 9px; color: var(--text3); font-weight: 800; text-transform: uppercase;">{{ $label }}</span>
                                                <span
                                                    style="font-size: 11px; color: var(--text); font-weight: 600; text-align: right;">{{ $shipping[$key] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 10px;">
                                Timestamps</p>
                            <p style="font-size: 11px; color: var(--text2);">Created:
                                {{ $payment->created_at->format('d M, h:i A') }}</p>
                            <p style="font-size: 11px; color: var(--text2);">Updated:
                                {{ $payment->updated_at->format('d M, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    {{-- Refund Modal --}}
    <div id="refundModal"
        style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center; padding: 20px;">
        <div class="card"
            style="width: 100%; max-width: 400px; padding: 25px; border-radius: var(--radius); border: 1px solid var(--border); box-shadow: var(--shadow-lg);">
            <h2 style="font-size: 20px; font-weight: 900; margin-bottom: 10px;">Refund Order</h2>
            <p style="font-size: 12px; color: var(--text2); margin-bottom: 20px;">Refund
                <strong>₹{{ $payment->total_amount }}</strong> to customer?
            </p>
            <form action="{{ route('admin.payments.refund', $payment->id) }}" method="POST">
                @csrf
                <textarea name="refund_reason" rows="3" required placeholder="Reason..."
                    style="width: 100%; background: var(--card2); border: 1px solid var(--border); border-radius: 10px; padding: 10px; margin-bottom: 20px; outline: none;"></textarea>
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('refundModal').style.display='none'"
                        class="btn-outline" style="flex: 1; height: 40px; border-radius: 10px;">CANCEL</button>
                    <button type="submit" class="btn-outline"
                        style="flex: 1; height: 40px; border-radius: 10px; background: var(--red); color: white; border: none;">REFUND</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
