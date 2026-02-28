<div class="card"
    style="padding: 0; overflow: hidden; position: relative; border-radius: var(--radius); border: 1px solid var(--border); min-height: 400px;">

    {{-- Loading Overlay --}}
    <div x-show="loading" class="fixed inset-0 z-[9999] flex items-center justify-center"
        style="background: rgba(0,0,0,0.1); backdrop-filter: blur(3px); pointer-events: none;">
        <div
            style="background: var(--card); padding: 25px 40px; border-radius: 20px; border: 1px solid var(--border); box-shadow: var(--shadow-lg); text-align: center;">
            <div
                style="width: 40px; height: 40px; border: 3px solid var(--card2); border-top: 3px solid var(--text); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto 10px;">
            </div>
            <span
                style="font-size: 11px; font-weight: 800; color: var(--text); text-transform: uppercase;">Loading</span>
        </div>
    </div>

    {{-- Empty State --}}
    <div x-show="!loading && orders.length === 0" style="padding: 60px 20px; text-align: center; color: var(--text3);">
        <p style="font-size: 32px; margin-bottom: 10px;">📋</p>
        <p style="font-weight: 800; font-size: 14px;">No orders found</p>
        <p style="font-size: 12px; margin-top: 4px;">Try adjusting your search or filters.</p>
    </div>

    {{-- Table --}}
    <div x-show="!loading && orders.length > 0" class="table-scroll" style="overflow-x: auto;">
        <table class="data-table" style="width: 100%; min-width: 960px; border-collapse: collapse;">
            <thead>
                <tr style="background: var(--card2); border-bottom: 1px solid var(--border);">
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Order</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Customer</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Category</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Amount</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Method</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Payment Status</th>
                    <th
                        style="padding: 14px 20px; text-align: left; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Date</th>
                    <th
                        style="padding: 14px 20px; text-align: right; font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
                        Actions</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="order in orders" :key="order.id">
                    <tr style="border-bottom: 1px solid var(--border);">

                        {{-- Order --}}
                        <td style="padding: 15px 20px;">
                            <span style="font-weight: 800; color: var(--text); font-size: 13px; display: block;"
                                x-text="order.order_number"></span>
                            <span style="font-size: 9px; color: var(--text3); font-family: monospace;"
                                x-text="order.razorpay_payment_id ? order.razorpay_payment_id : (order.payment_method === 'cod' ? 'COD Order' : 'No Transaction ID')"></span>
                        </td>

                        {{-- Customer --}}
                        <td style="padding: 15px 20px;">
                            <div class="customer-cell">
                                <div class="customer-avatar"
                                    style="background: var(--card2); color: var(--text); font-weight: 800;"
                                    x-text="order.user.name.charAt(0).toUpperCase()"></div>
                                <div>
                                    <div class="customer-name" style="font-size: 13px;" x-text="order.user.name"></div>
                                    <div class="card-sub" style="font-size: 11px;" x-text="order.user.email"></div>
                                </div>
                            </div>
                        </td>

                        {{-- Category (UPDATED FOR MULTIPLE ROWS) --}}
                        <td style="padding: 15px 20px;">
                            <div style="display: flex; flex-direction: column; gap: 6px; align-items: flex-start;">
                                <template x-for="(cat, index) in (order.categories ? order.categories.split(', ') : [])"
                                    :key="index">
                                    <span
                                        style="font-size: 11px; font-weight: 700; color: var(--text2); background: var(--bg); padding: 4px 10px; border-radius: 6px; border: 1px solid var(--border); white-space: nowrap;"
                                        x-text="cat"></span>
                                </template>
                            </div>
                        </td>

                        {{-- Amount --}}
                        <td style="padding: 15px 20px; font-weight: 800; color: var(--text);">
                            ₹<span x-text="parseFloat(order.total_amount).toLocaleString('en-IN')"></span>
                        </td>

                        {{-- Payment Method --}}
                        <td style="padding: 15px 20px;">
                            <span x-show="order.payment_method === 'cod'"
                                style="display: inline-block; white-space: nowrap; padding: 3px 10px; border-radius: 8px; font-size: 9px; font-weight: 800; background: #FFF7ED; color: #C2410C; border: 1px solid #FED7AA;">
                                Cash on Delivery
                            </span>
                            <span x-show="order.payment_method !== 'cod'"
                                style="display: inline-block; white-space: nowrap; padding: 3px 10px; border-radius: 8px; font-size: 9px; font-weight: 800; background: #EEF2FF; color: #4338CA; border: 1px solid #C7D2FE;">
                                Online
                            </span>
                        </td>

                        {{-- Payment Status --}}
                        <td style="padding: 15px 20px;">
                            <span
                                :style="order.payment_status === 'completed' ?
                                    'background:#DCFCE7; color:#15803D; border:1px solid #BBF7D0;' :
                                    'background:#FEF9C3; color:#854D0E; border:1px solid #FDE68A;'"
                                style="font-size: 9px; padding: 3px 10px; border-radius: 8px; font-weight: 800; display: inline-block;"
                                x-text="order.payment_status === 'completed' ? 'Completed' : 'Pending'">
                            </span>
                        </td>

                        {{-- Date --}}
                        <td style="padding: 15px 20px;">
                            <span style="font-size: 11px; font-weight: 700; color: var(--text2);"
                                x-text="formatDate(order.created_at)"></span>
                            <span x-show="order.paid_at"
                                style="display: block; font-size: 9px; color: #16a34a; margin-top: 2px; font-weight: 700;"
                                x-text="order.paid_at ? 'Paid: ' + formatDate(order.paid_at) : ''"></span>
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 15px 20px; text-align: right;">
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 8px;">

                                {{-- View --}}
                                <a :href="'/admin/payments/' + order.id" class="icon-btn"
                                    style="background: var(--card2);" title="View Order">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                {{-- "Mark as Completed" button --}}
                                <template x-if="order.payment_method === 'cod' && order.payment_status === 'pending'">
                                    <button @click="markCodPaid(order)" :disabled="order.marking"
                                        title="Mark as Completed and Assign QR Codes"
                                        style="display: inline-flex; align-items: center; gap: 5px; height: 32px; padding: 0 12px; border-radius: 8px; font-size: 10px; font-weight: 800; color: white; border: none; cursor: pointer; white-space: nowrap;"
                                        :style="order.marking ? 'background:#9CA3AF; cursor:not-allowed;' :
                                            'background:#F97316;'">
                                        <span x-show="!order.marking">Mark as Completed</span>
                                        <span x-show="order.marking">Processing...</span>
                                    </button>
                                </template>

                            </div>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div x-show="pagination.last_page > 1"
        style="padding: 15px 20px; background: var(--card2); border-top: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
        <span style="font-size: 10px; font-weight: 800; color: var(--text3); text-transform: uppercase;">
            Page <span x-text="pagination.current_page"></span> of <span x-text="pagination.last_page"></span>
            &nbsp;·&nbsp; <span x-text="pagination.total"></span> orders
        </span>
        <div style="display: flex; gap: 8px;">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                class="btn-outline" style="padding: 5px 12px; font-size: 11px; border-radius: 8px;">← Prev</button>
            <button @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                style="padding: 5px 12px; font-size: 11px; border-radius: 8px;">Next →</button>
        </div>
    </div>
</div>
