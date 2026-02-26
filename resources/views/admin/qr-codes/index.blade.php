@extends('layout.app')

@section('content')
    <div class="main-area" x-data="qrApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="topbar-left">
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">QR
                            Inventory</h1>
                        <p class="page-subtitle"
                            style="margin: 2px 0 0 0; color: var(--text3); font-size: 11px; font-weight: 700; text-transform: uppercase;">
                            Manage Tracking Assets</p>
                    </div>
                </div>

                <div class="topbar-right">
                    <a href="{{ route('admin.qr-codes.create') }}"
                        style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; box-shadow: var(--shadow-sm); transition: transform 0.2s;"
                        onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        + Generate Batch
                    </a>
                </div>
            </div>

            <div class="anim delay-1">
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

                    <div style="display: flex; gap: 10px; flex-wrap: wrap; flex: 1; min-width: 200px;">
                        <select x-model="filters.category_id" @change="filters.page = 1; fetchData()"
                            style="flex: 1; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text2);">
                            <option value="">Categories</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <select x-model="filters.status" @change="filters.page = 1; fetchData()"
                            style="flex: 1; height: 42px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text2);">
                            <option value="">Status</option>
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

                <div style="margin-bottom: 15px;">
                    @include('admin.qr-codes.partials._table')
                </div>
            </div>

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

            <div style="height: 30px;"></div>
        </div>
    </div>

    <script>
        function qrApp() {
            return {
                qrCodes: [],
                loading: false,
                selected: [],
                allSelected: false,
                filters: {
                    search: '',
                    category_id: '',
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
                    let params = new URLSearchParams(this.filters).toString();
                    try {
                        const response = await fetch(`{{ route('admin.qr-codes.index') }}?${params}`, {
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
                        console.error("Fetch error");
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
                    if (!confirm("Are you sure you want to delete this QR?")) return;
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
                        alert("Delete failed");
                    }
                },

                async bulkDelete() {
                    if (!confirm(`Delete ${this.selected.length} QR codes?`)) return;
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
                        alert("Bulk delete failed");
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
@endsection
