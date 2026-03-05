<div class="card"
    style="padding: 0; overflow: hidden; position: relative; border: 1px solid var(--border); min-height: 400px; display: flex; flex-direction: column; border-radius: 15px;">

    {{-- Circle Spinning Loader --}}
    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
        style="position: absolute; background: rgba(var(--bg), 0.5); backdrop-filter: blur(2px); width:100%; height:100%;">
        <div
            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
            <div
                style="width: 35px; height: 35px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 12px;">
            </div>
            <span
                style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 1px; display: block;">Syncing
                Data</span>
        </div>
    </div>

    {{-- Table Structure --}}
    <div x-show="!loading" class="table-scroll" style="overflow-x: auto; flex: 1;">
        <table style="width: 100%; min-width: 800px; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--card2);">
                    <th
                        style="width: 80px; padding: 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800;">
                        Icon</th>
                    <th
                        style="padding: 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800;">
                        Title</th>
                    <th
                        style="padding: 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800;">
                        Description</th>
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
                        <td style="padding: 12px 15px;">
                            <div
                                style="width: 40px; height: 40px; border-radius: 10px; background: var(--bg); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                <template x-if="item.icon_image">
                                    <img :src="'/storage/' + item.icon_image"
                                        style="width: 28px; height: 28px; object-fit: contain;">
                                </template>
                            </div>
                        </td>
                        <td style="padding: 12px 15px; font-weight: 800; color: var(--text); font-size: 13px;"
                            x-text="item.title"></td>
                        <td style="padding: 12px 15px; color: var(--text2); font-size: 12px; line-height: 1.4;"
                            x-text="item.description"></td>
                        <td style="padding: 12px 15px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <button @click="editItem(item)" class="icon-btn"
                                    style="background: var(--card2); width: 32px; height: 32px; color: var(--blue); border:none; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button @click="deleteItem(item.id)" class="icon-btn"
                                    style="background: var(--card2); width: 32px; height: 32px; color: var(--red); border:none; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
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

    [x-cloak] {
        display: none !important;
    }
</style>
