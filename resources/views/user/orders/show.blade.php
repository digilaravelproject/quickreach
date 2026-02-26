@extends('user_layout.user')

@section('content')
    {{-- Main Container with your brand background color --}}
    <div class="min-h-screen bg-[#F5F5F3] py-8 px-5 max-w-md mx-auto">

        {{-- ── HEADER ── --}}
        <div class="flex items-center mb-8">
            <a href="{{ route('user.new.orders.index') }}"
                style="width:40px; height:40px; background:#fff; border-radius:12px; display:flex; align-items:center; justify-content:center; margin-right:15px; border:1px solid rgba(0,0,0,0.05); text-decoration:none; color:#000; box-shadow:0 4px 10px rgba(0,0,0,0.03)">
                ←
            </a>
            <div>
                <p class="f-display"
                    style="font-size:10px;font-weight:600;color:#ADADAD;letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                    QwickReach Details</p>
                <h1 class="f-display" style="font-size:22px;font-weight:800;color:#0A0A0A;line-height:1.2">
                    Order Summary</h1>
            </div>
        </div>

        {{-- ── ORDER ID PILL (Exact style of your Category Pill) ── --}}
        <div
            style="background:#fff;border-radius:20px;border:1px solid rgba(0,0,0,.07);padding:14px 18px;display:flex;align-items:center;gap:14px;margin-bottom:24px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.05)">
            <div
                style="width:44px;height:44px;background:#F5F5F3;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;border: 1px solid #eee;">
                📦</div>
            <div style="flex:1;min-width:0">
                <p class="f-display"
                    style="font-size:9px;color:#ADADAD;font-weight:700;text-transform:uppercase;letter-spacing:.12em;margin-bottom:2px">
                    Order Number</p>
                <p class="f-display" style="font-size:14px;font-weight:800;color:#0A0A0A">#{{ $order->order_number }}</p>
            </div>
            <div style="text-align:right;flex-shrink:0">
                <p class="f-display"
                    style="font-size:9px;color:#ADADAD;font-weight:700;text-transform:uppercase;letter-spacing:.12em;margin-bottom:2px">
                    Status</p>
                <p class="f-display"
                    style="font-size:11px;font-weight:800;color:#fff;background:#0A0A0A;padding:4px 10px;border-radius:8px; border-bottom: 2px solid #86D657">
                    {{ strtoupper($order->payment_status) }}</p>
            </div>
        </div>

        {{-- ── MAIN CONTENT CARD ── --}}
        <div
            style="background:#fff;border-radius:28px;border:1px solid rgba(0,0,0,.07);padding:24px 20px;box-shadow:0 20px 30px -10px rgba(0,0,0,0.07);margin-bottom:24px">

            <p class="f-display"
                style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                Purchased Tags</p>

            {{-- Items Loop --}}
            <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:28px;">
                @foreach ($order->items as $item)
                    <div
                        style="display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:18px;border:1.5px solid #F5F5F3;background:#F5F5F3;">
                        <span style="font-size:22px">🏷️</span>
                        <div style="flex:1">
                            <p class="f-display" style="font-size:14px;font-weight:700;color:#0A0A0A">
                                {{ $item->category->name }}</p>
                            <p style="font-size:11px;color:#ADADAD;font-weight:600">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <p class="f-display" style="font-size:14px;font-weight:800;color:#0A0A0A">
                            ₹{{ number_format($item->subtotal, 0) }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Price Breakdown (Black Card style with Lime Green) --}}
            <div
                style="background:#0A0A0A; border-radius:22px; padding:20px; color:#fff; border-bottom: 5px solid #86D657;">
                <div
                    style="display:flex; justify-content:space-between; margin-bottom:10px; font-size:12px; opacity:0.6; font-weight:600; text-transform:uppercase; letter-spacing:1px">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div
                    style="display:flex; justify-content:space-between; margin-bottom:18px; font-size:12px; opacity:0.6; font-weight:600; text-transform:uppercase; letter-spacing:1px">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div style="height:1px; background:rgba(255,255,255,0.1); margin-bottom:18px"></div>
                <div style="display:flex; justify-content:space-between; align-items:center">
                    <span class="f-display" style="font-size:14px; font-weight:800; text-transform:uppercase">Total
                        Amount</span>
                    <span class="f-display"
                        style="font-size:24px; font-weight:900; color:#86D657">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- ── SHIPPING INFO CARD ── --}}
        <div
            style="background:#fff;border-radius:28px;border:1px solid rgba(0,0,0,.07);padding:24px 20px;box-shadow:0 20px 30px -10px rgba(0,0,0,0.07);margin-bottom:24px">
            <p class="f-display"
                style="font-size:11px;font-weight:700;color:#ADADAD;text-transform:uppercase;letter-spacing:.12em;margin-bottom:14px">
                Shipping Address</p>

            <div style="display:flex; gap:16px; align-items:flex-start">
                <div
                    style="width:44px; height:44px; background:#F5F5F3; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; border: 1px solid #eee;">
                    📍</div>
                <div>
                    <p class="f-display" style="font-size:15px; font-weight:800; color:#0A0A0A; margin-bottom:4px">
                        {{ $order->shipping_data['full_name'] ?? auth()->user()->name }}</p>
                    <p style="font-size:13px; color:#ADADAD; line-height:1.6; font-weight:600">
                        {{ $order->shipping_data['address'] ?? 'Address not found' }}</p>
                    <div
                        style="margin-top:12px; display:inline-block; background:#F5F5F3; padding:5px 12px; border-radius:10px; border: 1px solid #eee;">
                        <p style="font-size:12px; color:#0A0A0A; font-weight:800">📞
                            {{ $order->shipping_data['phone'] ?? auth()->user()->phone }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── FOOTER BRANDING ── --}}
        <div style="display:flex;align-items:center;gap:14px;justify-content:center;padding:8px 0 4px">
            <div style="height:1px;flex:1;background:linear-gradient(to right,transparent,rgba(0,0,0,.09))"></div>
            <p class="f-display" style="font-size:11px;font-weight:800;letter-spacing:.04em;color:#ADADAD">Qwick<span
                    style="color:#86D657">Reach</span></p>
            <div style="height:1px;flex:1;background:linear-gradient(to left,transparent,rgba(0,0,0,.09))"></div>
        </div>
    </div>
@endsection
