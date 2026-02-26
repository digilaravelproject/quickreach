<div style="text-align: center; margin-bottom: 20px; flex-shrink: 0;">
    <h2 style="margin: 0; color: var(--text); font-size: 20px; letter-spacing: -0.5px;"
        x-text="editMode ? 'Edit Slider' : 'Add New Slider'"></h2>
    <p
        style="margin: 5px 0 0 0; color: var(--text3); font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
        Fill in the details below</p>
</div>

<form @submit.prevent="saveSlider" enctype="multipart/form-data"
    style="display: flex; flex-direction: column; max-height: 70vh;">

    <div style="overflow-y: auto; padding-right: 8px; margin-bottom: 20px; flex-grow: 1;" class="custom-scroll">
        <div style="margin-bottom: 18px;">
            <label
                style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Slider
                Title</label>
            <input type="text" x-model="formData.title" placeholder="e.g. Summer Collection 2026"
                style="width: 100%; background: var(--card2); border: 1px solid var(--border); padding: 12px 15px; border-radius: 12px; color: var(--text); outline: none;">
        </div>

        <div style="margin-bottom: 18px;">
            <label
                style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Banner
                Image</label>
            <div
                style="position: relative; border: 2px dashed var(--border); border-radius: 15px; padding: 20px; text-align: center; background: var(--bg);">
                <input type="file" @change="handleFileUpload"
                    style="position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; z-index: 2;">

                <template x-if="!imagePreview">
                    <div style="color: var(--text3);">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 32px; margin: 0 auto 10px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p style="font-size: 11px; font-weight: 600;">Tap to upload banner</p>
                    </div>
                </template>

                <template x-if="imagePreview">
                    <div style="position: relative; z-index: 1;">
                        <img :src="imagePreview"
                            style="width: 100%; height: 140px; object-fit: cover; border-radius: 10px;">
                        <div style="margin-top: 8px; font-size: 9px; color: var(--blue); font-weight: 800;">REPLACE
                            IMAGE</div>
                    </div>
                </template>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <div>
                <label
                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Priority</label>
                <input type="number" x-model="formData.order_priority"
                    style="width: 100%; background: var(--card2); border: 1px solid var(--border); padding: 12px; border-radius: 12px; color: var(--text); outline: none;">
            </div>
            <div>
                <label
                    style="display: block; font-size: 10px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Status</label>
                <select x-model="formData.is_active"
                    style="width: 100%; background: var(--card2); border: 1px solid var(--border); padding: 12px; border-radius: 12px; color: var(--text); outline: none; cursor: pointer;">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div
        style="display: flex; gap: 12px; flex-shrink: 0; background: var(--bg); padding-top: 10px; border-top: 1px solid var(--border);">
        <button type="button" @click="openModal = false"
            style="flex: 1; padding: 12px; border: 1px solid var(--border); background: var(--card2); color: var(--text); border-radius: 12px; cursor: pointer; font-weight: 800; font-size: 12px;">
            CANCEL
        </button>
        <button type="submit"
            style="flex: 2; padding: 12px; background: var(--text); color: var(--bg); border: none; border-radius: 12px; cursor: pointer; font-weight: 900; font-size: 12px; text-transform: uppercase;">
            <span x-text="editMode ? 'Update Slider' : 'Create Slider'"></span>
        </button>
    </div>
</form>

<style>
    /* Custom thin scrollbar for cleaner UI */
    .custom-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 10px;
    }
</style>
