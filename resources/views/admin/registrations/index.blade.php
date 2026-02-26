@extends('layout.app')

@section('content')
    <div class="main-area" x-data="regApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 20px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div class="topbar-left">
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">
                            User Directory</h1>
                        <p class="page-subtitle" style="margin: 2px 0 0 0; color: var(--text2); font-size: 11px;">Managing
                            All Registered Smart Tags</p>
                    </div>
                </div>

                <div class="header-actions">
                    <div class="search-wrap" style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                            <circle cx="11" cy="11" r="8" stroke-width="2" />
                            <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                        </svg>
                        <input type="text" x-model="search" @input.debounce.500ms="fetchData()"
                            placeholder="Search name, phone, QR..."
                            style="width: 250px; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 8px 12px 8px 35px; outline: none; font-size: 13px;">
                    </div>
                </div>
            </div>

            <div class="anim delay-1">
                <div style="margin-bottom: 15px;">
                    @include('admin.registrations.partials._table')
                </div>

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
        function regApp() {
            return {
                registrations: [],
                loading: false,
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
                    try {
                        const res = await fetch(
                            `{{ route('admin.registrations.index') }}?search=${this.search}&page=${this.pagination.current_page}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            }).then(r => r.json());
                        this.registrations = res.data;
                        this.pagination.current_page = res.current_page;
                        this.pagination.last_page = res.last_page;
                    } catch (e) {
                        console.error(e);
                    }
                    this.loading = false;
                },
                changePage(p) {
                    if (p < 1 || p > this.pagination.last_page) return;
                    this.pagination.current_page = p;
                    this.fetchData();
                    document.querySelector('.page-scroll').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },
                async deleteReg(id) {
                    if (!confirm('Are you sure you want to delete this user registration?')) return;
                    await fetch(`/admin/registrations/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    this.fetchData();
                },
                formatDate(date) {
                    if (!date) return '-';
                    return new Date(date).toLocaleDateString('en-GB', {
                        day: '2-digit',
                        month: 'short'
                    });
                }
            }
        }
    </script>
@endsection
