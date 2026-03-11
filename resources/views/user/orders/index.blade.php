@extends('user_layout.user')

@section('content')
    <div class="min-h-screen bg-[#F5F5F3] py-8 px-4">
        <div class="max-w-md mx-auto">

            {{-- ── HEADER ── --}}
            <div class="flex items-center mb-8">
                <div>
                    <p class="f-display"
                        style="font-size:10px;font-weight:600;color:#ADADAD;letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                        Transaction History</p>
                    <h1 class="f-display" style="font-size:24px;font-weight:900;color:#0A0A0A;line-height:1.2">
                        My Orders</h1>
                </div>
            </div>

            @forelse($orders as $order)
                {{-- ── ORDER CARD ── --}}
                <div
                    style="background:#fff; border-radius:28px; border:1px solid rgba(0,0,0,.07); padding:24px 20px; box-shadow:0 15px 35px -10px rgba(0,0,0,0.05); margin-bottom:20px; position: relative; overflow: hidden;">

                    {{-- Top Row: Order Meta --}}
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:20px">
                        <div>
                            <p
                                style="font-size:9px; color:#ADADAD; font-weight:700; text-transform:uppercase; letter-spacing:.12em; margin-bottom:4px">
                                Order ID</p>
                            <p style="font-size:14px; font-weight:800; color:#0A0A0A">#{{ $order->order_number }}</p>
                        </div>
                        <div style="text-align:right">
                            {{-- Status Pill --}}
                            <span
                                style="display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:100px; font-size:10px; font-weight:800; text-transform:uppercase; letter-spacing:.05em;
                            {{ $order->payment_status == 'paid' ? 'background:#F0FDF4; color:#16A34A; border:1px solid #DCFCE7' : 'background:#FFF7ED; color:#EA580C; border:1px solid #FFEDD5' }}">
                                <span
                                    style="width:6px; height:6px; border-radius:50%; {{ $order->payment_status == 'paid' ? 'background:#22C55E' : 'background:#F97316' }}"></span>
                                {{ $order->payment_status }}
                            </span>
                        </div>
                    </div>

                    {{-- Items List (Pill Style) --}}
                    <div style="margin-bottom:20px">
                        @foreach ($order->items as $item)
                            <div
                                style="background:#F5F5F3; border-radius:16px; padding:12px 16px; display:flex; align-items:center; gap:12px; margin-bottom:8px; border: 1px solid rgba(0,0,0,0.03)">
                                <div style="font-size:18px">🏷️</div>
                                <div style="flex:1">
                                    <p style="font-size:13px; font-weight:700; color:#0A0A0A">{{ $item->category->name }}
                                    </p>
                                    <p style="font-size:10px; color:#ADADAD; font-weight:600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p style="font-size:13px; font-weight:800; color:#0A0A0A">
                                    ₹{{ number_format($item->subtotal, 0) }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer Info --}}
                    <div
                        style="display:flex; justify-content:space-between; align-items:center; padding-top:18px; border-top:1px solid rgba(0,0,0,0.05)">
                        <div>
                            <p style="font-size:13px; font-weight:800; color:#0A0A0A">
                                {{ $order->created_at->format('d M, Y') }}</p>
                            <p style="font-size:18px; font-weight:900; color:#0A0A0A; margin-top:2px">
                                ₹{{ number_format($order->total_amount, 2) }}</p>
                        </div>

                        <a href="{{ route('user.orders.show', $order->id) }}"
                            style="background:#0A0A0A; color:#fff; padding:12px 18px; border-radius:16px; font-size:12px; font-weight:800; text-decoration:none; display:flex; align-items:center; gap:8px; border-bottom: 3px solid #86D657; transition:all .2s ease"
                            onmousedown="this.style.transform='scale(.96)'" onmouseup="this.style.transform='scale(1)'">
                            Details →
                        </a>
                    </div>
                </div>
            @empty
                {{-- ── EMPTY STATE ── --}}
                <div
                    style="background:#fff; border-radius:28px; border:1px solid rgba(0,0,0,.07); padding:60px 20px; text-align:center; box-shadow:0 20px 30px -10px rgba(0,0,0,0.07)">
                    <div
                        style="width:64px; height:64px; background:#F5F5F3; border-radius:20px; display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 20px">
                        📦</div>
                    <h3 style="font-size:18px; font-weight:800; color:#0A0A0A; margin-bottom:8px">No orders found</h3>
                    <p style="font-size:13px; color:#ADADAD; font-weight:600; margin-bottom:24px">Your purchase history will
                        appear here once you order a tag.</p>
                    <a href="/"
                        style="display:inline-block; background:#0A0A0A; color:#fff; padding:14px 30px; border-radius:18px; text-decoration:none; font-size:14px; font-weight:800; border-bottom: 4px solid #86D657">Shop
                        Tags</a>
                </div>
            @endforelse

            {{-- Pagination --}}
            <div class="mt-8 px-2">
                {{ $orders->links() }}
            </div>

            {{-- ── MY QR CODES SECTION ── --}}
            <div style="margin-top:40px; margin-bottom:8px;">
                <p class="f-display"
                    style="font-size:10px;font-weight:600;color:#ADADAD;letter-spacing:.15em;text-transform:uppercase;margin-bottom:3px">
                    QwickReach Tags</p>
                <h2 class="f-display"
                    style="font-size:24px;font-weight:900;color:#0A0A0A;line-height:1.2;margin-bottom:20px">
                    My QR Codes</h2>

                @forelse($qrCodes as $qr)
                    <div
                        style="background:#fff; border-radius:28px; border:1px solid rgba(0,0,0,.07); padding:20px; box-shadow:0 15px 35px -10px rgba(0,0,0,0.05); margin-bottom:16px; display:flex; align-items:center; gap:16px;">

                        {{-- QR Icon --}}
                        <div
                            style="width:52px; height:52px; background:#F5F5F3; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; border:1px solid rgba(0,0,0,0.05)">
                            🏷️
                        </div>

                        {{-- Info --}}
                        <div style="flex:1; min-width:0;">
                            <p
                                style="font-size:9px; color:#ADADAD; font-weight:700; text-transform:uppercase; letter-spacing:.12em; margin-bottom:3px;">
                                {{ $qr->category->name ?? 'N/A' }}</p>
                            <p
                                style="font-size:14px; font-weight:800; color:#0A0A0A; font-style:italic; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $qr->qr_code }}</p>
                            <p style="font-size:10px; color:#ADADAD; font-weight:600; margin-top:2px;">
                                {{ $qr->created_at->format('d M, Y') }}</p>
                        </div>

                        {{-- Status Pill --}}
                        <div
                            style="flex-shrink:0; text-align:right; display:flex; flex-direction:column; align-items:flex-end; gap:8px;">
                            <span
                                style="display:inline-flex; align-items:center; gap:5px; padding:5px 10px; border-radius:100px; font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.05em;
                                @if ($qr->status === 'registered') background:#F0FDF4; color:#16A34A; border:1px solid #DCFCE7;
                                @elseif($qr->status === 'assigned') background:#FFF7ED; color:#EA580C; border:1px solid #FFEDD5;
                                @elseif($qr->status === 'inactive') background:#F3F4F6; color:#6B7280; border:1px solid #E5E7EB;
                                @else background:#EFF6FF; color:#2563EB; border:1px solid #DBEAFE; @endif">
                                <span
                                    style="width:5px; height:5px; border-radius:50%;
                                    @if ($qr->status === 'registered') background:#22C55E;
                                    @elseif($qr->status === 'assigned') background:#F97316;
                                    @elseif($qr->status === 'inactive') background:#9CA3AF;
                                    @else background:#3B82F6; @endif"></span>
                                {{ $qr->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div
                        style="background:#fff; border-radius:28px; border:1px solid rgba(0,0,0,.07); padding:50px 20px; text-align:center; box-shadow:0 20px 30px -10px rgba(0,0,0,0.07)">
                        <div
                            style="width:56px; height:56px; background:#F5F5F3; border-radius:18px; display:flex; align-items:center; justify-content:center; font-size:28px; margin:0 auto 16px">
                            🏷️</div>
                        <h3 style="font-size:16px; font-weight:800; color:#0A0A0A; margin-bottom:6px">No QR codes found</h3>
                        <p style="font-size:12px; color:#ADADAD; font-weight:600;">Your QR tags will appear here once
                            assigned.</p>
                    </div>
                @endforelse

                {{-- QR Codes Pagination --}}
                <div class="mt-6 px-2">
                    {{ $qrCodes->links() }}
                </div>
            </div>

            {{-- Footer Branding --}}
            <div style="display:flex; align-items:center; gap:14px; justify-content:center; padding:32px 0 20px">
                <div style="height:1px; flex:1; background:linear-gradient(to right,transparent,rgba(0,0,0,.09))"></div>
                <p class="f-display" style="font-size:11px; font-weight:800; letter-spacing:.04em; color:#ADADAD">Qwick<span
                        style="color:#86D657">Reach</span></p>
                <div style="height:1px; flex:1; background:linear-gradient(to left,transparent,rgba(0,0,0,.09))"></div>
            </div>
        </div>
    </div>

    <style>
        /* Pagination styling to match your theme */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .page-item.active .page-link {
            background-color: #0A0A0A !important;
            border-color: #0A0A0A !important;
            color: #fff !important;
            border-radius: 8px;
        }

        .page-link {
            color: #0A0A0A !important;
            border-radius: 8px;
            font-weight: 700;
            border: none !important;
            background: transparent !important;
        }
    </style>
@endsection
