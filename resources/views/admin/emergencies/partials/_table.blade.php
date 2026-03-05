<div class="card"
    style="padding: 0; overflow: hidden; position: relative; border: 1px solid var(--border); min-height: 350px; display: flex; flex-direction: column; border-radius: 15px;">

    {{-- Spinning Loader --}}
    <div x-show="loading" class="absolute inset-0 z-50 flex items-center justify-center"
        style="position: absolute; background: rgba(var(--bg), 0.5); backdrop-filter: blur(2px); width:100%; height:100%; z-index: 10;">
        <div
            style="background: var(--card); padding: 20px 30px; border-radius: 20px; border: 1px solid var(--border); text-align: center; box-shadow: var(--shadow-lg);">
            <div
                style="width: 32px; height: 32px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 10px;">
            </div>
            <span
                style="font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 1px;">Refreshing</span>
        </div>
    </div>

    {{-- Table --}}
    <div x-show="!loading" class="table-scroll" style="overflow-x: auto; flex: 1;">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="background: var(--card2);">
                    <th
                        style="padding: 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        List Item (Emergency)</th>
                    <th
                        style="width: 120px; padding: 15px; text-align: center; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in items" :key="item.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                        onmouseover="this.style.background='var(--card2)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <span style="color: #ef4444; font-size: 18px;">●</span>
                                <span style="font-size: 14px; font-weight: 800; color: var(--text);"
                                    x-text="item.title"></span>
                            </div>
                        </td>
                        <td style="padding: 12px 15px;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                {{-- Edit Button --}}
                                <button @click="editItem(item)"
                                    style="background: var(--card2); width: 32px; height: 32px; color: var(--blue); border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            stroke-width="2.5" />
                                    </svg>
                                </button>
                                {{-- Delete Form --}}
                                <form :action="`/admin/emergencies/${item.id}`" method="POST"
                                    onsubmit="return confirm('Delete this point?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="background: var(--card2); width: 32px; height: 32px; color: var(--red); border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            style="width:14px;">
                                            <path
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                stroke-width="2.5" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- Empty State --}}
    <div x-show="!loading && items.length === 0"
        style="padding: 60px 0; text-align: center; color: var(--text3); font-size: 11px; font-weight: 800; text-transform: uppercase;">
        No points found.
    </div>
</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
