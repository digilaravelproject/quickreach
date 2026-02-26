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
