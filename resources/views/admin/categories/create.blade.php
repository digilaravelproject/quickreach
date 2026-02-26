@extends('layout.app')

@section('content')
    <div class="main-area" x-data="imagePreview()">
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
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">New Category</h1>
                        <p
                            style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 1px;">
                            Add new inventory group</p>
                    </div>
                </div>
                <div class="live-badge"
                    style="font-size: 10px; padding: 4px 12px; background: var(--blue-bg); color: var(--blue); border: 1px solid var(--blue);">
                    CREATE MODE</div>
            </div>

            <div class="max-w-3xl mx-auto anim delay-1">

                @if ($errors->any())
                    <div
                        style="margin-bottom: 15px; padding: 12px; background: var(--red-bg); border-radius: 12px; border: 1px solid rgba(239, 68, 68, 0.2);">
                        <p
                            style="color: var(--red); font-size: 11px; font-weight: 800; text-transform: uppercase; margin-bottom: 5px;">
                            Fix following errors:</p>
                        <ul style="margin: 0; padding-left: 15px; color: var(--red); font-size: 11px; font-weight: 600;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card"
                        style="padding: 0; overflow: hidden; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm);">

                        <div style="background: var(--card2); padding: 15px 25px; border-bottom: 1px solid var(--border);">
                            <h2
                                style="font-size: 12px; font-weight: 800; margin: 0; text-transform: uppercase; color: var(--text3); letter-spacing: 1px;">
                                General Information</h2>
                        </div>

                        <div style="padding: 25px; display: flex; flex-direction: column; gap: 25px;">

                            <div
                                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label
                                        style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 0.5px;">Category
                                        Name <span style="color: var(--red);">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        placeholder="e.g. Car Tag"
                                        style="width: 100%; height: 48px; padding: 0 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 700; color: var(--text); outline: none; transition: border 0.3s;">
                                </div>

                                <div style="display: flex; flex-direction: column; gap: 8px;">
                                    <label
                                        style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 0.5px;">Price
                                        (INR) <span style="color: var(--red);">*</span></label>
                                    <div style="position: relative;">
                                        <span
                                            style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); font-weight: 800; color: var(--blue);">₹</span>
                                        <input type="number" name="price" step="0.01" value="{{ old('price') }}"
                                            required placeholder="0.00"
                                            style="width: 100%; height: 48px; padding: 0 15px 0 35px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 800; color: var(--text); outline: none;">
                                    </div>
                                </div>
                            </div>

                            <div
                                style="padding: 20px; background: var(--card2); border-radius: 15px; border: 1px dashed var(--border);">
                                <label
                                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; margin-bottom: 15px; letter-spacing: 0.5px;">Branding
                                    & Identity</label>
                                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                                    <div
                                        style="width: 80px; height: 80px; background: var(--card); border: 2px solid var(--border); border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
                                        <template x-if="imageUrl">
                                            <img :src="imageUrl"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </template>
                                        <template x-if="!imageUrl">
                                            <svg style="width: 30px; color: var(--border);" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </template>
                                    </div>
                                    <div style="flex: 1; min-width: 180px;">
                                        <input type="file" name="icon" @change="fileChosen" accept="image/*"
                                            style="font-size: 11px; font-weight: 700; color: var(--text3);">
                                        <p style="font-size: 9px; color: var(--text3); margin-top: 5px; font-weight: 600;">
                                            PNG, JPG up to 2MB (Square recommended)</p>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label
                                    style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 0.5px;">Product
                                    Description</label>
                                <textarea name="description" rows="3" placeholder="Describe the tag use-case..."
                                    style="width: 100%; padding: 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 600; color: var(--text); outline: none; resize: none; font-size: 13px;">{{ old('description') }}</textarea>
                            </div>

                            <div
                                style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center; justify-content: space-between; padding-top: 10px; border-top: 1px solid var(--border);">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <span
                                        style="font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase;">Active
                                        Status</span>
                                    <label style="position: relative; display: inline-block; width: 44px; height: 22px;">
                                        <input type="checkbox" name="is_active" value="1" checked
                                            style="opacity: 0; width: 0; height: 0;">
                                        <span class="slider"
                                            style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ddd; transition: .4s; border-radius: 34px;"></span>
                                    </label>
                                </div>

                                <button type="submit"
                                    style="padding: 12px 25px; background: var(--text); color: var(--bg); border: none; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: 0.2s; box-shadow: var(--shadow-sm);">
                                    Create Category
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    <script>
        function imagePreview() {
            return {
                imageUrl: '',
                fileChosen(event) {
                    if (!event.target.files.length) return;
                    let file = event.target.files[0];
                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = e => this.imageUrl = e.target.result;
                }
            }
        }
    </script>

    <style>
        /* Toggle Fix */
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
