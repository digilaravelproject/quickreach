@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">
                        Analytics Overview</h1>
                    <p class="page-subtitle"
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 11px; font-weight: 700; text-transform: uppercase;">
                        Engagement & Revenue Insights</p>
                </div>

                <form method="GET" action="{{ route('admin.analytics') }}"
                    style="display: flex; align-items: center; gap: 8px; background: var(--card2); padding: 5px 10px; border-radius: 12px; border: 1px solid var(--border);">
                    <input type="date" name="date_from" value="{{ $dateFrom }}"
                        style="background: transparent; border: none; font-size: 11px; font-weight: 700; color: var(--text); outline: none; cursor: pointer;">
                    <span style="color: var(--text3); font-weight: 900;">-</span>
                    <input type="date" name="date_to" value="{{ $dateTo }}"
                        style="background: transparent; border: none; font-size: 11px; font-weight: 700; color: var(--text); outline: none; cursor: pointer;">
                    <button type="submit" class="btn-outline"
                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; background: var(--text); color: var(--bg); border: none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </form>
            </div>

            <div class="anim delay-1">
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-bottom: 15px;">
                    <div class="card"
                        style="padding: 20px; border: 1px solid var(--border); position: relative; overflow: hidden;">
                        <p
                            style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                            Total Scans</p>
                        <h3 style="font-size: 24px; font-weight: 900; color: var(--text);">
                            {{ number_format($scanStats['total_scans']) }}</h3>
                        <span
                            style="font-size: 9px; font-weight: 800; color: var(--blue); background: var(--blue-bg); padding: 2px 8px; border-radius: 20px; text-transform: uppercase;">Period
                            Activity</span>
                    </div>

                    <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                        <p
                            style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                            Calls Connected</p>
                        <h3 style="font-size: 24px; font-weight: 900; color: var(--text);">
                            {{ number_format($scanStats['call_actions']) }}</h3>
                        <span
                            style="font-size: 9px; font-weight: 800; color: #8b5cf6; background: #ede9fe; padding: 2px 8px; border-radius: 20px; text-transform: uppercase;">Privacy
                            Masked</span>
                    </div>

                    <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                        <p
                            style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                            WhatsApp Chats</p>
                        <h3 style="font-size: 24px; font-weight: 900; color: var(--text);">
                            {{ number_format($scanStats['whatsapp_actions']) }}</h3>
                        <span
                            style="font-size: 9px; font-weight: 800; color: var(--green); background: var(--green-bg); padding: 2px 8px; border-radius: 20px; text-transform: uppercase;">Direct
                            Links</span>
                    </div>

                    <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                        <p
                            style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                            Emergency Alerts</p>
                        <h3 style="font-size: 24px; font-weight: 900; color: var(--red);">
                            {{ number_format($scanStats['emergency_actions']) }}</h3>
                        <span
                            style="font-size: 9px; font-weight: 800; color: var(--red); background: var(--red-bg); padding: 2px 8px; border-radius: 20px; text-transform: uppercase;">Critical
                            SOS</span>
                    </div>
                </div>

                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 12px; margin-bottom: 15px;">
                    <div class="card" style="grid-column: span 2; padding: 20px; border: 1px solid var(--border);">
                        <h3
                            style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 20px;">
                            Scan Activity Trend</h3>
                        <div style="height: 280px; width: 100%;"><canvas id="dailyScansChart"></canvas></div>
                    </div>

                    <div class="card" style="padding: 20px; border: 1px solid var(--border); text-align: center;">
                        <h3
                            style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 20px;">
                            Action Distribution</h3>
                        <div
                            style="height: 220px; width: 100%; display: flex; align-items: center; justify-content: center;">
                            <canvas id="actionsChart"></canvas>
                        </div>
                        <div style="margin-top: 20px; display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">
                            <div
                                style="display: flex; align-items: center; gap: 5px; font-size: 9px; font-weight: 800; color: var(--text2);">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #a855f7;"></span> CALL
                            </div>
                            <div
                                style="display: flex; align-items: center; gap: 5px; font-size: 9px; font-weight: 800; color: var(--text2);">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #22c55e;"></span>
                                WHATSAPP</div>
                            <div
                                style="display: flex; align-items: center; gap: 5px; font-size: 9px; font-weight: 800; color: var(--text2);">
                                <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444;"></span>
                                EMERGENCY</div>
                        </div>
                    </div>
                </div>

                <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                    <div style="padding: 15px 20px; background: var(--card2); border-bottom: 1px solid var(--border);">
                        <h3
                            style="font-size: 11px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin: 0;">
                            Top 10 Most Scanned QRs</h3>
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                            <thead>
                                <tr style="background: var(--bg);">
                                    <th
                                        style="padding: 12px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                                        QR Code</th>
                                    <th
                                        style="padding: 12px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                                        Category</th>
                                    <th
                                        style="padding: 12px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                                        Owner</th>
                                    <th
                                        style="padding: 12px 20px; text-align: right; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                                        Scans</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topScannedQrs as $qr)
                                    <tr style="border-bottom: 1px solid var(--border);">
                                        <td style="padding: 12px 20px;">
                                            <span class="prog-code"
                                                style="font-family: monospace; font-size: 12px;">{{ $qr->display_code ?? $qr->qr_code }}</span>
                                        </td>
                                        <td style="padding: 12px 20px;">
                                            <span class="badge"
                                                style="background: var(--card2); color: var(--text); font-size: 9px; font-weight: 800;">{{ $qr->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td style="padding: 12px 20px;">
                                            <div style="display: flex; align-items: center; gap: 8px;">
                                                <div
                                                    style="width: 24px; height: 24px; border-radius: 6px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 900;">
                                                    {{ substr($qr->registration->full_name ?? 'U', 0, 1) }}</div>
                                                <span
                                                    style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $qr->registration->full_name ?? 'Unassigned' }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 12px 20px; text-align: right;">
                                            <span
                                                style="font-size: 14px; font-weight: 900; color: var(--blue);">{{ $qr->scans_count }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            style="padding: 40px; text-align: center; color: var(--text3); font-size: 12px; font-weight: 700; text-transform: uppercase;">
                                            No scan data found</td>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Line Chart
            const dailyCtx = document.getElementById('dailyScansChart').getContext('2d');
            const dailyData = @json($dailyScans);
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: dailyData.map(item => item.date),
                    datasets: [{
                        data: dailyData.map(item => item.count),
                        borderColor: '#3b82f6',
                        borderWidth: 3,
                        tension: 0.4,
                        pointRadius: 0,
                        fill: true,
                        backgroundColor: 'rgba(59, 130, 246, 0.03)'
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
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.03)'
                            },
                            ticks: {
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
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });

            // 2. Doughnut Chart
            const actionCtx = document.getElementById('actionsChart').getContext('2d');
            const scanStats = @json($scanStats);
            new Chart(actionCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Calls', 'WhatsApp', 'Emergency', 'View Only'],
                    datasets: [{
                        data: [
                            scanStats.call_actions,
                            scanStats.whatsapp_actions,
                            scanStats.emergency_actions,
                            scanStats.total_scans - (scanStats.call_actions + scanStats
                                .whatsapp_actions + scanStats.emergency_actions)
                        ],
                        backgroundColor: ['#a855f7', '#22c55e', '#ef4444', 'rgba(0,0,0,0.05)'],
                        borderWidth: 0,
                        hoverOffset: 4
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
                    cutout: '75%'
                }
            });
        });
    </script>
@endsection
