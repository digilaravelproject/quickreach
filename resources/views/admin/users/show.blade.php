@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 20px !important;">

            {{-- Header Section --}}
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                <a href="{{ route('admin.users.index') }}" class="btn-outline"
                    style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; letter-spacing: -0.5px;">User Profile</h1>
                    <p style="margin: 0; color: var(--text3); font-size: 11px;">Detailed overview of registered user and
                        purchases</p>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px;">

                {{-- User Card --}}
                <div class="card"
                    style="padding: 25px; border: 1px solid var(--border); display: flex; flex-direction: column; justify-content: center;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <div
                            style="width: 65px; height: 65px; border-radius: 18px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 26px; box-shadow: var(--shadow);">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 style="margin: 0; font-size: 19px; font-weight: 800; color: var(--text);">
                                {{ $user->name }}</h2>
                            <p style="margin: 0; color: var(--text3); font-size: 12px;">Customer since
                                {{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                    <div style="display: grid; gap: 15px;">
                        <div>
                            <span
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 2px;">Email</span>
                            <p style="margin: 0; font-weight: 700; font-size: 14px; color: var(--text);">{{ $user->email }}
                            </p>
                        </div>
                        <div>
                            <span
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; display: block; margin-bottom: 2px;">Mobile</span>
                            <p style="margin: 0; font-weight: 700; font-size: 14px; color: var(--text);">
                                {{ $user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary Stats --}}
                <div class="card" style="padding: 25px; border: 1px solid var(--border);">
                    <h3
                        style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">
                        Account Summary</h3>
                    <div style="display: grid; gap: 10px;">
                        <div
                            style="padding: 15px; background: var(--card2); border-radius: 12px; border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 700; color: var(--text2);">Total Orders</span>
                            <span
                                style="font-size: 22px; font-weight: 900; color: var(--text);">{{ $user->orders_count }}</span>
                        </div>
                        <div
                            style="padding: 15px; background: var(--card2); border-radius: 12px; border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 700; color: var(--text2);">Registration Status</span>
                            <span
                                style="font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; background: #e0f2f1; color: #00695c;">ACTIVE</span>
                        </div>
                    </div>
                </div>

                {{-- Full Width Order/QR Management Table --}}
                <div class="card"
                    style="grid-column: 1 / -1; padding: 0; border: 1px solid var(--border); overflow: hidden;">
                    <div
                        style="padding: 15px 20px; background: var(--card2); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                        <h3
                            style="margin: 0; font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                            Order & QR Codes History</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                            <thead>
                                <tr style="text-align: left; background: var(--bg);">
                                    <th
                                        style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">
                                        Order Info</th>
                                    <th
                                        style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">
                                        Purchased Qty</th>
                                    <th
                                        style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">
                                        QR Management</th>
                                    <th
                                        style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">
                                        Total Paid</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->orders as $order)
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 15px 20px;">
                                            <div style="font-weight: 800; font-size: 14px; color: var(--text);">
                                                #{{ $order->order_number }}</div>
                                            <div style="font-size: 11px; color: var(--text3);">
                                                {{ $order->created_at->format('d M, Y') }}</div>
                                        </td>

                                        {{-- Quantity Logic --}}
                                        <td style="padding: 15px 20px;">
                                            @foreach ($order->items as $item)
                                                <div
                                                    style="display: flex; align-items: center; gap: 5px; margin-bottom: 3px;">
                                                    <span
                                                        style="background: var(--text); color: var(--bg); font-size: 10px; font-weight: 900; padding: 2px 6px; border-radius: 4px;">{{ $item->quantity }}</span>
                                                    <span
                                                        style="font-size: 12px; font-weight: 600; color: var(--text2);">{{ $item->category->name ?? 'Tags' }}</span>
                                                </div>
                                            @endforeach
                                        </td>

                                        {{-- QR Download Logic --}}
                                        <td style="padding: 15px 20px;">
                                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                @forelse($order->qrCodes as $qr)
                                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                                        <span
                                                            style="font-size: 10px; font-weight: 800; color: var(--text2);">{{ $qr->qr_code }}</span>
                                                        @if (in_array($qr->status, ['sold', 'registered']))
                                                            <a href="{{ route('admin.qr.generateCard', $qr->id) }}"
                                                                target="_blank"
                                                                style="display: inline-flex; align-items: center; gap: 5px; background: var(--card2); border: 1px solid var(--border); padding: 5px 10px; border-radius: 8px; font-size: 10px; font-weight: 800; color: var(--text); text-decoration: none; transition: 0.2s;">
                                                                <svg fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24" style="width: 12px;">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2.5"
                                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                DOWNLOAD
                                                            </a>
                                                        @else
                                                            <span
                                                                style="font-size: 9px; color: var(--text3); font-weight: 700; text-transform: uppercase;">{{ $qr->status }}</span>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <span
                                                        style="font-size: 11px; color: var(--text3); font-style: italic;">Processing
                                                        QR Generation...</span>
                                                @endforelse
                                            </div>
                                        </td>

                                        <td style="padding: 15px 20px;">
                                            <div style="font-weight: 900; font-size: 15px; color: var(--text);">
                                                ₹{{ number_format($order->total_amount, 2) }}</div>
                                            <div style="font-size: 9px; font-weight: 800; color: #00695c;">
                                                {{ strtoupper($order->payment_status) }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="padding: 40px; text-align: center;">
                                            <p style="margin: 0; color: var(--text3); font-size: 13px; font-weight: 600;">No
                                                order history found for this user.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    <style>
        .card {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline:hover {
            background: var(--card2);
            transform: translateY(-1px);
            transition: 0.2s;
        }

        table tr:hover {
            background: var(--card2);
            transition: 0.1s;
        }
    </style>
@endsection
