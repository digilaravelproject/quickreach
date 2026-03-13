@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="topbar-left">
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">
                            Fraud Detection</h1>
                        <p class="page-subtitle" style="margin: 2px 0 0 0; color: var(--text2); font-size: 11px;">Call logs grouped by owner number</p>
                    </div>
                </div>

                <form action="" method="GET" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: center;">
                    <div style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search QR code or owner number"
                            style="width: 250px; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 8px 12px 8px 35px; outline: none; font-size: 13px;">
                    </div>

                    <button type="submit"
                        style="display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; background: var(--blue); color: var(--bg); border: none; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.2s; white-space: nowrap;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filter
                    </button>
                </form>
            </div>

            <div class="anim delay-1">
                <div class="card" style="padding: 20px; border: 1px solid var(--border);">
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                            <thead>
                                <tr>
                                    <th style="text-align: left; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">QR Code</th>
                                    <th style="text-align: left; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Owner Number</th>
                                    <th style="text-align: left; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Type</th>
                                    <th style="text-align: left; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Initiated</th>
                                    <th style="text-align: right; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Calls</th>
                                    <th style="text-align: center; padding: 10px 12px; color: var(--text3); font-weight: 800; text-transform: uppercase;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fraudDetections as $item)
                                    <tr style="border-top: 1px solid var(--border);">
                                        <td style="padding: 10px 12px;">
                                            @if ($item->qr_id)
                                                <a href="{{ route('admin.qr-codes.show', $item->qr_id) }}"
                                                    style="color: var(--blue); font-weight: 700; text-decoration: none;">
                                                    {{ $item->qr_code_id }}
                                                </a>
                                            @else
                                                <span style="color: var(--text3);">{{ $item->qr_code_id }}</span>
                                            @endif
                                        </td>
                                        <td style="padding: 10px 12px;">
                                            {{ $item->to_number }}
                                        </td>
                                        <td style="padding: 10px 12px; text-transform: capitalize;">
                                            {{ str_replace('_', ' ', $item->type) }}
                                        </td>
                                        <td style="padding: 10px 12px;">
                                            {{ $item->initiation_time ? \Illuminate\Support\Carbon::parse($item->initiation_time)->format('d M Y, h:i A') : '—' }}
                                        </td>
                                        <td style="padding: 10px 12px; text-align: right;">
                                            {{ $item->total_calls }}
                                        </td>
                                        <td style="padding: 10px 12px; text-align: center;">
                                            @if ($item->qr_id)
                                                <button type="button" class="fraud-toggle" data-qr-id="{{ $item->qr_id }}" data-status="{{ $item->qr_status }}"
                                                    style="background: none; border: none; cursor: pointer; padding: 0; display: inline-flex; align-items: center;">
                                                    <span class="fraud-toggle-track"></span>
                                                    <span class="fraud-toggle-thumb"></span>
                                                </button>
                                            @else
                                                <span style="color: var(--text3);">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 20px; color: var(--text3); font-style: italic;">
                                            No call records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 11px; color: var(--text3);">
                            Showing {{ $fraudDetections->firstItem() ?? 0 }} - {{ $fraudDetections->lastItem() ?? 0 }} of {{ $fraudDetections->total() }} records
                        </span>
                        <div>
                            {{ $fraudDetections->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <div style="height: 30px;"></div>
        </div>
    </div>

    <script>
        (function () {
            const csrfToken = '{{ csrf_token() }}';

            function updateToggleAppearance(button) {
                const status = button.getAttribute('data-status');
                const track = button.querySelector('.fraud-toggle-track');
                const thumb = button.querySelector('.fraud-toggle-thumb');

                const isInactive = status === 'inactive';

                if (track) {
                    track.style.background = isInactive ? '#e5e7eb' : '#7c3aed';
                }
                if (thumb) {
                    thumb.style.left = isInactive ? '3px' : '19px';
                }
                button.setAttribute('title', isInactive ? 'Activate' : 'Deactivate');
            }

            async function toggleStatus(button) {
                const qrId = button.getAttribute('data-qr-id');
                const status = button.getAttribute('data-status');
                const action = status === 'inactive' ? 'activate' : 'deactivate';

                if (!confirm(`Are you sure you want to ${action} this QR code?`)) return;

                try {
                    const res = await fetch(`/admin/qr-codes/${qrId}/toggle-inactive`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (!res.ok) throw new Error('Failed');

                    // reload to get fresh status
                    window.location.reload();
                } catch (e) {
                    alert('Failed to toggle status.');
                }
            }

            document.querySelectorAll('.fraud-toggle').forEach(button => {
                updateToggleAppearance(button);
                button.addEventListener('click', () => toggleStatus(button));
            });
        })();
    </script>

    <style>
        .fraud-toggle {
            width: 34px;
            height: 18px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 0;
        }

        .fraud-toggle-track {
            width: 100%;
            height: 100%;
            border-radius: 50px;
            display: block;
            transition: background 0.25s ease;
        }

        .fraud-toggle-thumb {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #fff;
            position: absolute;
            top: 3px;
            left: 3px;
            transition: left 0.25s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
