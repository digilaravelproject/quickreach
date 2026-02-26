@extends('layout.app')

@section('content')
    <div class="main-area custom-scroll" style="padding: 25px; height: 100vh; overflow-y: auto;" x-data="notificationHandler()">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="font-size: 22px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                    Announcements</h1>
                <p style="font-size: 12px; color: var(--text3); margin-top: 4px;">Broadcast messages to all QwickReach users.
                </p>
            </div>
            <button @click="openModal = true"
                style="background: var(--text); color: var(--bg); padding: 12px 24px; border-radius: 14px; font-weight: 900; border: none; cursor: pointer; display: flex; align-items: center; gap: 10px; shadow: 0 10px 15px -3px rgba(0,0,0,0.1);">
                <span style="font-size: 18px;">+</span> NEW BROADCAST
            </button>
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 25px;">
            <div style="flex: 2; position: relative;">
                <input type="text" x-model="filters.search" @input.debounce.500ms="fetchNotifications()"
                    placeholder="Search by title..."
                    style="width: 100%; background: var(--card2); border: 1px solid var(--border); padding: 14px 14px 14px 40px; border-radius: 14px; color: var(--text); outline: none;">
                <span style="position: absolute; left: 15px; top: 15px; opacity: 0.5;">🔍</span>
            </div>
            <select x-model="filters.status" @change="fetchNotifications()"
                style="flex: 1; background: var(--card2); border: 1px solid var(--border); padding: 14px; border-radius: 14px; color: var(--text); outline: none; cursor: pointer;">
                <option value="all">All Status</option>
                <option value="active">Live Only</option>
                <option value="inactive">Expired Only</option>
            </select>
        </div>

        @include('admin.announcements.partials._table')

        @include('admin.announcements.partials._modal')

    </div>

    <script>
        function notificationHandler() {
            return {
                openModal: false,
                loading: false,
                announcements: [],
                pagination: {
                    current_page: 1,
                    last_page: 1,
                    prev_page_url: null,
                    next_page_url: null
                },
                filters: {
                    search: '',
                    status: 'all'
                },
                formData: {
                    title: '',
                    message: ''
                },

                init() {
                    this.fetchNotifications();
                },

                async fetchNotifications(url = "{{ route('admin.announcements.index') }}") {
                    const fetchUrl = new URL(url);
                    // Append filters only if it's the base index route
                    if (!url.includes('page=')) {
                        fetchUrl.searchParams.append('search', this.filters.search);
                        fetchUrl.searchParams.append('status', this.filters.status);
                    }

                    const res = await fetch(fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const result = await res.json();
                    this.announcements = result.data;
                    this.pagination = result.pagination;
                },

                async changePage(url) {
                    if (url) await this.fetchNotifications(url);
                },

                async saveNotification() {
                    if (!this.formData.title || !this.formData.message) return alert('Please fill all fields');
                    this.loading = true;
                    const res = await fetch("{{ route('admin.announcements.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.formData)
                    });
                    if (res.ok) {
                        this.formData = {
                            title: '',
                            message: ''
                        };
                        this.openModal = false;
                        await this.fetchNotifications();
                    }
                    this.loading = false;
                },

                async toggleStatus(id) {
                    const res = await fetch(`/admin/announcements/toggle/${id}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (res.ok) await this.fetchNotifications();
                },

                async deleteNotification(id) {
                    if (!confirm('Are you sure you want to delete this?')) return;
                    const res = await fetch(`/admin/announcements/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
                    if (res.ok) await this.fetchNotifications();
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
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection
