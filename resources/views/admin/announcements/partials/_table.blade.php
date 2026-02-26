<div class="card"
    style="background: var(--card2); border-radius: 15px; overflow: hidden; border: 1px solid var(--border); display: flex; flex-direction: column;">
    <div style="overflow-x: auto;" class="custom-scroll">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="background: rgba(0,0,0,0.1); border-bottom: 1px solid var(--border);">
                    <th
                        style="padding: 15px; text-align: left; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                        Notification</th>
                    <th
                        style="padding: 15px; text-align: center; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                        Status</th>
                    <th
                        style="padding: 15px; text-align: center; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                        Date</th>
                    <th
                        style="padding: 15px; text-align: right; font-size: 11px; color: var(--text3); text-transform: uppercase;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="item in announcements" :key="item.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: 0.2s;"
                        onmouseover="this.style.background='rgba(255,255,255,0.02)'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 15px;">
                            <div style="font-weight: 700; color: var(--text); font-size: 13px;" x-text="item.title">
                            </div>
                            <div style="font-size: 11px; color: var(--text3); margin-top: 4px;"
                                x-text="item.message.substring(0, 80) + '...'"></div>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <button @click="toggleStatus(item.id)"
                                :style="{
                                    padding: '5px 14px',
                                    borderRadius: '20px',
                                    fontSize: '10px',
                                    fontWeight: '900',
                                    background: item.is_active ? '#22c55e' : 'var(--border)',
                                    color: 'white',
                                    border: 'none',
                                    cursor: 'pointer'
                                }">
                                <span x-text="item.is_active ? 'LIVE' : 'EXPIRED'"></span>
                            </button>
                        </td>
                        <td style="padding: 15px; text-align: center; font-size: 11px; color: var(--text3);"
                            x-text="formatDate(item.created_at)"></td>
                        <td style="padding: 15px; text-align: right;">
                            <button @click="deleteNotification(item.id)" title="Delete Notification"
                                style="background: rgba(239, 68, 68, 0.1); border: none; color: #ef4444; width: 32px; height: 32px; border-radius: 10px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s ease;"
                                onmouseover="this.style.background='#ef4444'; this.style.color='#ffffff';"
                                onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444';">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>
                <template x-if="announcements.length === 0">
                    <tr>
                        <td colspan="4"
                            style="padding: 50px; text-align: center; color: var(--text3); font-weight: 700;">NO HISTORY
                            FOUND</td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div
        style="padding: 15px; display: flex; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.1); border-top: 1px solid var(--border);">
        <div style="font-size: 11px; color: var(--text3); font-weight: 700;">
            Page <span x-text="pagination.current_page" style="color: var(--text);"></span> of <span
                x-text="pagination.last_page"></span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button @click="changePage(pagination.prev_page_url)" :disabled="!pagination.prev_page_url"
                style="padding: 8px 16px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 11px; font-weight: 800; cursor: pointer;"
                :style="{ opacity: pagination.prev_page_url ? 1 : 0.4 }">
                PREVIOUS
            </button>
            <button @click="changePage(pagination.next_page_url)" :disabled="!pagination.next_page_url"
                style="padding: 8px 16px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 11px; font-weight: 800; cursor: pointer;"
                :style="{ opacity: pagination.next_page_url ? 1 : 0.4 }">
                NEXT
            </button>
        </div>
    </div>
</div>
