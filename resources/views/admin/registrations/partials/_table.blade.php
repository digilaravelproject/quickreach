<div class="card" style="padding: 0; overflow: hidden; position: relative; border: 1px solid var(--border);">
    <div x-show="loading" class="absolute inset-0 z-20 flex items-center justify-center"
        style="background: rgba(var(--bg), 0.6); backdrop-filter: blur(2px);">
        <div class="live-badge" style="background: var(--text); color: var(--bg); padding: 8px 16px;">Updating...</div>
    </div>

    <div class="table-scroll" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="data-table" style="width: 100%; min-width: 1000px; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--card2);">
                    <th
                        style="padding: 15px 20px; text-align: left; color: var(--text3); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Registered User</th>
                    <th
                        style="padding: 15px 20px; text-align: left; color: var(--text3); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Linked QR</th>
                    <th
                        style="padding: 15px 20px; text-align: left; color: var(--text3); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Emergency Contacts</th>
                    <th
                        style="padding: 15px 20px; text-align: left; color: var(--text3); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Status</th>
                    <th
                        style="padding: 15px 20px; text-align: right; color: var(--text3); font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="reg in registrations" :key="reg.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                        onmouseover="this.style.background='var(--card2)'"
                        onmouseout="this.style.background='transparent'">

                        <td style="padding: 15px 20px;">
                            <div class="customer-cell">
                                <div class="customer-avatar"
                                    style="background: var(--text); color: var(--bg); width: 40px; height: 40px; font-weight: 800; border-radius: 12px; font-size: 14px;"
                                    x-text="reg.full_name.charAt(0).toUpperCase()">
                                </div>
                                <div>
                                    <div class="customer-name" style="font-size: 14px; color: var(--text);"
                                        x-text="reg.full_name"></div>
                                    <div class="card-sub" style="font-size: 11px; font-family: monospace;"
                                        x-text="reg.mobile_number"></div>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 15px 20px;">
                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <span class="prog-code"
                                    style="background: var(--card2); padding: 4px 8px; border-radius: 6px; width: fit-content; color: var(--text);"
                                    x-text="reg.qr_code?.qr_code || 'DELETED'"></span>
                                <span
                                    style="font-size: 10px; color: var(--blue); font-weight: 700; text-transform: uppercase;"
                                    x-text="reg.qr_code?.category?.name || ''"></span>
                            </div>
                        </td>

                        <td style="padding: 15px 20px;">
                            <div style="display: flex; flex-direction: column; gap: 2px;">
                                <div style="font-size: 11px; color: var(--text2); font-weight: 600;">P1: <span
                                        x-text="reg.friend_family_1 || '—'"></span></div>
                                <div style="font-size: 11px; color: var(--text2); font-weight: 600;">P2: <span
                                        x-text="reg.friend_family_2 || '—'"></span></div>
                            </div>
                        </td>

                        <td style="padding: 15px 20px;">
                            <span :class="reg.is_active ? 'badge-paid' : 'badge-failed'" class="badge"
                                style="font-size: 10px; padding: 4px 12px;"
                                x-text="reg.is_active ? 'Active' : 'Disabled'"></span>
                        </td>

                        <td style="padding: 15px 20px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a :href="`/admin/registrations/${reg.id}/edit`" class="icon-btn"
                                    style="color: var(--text2); background: var(--card2); border-radius: 8px; width: 34px; height: 34px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button @click="deleteReg(reg.id)" class="icon-btn"
                                    style="color: var(--red); background: var(--red-bg); border-radius: 8px; width: 34px; height: 34px;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </template>

                <tr x-show="!loading && registrations.length === 0">
                    <td colspan="5" style="text-align: center; padding: 60px; color: var(--text3);">
                        No registered users found matching your search.
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
