@extends('layout.app')

@section('content')
    <div class="main-area" x-data="contactManager()">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 20px !important; height: 100vh; overflow-y: auto;">

            <div class="header-card"
                style="margin-bottom: 25px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h1 class="title"
                        style="margin: 0; font-size: 22px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                        Customer Inquiries</h1>
                    <p
                        style="margin: 4px 0 0 0; color: var(--text3); font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        Manage User Messages & Support</p>
                </div>
            </div>

            @if (session('success'))
                <div
                    style="background: #22c55e; color: white; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 12px; font-weight: 800;">
                    ✓ {{ session('success') }}</div>
            @endif

            <div class="card"
                style="background: var(--card2); border-radius: 18px; border: 1px solid var(--border); overflow: hidden;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                        <thead>
                            <tr style="background: rgba(0,0,0,0.02); border-bottom: 1px solid var(--border);">
                                <th
                                    style="padding: 15px; text-align: left; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                                    User Details</th>
                                <th
                                    style="padding: 15px; text-align: left; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                                    Message</th>
                                <th
                                    style="padding: 15px; text-align: center; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                                    Status</th>
                                <th
                                    style="padding: 15px; text-align: right; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr style="border-bottom: 1px solid var(--border); transition: 0.2s;"
                                    class="{{ !$msg->is_read ? 'unread-row' : '' }}">
                                    <td style="padding: 15px;">
                                        <div style="font-weight: 800; color: var(--text); font-size: 13px;">
                                            {{ $msg->name }}</div>
                                        <div style="font-size: 11px; color: var(--brand-purple); font-weight: 600;">
                                            {{ $msg->email }}</div>
                                        <div style="font-size: 10px; color: var(--text3); margin-top: 4px;">
                                            {{ $msg->created_at->format('d M, Y • h:i A') }}</div>
                                    </td>
                                    <td style="padding: 15px;">
                                        <div
                                            style="font-size: 12px; color: var(--text2); line-height: 1.5; max-width: 300px;">
                                            {{ $msg->message }}
                                        </div>
                                    </td>
                                    <td style="padding: 15px; text-align: center;">
                                        <button @click="toggleRead({{ $msg->id }}, $event)"
                                            style="border: none; padding: 5px 12px; border-radius: 20px; font-size: 9px; font-weight: 900; cursor: pointer; text-transform: uppercase;"
                                            class="{{ $msg->is_read ? 'btn-read' : 'btn-unread' }}">
                                            {{ $msg->is_read ? 'READ' : 'NEW' }}
                                        </button>
                                    </td>
                                    <td style="padding: 15px; text-align: right;">
                                        <div style="display: flex; gap: 10px; justify-content: flex-end;">
                                            <form action="{{ route('admin.contacts.destroy', $msg->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this inquiry permanently?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; width: 32px; height: 32px; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                                    <svg width="14" height="14" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path
                                                            d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            stroke-linecap="round"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        style="padding: 60px; text-align: center; color: var(--text3); font-weight: 800; letter-spacing: 1px;">
                                        NO INQUIRIES RECEIVED YET</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="margin-top: 20px;">
                {{ $messages->links() }}
            </div>
        </div>
    </div>

    <style>
        .unread-row {
            background: rgba(91, 91, 219, 0.03);
        }

        .btn-read {
            background: var(--bg);
            color: var(--text3);
            border: 1px solid var(--border);
        }

        .btn-unread {
            background: var(--brand-purple);
            color: white;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }
    </style>

    <script>
        function contactManager() {
            return {
                async toggleRead(id, event) {
                    const btn = event.target;
                    const row = btn.closest('tr');
                    try {
                        const res = await fetch(`/admin/contacts/toggle/${id}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        if (data.success) {
                            if (data.is_read) {
                                btn.textContent = 'READ';
                                btn.className = 'btn-read';
                                row.classList.remove('unread-row');
                            } else {
                                btn.textContent = 'NEW';
                                btn.className = 'btn-unread';
                                row.classList.add('unread-row');
                            }
                        }
                    } catch (e) {
                        console.error("Toggle error");
                    }
                }
            }
        }
    </script>
@endsection
