@extends('layout.app')

@section('content')
    <div class="main-area" x-data="categoryApp()" x-init="init()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 25px; display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text); letter-spacing: -0.5px;">QR
                        Categories</h1>
                    <p class="page-subtitle"
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 11px; font-weight: 700; text-transform: uppercase;">
                        Manage pricing, icons and inventory</p>
                </div>

                <div class="topbar-right">
                    <a href="{{ route('admin.categories.create') }}"
                        style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; box-shadow: var(--shadow-sm); display: inline-flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px; line-height: 1;">+</span> Add New Category
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
                            placeholder="Search by name or slug..."
                            style="width: 100%; background: var(--card2); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 12px 10px 35px; outline: none; font-size: 13px;">
                    </div>

                    <div style="display: flex; gap: 10px; align-items: center;">
                        <select x-model="filters.status" @change="filters.page = 1; fetchData()"
                            style="height: 42px; min-width: 150px; border-radius: 10px; border: 1px solid var(--border); background: var(--card2); padding: 0 10px; font-weight: 700; font-size: 12px; color: var(--text2); outline: none;">
                            <option value="">All Status</option>
                            <option value="active">Active Only</option>
                            <option value="inactive">Inactive Only</option>
                        </select>

                        <button @click="resetFilters()"
                            style="background: transparent; border: none; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; cursor: pointer; padding: 0 10px; letter-spacing: 1px;">
                            Reset
                        </button>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    @include('admin.categories.partials._table')
                </div>

                <div x-show="pagination.last_page > 1"
                    style="padding: 15px 20px; background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); display: flex; align-items: center; justify-content: space-between;">

                    <span style="font-size: 11px; font-weight: 700; color: var(--text3); text-transform: uppercase;">
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
        function categoryApp() {
            return {
                categories: [],
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

                resetFilters() {
                    this.filters = {
                        search: '',
                        status: '',
                        page: 1
                    };
                    this.fetchData();
                },

                async fetchData() {
                    this.loading = true;
                    let params = new URLSearchParams(this.filters);
                    try {
                        const response = await fetch(`{{ route('admin.categories.index') }}?${params.toString()}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        if (!response.ok) throw new Error('Failed to fetch');
                        const result = await response.json();
                        this.categories = result.data || [];
                        this.pagination.current_page = result.current_page;
                        this.pagination.last_page = result.last_page;
                    } catch (error) {
                        console.error("Fetch Error:", error);
                    } finally {
                        this.loading = false;
                    }
                },

                async toggleStatus(category) {
                    try {
                        const response = await fetch(`/admin/categories/${category.id}/toggle-status`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        if (response.ok) {
                            category.is_active = !category.is_active;
                        }
                    } catch (error) {
                        alert("Status change failed!");
                    }
                },

                async deleteCategory(category) {
                    if (!confirm(`Are you sure you want to delete ${category.name}?`)) return;
                    try {
                        const response = await fetch(`/admin/categories/${category.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });
                        const result = await response.json();
                        if (response.ok) {
                            this.fetchData();
                        } else {
                            alert(result.error || "Delete failed!");
                        }
                    } catch (error) {
                        alert("Server error!");
                    }
                },

                changePage(p) {
                    if (p < 1 || p > this.pagination.last_page) return;
                    this.filters.page = p;
                    this.fetchData();
                    document.querySelector('.page-scroll').scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            }
        }
    </script>
@endsection
