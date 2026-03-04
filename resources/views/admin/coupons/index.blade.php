@extends('layout.app')

@section('content')
<div class="main-area">
    <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

        {{-- Header Card --}}
        <div class="card" style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
            <div class="topbar-left">
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">Coupon Codes</h1>
                    <p class="page-subtitle" style="margin: 2px 0 0 0; color: var(--text2); font-size: 11px;">Manage and assign coupons to users</p>
                </div>
            </div>

            <div class="header-actions" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <form action="{{ route('admin.coupons.index') }}" method="GET" style="display: flex; gap: 10px; align-items: center; margin: 0;">
                    <div style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search code or user..." style="width: 200px; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 8px 12px 8px 35px; outline: none; font-size: 13px;">
                    </div>

                    <select name="status" onchange="this.form.submit()" style="background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 8px 12px; outline: none; font-size: 13px;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.coupons.index') }}" style="color: var(--text3); text-decoration: none; font-size: 13px; font-weight: 600; padding: 8px;">Clear</a>
                    @endif
                </form>

                <div style="width: 1px; height: 24px; background: var(--border); margin: 0 5px;"></div>

                <a href="{{ route('admin.coupons.create') }}" style="display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; background: var(--text); color: var(--bg); border: none; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.2s; white-space: nowrap;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    Create
                </a>
            </div>
        </div>

        @if (session('success'))
            <div style="margin-bottom: 15px; background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 12px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 600;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Content --}}
        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
                    <thead>
                        <tr style="text-align: left; background: var(--card2); border-bottom: 1px solid var(--border);">
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">ID</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">User Name</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Coupon Code</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Discount</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Total Sales</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Users</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Expires On</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Status</th>
                            <th style="padding: 15px 20px; font-size: 10px; color: var(--text3); font-weight: 800; text-transform: uppercase; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($coupons as $coupon)
                            <tr style="border-bottom: 1px solid var(--border); transition: background 0.15s;" onmouseover="this.style.background='var(--card2)'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">#{{ $coupon->id }}</td>
                                <td style="padding: 15px 20px; font-weight: 600; font-size: 13px; color: var(--text);">{{ $coupon->user->name ?? 'N/A' }}</td>
                                <td style="padding: 15px 20px;">
                                    <span style="background: var(--blue); color: #fff; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px; letter-spacing: 0.5px;">
                                        {{ $coupon->code }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; font-weight: 800; font-size: 14px; color: var(--text);">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }}%
                                    @else
                                        ₹{{ rtrim(rtrim($coupon->discount_amount, '0'), '.') }}
                                    @endif
                                </td>
                                <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">
                                    <span style="background: #e3f2fd; color: #1565c0; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        ₹{{ number_format($coupon->total_sales ?? 0, 2) }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; font-weight: 700; font-size: 13px; color: var(--text);">
                                    <span style="background: #f3e5f5; color: #7b1fa2; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 800;">
                                        {{ $coupon->unique_users ?? 0 }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; font-size: 13px; color: var(--text2); font-weight: 500;">
                                    {{ $coupon->expires_at ? $coupon->expires_at->format('d M, Y') : 'Life Time' }}
                                </td>
                                <td style="padding: 15px 20px;">
                                    <span style="{{ $coupon->is_active ? 'background: #e0f2f1; color: #00695c;' : 'background: #ffebee; color: #c62828;' }} font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; text-transform: uppercase;">
                                        {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td style="padding: 15px 20px; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                        <a href="{{ route('admin.coupons.show', $coupon->id) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; border: 1px solid var(--border); color: var(--text); background: var(--card2); text-decoration: none;">
                                            View
                                        </a>

                                        <form action="{{ route('admin.coupons.toggle-status', $coupon->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <button type="submit" style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; border: 1px solid {{ $coupon->is_active ? 'var(--red)' : 'var(--green)' }}; color: {{ $coupon->is_active ? 'var(--red)' : 'var(--green)' }}; background: transparent;" onmouseover="this.style.background='{{ $coupon->is_active ? 'var(--red-bg)' : 'var(--green-bg)' }}'" onmouseout="this.style.background='transparent'">
                                                {{ $coupon->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        
                                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; border: 1px solid var(--border); color: var(--text); background: var(--card2); text-decoration: none;">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this coupon?');" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 6px 12px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer; transition: 0.2s; border: 1px solid var(--red); color: white; background: var(--red);">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="padding: 40px; text-align: center; color: var(--text3); font-size: 13px; font-weight: 600;">
                                    @if(request()->anyFilled(['search', 'status']))
                                        No coupons found matching your filters.
                                    @else
                                        No coupons created yet.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
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
