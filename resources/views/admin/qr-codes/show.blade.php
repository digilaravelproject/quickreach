@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.qr-codes.index') }}" class="btn-outline"
                        style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: var(--text); text-decoration: none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">QR Details:
                            {{ $qrCode->qr_code }}</h1>
                        <p
                            style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 1px;">
                            Asset Management</p>
                    </div>
                </div>

                @if ($qrCode->qr_image_path)
                    <a href="{{ asset('storage/' . $qrCode->qr_image_path) }}" download class="btn-outline"
                        style="padding: 8px 15px; border-radius: 10px; font-size: 10px; font-weight: 800; display: flex; align-items: center; gap: 6px; text-decoration: none;">
                        <svg style="width:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" stroke-width="2.5" />
                        </svg>
                        DOWNLOAD QR
                    </a>
                @endif
            </div>

            <div class="anim delay-1">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">

                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div class="card" style="padding: 30px; border: 1px solid var(--border); text-align: center;">
                            <div
                                style="background: var(--card2); border: 1px solid var(--border); border-radius: 15px; padding: 15px; display: inline-block; margin-bottom: 15px;">
                                @if ($qrCode->qr_image_path)
                                    <img src="{{ asset('storage/' . $qrCode->qr_image_path) }}" alt="QR"
                                        style="width: 160px; height: 160px; object-fit: contain;">
                                @else
                                    <div
                                        style="width: 160px; height: 160px; display: flex; align-items: center; justify-content: center; color: var(--text3); font-size: 11px; font-style: italic;">
                                        No Image Available</div>
                                @endif
                            </div>
                            <h3 style="font-size: 18px; font-weight: 900; color: var(--text); margin-bottom: 5px;">
                                {{ $qrCode->qr_code }}</h3>
                            <p style="font-size: 10px; font-weight: 800; color: var(--blue); text-transform: uppercase;">
                                {{ $qrCode->category->name ?? 'No Category' }}</p>

                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid var(--border);">
                                <span
                                    class="badge {{ $qrCode->status === 'available' ? 'badge-paid' : ($qrCode->status === 'assigned' ? 'badge-pending' : 'badge-failed') }}"
                                    style="font-size: 10px; font-weight: 800; padding: 6px 15px;">
                                    {{ strtoupper($qrCode->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                            <p
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 1px;">
                                Metadata</p>
                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                                    <span style="color: var(--text2);">Created At</span>
                                    <span
                                        style="font-weight: 700; color: var(--text);">{{ $qrCode->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                                    <span style="color: var(--text2);">Last Updated</span>
                                    <span
                                        style="font-weight: 700; color: var(--text);">{{ $qrCode->updated_at->format('d M Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 15px; grid-column: span 2;">

                        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                            <div
                                style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">
                                Registration Information
                            </div>
                            <div style="padding: 25px;">
                                @if ($qrCode->registration)
                                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                                        <div
                                            style="width: 60px; height: 60px; border-radius: 15px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 22px;">
                                            {{ strtoupper(substr($qrCode->registration->full_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h4 style="font-size: 20px; font-weight: 800; color: var(--text); margin: 0;">
                                                {{ $qrCode->registration->full_name }}</h4>
                                            <p style="font-size: 14px; color: var(--text2); font-weight: 600; margin: 0;">
                                                {{ $qrCode->registration->mobile_number }}</p>
                                        </div>
                                    </div>

                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Full Name</p>
                                            <p style="font-size: 13px; font-weight: 700; color: var(--text);">
                                                {{ $qrCode->registration->full_name }}</p>
                                        </div>
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Mobile Number</p>
                                            <p style="font-size: 13px; font-weight: 700; color: var(--text);">
                                                {{ $qrCode->registration->mobile_number }}</p>
                                        </div>
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Friend/Family 1</p>
                                            <p style="font-size: 13px; font-weight: 700; color: var(--text);">
                                                {{ $qrCode->registration->friend_family_1 ?? 'N/A' }}</p>
                                        </div>
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Friend/Family 2</p>
                                            <p style="font-size: 13px; font-weight: 700; color: var(--text);">
                                                {{ $qrCode->registration->friend_family_2 ?? 'N/A' }}</p>
                                        </div>
                                        <div
                                            style="padding: 15px; background: var(--card2); border-radius: 12px; grid-column: span 2;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Full Address</p>
                                            <p style="font-size: 13px; font-weight: 700; color: var(--text);">
                                                {{ $qrCode->registration->full_address ?? 'N/A' }}</p>
                                        </div>
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Selected Tags</p>
                                            <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px;">
                                                @php
                                                    $tags = is_string($qrCode->registration->selected_tags)
                                                        ? json_decode($qrCode->registration->selected_tags, true)
                                                        : $qrCode->registration->selected_tags;
                                                @endphp
                                                @if (is_array($tags))
                                                    @foreach ($tags as $tag)
                                                        <span
                                                            style="background: var(--blue); color: white; font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 700;">{{ $tag }}</span>
                                                    @endforeach
                                                @else
                                                    <span
                                                        style="font-size: 13px; font-weight: 700; color: var(--text);">{{ $qrCode->registration->selected_tags ?? 'N/A' }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div style="padding: 15px; background: var(--card2); border-radius: 12px;">
                                            <p
                                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 5px;">
                                                Status</p>
                                            <span
                                                class="badge {{ $qrCode->registration->is_active ? 'badge-paid' : 'badge-failed' }}"
                                                style="font-size: 10px; font-weight: 800;">
                                                {{ $qrCode->registration->is_active ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div style="text-align: center; padding: 40px 0;">
                                        <div
                                            style="background: var(--card2); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                            <svg style="width: 24px; color: var(--text3);" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                    stroke-width="2" />
                                            </svg>
                                        </div>
                                        <p
                                            style="font-size: 12px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px;">
                                            This QR code has not been registered yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                            <div
                                style="padding: 12px 20px; background: var(--card2); border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center;">
                                <span
                                    style="font-weight: 800; font-size: 10px; text-transform: uppercase; color: var(--text3);">Scan
                                    Activity History</span>
                                <span style="font-size: 10px; font-weight: 900; color: var(--blue);">TOTAL SCANS:
                                    {{ $qrCode->scans_count ?? 0 }}</span>
                            </div>
                            <div style="padding: 20px;">
                                <div style="height: 250px; width: 100%;">
                                    <canvas id="scanChart"></canvas>
                                </div>
                                @if (($qrCode->scans_count ?? 0) == 0)
                                    <p
                                        style="text-align: center; color: var(--text3); font-size: 12px; margin-top: 15px; font-style: italic;">
                                        No scan activity recorded yet.</p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('scanChart');
                if (canvas) {
                    new Chart(canvas.getContext('2d'), {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                            datasets: [{
                                label: 'Total Scans',
                                data: [0, 0, 0, 0, 0],
                                borderColor: '#6366f1',
                                borderWidth: 3,
                                tension: 0.4,
                                pointRadius: 0,
                                fill: true,
                                backgroundColor: 'rgba(99, 102, 241, 0.05)'
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
                                        },
                                        stepSize: 1
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
                }
            });
        </script>
    @endpush
@endsection
