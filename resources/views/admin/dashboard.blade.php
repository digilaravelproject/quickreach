@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px 10px 40px 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; letter-spacing: -0.5px;">Dashboard Overview</h1>
                    <p
                        style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">
                        Welcome back, Administrator</p>
                </div>
                <div class="live-badge" style="font-size: 10px; padding: 4px 10px;">System Live</div>
            </div>

            <div class="stat-grid anim delay-1" style="margin-bottom: 15px; gap: 10px;">
                <div class="card" style="padding: 20px;">
                    <div class="stat-top">
                        <span class="stat-label">Total Revenue</span>
                        <div class="stat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg></div>
                    </div>
                    <div class="stat-val" style="font-size: 22px;">₹{{ number_format($stats['total_revenue']) }}</div>
                    <div><span class="stat-change up">+₹{{ number_format($stats['today_revenue']) }}</span> <span
                            class="stat-period">today</span></div>
                </div>

                <div class="card" style="padding: 20px;">
                    <div class="stat-top">
                        <span class="stat-label">Customers</span>
                        <div class="stat-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg></div>
                    </div>
                    <div class="stat-val" style="font-size: 22px;">{{ number_format($stats['total_users']) }}</div>
                    <p class="stat-period">Active registrations</p>
                </div>

                <div class="card" style="padding: 20px;">
                    <div class="stat-top">
                        <span class="stat-label">Inventory</span>
                        <div class="stat-icon" style="background:var(--amber-bg)"><svg style="color:var(--amber)"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg></div>
                    </div>
                    <div class="stat-val" style="font-size: 22px;">{{ number_format($stats['available_qrs']) }}</div>
                    <div class="prog-track" style="margin-top: 10px; height: 6px;">
                        <div class="prog-fill"
                            style="width: {{ $stats['total_qrs'] > 0 ? ($stats['available_qrs'] / $stats['total_qrs']) * 100 : 0 }}%; background: var(--text);">
                        </div>
                    </div>
                    <p class="stat-period" style="margin-top:5px;">{{ number_format($stats['registered_qrs']) }} active</p>
                </div>

                <div class="card" style="padding: 20px;">
                    <div class="stat-top">
                        <span class="stat-label">Scans</span>
                        <div class="stat-icon" style="background:#ede9fe"><svg style="color:#8b5cf6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg></div>
                    </div>
                    <div class="stat-val" style="font-size: 22px;">{{ number_format($stats['total_scans']) }}</div>
                    <div><span class="stat-change up" style="color:#8b5cf6">+{{ $stats['today_scans'] }}</span> <span
                            class="stat-period">today</span></div>
                </div>
            </div>

            <div class="grid-2 anim delay-2" style="gap: 10px; margin-bottom: 15px;">
                <div class="card" style="padding: 20px;">
                    <div class="card-header" style="padding: 0 0 15px 0;">
                        <span class="card-title">Revenue Chart</span>
                        <form method="GET" action="{{ route('admin.dashboard') }}" id="periodForm">
                            <select name="period" onchange="this.form.submit()"
                                style="appearance:none; border:1px solid var(--border); background:var(--card2); color:var(--text); padding: 4px 12px; border-radius: 8px; cursor:pointer; font-size: 11px; font-weight: 700;">
                                <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </form>
                    </div>
                    <div class="chart-wrap ch-240">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="card" style="padding: 20px;">
                    <div class="card-header" style="padding: 0 0 15px 0;">
                        <span class="card-title">Recent Activity</span>
                        <a href="{{ route('admin.qr-codes.index') }}"
                            style="color:var(--blue); text-decoration:none; font-weight:800; font-size: 11px; text-transform: uppercase;">View
                            All</a>
                    </div>
                    <div style="max-height: 240px; overflow-y: auto; padding-right: 5px;">
                        @forelse ($recentRegistrations as $qr)
                            <div
                                style="padding: 10px 0; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <div
                                        style="background:var(--card2); width:32px; height:32px; font-size:10px; border:1px solid var(--border); display:flex; align-items:center; justify-content:center; border-radius:10px; font-weight:800; color:var(--text);">
                                        {{ $qr->registration ? strtoupper(substr($qr->registration->full_name, 0, 2)) : 'U' }}
                                    </div>
                                    <div>
                                        <div style="font-size: 13px; font-weight:700; color:var(--text);">
                                            {{ $qr->registration->full_name ?? 'Unknown User' }}</div>
                                        <div style="font-size: 10px; color:var(--text3); text-transform: uppercase;">
                                            Activated Tag</div>
                                    </div>
                                </div>
                                <span
                                    style="font-size: 10px; font-weight: 700; color:var(--text3);">{{ $qr->updated_at->diffForHumans(null, true) }}</span>
                            </div>
                        @empty
                            <div style="text-align:center; padding: 20px; color: var(--text3);">No activity.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card anim delay-3" style="padding: 20px;">
                <div class="card-header" style="padding: 0 0 15px 0;">
                    <h3 class="card-title">Recent Transactions</h3>
                    <a href="{{ route('admin.payments.index') }}" class="btn-outline"
                        style="font-size: 10px; padding: 6px 12px; border-radius: 8px; font-weight: 800;">VIEW ALL</a>
                </div>
                <div class="table-scroll" style="overflow-x: auto;">
                    <table class="data-table" style="width: 100%; min-width: 700px; border-collapse: collapse;">
                        <thead>
                            <tr style="background: var(--card2);">
                                <th
                                    style="padding: 12px 15px; text-align: left; color:var(--text3); font-size:10px; text-transform:uppercase; font-weight: 800;">
                                    User</th>
                                <th
                                    style="padding: 12px 15px; text-align: left; color:var(--text3); font-size:10px; text-transform:uppercase; font-weight: 800;">
                                    Order ID</th>
                                <th
                                    style="padding: 12px 15px; text-align: left; color:var(--text3); font-size:10px; text-transform:uppercase; font-weight: 800;">
                                    Amount</th>
                                <th
                                    style="padding: 12px 15px; text-align: left; color:var(--text3); font-size:10px; text-transform:uppercase; font-weight: 800;">
                                    Status</th>
                                <th
                                    style="padding: 12px 15px; text-align: right; color:var(--text3); font-size:10px; text-transform:uppercase; font-weight: 800;">
                                    Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPayments as $payment)
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 12px 15px; color:var(--text); font-size:13px; font-weight: 600;">
                                        {{ $payment->user->name ?? 'Guest' }}</td>
                                    <td
                                        style="padding: 12px 15px; font-family:monospace; color:var(--text2); font-size: 12px;">
                                        {{ $payment->order_number }}</td>
                                    <td style="padding: 12px 15px; font-weight: 800; color:var(--text);">
                                        ₹{{ number_format($payment->total_amount, 2) }}</td>
                                    <td style="padding: 12px 15px;">
                                        <span
                                            class="badge @if ($payment->payment_status === 'completed') badge-paid @elseif($payment->payment_status === 'pending') badge-pending @else badge-failed @endif"
                                            style="font-size: 9px; font-weight: 800;">
                                            {{ strtoupper($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td
                                        style="padding: 12px 15px; text-align: right; color:var(--text3); font-size:11px; font-weight: 700;">
                                        {{ $payment->created_at->format('d M, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 30px; color:var(--text3);">No
                                        records.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const chartData = @json($chartData);
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.map(i => i.label),
                    datasets: [{
                        data: chartData.map(i => i.revenue),
                        borderColor: '#6366f1',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 0,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(0,0,0,0.03)'
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 10
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
