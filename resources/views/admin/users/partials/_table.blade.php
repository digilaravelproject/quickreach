<style>
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
    }

    .res-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .res-table th {
        background: var(--card2);
        padding: 12px 20px;
        text-align: left;
        font-size: 10px;
        font-weight: 800;
        color: var(--text3);
        text-transform: uppercase;
        white-space: nowrap;
    }

    .res-table td {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border);
        font-size: 13px;
        color: var(--text);
        white-space: nowrap;
    }

    /* Pagination inside table footer */
    .table-footer {
        padding: 12px 20px;
        background: var(--card2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid var(--border);
    }

    /* Circle Loader Style */
    .loader-circle {
        border: 3px solid var(--border);
        border-top: 3px solid var(--text);
        border-radius: 50%;
        width: 28px;
        height: 28px;
        animation: spin 1s linear infinite;
        margin: 0 auto 10px auto;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<div class="table-responsive anim">
    <table class="res-table">
        <thead>
            <tr>
                <th style="width: 40px; text-align: center;">
                    <input type="checkbox" x-model="selectAll" @change="toggleSelectAll()" style="cursor: pointer;">
                </th>
                <th>User Details</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Joined Date</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- 1. Loading State with Circle Spinner --}}
            <template x-if="loading">
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px 20px;">
                        <div class="loader-circle"></div>
                        <div style="font-size: 12px; font-weight: 700; color: var(--text3);">Loading Users...</div>
                    </td>
                </tr>
            </template>

            {{-- 2. Empty State (Not Found Message) --}}
            <template x-if="!loading && users.length === 0">
                <tr>
                    <td colspan="6" style="text-align: center; padding: 60px 20px;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="width: 48px; height: 48px; color: var(--text3); margin-bottom: 12px; opacity: 0.5;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                            </path>
                        </svg>
                        <div style="font-size: 15px; font-weight: 800; color: var(--text2);">No Users Found</div>
                        <div style="font-size: 12px; color: var(--text3); margin-top: 4px;">We couldn't find any users
                            matching your criteria.</div>
                    </td>
                </tr>
            </template>

            {{-- 3. Data Loop --}}
            <template x-for="user in users" :key="user.id">
                <tr x-show="!loading">
                    <td style="text-align: center;">
                        <input type="checkbox" :value="user.id" x-model="selectedUsers" style="cursor: pointer;">
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 30px; border-radius: 8px; background: var(--text); color: var(--bg); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 12px;"
                                x-text="user.name.charAt(0)"></div>
                            <div style="text-align: left;">
                                <div style="font-weight: 700;" x-text="user.name"></div>
                                <div style="font-size: 10px; color: var(--text3);" x-text="user.email"></div>
                            </div>
                        </div>
                    </td>
                    <td x-text="user.phone || 'N/A'"></td>
                    <td>
                        <button @click="toggleUserStatus(user)"
                            style="padding: 4px 10px; font-size: 10px; font-weight: 800; border-radius: 6px; cursor: pointer; border: none; transition: 0.2s;"
                            x-text="user.is_active ? 'ACTIVE' : 'INACTIVE'"
                            :style="user.is_active ? 'background: #e0f2f1; color: #00695c;' :
                                'background: #ffebee; color: #c62828;'">
                        </button>
                    </td>
                    <td x-text="new Date(user.created_at).toLocaleDateString('en-GB')"></td>
                    <td style="text-align: right;">
                        <a :href="'/admin/users/' + user.id" class="btn-outline"
                            style="padding: 5px 12px; font-size: 10px; text-decoration: none; border-radius: 6px; font-weight: 800; display: inline-flex; align-items: center; gap: 5px;">

                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width:14px; height:14px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>

                            VIEW
                        </a>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>

    {{-- Pagination Inside Table (Hidden when there's no data) --}}
    <div class="table-footer" x-show="users.length > 0 && pagination.last_page > 1">
        <span style="font-size: 10px; font-weight: 800; color: var(--text3);">
            PAGE <span x-text="pagination.current_page"></span> OF <span x-text="pagination.last_page"></span>
        </span>
        <div style="display: flex; gap: 5px;">
            <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
                class="btn-outline"
                style="padding: 4px 10px; font-size: 10px; font-weight: 800; cursor: pointer;">PREV</button>
            <button @click="changePage(pagination.current_page + 1)"
                :disabled="pagination.current_page === pagination.last_page" class="btn-outline"
                style="padding: 4px 10px; font-size: 10px; font-weight: 800; cursor: pointer;">NEXT</button>
        </div>
    </div>
</div>
