@extends('layout.app')

@section('content')
<div class="main-area">
    <div class="page-scroll" style="background: var(--bg); padding: 20px !important;">
        
        {{-- Header Section --}}
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <a href="{{ route('admin.coupons.index') }}" class="btn-outline"
                style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 10px; background: var(--card); border: 1px solid var(--border); color: var(--text);">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="title" style="margin: 0; font-size: 20px; letter-spacing: -0.5px;">Coupon Code Details</h1>
                <p style="margin: 0; color: var(--text3); font-size: 11px;">View usage and user information for this coupon.</p>
            </div>
        </div>

        {{-- Coupon Summary Card --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 20px;">
            {{-- Coupon Code Card --}}
            <div class="card" style="padding: 20px; border: 1px solid var(--border); background: var(--card); border-radius: var(--radius);">
                <p style="margin: 0 0 8px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Coupon Code</p>
                <p style="margin: 0; font-size: 24px; font-weight: 800; color: var(--blue); letter-spacing: 1px;">{{ $coupon->code }}</p>
            </div>

            {{-- Total Sales Card --}}
            <div class="card" style="padding: 20px; border: 1px solid var(--border); background: var(--card); border-radius: var(--radius);">
                <p style="margin: 0 0 8px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Total Sales</p>
                <p style="margin: 0; font-size: 24px; font-weight: 800; color: var(--green);">{{ $totalSales }}</p>
            </div>

            {{-- Unique Users Card --}}
            <div class="card" style="padding: 20px; border: 1px solid var(--border); background: var(--card); border-radius: var(--radius);">
                <p style="margin: 0 0 8px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Unique Users</p>
                <p style="margin: 0; font-size: 24px; font-weight: 800; color: var(--blue);">{{ $uniqueUsers }}</p>
            </div>

            {{-- Total Discount Card --}}
            <div class="card" style="padding: 20px; border: 1px solid var(--border); background: var(--card); border-radius: var(--radius);">
                <p style="margin: 0 0 8px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Total Discount Given</p>
                <p style="margin: 0; font-size: 24px; font-weight: 800; color: var(--red);">₹{{ number_format($totalDiscount, 2) }}</p>
            </div>
        </div>

        {{-- Coupon Info Section --}}
        <div class="card" style="padding: 20px; border: 1px solid var(--border); background: var(--card); border-radius: var(--radius); margin-bottom: 20px;">
            <h2 style="margin: 0 0 15px 0; font-size: 14px; font-weight: 800; color: var(--text);">Coupon Information</h2>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Assigned To</p>
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--text);">{{ $coupon->user->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Discount Type</p>
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--text);">
                        @if($coupon->discount_type === 'percentage')
                            Percentage (%)
                        @else
                            Fixed Amount (₹)
                        @endif
                    </p>
                </div>

                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Discount Amount</p>
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--text);">
                        @if($coupon->discount_type === 'percentage')
                            {{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }}%
                        @else
                            ₹{{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }}
                        @endif
                    </p>
                </div>

                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Expires On</p>
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--text);">
                        {{ $coupon->expires_at ? $coupon->expires_at->format('d M, Y') : 'Lifetime' }}
                    </p>
                </div>

                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Status</p>
                    <span style="{{ $coupon->is_active ? 'background: #e0f2f1; color: #00695c;' : 'background: #ffebee; color: #c62828;' }} font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div>
                    <p style="margin: 0 0 4px 0; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Created On</p>
                    <p style="margin: 0; font-size: 13px; font-weight: 600; color: var(--text);">{{ $coupon->created_at->format('d M, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Users Table Section --}}
        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden; margin-bottom: 20px;">
            <div style="padding: 20px; border-bottom: 1px solid var(--border);">
                <h2 style="margin: 0; font-size: 14px; font-weight: 800; color: var(--text);">Users Who Used This Coupon</h2>
            </div>

            @if($usersWithOrders->isNotEmpty())
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
                        <thead>
                            <tr style="text-align: left; background: var(--card2); border-bottom: 1px solid var(--border);">
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">User Name</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Email</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Orders Count</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Total Amount Spent</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usersWithOrders as $userOrders)
                                <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s;" onmouseover="this.style.background='var(--card2)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 15px 20px; font-weight: 600; font-size: 13px; color: var(--text);">{{ $userOrders['user']->name }}</td>
                                    <td style="padding: 15px 20px; font-weight: 500; font-size: 12px; color: var(--text2);">{{ $userOrders['user']->email }}</td>
                                    <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">{{ $userOrders['orders_count'] }}</td>
                                    <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">₹{{ number_format($userOrders['total_spent'], 2) }}</td>
                                    <td style="padding: 15px 20px; text-align: right;">
                                        @if($userOrders['user']->id)
                                            <a href="{{ route('admin.users.show', $userOrders['user']->id) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; border: 1px solid var(--border); color: var(--text); background: var(--card2); text-decoration: none;">
                                                View User
                                            </a>
                                        @else
                                            <span style="font-size:11px;color:var(--text2);">Guest</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 40px; text-align: center; color: var(--text3); font-size: 13px; font-weight: 600;">
                    No users have used this coupon yet.
                </div>
            @endif
        </div>

        {{-- Orders Details Section --}}
        @if($usersWithOrders->isNotEmpty())
            <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                <div style="padding: 20px; border-bottom: 1px solid var(--border);">
                    <h2 style="margin: 0; font-size: 14px; font-weight: 800; color: var(--text);">Orders Using This Coupon</h2>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
                        <thead>
                            <tr style="text-align: left; background: var(--card2); border-bottom: 1px solid var(--border);">
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Order ID</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">User</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Subtotal</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Discount</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Total Amount</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Payment Status</th>
                                <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($coupon->orders as $order)
                                <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s;" onmouseover="this.style.background='var(--card2)'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 15px 20px; font-weight: 700; font-size: 12px; color: var(--blue);">#{{ $order->id }}</td>
                                    <td style="padding: 15px 20px; font-weight: 600; font-size: 13px; color: var(--text);">
                                        @if($order->user)
                                            {{ $order->user->name }}
                                        @else
                                            {{ $order->shipping_data['name'] ?? 'Guest' }}
                                        @endif
                                    </td>
                                    <td style="padding: 15px 20px; font-weight: 600; font-size: 13px; color: var(--text);">₹{{ number_format($order->subtotal, 2) }}</td> <!-- unchanged, just keeping context -->
                                    <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--red);">-₹{{ number_format($order->shipping_data['discount'] ?? 0, 2) }}</td>
                                    <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">₹{{ number_format($order->total_amount, 2) }}</td>
                                    <td style="padding: 15px 20px;">
                                        <span style="{{ $order->payment_status === 'completed' ? 'background: #e0f2f1; color: #00695c;' : 'background: #fff3cd; color: #856404;' }} font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                                            {{ $order->payment_status }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px 20px; font-size: 12px; color: var(--text2);">{{ $order->created_at->format('d M, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <div style="height: 30px;"></div>
    </div>
</div>

<style>
    .card {
        background: var(--card);
        border-radius: var(--radius);
        box-shadow: var(--shadow-sm);
    }
</style>
@endsection
