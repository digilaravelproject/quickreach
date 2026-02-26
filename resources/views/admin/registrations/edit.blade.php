@extends('layout.app')

@section('content')
    <div class="main-area">
        <div class="page-scroll" style="background: var(--bg); padding: 10px 10px 40px 10px !important;">

            <div style="margin: 5px 0 15px 5px;">
                <a href="{{ route('admin.registrations.index') }}"
                    style="display: inline-flex; align-items: center; gap: 6px; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; text-decoration: none;">
                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Directory
                </a>
            </div>

            <div class="card"
                style="max-width: 900px; margin: 0 auto; padding: 0; overflow: hidden; border: 1px solid var(--border); border-radius: var(--radius); box-shadow: var(--shadow-sm);">

                <div style="background: var(--text); padding: 25px; color: var(--bg);">
                    <h1
                        style="font-size: 20px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: -0.5px; font-style: italic;">
                        Edit Registration</h1>
                    <p
                        style="font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; opacity: 0.8; margin-top: 4px;">
                        Record ID: #{{ $registration->id }}</p>
                </div>

                <form action="{{ route('admin.registrations.update', $registration) }}" method="POST"
                    style="padding: 25px;">
                    @csrf
                    @method('PUT')

                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 25px;">
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-left: 2px;">Full
                                Name</label>
                            <input type="text" name="full_name" value="{{ $registration->full_name }}"
                                style="width: 100%; height: 45px; padding: 0 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text); outline: none;">
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-left: 2px;">Mobile
                                Number</label>
                            <input type="text" name="mobile_number" value="{{ $registration->mobile_number }}"
                                style="width: 100%; height: 45px; padding: 0 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text); outline: none;">
                        </div>
                    </div>

                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 25px; padding: 20px; background: var(--card2); border-radius: 15px; border: 1px dashed var(--border);">
                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: 1px;">Friend
                                / Family 1</label>
                            <input type="text" name="friend_family_1" value="{{ $registration->friend_family_1 }}"
                                placeholder="Contact Number 1"
                                style="width: 100%; height: 45px; padding: 0 15px; background: var(--card); border: 1px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text); outline: none;">
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 6px;">
                            <label
                                style="font-size: 10px; font-weight: 800; color: var(--blue); text-transform: uppercase; letter-spacing: 1px;">Friend
                                / Family 2</label>
                            <input type="text" name="friend_family_2" value="{{ $registration->friend_family_2 }}"
                                placeholder="Contact Number 2"
                                style="width: 100%; height: 45px; padding: 0 15px; background: var(--card); border: 1px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text); outline: none;">
                        </div>
                    </div>

                    <div style="margin-bottom: 25px; display: flex; flex-direction: column; gap: 6px;">
                        <label
                            style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase; letter-spacing: 1px; margin-left: 2px;">Full
                            Address</label>
                        <textarea name="full_address" rows="3"
                            style="width: 100%; padding: 12px 15px; background: var(--card2); border: 1px solid var(--border); border-radius: 10px; font-weight: 700; color: var(--text); outline: none; resize: none; font-size: 13px;">{{ $registration->full_address }}</textarea>
                    </div>

                    <div
                        style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; background: var(--card2); border: 1px solid var(--border); border-radius: 12px; margin-bottom: 25px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div
                                style="width: 8px; height: 8px; border-radius: 50%; background: {{ $registration->is_active ? 'var(--green)' : 'var(--red)' }}">
                            </div>
                            <span
                                style="font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase;">Profile
                                Status</span>
                        </div>

                        <label style="position: relative; display: inline-block; width: 46px; height: 24px;">
                            <input type="checkbox" name="is_active" value="1" style="opacity: 0; width: 0; height: 0;"
                                {{ $registration->is_active ? 'checked' : '' }}>
                            <span class="slider"
                                style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ddd; transition: .4s; border-radius: 24px;"></span>
                        </label>
                    </div>

                    <button type="submit"
                        style="width: 100%; height: 50px; background: var(--text); color: var(--bg); border: none; border-radius: 12px; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 2px; cursor: pointer; transition: 0.2s;">
                        Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Toggle Switch Style */
        input:checked+.slider {
            background-color: var(--blue);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>
@endsection
