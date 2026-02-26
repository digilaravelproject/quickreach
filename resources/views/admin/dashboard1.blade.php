@extends('layout.app')

@section('content')
    <div class="flex flex-col h-full">

        <div
            class="px-8 py-6 bg-white border-b border-gray-100 flex justify-between items-center sticky top-0 z-20 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 font-sans">Dashboard Overview</h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back! Here's what's happening today.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.analytics') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    View Analytics
                </a>
                <a href="{{ route('admin.qr-codes.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-xl text-sm font-medium text-white hover:bg-brand-700 shadow-lg shadow-brand-500/30 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Generate QRs
                </a>
            </div>
        </div>

        <div class="flex-1 overflow-auto p-8 pb-20">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">₹{{ number_format($stats['total_revenue']) }}</h3>
                        <div class="flex items-center mt-2 text-sm">
                            <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded-full font-medium flex items-center">
                                +₹{{ number_format($stats['today_revenue']) }}
                            </span>
                            <span class="text-gray-400 ml-2">today</span>
                        </div>
                    </div>
                    <div
                        class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent opacity-50">
                    </div>
                    <svg class="absolute right-4 bottom-4 w-16 h-16 text-green-50 transform rotate-12 group-hover:scale-110 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500">Registered Customers</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_users']) }}</h3>
                        <p class="text-xs text-gray-400 mt-2">Active registrations</p>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-blue-50 to-transparent opacity-50">
                    </div>
                    <svg class="absolute right-4 bottom-4 w-16 h-16 text-blue-50 transform rotate-12 group-hover:scale-110 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500">Inventory Status</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold text-gray-900">{{ number_format($stats['available_qrs']) }}</h3>
                            <span class="text-xs text-gray-500">available</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                            <div class="bg-brand-500 h-1.5 rounded-full"
                                style="width: {{ $stats['total_qrs'] > 0 ? ($stats['available_qrs'] / $stats['total_qrs']) * 100 : 0 }}%">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">{{ number_format($stats['registered_qrs']) }} active /
                            {{ number_format($stats['total_qrs']) }} total</p>
                    </div>
                    <svg class="absolute right-4 bottom-4 w-16 h-16 text-brand-50 transform rotate-12 group-hover:scale-110 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-sm font-medium text-gray-500">Total Scans</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_scans']) }}</h3>
                        <div class="flex items-center mt-2 text-sm">
                            <span
                                class="text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full font-medium flex items-center">
                                +{{ $stats['today_scans'] }}
                            </span>
                            <span class="text-gray-400 ml-2">today</span>
                        </div>
                    </div>
                    <div
                        class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-purple-50 to-transparent opacity-50">
                    </div>
                    <svg class="absolute right-4 bottom-4 w-16 h-16 text-purple-50 transform rotate-12 group-hover:scale-110 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-gray-800">Revenue Chart</h3>
                        <form method="GET" action="{{ route('admin.dashboard') }}">
                            <select name="period" onchange="this.form.submit()"
                                class="bg-gray-50 border border-gray-200 text-gray-700 text-xs rounded-lg px-3 py-1.5 focus:ring-brand-500 focus:border-brand-500 block outline-none cursor-pointer">
                                <option value="daily" {{ $period === 'daily' ? 'selected' : '' }}>Last 30 Days</option>
                                <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>Last 12 Months
                                </option>
                                <option value="yearly" {{ $period === 'yearly' ? 'selected' : '' }}>Last 5 Years</option>
                            </select>
                        </form>
                    </div>
                    <div class="h-80 w-full relative">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
                        <a href="{{ route('admin.qr-codes.index') }}"
                            class="text-xs text-brand-600 hover:text-brand-800 font-semibold uppercase tracking-wider">View
                            All</a>
                    </div>
                    <div class="flex-1 overflow-auto max-h-[350px]">
                        @if ($recentRegistrations->isEmpty())
                            <div class="p-6 text-center text-gray-400 text-sm">No recent activity.</div>
                        @else
                            <div class="divide-y divide-gray-50">
                                @foreach ($recentRegistrations as $qr)
                                    <div class="p-4 hover:bg-gray-50 transition-colors flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center font-bold text-xs shrink-0 border border-brand-100">
                                            {{ $qr->registration ? strtoupper(substr($qr->registration->full_name, 0, 2)) : 'U' }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 truncate">
                                                {{ $qr->registration->full_name ?? 'Unknown User' }}</p>
                                            <p class="text-xs text-gray-500 truncate">Activated {{ $qr->category->name }}
                                                Tag</p>
                                        </div>
                                        <span
                                            class="text-xs text-gray-400 shrink-0">{{ $qr->updated_at->diffForHumans(null, true) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Transactions</h3>
                    <a href="{{ route('admin.payments.index') }}"
                        class="text-xs text-brand-600 hover:text-brand-800 font-semibold uppercase tracking-wider">View All
                        Payments</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500 font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Order Number</th>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentPayments as $payment)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="font-medium text-gray-900 text-sm">
                                                {{ $payment->user->name ?? 'Guest' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $payment->order_number ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        ₹{{ number_format($payment->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($payment->payment_status === 'completed')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Paid</span>
                                        @elseif($payment->payment_status === 'pending')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Failed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-gray-400">
                                        {{ $payment->created_at->format('d M, Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">No transactions
                                        found yet.</td>
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

            // Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(139, 92, 246, 0.15)');
            gradient.addColorStop(1, 'rgba(139, 92, 246, 0)');

            // Data from Controller
            const chartData = @json($chartData);
            const labels = chartData.map(item => item.label);
            const data = chartData.map(item => item.revenue);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.length ? labels : ['No Data'],
                    datasets: [{
                        label: 'Revenue (₹)',
                        data: data.length ? data : [0],
                        borderColor: '#8b5cf6',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#8b5cf6',
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Revenue: ₹' + context.parsed.y.toLocaleString('en-IN');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [2, 4],
                                color: '#f3f4f6'
                            },
                            ticks: {
                                font: {
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    size: 11
                                },
                                callback: function(value) {
                                    return '₹' + value.toLocaleString('en-IN');
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    family: "'Plus Jakarta Sans', sans-serif",
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
