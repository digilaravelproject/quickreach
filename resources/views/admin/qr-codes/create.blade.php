@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px 10px 40px 10px !important;">

            <div class="card"
                style="margin: 0 0 15px 0; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius); border: 1px solid var(--border);">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <a href="{{ route('admin.qr-codes.index') }}" class="btn-outline"
                        style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div>
                        <h1 class="title" style="margin: 0; font-size: 18px; letter-spacing: -0.5px;">Generate QR Codes
                        </h1>
                        <p
                            style="font-size: 10px; font-weight: 700; color: var(--text3); text-transform: uppercase; margin-top: 2px;">
                            Create bulk tags for inventory</p>
                    </div>
                </div>
            </div>

            <div class="max-w-3xl mx-auto anim delay-1">
                @if (session('error'))
                    <div
                        style="margin-bottom: 15px; padding: 12px 20px; background: var(--red-bg); color: var(--red); border-radius: 12px; font-size: 12px; font-weight: 700; border: 1px solid rgba(239, 68, 68, 0.2);">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.qr-codes.store') }}" method="POST">
                    @csrf

                    <div class="card" style="padding: 25px; border: 1px solid var(--border); margin-bottom: 15px;">
                        <label
                            style="display: block; font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">
                            1. Select Product Category <span style="color: var(--red);">*</span>
                        </label>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
                            @foreach ($categories as $category)
                                <label style="position: relative; cursor: pointer; display: block;">
                                    <input type="radio" name="category_id" value="{{ $category->id }}" class="peer"
                                        style="display: none;" {{ old('category_id') == $category->id ? 'checked' : '' }}
                                        required>
                                    <div class="category-radio-card"
                                        style="padding: 15px; border: 1px solid var(--border); border-radius: 15px; background: var(--card2); transition: all 0.2s; display: flex; align-items: center; gap: 12px;">
                                        <div
                                            style="width: 40px; height: 40px; border-radius: 10px; background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 18px; color: var(--text2);">
                                            @if ($category->icon)
                                                <i class="{{ $category->icon }}"></i>
                                            @else
                                                {{ substr($category->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <div style="flex: 1;">
                                            <p style="font-weight: 800; color: var(--text); font-size: 13px; margin: 0;">
                                                {{ $category->name }}</p>
                                            <p style="font-size: 10px; font-weight: 700; color: var(--text3);">
                                                ₹{{ number_format($category->price, 2) }}</p>
                                        </div>
                                        <div class="check-icon" style="opacity: 0; color: var(--blue);">
                                            <svg style="width: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('category_id')
                            <p style="color: var(--red); font-size: 10px; font-weight: 700; margin-top: 10px;">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="card" style="padding: 25px; border: 1px solid var(--border); margin-bottom: 20px;">
                        <label for="quantity"
                            style="display: block; font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">
                            2. Quantity to Generate <span style="color: var(--red);">*</span>
                        </label>
                        <p style="font-size: 10px; color: var(--text3); margin-bottom: 15px;">Max 1000 codes per batch.</p>

                        <div style="position: relative; max-width: 200px;">
                            <input type="number" name="quantity" id="quantity" min="1" max="1000"
                                value="{{ old('quantity', 100) }}"
                                style="width: 100%; height: 48px; padding: 0 50px 0 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; font-weight: 800; color: var(--text); outline: none;"
                                required>
                            <span
                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">PCS</span>
                        </div>
                        @error('quantity')
                            <p style="color: var(--red); font-size: 10px; font-weight: 700; margin-top: 10px;">
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        style="width: 100%; height: 55px; background: var(--text); color: var(--bg); border: none; border-radius: 15px; font-size: 12px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: var(--shadow-lg);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Start Batch Generation
                    </button>
                </form>
            </div>
            <div style="height: 40px;"></div>
        </div>
    </div>

    <style>
        /* Radio Card Selection Logic */
        input[type="radio"]:checked+.category-radio-card {
            border-color: var(--blue) !important;
            background: var(--blue-bg) !important;
            box-shadow: 0 0 0 1px var(--blue);
        }

        input[type="radio"]:checked+.category-radio-card .check-icon {
            opacity: 1 !important;
        }

        input[type="radio"]:checked+.category-radio-card i,
        input[type="radio"]:checked+.category-radio-card div {
            color: var(--blue) !important;
        }
    </style>
@endsection
