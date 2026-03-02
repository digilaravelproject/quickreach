@extends('layout.app')

@section('content')
    <div class="main-area" x-data="batchApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            {{-- ── TOPBAR ── --}}
            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="topbar-left">
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">QR
                            Batches</h1>
                        <p class="page-subtitle"
                            style="margin: 2px 0 0 0; color: var(--text3); font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            Bulk Generated Batches</p>
                    </div>
                </div>
                <div class="topbar-right">
                    <a href="{{ route('admin.qr-codes.create') }}"
                        style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; box-shadow: var(--shadow-sm);">
                        + Generate Batch
                    </a>
                </div>
            </div>

            <div class="anim delay-1">

                {{-- ── FILTERS ── --}}
                <div class="card"
                    style="margin-bottom: 15px; padding: 12px; display: flex; flex-wrap: wrap; gap: 12px; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">

                    <div class="search-wrap" style="flex: 1; min-width: 250px; position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <input type="text" x-model="filters.search" @input.debounce.500ms="filters.page = 1; fetchData()"
                            placeholder="Search by Batch Code..."
                            style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 12px 10px 35px; outline: none; font-size: 13px;">
                    </div>

                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <select x-model="filters.category_id" @change="filters.page = 1; fetchData()"
                            style="height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text2);">
                            <option value="">All Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <button @click="resetFilters()" class="btn-outline"
                            style="height: 42px; padding: 0 15px; border-radius: 10px; font-weight: 800; font-size: 10px; text-transform: uppercase;">
                            Reset
                        </button>
                    </div>
                </div>

                {{-- ── BATCHES TABLE ── --}}
                <div class="card"
                    style="padding: 0; overflow: hidden; position: relative; border: 1px solid var(--border); min-height: 400px; display: flex; flex-direction: column;">

                    {{-- Loader --}}
                    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
                        style="background: rgba(var(--bg), 0.4); backdrop-filter: blur(4px); pointer-events: none;">
                        <div
                            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
                            <div
                                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 15px;">
                            </div>
                            <span
                                style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 2px;">Loading
                                Batches</span>
                        </div>
                    </div>

                    <div x-show="!loading" x-cloak class="table-scroll" style="overflow-x: auto; flex: 1;">
                        <table class="data-table"
                            style="width: 100%; min-width: 900px; border-collapse: collapse; table-layout: fixed;">
                            <thead>
                                <tr style="background: var(--card2);">
                                    <th
                                        style="width: 22%; padding: 15px 20px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Batch Code</th>
                                    <th
                                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Category</th>
                                    <th
                                        style="width: 10%; padding: 15px 15px; text-align: center; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Total</th>
                                    <th
                                        style="width: 30%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Status Breakdown</th>
                                    <th
                                        style="width: 13%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Created</th>
                                    <th
                                        style="width: 10%; padding: 15px 20px; text-align: center; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="batch in batches" :key="batch.id">
                                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                                        onmouseover="this.style.background='var(--card2)'"
                                        onmouseout="this.style.background='transparent'">

                                        {{-- Batch Code --}}
                                        <td style="padding: 14px 20px;">
                                            <div style="font-size: 13px; font-weight: 800; color: var(--text); font-style: italic;"
                                                x-text="batch.batch_code"></div>
                                            <div style="font-size: 10px; font-weight: 700; color: var(--text3); margin-top: 2px;"
                                                x-text="'ID #' + batch.id"></div>
                                        </td>

                                        {{-- Category --}}
                                        <td style="padding: 14px 15px;">
                                            <span class="prog-code"
                                                style="font-size: 10px; background: var(--card2); color: var(--text);"
                                                x-text="batch.category ? batch.category.name : 'N/A'"></span>
                                        </td>

                                        {{-- Total QR Count --}}
                                        <td style="padding: 14px 15px; text-align: center;">
                                            <span style="font-size: 18px; font-weight: 900; color: var(--text);"
                                                x-text="batch.qr_codes_count ?? batch.quantity"></span>
                                        </td>

                                        {{-- Status Breakdown --}}
                                        <td style="padding: 14px 15px;">
                                            <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                                <span class="badge badge-paid"
                                                    style="padding: 3px 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;">
                                                    <span x-text="batch.available_count ?? 0"></span> Available
                                                </span>
                                                <span class="badge badge-pending"
                                                    style="padding: 3px 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;">
                                                    <span x-text="batch.assigned_count ?? 0"></span> Assigned
                                                </span>
                                                <span class="badge badge-failed"
                                                    style="padding: 3px 8px; font-size: 9px; font-weight: 800; text-transform: uppercase;">
                                                    <span x-text="batch.registered_count ?? 0"></span> Registered
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Date --}}
                                        <td style="padding: 14px 15px;">
                                            <span style="font-size: 11px; font-weight: 700; color: var(--text2);"
                                                x-text="formatDate(batch.created_at)"></span>
                                        </td>

                                        {{-- Actions: View | Download | Delete --}}
                                        <td style="padding: 14px 20px; text-align: center;">
                                            <div style="display: flex; justify-content: center; gap: 6px;">

                                                {{-- View QR Codes --}}
                                                <a :href="`/admin/qr-batches/${batch.id}`" class="icon-btn"
                                                    title="View QR Codes"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--blue); display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        style="width:14px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- Download ZIP --}}
                                                <a :href="`/admin/qr-batches/${batch.id}/download`" class="icon-btn"
                                                    title="Download ZIP"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--text2); display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        style="width:14px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>

                                                {{-- Delete (sirf tab jab koi assigned/registered na ho) --}}
                                                <button
                                                    x-show="(batch.assigned_count ?? 0) === 0 && (batch.registered_count ?? 0) === 0"
                                                    @click="deleteBatch(batch.id)" class="icon-btn" title="Delete Batch"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--red); border: none; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        style="width:14px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>

                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div x-show="pagination.last_page > 1" x-cloak
                        style="padding: 15px 20px; background: var(--card2); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                        <div style="font-size: 11px; font-weight: 700; color: var(--text2);">
                            <span style="color: var(--text);" x-text="pagination.total"></span> total batches
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <button @click="changePage(pagination.current_page - 1)"
                                :disabled="pagination.current_page === 1" class="btn-outline"
                                style="padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;"
                                :style="pagination.current_page === 1 ? 'opacity: 0.3; cursor: not-allowed;' : ''">Prev</button>

                            <div
                                style="display: flex; gap: 4px; align-items: center; padding: 0 10px; font-size: 11px; font-weight: 800; color: var(--text);">
                                <span x-text="pagination.current_page"></span> / <span
                                    x-text="pagination.last_page"></span>
                            </div>

                            <button @click="changePage(pagination.current_page + 1)"
                                :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                                style="padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;"
                                :style="pagination.current_page === pagination.last_page ?
                                    'opacity: 0.3; cursor: not-allowed;' : ''">Next</button>
                        </div>
                    </div>

                    {{-- Empty State --}}
                    <div x-show="!loading && batches.length === 0" x-cloak
                        style="padding: 80px 0; text-align: center; color: var(--text3); font-size: 12px; font-weight: 700; text-transform: uppercase;">
                        Koi batch nahi mili. Pehle ek batch generate karein.
                    </div>

                </div>
            </div>

            <div style="height: 30px;"></div>
        </div>
    </div>

    <script>
        function batchApp() {
            return {
                batches: [],
                loading: false,
                filters: {
                    search: '',
                    category_id: '',
                    page: 1
                },
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    total: 0
                },

                init() {
                    this.fetchData();
                },

                async fetchData() {
                    this.loading = true;
                    const params = new URLSearchParams(this.filters).toString();
                    try {
                        const response = await fetch(`{{ route('admin.qr-batches.index') }}?${params}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const res = await response.json();
                        this.batches = res.data;
                        this.pagination = {
                            current_page: res.current_page,
                            last_page: res.last_page,
                            total: res.total
                        };
                    } catch (e) {
                        console.error('Fetch error', e);
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
                        category_id: '',
                        page: 1
                    };
                    this.fetchData();
                },

                async deleteBatch(id) {
                    if (!confirm('Kya aap is batch aur uske saare QR codes delete karna chahte hain?')) return;
                    try {
                        const response = await fetch(`/admin/qr-batches/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const res = await response.json();
                        if (response.ok) {
                            this.fetchData();
                        } else {
                            alert(res.error ?? 'Delete failed');
                        }
                    } catch (e) {
                        alert('Delete failed');
                    }
                },

                formatDate(dateStr) {
                    return new Date(dateStr).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }
            }
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
