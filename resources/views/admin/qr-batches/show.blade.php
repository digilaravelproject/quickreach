@extends('layout.app')

@section('content')
    <div class="main-area" x-data="batchQrApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            {{-- ── TOPBAR ── --}}
            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.qr-batches.index') }}" class="btn-outline"
                        style="width: 34px; height: 34px; display: flex; align-items: center; justify-content: center; border-radius: 10px; color: var(--text); text-decoration: none;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">
                            {{ $qrBatch->batch_code }}</h1>
                        <p
                            style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; margin-top: 2px;">
                            {{ $qrBatch->category->name ?? 'N/A' }} &bull; {{ $qrBatch->quantity }} QR Codes
                        </p>
                    </div>
                </div>

                {{-- Download Batch ZIP --}}
                <a href="{{ route('admin.qr-batches.download', $qrBatch) }}"
                    style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: var(--shadow-sm);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:15px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download All ZIP
                </a>
            </div>

            {{-- ── BATCH STATS ── --}}
            <div class="anim delay-1"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; margin-bottom: 15px;">
                @php
                    $stats = [
                        ['label' => 'Total', 'value' => $qrBatch->quantity, 'color' => 'var(--text)'],
                        [
                            'label' => 'Available',
                            'value' => $qrBatch->qrCodes()->where('status', 'available')->count(),
                            'color' => 'var(--green)',
                        ],
                        [
                            'label' => 'Assigned',
                            'value' => $qrBatch->qrCodes()->where('status', 'assigned')->count(),
                            'color' => 'var(--yellow)',
                        ],
                        [
                            'label' => 'Registered',
                            'value' => $qrBatch->qrCodes()->where('status', 'registered')->count(),
                            'color' => 'var(--red)',
                        ],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="card" style="padding: 18px 20px; border: 1px solid var(--border); text-align: center;">
                        <div style="font-size: 26px; font-weight: 900; color: {{ $stat['color'] }};">{{ $stat['value'] }}
                        </div>
                        <div
                            style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">
                            {{ $stat['label'] }}</div>
                    </div>
                @endforeach
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
                            placeholder="Search QR Code..."
                            style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 12px 10px 35px; outline: none; font-size: 13px;">
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <select x-model="filters.status" @change="filters.page = 1; fetchData()"
                            style="height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text2);">
                            <option value="">All Status</option>
                            <option value="available">Available</option>
                            <option value="assigned">Assigned</option>
                            <option value="registered">Registered</option>
                        </select>

                        <button @click="resetFilters()" class="btn-outline"
                            style="height: 42px; padding: 0 15px; border-radius: 10px; font-weight: 800; font-size: 10px; text-transform: uppercase;">
                            Reset
                        </button>
                    </div>
                </div>

                {{-- ── QR CODES TABLE ── --}}
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
                                QR Codes</span>
                        </div>
                    </div>

                    <div x-show="!loading" x-cloak class="table-scroll" style="overflow-x: auto; flex: 1;">
                        <table class="data-table"
                            style="width: 100%; min-width: 900px; border-collapse: collapse; table-layout: fixed;">
                            <thead>
                                <tr style="background: var(--card2);">
                                    <th style="width: 5%; padding: 15px 20px;">
                                        <input type="checkbox" @change="toggleAll($event)" class="checkbox-custom">
                                    </th>
                                    <th
                                        style="width: 18%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        QR Code</th>
                                    <th
                                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Status</th>
                                    <th
                                        style="width: 28%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Owner</th>
                                    <th
                                        style="width: 16%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Created</th>
                                    <th
                                        style="width: 18%; padding: 15px 20px; text-align: center; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="qr in qrCodes" :key="qr.id">
                                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                                        onmouseover="this.style.background='var(--card2)'"
                                        onmouseout="this.style.background='transparent'">

                                        {{-- Checkbox --}}
                                        <td style="padding: 12px 20px;">
                                            <input type="checkbox" :value="qr.id" x-model="selected"
                                                class="checkbox-custom">
                                        </td>

                                        {{-- QR Code --}}
                                        <td style="padding: 12px 15px;">
                                            <a :href="`/admin/qr-codes/${qr.id}`" style="text-decoration: none;">
                                                <div style="font-size: 13px; font-weight: 800; color: var(--text); font-style: italic;"
                                                    x-text="qr.qr_code"></div>
                                            </a>
                                        </td>

                                        {{-- Status --}}
                                        <td style="padding: 12px 15px;">
                                            <span class="badge"
                                                :class="{
                                                    'badge-paid': qr.status === 'available',
                                                    'badge-pending': qr.status === 'assigned',
                                                    'badge-failed': qr.status === 'registered'
                                                }"
                                                style="padding: 4px 10px; font-size: 9px; font-weight: 800; text-transform: uppercase;"
                                                x-text="qr.status"></span>
                                        </td>

                                        {{-- Owner --}}
                                        <td style="padding: 12px 15px;">
                                            <template x-if="qr.registration">
                                                <div style="min-width: 0;">
                                                    <div style="font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                        x-text="qr.registration.full_name"></div>
                                                    <div style="font-size: 10px; color: var(--text3);"
                                                        x-text="qr.registration.mobile_number"></div>
                                                </div>
                                            </template>
                                            <template x-if="!qr.registration">
                                                <span style="font-size: 11px; color: var(--text3); font-style: italic;">Not
                                                    Registered</span>
                                            </template>
                                        </td>

                                        {{-- Date --}}
                                        <td style="padding: 12px 15px;">
                                            <span style="font-size: 11px; font-weight: 700; color: var(--text2);"
                                                x-text="formatDate(qr.created_at)"></span>
                                        </td>

                                        {{-- Actions --}}
                                        <td style="padding: 12px 20px; text-align: center;">
                                            <div style="display: flex; justify-content: center; gap: 6px;">
                                                {{-- View Detail --}}
                                                <a :href="`/admin/qr-codes/${qr.id}`" class="icon-btn"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--blue);">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        style="width:14px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- Download Single QR SVG --}}
                                                <a :href="qr.qr_image_path ? `/storage/${qr.qr_image_path}` : '#'"
                                                    :download="qr.qr_code + '.svg'" x-show="qr.qr_image_path"
                                                    class="icon-btn"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--text2);">
                                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        style="width:14px;">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                </a>

                                                {{-- Delete (sirf available) --}}
                                                <button @click="deleteSingle(qr.id)" x-show="qr.status === 'available'"
                                                    class="icon-btn"
                                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--red); border: none; cursor: pointer;">
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
                            <span style="color: var(--text);" x-text="pagination.total"></span> total QR codes
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

                    {{-- Empty --}}
                    <div x-show="!loading && qrCodes.length === 0" x-cloak
                        style="padding: 80px 0; text-align: center; color: var(--text3); font-size: 12px; font-weight: 700; text-transform: uppercase;">
                        Is batch mein koi QR code nahi mila.
                    </div>
                </div>
            </div>

            {{-- Bulk Delete Bar --}}
            <div x-show="selected.length > 0" x-transition
                style="position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%); z-index: 999; background: var(--text); color: var(--bg); padding: 12px 25px; border-radius: 15px; box-shadow: var(--shadow-lg); display: flex; align-items: center; gap: 20px; border: 1px solid var(--border);">
                <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px;">
                    <span x-text="selected.length" style="color: var(--blue);"></span> Selected
                </span>
                <div style="width: 1px; height: 15px; background: rgba(255,255,255,0.2);"></div>
                <button @click="bulkDelete()"
                    style="background: none; border: none; font-size: 11px; font-weight: 900; color: var(--red); cursor: pointer; text-transform: uppercase;">
                    Bulk Delete
                </button>
            </div>

            <div style="height: 40px;"></div>
        </div>
    </div>

    <script>
        function batchQrApp() {
            return {
                qrCodes: [],
                loading: false,
                selected: [],
                allSelected: false,
                filters: {
                    search: '',
                    status: '',
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
                        const response = await fetch(`{{ route('admin.qr-batches.show', $qrBatch) }}?${params}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const res = await response.json();
                        this.qrCodes = res.data;
                        this.pagination = {
                            current_page: res.current_page,
                            last_page: res.last_page,
                            total: res.total
                        };
                        this.selected = [];
                        this.allSelected = false;
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
                        status: '',
                        page: 1
                    };
                    this.fetchData();
                },

                toggleAll(e) {
                    this.allSelected = e.target.checked;
                    this.selected = this.allSelected ? this.qrCodes.map(q => q.id) : [];
                },

                async deleteSingle(id) {
                    if (!confirm('Kya aap ye QR code delete karna chahte hain?')) return;
                    try {
                        const response = await fetch(`/admin/qr-codes/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (response.ok) this.fetchData();
                    } catch (e) {
                        alert('Delete failed');
                    }
                },

                async bulkDelete() {
                    if (!confirm(`${this.selected.length} QR codes delete karna chahte hain?`)) return;
                    try {
                        const response = await fetch("{{ route('admin.qr-codes.bulk-destroy') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                qr_code_ids: this.selected
                            })
                        });
                        if (response.ok) this.fetchData();
                    } catch (e) {
                        alert('Bulk delete failed');
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

        .checkbox-custom {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 2px solid var(--border);
            cursor: pointer;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection
