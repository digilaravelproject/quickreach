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
</style>

<div class="table-responsive anim">
    <table class="res-table">
        <thead>
            <tr>
                <th>User Details</th>
                <th>Phone</th>
                <th>Joined Date</th>
                <th style="text-align: right;">Action</th>
            </tr>
        </thead>
        <tbody>
            <template x-if="loading">
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--text3);">Loading...</td>
                </tr>
            </template>

            <template x-for="user in users" :key="user.id">
                <tr>
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
                    <td x-text="new Date(user.created_at).toLocaleDateString('en-GB')"></td>
                    <td style="text-align: right;">
                        <a :href="'/admin/users/' + user.id" class="btn-outline"
                            style="padding: 5px 12px; font-size: 10px; text-decoration: none; border-radius: 6px; font-weight: 800;">VIEW</a>
                    </td>
                </tr>
            </template>
        </tbody>
    </table>

    {{-- Pagination Inside Table --}}
    <div class="table-footer" x-show="pagination.last_page > 1">
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
