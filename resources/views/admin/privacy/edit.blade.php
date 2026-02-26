@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto; overflow-x: hidden;">

            <div class="header-card" style="margin-bottom: 20px;">
                <h1 class="title"
                    style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                    Manage Privacy Policy</h1>
                <p
                    style="margin: 2px 0 0 0; color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase;">
                    Legal Content Management</p>
            </div>

            @if (session('success'))
                <div
                    style="background: #22c55e; color: white; padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 11px; font-weight: 800;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.privacy.update') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: column; gap: 20px; padding-bottom: 150px;">

                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="display: grid; gap: 12px;">
                            <label
                                style="font-size: 9px; font-weight: 800; color: var(--text3); text-transform: uppercase;">Policy
                                Title & Date</label>

                            <input type="text" name="title" value="{{ $policy->title }}" placeholder="Policy Title"
                                style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">

                            <input type="date" name="effective_date" value="{{ $policy->effective_date }}"
                                style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">
                        </div>
                    </div>

                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <label
                            style="font-size: 9px; font-weight: 800; color: var(--brand-purple); text-transform: uppercase; margin-bottom: 10px; display: block;">Policy
                            Content</label>
                        <div class="editor-container">
                            <textarea name="content" id="policy_editor">{{ $policy->content }}</textarea>
                        </div>
                    </div>

                    <div class="mobile-button-wrapper"
                        style="position: fixed; bottom: 20px; left: 0; right: 0; padding: 0 15px; z-index: 1000; pointer-events: none;">
                        <button type="submit"
                            style="pointer-events: auto; width: 100%; max-width: 400px; margin: 0 auto; background: var(--text); color: var(--bg); padding: 16px; border-radius: 15px; font-weight: 900; border: none; cursor: pointer; text-transform: uppercase; box-shadow: 0 10px 25px rgba(0,0,0,0.4); display: block; font-size: 12px;">
                            Save Privacy Policy
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable {
            min-height: 400px;
            background: var(--bg) !important;
            color: var(--text) !important;
            border-radius: 0 0 10px 10px !important;
        }

        .ck-toolbar {
            background: var(--card2) !important;
            border: 1px solid var(--border) !important;
        }
    </style>

    <script>
        ClassicEditor
            .create(document.querySelector('#policy_editor'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote',
                    'undo', 'redo'
                ]
            })
            .catch(error => console.error(error));
    </script>
@endsection
