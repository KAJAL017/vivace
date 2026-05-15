<div class="table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 30%;">Customer Name</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 20%;">Phone</th>
                <th style="width: 10%;">Orders</th>
                <th style="width: 10%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $key => $user)
            <tr data-id="{{ $user->id }}">
                <td>{{ $users->firstItem() + $key }}</td>
                <td>
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ $user->name }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="email-cell">
                        <iconify-icon icon="solar:letter-bold" class="email-icon"></iconify-icon>
                        <span>{{ $user->email ?? 'N/A' }}</span>
                    </div>
                </td>
                <td>
                    <div class="phone-cell">
                        <iconify-icon icon="solar:phone-bold" class="phone-icon"></iconify-icon>
                        <span>{{ $user->phone ?? 'N/A' }}</span>
                    </div>
                </td>
                <td>
                    @php
                        $orderCount = DB::table('orders')->where('user_id', $user->id)->count();
                    @endphp
                    <span class="badge-custom badge-orders">
                        <iconify-icon icon="solar:bag-bold"></iconify-icon>
                        {{ $orderCount }}
                    </span>
                </td>
                <td>
                    <div class="action-buttons">
                        <button class="btn-action btn-view" title="View Details">
                            <iconify-icon icon="solar:eye-bold"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 3rem; color: #7f8c8d;">
                    <iconify-icon icon="solar:users-group-rounded-broken" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></iconify-icon>
                    <p style="margin: 0; font-size: 1rem; font-weight: 600;">No customers found</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Try adjusting your search filters</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
