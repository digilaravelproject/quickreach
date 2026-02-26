@extends('layout.app')

@section('content')
    <div class="main-area" x-data="sliderHandler()">
        <div class="page-scroll" style="background: var(--bg); padding: 10px !important;">

            <div class="card"
                style="margin-bottom: 15px; padding: 15px 20px; display: flex; align-items: center; justify-content: space-between; border-radius: var(--radius); border: 1px solid var(--border);">
                <div>
                    <h1 class="title" style="margin: 0; font-size: 20px; color: var(--text);">Sliders</h1>
                    <p
                        style="margin: 2px 0 0 0; color: var(--text3); font-size: 11px; font-weight: 700; text-transform: uppercase;">
                        Manage Home Banners</p>
                </div>
                <button @click="resetForm(); openModal = true" class="btn-primary"
                    style="padding: 10px 20px; background: var(--text); color: var(--bg); border: none; border-radius: 8px; font-weight: 800; cursor: pointer;">
                    + NEW SLIDER
                </button>
            </div>

            <div class="card" style="margin-bottom: 15px; padding: 12px; border: 1px solid var(--border);">
                <form method="GET" action="{{ route('admin.sliders.index') }}" style="display: flex; gap: 10px;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sliders..."
                        style="flex: 1; background: var(--card2); border: 1px solid var(--border); padding: 10px; border-radius: 10px; color: var(--text); outline: none;">
                    <button type="submit"
                        style="background: var(--text); color: var(--bg); border: none; padding: 0 15px; border-radius: 10px; cursor: pointer; font-weight: 800;">FILTER</button>
                </form>
            </div>

            <div class="card" style="padding: 0; border: 1px solid var(--border); overflow: hidden;">
                @include('admin.sliders.partials._table')
            </div>

            <div x-show="openModal"
                style="position: fixed; inset: 0; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); display: flex !important; align-items: center !important; justify-content: center !important; z-index: 9999; padding: 20px;"
                x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100">

                <div class="card" @click.away="openModal = false"
                    style="width: 100%; max-width: 500px; margin: auto; padding: 35px; background: var(--bg); border-radius: 28px; border: 1px solid var(--border); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">

                    @include('admin.sliders.partials._form')

                </div>
            </div>

        </div>
    </div>

    @include('admin.sliders.partials._scripts')
@endsection
