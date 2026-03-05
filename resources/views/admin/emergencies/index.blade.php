@extends('layout.app')

@section('content')
    <div class="main-area" x-data="emergencyApp()" x-init="fetchData()">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto; overflow-x: hidden;">

            {{-- Header Card --}}
            <div class="header-card"
                style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h1 class="title"
                        style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                        Everyday Emergencies</h1>
                    <p
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        Content Management with Text Editor</p>
                </div>
                <button @click="openAddModal()"
                    style="background: var(--text); color: var(--bg); padding: 10px 20px; border-radius: 12px; font-size: 11px; font-weight: 900; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 1px;">
                    + Add Content
                </button>
            </div>

            {{-- Success Alert --}}
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
                        placeholder="Search content..."
                        style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px 12px 10px 35px; outline: none; font-size: 13px;">
                </div>
            </div>

            {{-- Table File Include --}}
            @include('admin.emergencies.partials._table')

        </div>

        {{-- CKEditor Modal --}}
        <template x-if="showModal">
            <div
                style="position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; display:flex; align-items:center; justify-content:center; padding:20px; backdrop-filter: blur(4px);">
                <div class="card"
                    style="width:100%; max-width:650px; background:var(--bg); border:1px solid var(--border); padding:25px; border-radius:20px; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
                    <h2 style="color:var(--text); font-size:18px; font-weight:900; margin-bottom:20px; text-transform: uppercase;"
                        x-text="isEdit ? 'Update Emergency Info' : 'Create Emergency Info'"></h2>

                    <form :action="isEdit ? `/admin/emergencies/${formData.id}` : '{{ route('admin.emergencies.store') }}'"
                        method="POST" id="emergencyForm">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PATCH">
                        </template>

                        <div style="display:grid; gap:15px;">
                            <div>
                                <label
                                    style="font-size:10px; font-weight:800; color:var(--text3); text-transform:uppercase; margin-bottom:5px; display:block;">Main
                                    Heading</label>
                                <input type="text" name="title" x-model="formData.title" required
                                    style="width:100%; padding:12px; border-radius:10px; background:var(--card2); border:1px solid var(--border); color:var(--text); outline:none; font-size: 13px;">
                            </div>

                            {{-- Text Editor Container --}}
                            <div class="editor-container">
                                <label
                                    style="font-size:10px; font-weight:800; color:var(--text3); margin-bottom:5px; display:block; text-transform: uppercase;">Points
                                    (Lists & Description)</label>
                                <textarea name="description" id="emergencyEditor" x-model="formData.description"></textarea>
                            </div>

                            <div style="display:flex; gap:10px; margin-top:10px;">
                                <button type="submit" @click="saveEditorData()"
                                    style="flex:2; background:var(--text); color:var(--bg); padding:15px; border-radius:15px; font-weight:900; border:none; cursor:pointer; text-transform:uppercase; font-size:11px; letter-spacing: 1px;">
                                    Save Content
                                </button>
                                <button type="button" @click="closeModal()"
                                    style="flex:1; background:var(--card2); color:var(--text); border:1px solid var(--border); border-radius:15px; font-weight:900; cursor:pointer; font-size:11px; text-transform: uppercase;">
                                    Close
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    {{-- CKEditor Scripts --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        /* CKEditor Custom Styling for Dark Mode compatibility */
        .ck-editor__editable {
            min-height: 250px;
            background: var(--bg) !important;
            color: var(--text) !important;
            border-radius: 0 0 10px 10px !important;
            font-size: 14px;
        }

        .ck-toolbar {
            background: var(--card2) !important;
            border: 1px solid var(--border) !important;
            border-radius: 10px 10px 0 0 !important;
        }

        .ck.ck-editor__main>.ck-editor__editable:focus {
            border-color: var(--brand-purple) !important;
            box-shadow: none !important;
        }
    </style>

    <script>
        let editorInstance;

        function emergencyApp() {
            return {
                items: [],
                loading: false,
                search: '',
                showModal: false,
                isEdit: false,
                formData: {
                    id: '',
                    title: '',
                    description: ''
                },

                async fetchData() {
                    this.loading = true;
                    try {
                        const res = await fetch(`{{ route('admin.emergencies.index') }}?search=${this.search}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        const data = await res.json();
                        this.items = data.data;
                    } catch (e) {
                        console.error("Load failed");
                    }
                    this.loading = false;
                },

                openAddModal() {
                    this.isEdit = false;
                    this.formData = {
                        id: '',
                        title: '',
                        description: ''
                    };
                    this.showModal = true;
                    // NextTick ensures the DOM element for editor is ready
                    this.$nextTick(() => {
                        this.initEditor('');
                    });
                },

                editItem(item) {
                    this.isEdit = true;
                    this.formData = {
                        id: item.id,
                        title: item.title,
                        description: item.description
                    };
                    this.showModal = true;
                    this.$nextTick(() => {
                        this.initEditor(item.description);
                    });
                },

                initEditor(content) {
                    if (editorInstance) {
                        editorInstance.destroy();
                    }
                    ClassicEditor
                        .create(document.querySelector('#emergencyEditor'), {
                            toolbar: {
                                items: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList',
                                    'blockQuote'
                                ],
                                shouldNotGroupWhenFull: true
                            }
                        })
                        .then(editor => {
                            editorInstance = editor;
                            editor.setData(content || '');
                        })
                        .catch(error => console.error(error));
                },

                saveEditorData() {
                    if (editorInstance) {
                        // Sync CKEditor data to textarea for form submission
                        document.querySelector('#emergencyEditor').value = editorInstance.getData();
                    }
                },

                closeModal() {
                    this.showModal = false;
                    if (editorInstance) {
                        editorInstance.destroy().then(() => {
                            editorInstance = null;
                        });
                    }
                },

                async deleteItem(id) {
                    if (!confirm('Delete this content permanently?')) return;
                    this.loading = true;
                    await fetch(`/admin/emergencies/${id}`, {
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
