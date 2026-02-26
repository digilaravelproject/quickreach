@extends('layout.app')

@section('content')
    <div class="main-area" x-data="paymentApp()" x-init="init()">

        <div class="page-scroll" style="background: var(--bg); padding: 12px !important;">

            <div class="card"
                style="margin: 0 0 12px 0; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Payments Ledger</h1>
                <div class="live-badge" style="font-size: 10px; padding: 2px 8px;">System Live</div>
            </div>

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
                        <p class="stat-label" style="font-size: 10px;">Failed</p>
                        <p class="stat-val" style="color: var(--red); font-size: 18px; margin-top: 2px;">
                            {{ $stats['failed_count'] }}</p>
                    </div>
                </div>
            </div>

            <div class="card"
                style="margin-bottom: 12px; padding: 12px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="search-wrap" style="flex: 1; min-width: 200px;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px; left: 12px;">
                        <circle cx="11" cy="11" r="8" stroke-width="2" />
                        <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <input type="text" x-model="filters.search" @input.debounce.500ms="filters.page = 1; fetchData()"
                        placeholder="Search name, order or ID..."
                        style="width: 100%; padding-left: 35px; background: var(--card2); border: 1px solid var(--border); height: 40px; border-radius: 10px; font-size: 13px;">
                </div>

                <div style="display: flex; gap: 8px; width: 100%; sm:width: auto; flex: 1;">
                    <select x-model="filters.status" @change="filters.page = 1; fetchData()"
                        style="flex: 1; height: 40px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text);">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="failed">Failed</option>
                    </select>
                    <button @click="resetFilters()" class="btn-outline"
                        style="height: 40px; padding: 0 15px; border-radius: 10px; font-weight: 700; font-size: 11px;">Reset</button>
                </div>
            </div>

            <div style="padding: 0;">
                @include('admin.payments.partials._table')
            </div>

            <div style="height: 30px;"></div>
        </div>
    </div>

    <script>
        function paymentApp() {
            return {
                orders: [], // Ensure this matches your x-for in the partial
                loading: false,
                filters: {
                    search: '',
                    status: '',
                    page: 1
                },
                pagination: {
                    current_page: 1,
                    last_page: 1
                },
                init() {
                    this.fetchData();
                },
                async fetchData() {
                    this.loading = true;
                    let params = new URLSearchParams(this.filters).toString();
                    try {
                        const response = await fetch(`{{ route('admin.payments.index') }}?${params}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const res = await response.json();
                        // IMPORTANT: Make sure your controller returns 'data' array
                        this.orders = res.data;
                        this.pagination = {
                            current_page: res.current_page,
                            last_page: res.last_page
                        };
                    } catch (e) {
                        console.error("Data Load Error:", e);
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
                        page: 1
                    };
                    this.fetchData();
                },
                formatDate(d) {
                    if (!d) return '—';
                    return new Date(d).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }
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
