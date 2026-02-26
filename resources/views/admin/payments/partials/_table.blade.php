<div class="card"
    style="padding: 0; overflow: hidden; position: relative; border-radius: var(--radius); border: 1px solid var(--border); min-height: 400px;">

    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
        style="background: rgba(0,0,0,0.1); backdrop-filter: blur(3px); pointer-events: none;">
        <div
            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
            <div
                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 10px;">
            </div>
            <span
                style="font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase;">Syncing</span>
        </div>
    </div>

    <div class="table-scroll" style="overflow-x: auto;">
        <table class="data-table" style="width: 100%; min-width: 900px; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--card2); border-bottom: 1px solid var(--border);">
                    <th style="padding: 15px 20px;">Order Details</th>
                    <th style="padding: 15px 20px;">Customer</th>
                    <th style="padding: 15px 20px;">Amount</th>
                    <th style="padding: 15px 20px;">Status</th>
                    <th style="padding: 15px 20px;">Date</th>
                    <th style="padding: 15px 20px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="order in orders" :key="order.id">
                    <tr style="border-bottom: 1px solid var(--border);">
                        <td style="padding: 15px 20px;">
                            <span style="font-weight: 800; color: var(--text); font-size: 13px; display: block;"
                                x-text="order.order_number"></span>
                            <span style="font-size: 9px; color: var(--text3); font-family: monospace;"
                                x-text="order.payment_id || 'NO ID'"></span>
                        </td>
                        <td style="padding: 15px 20px;">
                            <div class="customer-cell">
                                <div class="customer-avatar"
                                    style="background: var(--card2); color: var(--text); font-weight: 800;"
                                    x-text="order.user ? order.user.name.charAt(0) : 'G'"></div>
                                <div>
                                    <div class="customer-name" style="font-size: 13px;"
                                        x-text="order.user ? order.user.name : 'Guest'"></div>
                                    <div class="card-sub" style="font-size: 11px;"
                                        x-text="order.user ? order.user.email : 'No Email'"></div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 15px 20px; font-weight: 800; color: var(--text);">₹<span
                                x-text="parseFloat(order.total_amount).toLocaleString()"></span></td>
                        <td style="padding: 15px 20px;">
                            <span
                                :class="{
                                    'badge-paid': order.payment_status === 'completed',
                                    'badge-pending': order.payment_status === 'pending',
                                    'badge-failed': order.payment_status === 'failed' || order
                                        .payment_status === 'refunded'
                                }"
                                class="badge" x-text="order.payment_status"></span>
                        </td>
                        <td style="padding: 15px 20px; font-size: 11px; font-weight: 700; color: var(--text2);"
                            x-text="formatDate(order.created_at)"></td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <a :href="'/admin/payments/' + order.id" class="icon-btn"
                                style="background: var(--card2);"><svg fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" style="width:14px;">
                                    <path
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg></a>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    <div x-show="pagination.last_page > 1"
        style="padding: 15px 20px; background: var(--card2); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
        <span style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">Page <span
                x-text="pagination.current_page"></span> / <span x-text="pagination.last_page"></span></span>
        <div style="display: flex; gap: 8px;">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                class="btn-outline" style="padding: 5px 12px; font-size: 11px; border-radius: 8px;">Prev</button>
            <button @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                style="padding: 5px 12px; font-size: 11px; border-radius: 8px;">Next</button>
        </div>
    </div>
</div>
