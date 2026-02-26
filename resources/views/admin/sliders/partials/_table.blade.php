<table style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background: var(--card2); border-bottom: 1px solid var(--border);">
            <th
                style="padding: 12px 20px; text-align: left; font-size: 10px; color: var(--text3); text-transform: uppercase; font-weight: 800;">
                Image</th>
            <th
                style="padding: 12px 20px; text-align: left; font-size: 10px; color: var(--text3); text-transform: uppercase; font-weight: 800;">
                Details</th>
            <th
                style="padding: 12px 20px; text-align: center; font-size: 10px; color: var(--text3); text-transform: uppercase; font-weight: 800;">
                Order</th>
            <th
                style="padding: 12px 20px; text-align: right; font-size: 10px; color: var(--text3); text-transform: uppercase; font-weight: 800;">
                Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($sliders as $slider)
            <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                onmouseover="this.style.background='var(--card2)'" onmouseout="this.style.background='transparent'">
                <td style="padding: 12px 20px; width: 100px;">
                    <img src="{{ asset('storage/' . $slider->image_path) }}"
                        style="width: 80px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border); box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                </td>
                <td style="padding: 12px 20px;">
                    <div style="font-weight: 700; color: var(--text); font-size: 13px;">{{ $slider->title }}</div>
                    <div style="font-size: 10px; color: var(--text3); margin-top: 2px;">
                        {{ $slider->link ?? 'No Link Attached' }}</div>
                </td>
                <td style="padding: 12px 20px; text-align: center;">
                    <span
                        style="font-size: 11px; font-weight: 900; color: var(--blue); background: var(--blue-bg); padding: 2px 10px; border-radius: 20px;">
                        {{ $slider->order_priority }}
                    </span>
                </td>
                <td style="padding: 12px 20px; text-align: right;">
                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                        <button @click="editSlider({{ json_encode($slider) }})" title="Edit Slider"
                            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: var(--card2); border: 1px solid var(--border); color: var(--blue); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </button>

                        <button @click="deleteSlider({{ $slider->id }})" title="Delete Slider"
                            style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; background: var(--card2); border: 1px solid var(--border); color: var(--red); border-radius: 8px; cursor: pointer; transition: all 0.2s;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4"
                    style="padding: 60px; text-align: center; color: var(--text3); font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">
                    <div style="margin-bottom: 10px; opacity: 0.5;">
                        <svg style="width: 48px; margin: 0 auto;" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    No Banners Found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
