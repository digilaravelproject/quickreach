@extends('layout.app')

@section('content')
    <div class="main-area" x-data="paymentApp()" x-init="init()">

        <div class="page-scroll" style="background: var(--bg); padding: 12px !important;">

            {{-- ── PAGE HEADER ── --}}
            <div class="card"
                style="margin: 0 0 12px 0; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Payments</h1>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <a href="{{ route('admin.payments.create') }}"
                        style="display: inline-flex; align-items: center; gap: 6px; height: 34px; padding: 0 14px; background: var(--text); color: var(--bg); border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; text-decoration: none;">
                        + Manual Entry
                    </a>
                    <div class="live-badge" style="font-size: 10px; padding: 2px 8px;">Live</div>
                </div>
            </div>

            {{-- ── STATS ── --}}
            <div class="card" style="margin: 0 0 12px 0; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                <div style="padding: 15px 15px 0;">
                    <h3 class="card-title" style="font-size: 14px;">Revenue Overview</h3>
                </div>
                <div class="stat-grid" style="padding: 15px; gap: 10px;">
                    <div
                        style="padding: 15px; border-radius: 16px; background: linear-gradient(135deg, #6366f1 0%, #4338ca 100%); color: white;">
                        <p style="font-size: 9px; font-weight: 700; opacity: 0.8; text-transform: uppercase;">Total Revenue
                        </p>
                        <p style="font-size: 20px; font-weight: 800; margin-top: 2px;">
                            ₹{{ number_format($stats['total_revenue'], 0) }}</p>
                    </div>
                    <div
                        style="padding: 15px; border-radius: 16px; background: var(--card); border: 1px solid var(--border);">
                        <p class="stat-label" style="font-size: 10px;">Today</p>
                        <p class="stat-val" style="color: var(--green); font-size: 18px; margin-top: 2px;">
                            ₹{{ number_format($stats['today_revenue'], 0) }}</p>
                    </div>
                    <div
                        style="padding: 15px; border-radius: 16px; background: var(--card); border: 1px solid var(--border);">
                        <p class="stat-label" style="font-size: 10px;">Pending</p>
                        <p class="stat-val" style="color: var(--amber); font-size: 18px; margin-top: 2px;">
                            {{ $stats['pending_count'] }}</p>
                    </div>
                    <div
                        style="padding: 15px; border-radius: 16px; background: var(--card); border: 1px solid var(--border);">
                        <p class="stat-label" style="font-size: 10px;">COD Pending</p>
                        <p class="stat-val" style="color: #F97316; font-size: 18px; margin-top: 2px;">
                            {{ $stats['cod_pending'] }}</p>
                    </div>
                </div>
            </div>

            {{-- ── FILTERS + EXPORT ── --}}
            <div class="card"
                style="margin-bottom: 12px; padding: 12px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">

                {{-- Search --}}
                <div class="search-wrap" style="flex: 1; min-width: 200px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px; left: 12px;">
                        <circle cx="11" cy="11" r="8" stroke-width="2" />
                        <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <input type="text" x-model="filters.search" @input.debounce.500ms="filters.page = 1; fetchData()"
                        placeholder="Search by name, order number or payment ID..."
                        style="width: 100%; padding-left: 35px; background: var(--card2); border: 1px solid var(--border); height: 40px; border-radius: 10px; font-size: 13px;">
                </div>

                <div style="display: flex; gap: 8px; flex-wrap: wrap;">

                    {{-- Payment Status Filter: only completed | pending --}}
                    <select x-model="filters.status" @change="filters.page = 1; fetchData()"
                        style="height: 40px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text);">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                    </select>

                    {{-- Payment Method Filter --}}
                    <select x-model="filters.payment_method" @change="filters.page = 1; fetchData()"
                        style="height: 40px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text);">
                        <option value="">All Methods</option>
                        <option value="online">Online</option>
                        <option value="offline">Offline/cash</option>
                        <option value="cod">Cash on Delivery</option>
                    </select>

                    {{-- Reset --}}
                    <button @click="resetFilters()" class="btn-outline"
                        style="height: 40px; padding: 0 15px; border-radius: 10px; font-weight: 700; font-size: 11px;">
                        Reset
                    </button>

                    {{-- Export CSV --}}
                    <button @click="exportCSV()" :disabled="exporting"
                        style="display: inline-flex; align-items: center; gap: 7px; height: 40px; padding: 0 16px; background: var(--text); color: var(--bg); border: none; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; white-space: nowrap;"
                        :style="exporting ? 'opacity: 0.5; cursor: not-allowed;' : ''">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        <span x-text="exporting ? 'Exporting...' : 'Export CSV'"></span>
                    </button>
                </div>
            </div>

            {{-- ── TABLE ── --}}
            <div style="padding: 0;">
                @include('admin.payments.partials._table')
            </div>

            <div style="height: 30px;"></div>
        </div>
    </div>

    {{-- Toast --}}
    <div id="toast"
        style="display:none; position: fixed; bottom: 24px; right: 24px; z-index: 9999; padding: 14px 24px; border-radius: 14px; font-weight: 800; font-size: 13px; color: white; box-shadow: 0 8px 30px rgba(0,0,0,0.2);">
    </div>

    <script>
        function paymentApp() {
            return {
                orders: [],
                loading: false,
                exporting: false,
                filters: {
                    search: '',
                    status: '',
                    payment_method: '',
                    page: 1,
                },
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    total: 0,
                },

                init() {
                    this.fetchData();
                },

                async fetchData() {
                    this.loading = true;
                    const params = new URLSearchParams();
                    Object.entries(this.filters).forEach(([k, v]) => {
                        if (v) params.set(k, v);
                    });

                    try {
                        const response = await fetch(`{{ route('admin.payments.index') }}?${params.toString()}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });
                        const res = await response.json();
                        this.orders = res.data.map(o => ({
                            ...o,
                            marking: false
                        }));
                        this.pagination = {
                            current_page: res.current_page,
                            last_page: res.last_page,
                            total: res.total,
                        };
                    } catch (e) {
                        console.error('Fetch error:', e);
                        this.showToast('Failed to load orders. Please refresh.', 'error');
                    }
                    this.loading = false;
                },

                changePage(p) {
                    if (p < 1 || p > this.pagination.last_page) return;
                    this.filters.page = p;
                    this.fetchData();
                    document.querySelector('.page-scroll').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                resetFilters() {
                    this.filters = {
                        search: '',
                        status: '',
                        payment_method: '',
                        page: 1
                    };
                    this.fetchData();
                },

                exportCSV() {
                    this.exporting = true;
                    const params = new URLSearchParams({
                        search: this.filters.search,
                        status: this.filters.status,
                        payment_method: this.filters.payment_method,
                    }).toString();
                    const a = document.createElement('a');
                    a.href = `{{ route('admin.payments.export') }}?${params}`;
                    a.download = '';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    setTimeout(() => this.exporting = false, 2000);
                },

                async markCodPaid(order) {
                    if (!confirm(`Mark order ${order.order_number} as completed and assign QR codes?`)) return;

                    order.marking = true;
                    try {
                        const res = await fetch(`/admin/payments/${order.id}/mark-paid`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // <-- FIXED CSRF TOKEN DIRECTLY FROM BLADE
                                'Accept': 'application/json',
                            },
                        });
                        const data = await res.json();

                        if (res.ok && data.success) {
                            this.showToast(data.message, 'success');
                            await this.fetchData();
                        } else {
                            this.showToast(data.message || 'Error updating order.', 'error');
                            order.marking = false;
                        }
                    } catch (e) {
                        this.showToast('Something went wrong. Please try again.', 'error');
                        order.marking = false;
                    }
                },

                formatDate(d) {
                    if (!d) return '—';
                    return new Date(d).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric',
                    });
                },

                showToast(message, type = 'success') {
                    const el = document.getElementById('toast');
                    el.textContent = message;
                    el.style.background = type === 'success' ? '#16a34a' : '#dc2626';
                    el.style.display = 'block';
                    setTimeout(() => el.style.display = 'none', 4000);
                },
            }
        }
    </script>

    <style>
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
