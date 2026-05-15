<div class="table-container">
    <table class="coupon-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">Coupon Code</th>
                <th style="width: 12%;">Discount</th>
                <th style="width: 25%;">Valid Period</th>
                <th style="width: 12%;">Type</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 14%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons as $key => $coupon)
            <tr data-id="{{ $coupon->id }}">
                <td>{{ $coupons->firstItem() + $key }}</td>
                <td>
                    <div class="coupon-code-cell">
                        <span class="coupon-code-badge">{{ $coupon->coupon_code }}</span>
                    </div>
                </td>
                <td>
                    <span class="discount-value">
                        @if($coupon->coupon_type == 1)
                            {{ $coupon->discount_value }}%
                        @else
                            ${{ number_format($coupon->discount_value, 2) }}
                        @endif
                    </span>
                </td>
                <td>
                    <div class="date-range">
                        <div class="date-item">
                            <iconify-icon icon="solar:calendar-bold" class="date-icon"></iconify-icon>
                            <span>{{ \Carbon\Carbon::createFromFormat('d-m-Y', $coupon->start_date)->format('j M Y') }}</span>
                        </div>
                        <div class="date-separator">→</div>
                        <div class="date-item">
                            <iconify-icon icon="solar:calendar-bold" class="date-icon"></iconify-icon>
                            <span>{{ \Carbon\Carbon::createFromFormat('d-m-Y', $coupon->end_date)->format('j M Y') }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    @if($coupon->coupon_type == 1)
                        <span class="badge-custom badge-percentage">
                            <iconify-icon icon="solar:percent-bold"></iconify-icon>
                            Percentage
                        </span>
                    @else
                        <span class="badge-custom badge-fixed">
                            <iconify-icon icon="solar:dollar-bold"></iconify-icon>
                            Fixed
                        </span>
                    @endif
                </td>
                <td>
                    @if($coupon->status == 1)
                        <span class="badge-custom badge-active">
                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                            Active
                        </span>
                    @else
                        <span class="badge-custom badge-inactive">
                            <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                            Inactive
                        </span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn-action btn-edit">
                            <iconify-icon icon="solar:pen-2-bold"></iconify-icon>
                            Edit
                        </a>
                        <button class="btn-action btn-delete delete-btn">
                            <iconify-icon icon="solar:trash-bin-minimalistic-bold"></iconify-icon>
                            Delete
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 3rem; color: #7f8c8d;">
                    <iconify-icon icon="solar:inbox-line-broken" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></iconify-icon>
                    <p style="margin: 0; font-size: 1rem; font-weight: 600;">No coupons found</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Try adjusting your filters or create a new coupon</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
