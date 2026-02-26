<div x-show="openModal" x-cloak
    style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: 9999; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px);">

    <div @click.away="openModal = false" x-show="openModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        style="position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%); {{-- Ye line exact center mein laayegi --}}
                background: var(--card2);
                width: 90%;
                max-width: 450px;
                border-radius: 24px;
                border: 1px solid var(--border);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
                overflow: hidden;">

        <div
            style="padding: 20px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.02);">
            <h2 style="font-size: 16px; font-weight: 800; color: var(--text); font-family: 'Syne', sans-serif;">Create
                Broadcast</h2>
            <button @click="openModal = false"
                style="background: var(--bg); border: 1px solid var(--border); color: var(--text); width: 30px; height: 30px; border-radius: 50%; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center;">
                &times;
            </button>
        </div>

        <form @submit.prevent="saveNotification" style="padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label
                    style="display: block; font-size: 11px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Title</label>
                <input type="text" x-model="formData.title" placeholder="System Alert..."
                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); padding: 12px; border-radius: 12px; color: var(--text); outline: none;">
            </div>

            <div style="margin-bottom: 20px;">
                <label
                    style="display: block; font-size: 11px; font-weight: 800; color: var(--text3); margin-bottom: 8px; text-transform: uppercase;">Message</label>
                <textarea x-model="formData.message" rows="4" placeholder="Enter broadcast details..."
                    style="width: 100%; background: var(--bg); border: 1px solid var(--border); padding: 12px; border-radius: 12px; color: var(--text); outline: none; resize: none;"></textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="button" @click="openModal = false"
                    style="flex: 1; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: transparent; color: var(--text); font-weight: 800; cursor: pointer;">
                    CANCEL
                </button>
                <button type="submit" :disabled="loading"
                    style="flex: 2; padding: 12px; border-radius: 12px; background: var(--text); color: var(--bg); border: none; font-weight: 900; cursor: pointer;">
                    <span x-text="loading ? 'Publishing...' : 'PUBLISH NOW'"></span>
                </button>
            </div>
        </form>
    </div>
</div>
