<div class="card"
    style="border: 1px solid var(--border); border-radius: 15px; overflow: hidden; position: relative; min-height: 400px; background: var(--bg); display: flex; flex-direction: column;">

    {{-- Loader Circle --}}
    <div x-show="loading"
        style="position: absolute; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 50;">
        <div style="text-align: center;">
            <div
                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto;">
            </div>
            <p
                style="margin-top: 10px; font-size: 10px; font-weight: 800; color: var(--text); text-transform: uppercase;">
                Syncing...</p>
        </div>
    </div>

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 700px;">
            <thead>
                <tr style="background: var(--card2);">
                    <th
                        style="padding: 18px 15px; text-align: left; color: var(--text3); font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        Step</th>
                    <th
                        style="padding: 18px 15px; text-align: left; color: var(--text3); font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        Preview</th>
                    <th
                        style="padding: 18px 15px; text-align: left; color: var(--text3); font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        Info</th>
                    <th
                        style="padding: 18px 15px; text-align: center; color: var(--text3); font-size: 10px; font-weight: 800; text-transform: uppercase;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Alpine.js Loop --}}
                <template x-for="item in items" :key="item.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                        onmouseover="this.style.background='var(--card2)'"
                        onmouseout="this.style.background='transparent'">

                        <td style="padding: 15px;">
                            <div style="width: 28px; height: 28px; background: var(--text); color: var(--bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 900;"
                                x-text="item.step_order"></div>
                        </td>

                        <td style="padding: 15px;">
                            <div
                                style="width: 50px; height: 50px; border-radius: 12px; background: var(--card2); border: 1px solid var(--border); overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                <img :src="'/storage/' + item.image_path"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </td>

                        <td style="padding: 15px;">
                            <div style="font-weight: 800; color: var(--text); font-size: 14px; margin-bottom: 2px;"
                                x-text="item.title"></div>
                            <div style="font-size: 11px; color: var(--text3); max-width: 300px; line-height: 1.4;"
                                x-text="item.description"></div>
                        </td>

                        <td style="padding: 15px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <button @click="editItem(item)"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: var(--card2); border: 1px solid var(--border); color: var(--blue); cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button @click="deleteItem(item.id)"
                                    style="width: 32px; height: 32px; border-radius: 8px; background: var(--card2); border: 1px solid var(--border); color: var(--red); cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg width="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                {{-- Empty State (Using Alpine) --}}
                <template x-if="items.length === 0 && !loading">
                    <tr>
                        <td colspan="4"
                            style="padding: 50px; text-align: center; color: var(--text3); font-size: 11px; font-weight: 800; text-transform: uppercase;">
                            No steps found.
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
