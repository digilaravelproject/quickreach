@extends('layout.app')

@section('content')
    <div class="main-area">
        {{-- Mobile Responsive Scroll Wrapper --}}
        <div class="page-scroll custom-scroll"
            style="background: var(--bg); padding: 15px !important; height: 100vh; overflow-y: auto; overflow-x: hidden;">

            <div class="header-card"
                style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h1 class="title"
                        style="margin: 0; font-size: 20px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">
                        Manage About Page</h1>
                    <p
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 9px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                        Content Management with Editor</p>
                </div>
            </div>

            @if (session('success'))
                <div
                    style="background: #22c55e; color: white; padding: 10px; border-radius: 10px; margin-bottom: 20px; font-size: 11px; font-weight: 800;">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Container for sections with proper bottom padding for fixed button --}}
                <div style="display: flex; flex-direction: column; gap: 20px; padding-bottom: 150px;">

                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span
                                style="font-size: 11px; font-weight: 900; color: var(--brand-purple); text-transform: uppercase;">Section
                                1: Hero Header</span>
                        </div>
                        <div style="display: grid; gap: 12px;">
                            <input type="text" name="main_title" value="{{ $about->main_title }}"
                                placeholder="Main Title"
                                style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">

                            <div class="editor-container">
                                <label
                                    style="font-size: 9px; font-weight: 800; color: var(--text3); margin-bottom: 4px; display: block; text-transform: uppercase;">Main
                                    Description</label>
                                <textarea name="main_description" id="editor1">{{ $about->main_description }}</textarea>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; gap: 10px; background: var(--bg); padding: 10px; border-radius: 10px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset('storage/' . $about->main_image) }}"
                                        style="width: 50px; height: 35px; border-radius: 6px; object-fit: cover; background: var(--card2);">
                                    <span style="font-size: 10px; color: var(--text3);">Header Image</span>
                                </div>
                                <input type="file" name="main_image"
                                    style="font-size: 10px; color: var(--text3); width: 100%;">
                            </div>
                        </div>
                    </div>

                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span
                                style="font-size: 11px; font-weight: 900; color: #22c55e; text-transform: uppercase;">Section
                                2: Our Mission</span>
                        </div>
                        <div style="display: grid; gap: 12px;">
                            <input type="text" name="mission_title" value="{{ $about->mission_title }}"
                                placeholder="Mission Title"
                                style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">

                            <div class="editor-container">
                                <textarea name="mission_description" id="editor2">{{ $about->mission_description }}</textarea>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; gap: 10px; background: var(--bg); padding: 10px; border-radius: 10px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset('storage/' . $about->mission_image) }}"
                                        style="width: 50px; height: 35px; border-radius: 6px; object-fit: cover; background: var(--card2);">
                                    <span style="font-size: 10px; color: var(--text3);">Mission Image</span>
                                </div>
                                <input type="file" name="mission_image"
                                    style="font-size: 10px; color: var(--text3); width: 100%;">
                            </div>
                        </div>
                    </div>

                    <div class="card"
                        style="background: var(--card2); border-radius: 15px; border: 1px solid var(--border); padding: 15px;">
                        <div style="margin-bottom: 12px; border-bottom: 1px solid var(--border); padding-bottom: 8px;">
                            <span
                                style="font-size: 11px; font-weight: 900; color: #ef4444; text-transform: uppercase;">Section
                                3: Our Story</span>
                        </div>
                        <div style="display: grid; gap: 12px;">
                            <input type="text" name="story_title" value="{{ $about->story_title }}"
                                placeholder="Story Title"
                                style="width: 100%; background: var(--bg); border: 1px solid var(--border); color: var(--text); border-radius: 10px; padding: 10px; outline: none; font-size: 13px;">

                            <div class="editor-container">
                                <textarea name="story_description" id="editor3">{{ $about->story_description }}</textarea>
                            </div>

                            <div
                                style="display: flex; flex-direction: column; gap: 10px; background: var(--bg); padding: 10px; border-radius: 10px; border: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset('storage/' . $about->story_image) }}"
                                        style="width: 50px; height: 35px; border-radius: 6px; object-fit: cover; background: var(--card2);">
                                    <span style="font-size: 10px; color: var(--text3);">Story Image</span>
                                </div>
                                <input type="file" name="story_image"
                                    style="font-size: 10px; color: var(--text3); width: 100%;">
                            </div>
                        </div>
                    </div>

                    {{-- Action Button - Responsive Placement --}}
                    <div class="mobile-button-wrapper"
                        style="position: fixed; bottom: 20px; left: 0; right: 0; padding: 0 15px; z-index: 1000; pointer-events: none;">
                        <button type="submit"
                            style="pointer-events: auto; width: 100%; max-width: 400px; margin: 0 auto; background: var(--text); color: var(--bg); padding: 16px; border-radius: 15px; font-weight: 900; border: none; cursor: pointer; text-transform: uppercase; box-shadow: 0 10px 25px rgba(0,0,0,0.4); display: block; font-size: 12px; letter-spacing: 1px;">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CKEditor Scripts with Mobile Fix --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <style>
        /* CKEditor Mobile Styling */
        .ck-editor__editable {
            min-height: 120px;
            max-height: 300px;
            background: var(--bg) !important;
            color: var(--text) !important;
            border-radius: 0 0 10px 10px !important;
            font-size: 14px;
        }

        .ck-toolbar {
            background: var(--card2) !important;
            border-radius: 10px 10px 0 0 !important;
            border: 1px solid var(--border) !important;
            flex-wrap: wrap !important;
            /* Mobile toolbar wrap fix */
        }

        .ck.ck-editor__main>.ck-editor__editable:focus {
            border-color: var(--brand-purple) !important;
            box-shadow: none !important;
        }

        /* Hide Scrollbar for cleaner look */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }
    </style>

    <script>
        const editors = ['#editor1', '#editor2', '#editor3'];
        editors.forEach(id => {
            ClassicEditor
                .create(document.querySelector(id), {
                    // Optimized toolbar for mobile
                    toolbar: {
                        items: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                        shouldNotGroupWhenFull: true
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection
