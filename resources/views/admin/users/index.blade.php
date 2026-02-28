@extends('layout.app')

@section('content')
    <div class="main-area" x-data="userApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            {{-- Header Card --}}
            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="topbar-left">
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">
                            User Directory</h1>
                        <p class="page-subtitle" style="margin: 2px 0 0 0; color: var(--text2); font-size: 11px;">Managing
                            All Registered Users</p>
                    </div>
                </div>

                <div class="header-actions" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">

                    {{-- Search --}}
                    <div class="search-wrap" style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <input type="text" x-model="search" @input.debounce.500ms="fetchData()"
                            placeholder="Search name, email, phone..."
                            style="width: 250px; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 8px 12px 8px 35px; outline: none; font-size: 13px;">
                    </div>

                    {{-- Export Button --}}
                    <button @click="exportCSV()" :disabled="exporting"
                        style="display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; background: var(--text); color: var(--bg); border: none; border-radius: 10px; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.2s; white-space: nowrap;"
                        :style="exporting ? 'opacity: 0.5; cursor: not-allowed;' : ''">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                        </svg>
                        <span
                            x-text="exporting ? 'Exporting...' : (selectedUsers.length > 0 ? 'Export Selected (' + selectedUsers.length + ')' : 'Export All CSV')"></span>
                    </button>

                </div>
            </div>

            {{-- Table Content --}}
            <div class="anim delay-1">
                <div style="margin-bottom: 15px;">
                    @include('admin.users.partials._table')
                </div>

                {{-- Pagination --}}
                <div class="anim delay-2" x-show="pagination.last_page > 1"
                    style="padding: 15px 20px; background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; align-items: center; justify-content: space-between;">

                    <span class="stat-period"
                        style="font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase;">
                        Page <strong style="color: var(--text);" x-text="pagination.current_page"></strong> of <span
                            x-text="pagination.last_page"></span>
                    </span>

                    <div style="display: flex; gap: 8px;">
                        <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                            class="btn-outline"
                            style="padding: 6px 14px; font-size: 11px; font-weight: 700; cursor: pointer; border-radius: 8px;"
                            :style="pagination.current_page === 1 ? 'opacity: 0.3;' : ''">
                            Previous
                        </button>
                        <button @click="changePage(pagination.current_page + 1)"
                            :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                            style="padding: 6px 14px; font-size: 11px; font-weight: 700; cursor: pointer; border-radius: 8px;"
                            :style="pagination.current_page === pagination.last_page ? 'opacity: 0.3;' : ''">
                            Next
                        </button>
                    </div>
                </div>
            </div>

            <div style="height: 30px;"></div>
        </div>
    </div>

    <script>
        function userApp() {
            return {
                users: [],
                selectedUsers: [],
                selectAll: false,
                loading: false,
                exporting: false,
                search: '',
                pagination: {
                    current_page: 1,
                    last_page: 1
                },
                init() {
                    this.fetchData();
                },
                async fetchData() {
                    this.loading = true;
                    this.selectAll = false;
                    this.selectedUsers = [];
                    try {
                        const res = await fetch(
                            `{{ route('admin.users.index') }}?search=${this.search}&page=${this.pagination.current_page}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }).then(r => r.json());
                        this.users = res.data;
                        this.pagination.current_page = res.current_page;
                        this.pagination.last_page = res.last_page;
                    } catch (e) {
                        console.error(e);
                    }
                    this.loading = false;
                },
                toggleSelectAll() {
                    if (this.selectAll) {
                        this.selectedUsers = this.users.map(u => u.id);
                    } else {
                        this.selectedUsers = [];
                    }
                },
                changePage(p) {
                    if (p < 1 || p > this.pagination.last_page) return;
                    this.pagination.current_page = p;
                    this.fetchData();
                },
                async toggleUserStatus(user) {
                    try {
                        const res = await fetch(`/users/${user.id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        }).then(r => r.json());

                        if (res.success) {
                            user.is_active = res.is_active;
                        }
                    } catch (e) {
                        console.error("Error toggling status:", e);
                    }
                },
                exportCSV() {
                    this.exporting = true;
                    let url = `{{ route('admin.users.export') }}?search=${encodeURIComponent(this.search)}`;

                    // Add selected IDs to URL if any checkboxes are checked
                    if (this.selectedUsers.length > 0) {
                        url += `&ids=${this.selectedUsers.join(',')}`;
                    }

                    const a = document.createElement('a');
                    a.href = url;
                    a.download = '';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    setTimeout(() => {
                        this.exporting = false;
                        this.selectedUsers = [];
                        this.selectAll = false;
                    }, 2000);
                },
                formatDate(date) {
                    if (!date) return '-';
                    return new Date(date).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short',
                        year: 'numeric'
                    });
                }
            }
        }
    </script>
@endsection
