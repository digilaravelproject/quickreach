@extends('layout.app')

@section('content')
    <div class="main-area" x-data="howItWorksApp()" x-init="fetchData()">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto;">

            {{-- Header --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h1 style="color: var(--text); font-size: 20px; font-weight: 800; font-family: 'Syne'; margin:0;">How It
                        Works</h1>
                    <p style="color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase;">Manage
                        Step-by-Step Process</p>
                </div>
                <button @click="openAddModal()"
                    style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; border: none; cursor: pointer;">+
                    ADD STEP</button>
            </div>

            {{-- Filter --}}
            <div class="card"
                style="margin-bottom: 15px; padding: 12px; border: 1px solid var(--border); background: var(--card2); border-radius: 15px;">
                <input type="text" x-model="search" @input.debounce.500ms="fetchData()" placeholder="Search steps..."
                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 15px; outline: none; font-size: 13px;">
            </div>

            @include('admin.how-it-works.partials._table')
        </div>

        @include('admin.how-it-works.partials._modal')
    </div>

    <script>
        function howItWorksApp() {
            return {
                items: [],
                loading: false,
                search: '',
                showModal: false,
                isEdit: false,
                formData: {
                    id: '',
                    step_order: '',
                    title: '',
                    description: '',
                    image_url: ''
                },

                async fetchData() {
                    this.loading = true;
                    try {
                        const res = await fetch(`{{ route('admin.how-it-works.index') }}?search=${this.search}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        this.items = data.data;
                    } catch (e) {
                        console.error(e);
                    }
                    this.loading = false;
                },

                openAddModal() {
                    this.isEdit = false;
                    this.formData = {
                        id: '',
                        step_order: this.items.length + 1,
                        title: '',
                        description: '',
                        image_url: ''
                    };
                    this.showModal = true;
                },

                editItem(item) {
                    this.isEdit = true;
                    this.formData = {
                        id: item.id,
                        step_order: item.step_order,
                        title: item.title,
                        description: item.description,
                        image_url: item.image_path ? `/storage/${item.image_path}` : ''
                    };
                    this.showModal = true;
                },

                async deleteItem(id) {
                    if (!confirm('Delete this step?')) return;
                    this.loading = true;
                    await fetch(`/admin/how-it-works/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    this.fetchData();
                }
            }
        }
    </script>
@endsection
