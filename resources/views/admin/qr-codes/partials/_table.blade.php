{{-- QR Codes Table --}}
<div class="card"
    style="padding: 0; overflow: hidden; position: relative; border: 1px solid var(--border); min-height: 400px; display: flex; flex-direction: column;">

    {{-- ── FIXED SCREEN CENTER LOADER ── --}}
    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
        style="background: rgba(var(--bg), 0.4); backdrop-filter: blur(4px); pointer-events: none;">
        <div
            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
            <div
                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 15px;">
            </div>
            <span
                style="font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--text); letter-spacing: 2px; display: block;">Syncing
                Inventory</span>
        </div>
    </div>

    {{-- ── RESPONSIVE TABLE ── --}}
    <div x-show="!loading" x-cloak class="table-scroll"
        style="overflow-x: auto; flex: 1; -webkit-overflow-scrolling: touch;">
        <table class="data-table"
            style="width: 100%; min-width: 1000px; border-collapse: collapse; table-layout: fixed;">
            <thead>
                <tr style="background: var(--card2);">
                    <th style="width: 5%; padding: 15px 20px;">
                        <input type="checkbox" @change="toggleAll($event)" class="checkbox-custom">
                    </th>
                    <th
                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        QR Code</th>
                    <th
                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Category</th>
                    <th
                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Status</th>
                    <th
                        style="width: 25%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Owner</th>
                    <th
                        style="width: 15%; padding: 15px 15px; text-align: left; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Created</th>
                    <th
                        style="width: 10%; padding: 15px 20px; text-align: center; color: var(--text3); font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="qr in qrCodes" :key="qr.id">
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;"
                        onmouseover="this.style.background='var(--card2)'"
                        onmouseout="this.style.background='transparent'">
                        {{-- Checkbox --}}
                        <td style="padding: 12px 20px;">
                            <input type="checkbox" :value="qr.id" x-model="selected" class="checkbox-custom">
                        </td>

                        {{-- QR Code --}}
                        <td style="padding: 12px 15px;">
                            <a :href="`/admin/qr-codes/${qr.id}`" style="text-decoration: none;">
                                <div style="font-size: 13px; font-weight: 800; color: var(--text); font-style: italic;"
                                    x-text="qr.qr_code"></div>
                            </a>
                        </td>

                        {{-- Category --}}
                        <td style="padding: 12px 15px;">
                            <span class="prog-code"
                                style="font-size: 10px; background: var(--card2); color: var(--text);"
                                x-text="qr.category ? qr.category.name : 'N/A'"></span>
                        </td>

                        {{-- Status --}}
                        <td style="padding: 12px 15px;">
                            <span class="badge"
                                :class="{
                                    'badge-paid': qr.status === 'available',
                                    'badge-pending': qr.status === 'assigned',
                                    'badge-failed': qr.status === 'registered'
                                }"
                                style="padding: 4px 10px; font-size: 9px; font-weight: 800; text-transform: uppercase;"
                                x-text="qr.status"></span>
                        </td>

                        {{-- Owner --}}
                        <td style="padding: 12px 15px;">
                            <template x-if="qr.registration">
                                <div style="min-width: 0;">
                                    <div style="font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                        x-text="qr.registration.full_name"></div>
                                    <div style="font-size: 10px; color: var(--text3);"
                                        x-text="qr.registration.mobile_number"></div>
                                </div>
                            </template>
                            <template x-if="!qr.registration">
                                <span style="font-size: 11px; color: var(--text3); font-style: italic;">Not
                                    Registered</span>
                            </template>
                        </td>

                        {{-- Date --}}
                        <td style="padding: 12px 15px;">
                            <span style="font-size: 11px; font-weight: 700; color: var(--text2);"
                                x-text="formatDate(qr.created_at)"></span>
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 12px 20px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 8px;">
                                <a :href="`/admin/qr-codes/${qr.id}`" class="icon-btn"
                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--blue);">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <button @click="deleteSingle(qr.id)" x-show="qr.status === 'available'" class="icon-btn"
                                    style="background: var(--card2); width: 30px; height: 30px; color: var(--red);">
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

    {{-- ── PAGINATION ATTACHED TO CARD ── --}}
    <div x-show="pagination.last_page > 1" x-cloak
        style="padding: 15px 20px; background: var(--card2); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 11px; font-weight: 700; color: var(--text2);">
            <span style="color: var(--text);" x-text="pagination.total"></span> total items
        </div>
        <div style="display: flex; gap: 8px;">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                class="btn-outline"
                style="padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;"
                :style="pagination.current_page === 1 ? 'opacity: 0.3; cursor: not-allowed;' : ''">Prev</button>

            <div
                style="display: flex; gap: 4px; align-items: center; padding: 0 10px; font-size: 11px; font-weight: 800; color: var(--text);">
                <span x-text="pagination.current_page"></span> / <span x-text="pagination.last_page"></span>
            </div>

            <button @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                style="padding: 6px 14px; border-radius: 8px; font-size: 11px; font-weight: 700; cursor: pointer;"
                :style="pagination.current_page === pagination.last_page ? 'opacity: 0.3; cursor: not-allowed;' : ''">Next</button>
        </div>
    </div>

    {{-- Empty State --}}
    <div x-show="!loading && qrCodes.length === 0" x-cloak
        style="padding: 80px 0; text-align: center; color: var(--text3); font-size: 12px; font-weight: 700; text-transform: uppercase;">
        No QR codes found in inventory.
    </div>
</div>

<style>
    [x-cloak] {
        display: none !important;
    }

    .checkbox-custom {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 2px solid var(--border);
        cursor: pointer;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
