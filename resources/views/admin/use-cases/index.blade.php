@extends('layout.app')

@section('content')
    <div class="main-area" x-data="useCaseApp()" x-init="fetchData()">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto; overflow-x: hidden;">

            {{-- Header Section --}}
            <div class="header-card"
                style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h1 class="title"
                        style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                        Manage Use Cases</h1>
                    <p
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        Control where QR tags are used</p>
                </div>
                <button @click="openAddModal()"
                    style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; border: none; cursor: pointer; text-transform: uppercase;">
                    + Add New
                </button>
            </div>

            {{-- Success Alert (From Session) --}}
            @if (session('success'))
                <div
                    style="background: #22c55e; color: white; padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 11px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
                    <svg style="width:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search Filter --}}
            <div class="card"
                style="margin-bottom: 15px; padding: 12px; border: 1px solid var(--border); background: var(--card2); border-radius: 15px;">
                <div style="position: relative;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="width: 14px; position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text3);">
                        <circle cx="11" cy="11" r="8" stroke-width="2" />
                        <path d="m21 21-4.35-4.35" stroke-linecap="round" stroke-width="2" />
                    </svg>
                    <input type="text" x-model="search" @input.debounce.500ms="fetchData()"
                        placeholder="Search use cases..."
                        style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 12px 10px 35px; outline: none; font-size: 13px;">
                </div>
            </div>

            {{-- Table Include --}}
            @include('admin.use-cases.partials._table')

        </div>

        {{-- Universal Modal (Add/Edit) --}}
        <template x-if="showModal">
            <div
                style="position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter: blur(4px);">
                <div class="card"
                    style="width:100%; max-width:450px; background:var(--bg); border:1px solid var(--border); padding:25px; border-radius:20px; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
                    <h2 style="color:var(--text); font-size:18px; font-weight:900; margin-bottom:20px; text-transform: uppercase;"
                        x-text="isEdit ? 'Edit Use Case' : 'Add Use Case'"></h2>

                    <form :action="isEdit ? `/admin/use-cases/${formData.id}` : '{{ route('admin.use-cases.store') }}'"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>

                        <div style="display:grid; gap:15px;">
                            <div>
                                <label
                                    style="font-size:10px; font-weight:800; color:var(--text3); text-transform:uppercase; margin-bottom:5px; display:block;">Title</label>
                                <input type="text" name="title" x-model="formData.title" required
                                    style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text); outline:none;">
                            </div>

                            <div>
                                <label
                                    style="font-size:10px; font-weight:800; color:var(--text3); text-transform:uppercase; margin-bottom:5px; display:block;">Description</label>
                                <textarea name="description" x-model="formData.description" required
                                    style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text); min-height:100px; outline:none; resize:none;"></textarea>
                            </div>

                            {{-- Image with Old & New Preview --}}
                            <div>
                                <label
                                    style="font-size:10px; font-weight:800; color:var(--text3); text-transform:uppercase; margin-bottom:5px; display:block;">Icon
                                    Preview</label>
                                <div
                                    style="display:flex; align-items:center; gap:12px; background:var(--card2); padding:12px; border-radius:12px; border:1px solid var(--border);">
                                    <div
                                        style="width:50px; height:50px; border-radius:10px; background:var(--bg); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; overflow:hidden;">
                                        <template x-if="formData.icon_url">
                                            <img :src="formData.icon_url"
                                                style="width:100%; height:100%; object-fit:cover;">
                                        </template>
                                        <template x-if="!formData.icon_url">
                                            <svg style="width:20px; color:var(--text3);" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    stroke-width="2"></path>
                                            </svg>
                                        </template>
                                    </div>
                                    <div style="flex:1;">
                                        <input type="file" name="icon_image"
                                            @change="formData.icon_url = URL.createObjectURL($event.target.files[0])"
                                            style="font-size:11px; color:var(--text3); width:100%;">
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex; gap:10px; margin-top:10px;">
                                <button type="submit"
                                    style="flex:2; background:var(--text); color:var(--bg); padding:15px; border-radius:15px; font-weight:900; border:none; cursor:pointer; text-transform:uppercase;">Save
                                    Changes</button>
                                <button type="button" @click="showModal = false"
                                    style="flex:1; background:var(--card2); color:var(--text); border:1px solid var(--border); border-radius:15px; font-weight:900; cursor:pointer;">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <script>
        function useCaseApp() {
            return {
                items: [],
                loading: false,
                search: '',
                showModal: false,
                isEdit: false,
                formData: {
                    id: '',
                    title: '',
                    description: '',
                    icon_url: ''
                },

                async fetchData() {
                    this.loading = true;
                    try {
                        const res = await fetch(`{{ route('admin.use-cases.index') }}?search=${this.search}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        this.items = data.data;
                    } catch (e) {
                        console.error("Error fetching data");
                    }
                    this.loading = false;
                },

                openAddModal() {
                    this.isEdit = false;
                    this.formData = {
                        id: '',
                        title: '',
                        description: '',
                        icon_url: ''
                    };
                    this.showModal = true;
                },

                editItem(item) {
                    this.isEdit = true;
                    this.formData = {
                        id: item.id,
                        title: item.title,
                        description: item.description,
                        icon_url: item.icon_image ? `/storage/${item.icon_image}` : ''
                    };
                    this.showModal = true;
                },

                async deleteItem(id) {
                    if (!confirm('Are you sure you want to delete this?')) return;
                    this.loading = true;
                    await fetch(`/admin/use-cases/${id}`, {
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
