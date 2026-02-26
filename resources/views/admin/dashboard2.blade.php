@extends('layout.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
            <div>
                <h4 class="fw-bold py-1 mb-0">Dashboard Overview</h4>
                <p class="text-muted mb-0">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.analytics') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-bar-chart-alt-2 me-1"></i> View Analytics
                </a>
                <a href="{{ route('admin.qr-codes.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Generate QRs
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-dollar"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Revenue</span>
                        <h3 class="card-title mb-2">₹{{ number_format($stats['total_revenue']) }}</h3>
                        <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                            +₹{{ number_format($stats['today_revenue']) }} today</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Customers</span>
                        <h3 class="card-title mb-2">{{ number_format($stats['total_users']) }}</h3>
                        <small class="text-muted">Active registrations</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-package"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Inventory Status</span>
                        <h3 class="card-title mb-2">{{ number_format($stats['available_qrs']) }}</h3>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                style="width: {{ $stats['total_qrs'] > 0 ? ($stats['available_qrs'] / $stats['total_qrs']) * 100 : 0 }}%">
                            </div>
                        </div>
                        <small class="text-muted">{{ number_format($stats['registered_qrs']) }} active /
                            {{ number_format($stats['total_qrs']) }} total</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-qr"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Scans</span>
                        <h3 class="card-title mb-2">{{ number_format($stats['total_scans']) }}</h3>
                        <small class="text-warning fw-semibold">+{{ $stats['today_scans'] }} today</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Revenue Chart</h5>
                        </div>
                        <div class="dropdown">
                            <form method="GET" action="{{ route('admin.dashboard') }}" id="periodForm">
                                <select name="period" onchange="document.getElementById('periodForm').submit()"
                                    class="form-select form-select-sm">
                                    <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Last 30 Days
                                    </option>
                                    <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 12 Months
                                    </option>
                                    <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Last 5 Years
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="revenueChartContainer" style="height: 350px;">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Recent Activity</h5>
                        <a href="{{ route('admin.qr-codes.index') }}" class="btn btn-sm btn-label-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @forelse ($recentRegistrations as $qr)
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            {{ $qr->registration ? strtoupper(substr($qr->registration->full_name, 0, 1)) : 'U' }}
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">{{ $qr->registration->full_name ?? 'Unknown User' }}</h6>
                                            <small class="text-muted d-block">Activated {{ $qr->category->name }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small
                                                class="fw-semibold">{{ $qr->updated_at->diffForHumans(null, true) }}</small>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-muted">No recent activity.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Recent Transactions
                <a href="{{ route('admin.payments.index') }}" class="btn btn-xs btn-outline-primary">View All Payments</a>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Order Number</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-end">Date</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($recentPayments as $payment)
                            <tr>
                                <td><strong>{{ $payment->user->name ?? 'Guest' }}</strong></td>
                                <td>{{ $payment->order_number ?? 'N/A' }}</td>
                                <td>₹{{ number_format($payment->total_amount, 2) }}</td>
                                <td>
                                    @if ($payment->payment_status === 'completed')
                                        <span class="badge bg-label-success me-1">Paid</span>
                                    @elseif($payment->payment_status === 'pending')
                                        <span class="badge bg-label-warning me-1">Pending</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">Failed</span>
                                    @endif
                                </td>
                                <td class="text-end">{{ $payment->created_at->format('d M, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No transactions found yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                    labels: chartData.map(item => item.label),
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: chartData.map(item => item.revenue),
                        borderColor: '#696cff', // Sneat Primary Color
                        backgroundColor: 'rgba(105, 108, 255, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#696cff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [5, 5],
                                color: '#e5e7eb'
                            },
                            ticks: {
                                callback: (value) => '₹' + value.toLocaleString('en-IN')
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
