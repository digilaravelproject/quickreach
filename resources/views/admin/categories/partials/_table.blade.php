<div class="card"
    style="padding: 0; overflow: hidden; border: 1px solid var(--border); border-radius: var(--radius); position: relative; min-height: 400px; display: flex; flex-direction: column;">

    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
        style="background: rgba(var(--bg), 0.2); backdrop-filter: blur(4px); pointer-events: none;">
        <div
            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
            <div
                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 15px;">
            </div>
            <span
                style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 2px;">Syncing
                Categories</span>
        </div>
    </div>

    <div class="table-scroll" style="overflow-x: auto; flex: 1; -webkit-overflow-scrolling: touch;">
        <table class="data-table"
            style="width: 100%; min-width: 900px; border-collapse: collapse; table-layout: fixed;">
            <thead>
                <tr style="background: var(--card2);">
                    <th
                        style="width: 30%; padding: 15px 20px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Icon & Name</th>
                    <th
                        style="width: 20%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Price</th>
                    <th
                        style="width: 20%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Inventory</th>
                    <th
                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Status</th>
                    <th
                        style="width: 15%; padding: 15px 20px; text-align: right; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="category in categories" :key="category.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                        onmouseover="this.style.background='var(--card2)'"
                        onmouseout="this.style.background='transparent'">

                        <td style="padding: 12px 20px;">
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div
                                    style="width: 38px; height: 38px; background: var(--card2); border: 1px solid var(--border); border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    <template x-if="category.icon && category.icon.includes('/')">
                                        <img :src="'/' + category.icon"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    </template>
                                    <template x-if="!category.icon || !category.icon.includes('/')">
                                        <span style="font-size: 18px;" x-text="category.icon || '📁'"></span>
                                    </template>
                                </div>
                                <div style="min-width: 0;">
                                    <div style="font-size: 13px; font-weight: 800; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                        x-text="category.name"></div>
                                    <div style="font-size: 9px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: 0.5px;"
                                        x-text="'slug: ' + category.slug"></div>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 12px 15px;">
                            <span style="font-size: 14px; font-weight: 900; color: var(--text);"
                                x-text="'₹' + parseFloat(category.price).toLocaleString('en-IN', {minimumFractionDigits: 2})"></span>
                        </td>

                        <td style="padding: 12px 15px;">
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 13px; font-weight: 800; color: var(--text);"
                                    x-text="category.qr_codes_count"></span>
                                <span
                                    style="font-size: 9px; font-weight: 700; color: var(--text3); text-transform: uppercase;">Codes
                                    Linked</span>
                            </div>
                        </td>

                        <td style="padding: 12px 15px;">
                            <button @click="toggleStatus(category)"
                                style="border: none; background: transparent; padding: 0; cursor: pointer;">
                                <span class="badge" :class="category.is_active ? 'badge-paid' : 'badge-failed'"
                                    style="font-size: 9px; font-weight: 800; text-transform: uppercase; padding: 4px 10px;"
                                    x-text="category.is_active ? '● Active' : '○ Inactive'"></span>
                            </button>
                        </td>

                        <td style="padding: 12px 20px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <a :href="'/admin/categories/' + category.id + '/edit'" class="icon-btn"
                                    style="background: var(--card2); color: var(--blue); width: 32px; height: 32px; border-radius: 8px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button @click="deleteCategory(category)" class="icon-btn"
                                    style="background: var(--card2); color: var(--red); width: 32px; height: 32px; border-radius: 8px;">
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

    <div x-show="categories.length === 0 && !loading" style="padding: 80px 0; text-align: center;">
        <div
            style="background: var(--card2); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
            <svg style="width: 24px; color: var(--text3);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                    stroke-width="2" />
            </svg>
        </div>
        <p
            style="color: var(--text3); font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">
            No Categories Found</p>
    </div>
</div>

<style>
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
