@extends('layout.app')

@section('content')
    <div class="main-area" x-data="imagePreview('{{ $category->icon ? asset($category->icon) : '' }}')">
        <div class="page-scroll" style="background: var(--bg); padding: 10px 10px 40px 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.categories.index') }}" class="btn-outline"
                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px; text-decoration: none; color: var(--text);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Edit Category</h1>
                        <p
                            style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-top: 2px;">
                            Updating: {{ $category->name }}</p>
                    </div>
                </div>
                <div class="live-badge"
                    style="font-size: 10px; padding: 4px 12px; background: var(--amber-bg); color: var(--amber); border: 1px solid var(--amber);">
                    EDIT MODE</div>
            </div>

            <div class="max-w-3xl mx-auto anim delay-1">

                @if ($errors->any())
                    <div
                        style="margin-bottom: 15px; padding: 12px; background: var(--red-bg); border-radius: 12px; border: 1px solid rgba(239, 68, 68, 0.2);">
                        <ul style="margin: 0; padding-left: 15px; color: var(--red); font-size: 11px; font-weight: 700;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card"
                        style="padding: 0; overflow: hidden; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm);">

                        <div style="background: var(--card2); padding: 15px 25px; border-bottom: 1px solid var(--border);">
                            <h2
                                style="font-size: 12px; font-weight: 800; margin: 0; text-transform: uppercase; color: var(--text3); letter-spacing: 1px;">
                                Update Details</h2>
                        </div>

                        <div style="padding: 25px; display: flex; flex-direction: column; gap: 25px;">

                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label
                                        style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">Category
                                        Name *</label>
                                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                                        style="width: 100%; height: 48px; padding: 0 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 700; color: var(--text); outline: none;">
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label
                                        style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">Price
                                        (INR) *</label>
                                    <div style="position: relative;">
                                        <span
                                            style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--blue);">₹</span>
                                        <input type="number" name="price" step="0.01"
                                            value="{{ old('price', $category->price) }}" required
                                            style="width: 100%; height: 48px; padding: 0 15px 0 35px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 800; color: var(--text); outline: none;">
                                    </div>
                                </div>
                            </div>

                            <div
                                style="padding: 20px; background: var(--card2); border-radius: 15px; border: 1px dashed var(--border);">
                                <label
                                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px;">Category
                                    Branding</label>
                                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                    <div
                                        style="width: 85px; height: 85px; background: var(--card); border: 2px solid var(--border); border-radius: 15px; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                        <template x-if="imageUrl">
                                            <img :src="imageUrl"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </template>
                                        <template x-if="!imageUrl">
                                            <svg style="width: 35px; color: var(--border);" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                    stroke-width="2" />
                                            </svg>
                                        </template>
                                    </div>
                                    <div style="flex: 1; min-width: 180px;">
                                        <input type="file" name="icon" @change="fileChosen" accept="image/*"
                                            style="font-size: 11px; font-weight: 700; color: var(--text2);">
                                        <p style="font-size: 9px; color: var(--text3); margin-top: 6px;">Leave empty to keep
                                            current icon. Square PNG recommended.</p>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label
                                    style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">Description</label>
                                <textarea name="description" rows="3" placeholder="Category details..."
                                    style="width: 100%; padding: 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 600; color: var(--text); outline: none; resize: none; font-size: 13px;">{{ old('description', $category->description) }}</textarea>
                            </div>

                            <div
                                style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; padding-top: 15px; border-top: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span
                                        style="font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase;">Is
                                        Active</span>
                                    <label style="position: relative; display: inline-block; width: 44px; height: 22px;">
                                        <input type="checkbox" name="is_active" value="1"
                                            {{ $category->is_active ? 'checked' : '' }}
                                            style="opacity: 0; width: 0; height: 0;">
                                        <span class="slider"
                                            style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ddd; transition: .4s; border-radius: 34px;"></span>
                                    </label>
                                </div>

                                <button type="submit"
                                    style="padding: 12px 30px; background: var(--text); color: var(--bg); border: none; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.2s; box-shadow: var(--shadow-sm);">
                                    Update Category
                                </button>
                            </div>

                        </div>
                    </div>
                </form>

                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin-top: 20px;">
                    <div class="card"
                        style="padding: 15px; border: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                        <div style="padding: 8px; background: var(--blue-bg); border-radius: 8px; color: var(--blue);"><svg
                                style="width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" />
                            </svg></div>
                        <div>
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); margin: 0; text-transform: uppercase;">
                                Modified</p>
                            <p style="font-size: 11px; font-weight: 700; margin: 0;">
                                {{ $category->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="card"
                        style="padding: 15px; border: 1px solid var(--border); display: flex; align-items: center; gap: 12px;">
                        <div style="padding: 8px; background: var(--green-bg); border-radius: 8px; color: var(--green);">
                            <svg style="width: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2.5" />
                            </svg>
                        </div>
                        <div>
                            <p
                                style="font-size: 9px; font-weight: 800; color: var(--text3); margin: 0; text-transform: uppercase;">
                                Status</p>
                            <p style="font-size: 11px; font-weight: 700; margin: 0;">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    <script>
        function imagePreview(initialUrl) {
            return {
                imageUrl: initialUrl,
                fileChosen(event) {
                    if (!event.target.files.length) return;
                    let file = event.target.files[0];
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        event.target.value = '';
                        return;
                    }
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => this.imageUrl = e.target.result;
                }
            }
        }
    </script>

    <style>
        input:checked+.slider {
            background-color: var(--blue);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>
@endsection
