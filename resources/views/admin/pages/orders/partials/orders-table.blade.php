<div class="table-container">
    <table class="orders-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 12%;">Order ID</th>
                <th style="width: 18%;">Customer</th>
                <th style="width: 15%;">Contact</th>
                <th style="width: 15%;">Order Date</th>
                <th style="width: 12%;">Amount</th>
                <th style="width: 13%;">Status</th>
                <th style="width: 10%;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $key => $order)
            <tr data-id="{{ $order->id }}">
                <td>{{ $orders->firstItem() + $key }}</td>
                <td>
                    <div class="order-id-cell">
                        <iconify-icon icon="solar:tag-bold" class="order-icon"></iconify-icon>
                        <span class="order-id-text">{{ $order->custom_order_id }}</span>
                    </div>
                </td>
                <td>
                    <div class="customer-info">
                        <div class="customer-avatar">
                            {{ strtoupper(substr($order->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="customer-details">
                            <span class="customer-name">{{ $order->name ?? 'N/A' }}</span>
                            <span class="customer-email">{{ $order->email ?? 'N/A' }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="contact-cell">
                        <iconify-icon icon="solar:phone-bold" class="contact-icon"></iconify-icon>
                        <span>{{ $order->phone ?? 'N/A' }}</span>
                    </div>
                </td>
                <td>
                    <div class="date-cell">
                        <div class="date-info">
                            <iconify-icon icon="solar:calendar-bold" class="date-icon"></iconify-icon>
                            <span class="date-text">
                                @php
                                    $orderDate = null;
                                    if(isset($order->date)) {
                                        try {
                                            // Try parsing the date format: d-m-Y H:i:s A
                                            $orderDate = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s A', $order->date);
                                        } catch (\Exception $e) {
                                            try {
                                                // Try parsing without time
                                                $orderDate = \Carbon\Carbon::createFromFormat('d-m-Y', $order->date);
                                            } catch (\Exception $e2) {
                                                try {
                                                    // Try standard format
                                                    $orderDate = \Carbon\Carbon::parse($order->date);
                                                } catch (\Exception $e3) {
                                                    $orderDate = null;
                                                }
                                            }
                                        }
                                    }
                                @endphp
                                @if($orderDate)
                                    {{ $orderDate->format('d M Y') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        @if($orderDate)
                            <span class="time-text">{{ $orderDate->format('h:i A') }}</span>
                        @endif
                    </div>
                </td>
                <td>
                    <span class="amount-text">₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                </td>
                <td>
                    @if($order->is_deliverd == 1)
                        <span class="badge-status badge-delivered">
                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                            Delivered
                        </span>
                    @elseif($order->is_cancel == 1)
                        <span class="badge-status badge-cancelled">
                            <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                            Cancelled
                        </span>
                    @elseif($order->is_confirm == 1)
                        <span class="badge-status badge-ongoing">
                            <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                            Ongoing
                        </span>
                    @else
                        <span class="badge-status badge-latest">
                            <iconify-icon icon="solar:star-bold"></iconify-icon>
                            Latest
                        </span>
                    @endif
                </td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('order.view', $order->custom_order_id) }}" class="btn-action btn-view" title="View Details">
                            <iconify-icon icon="solar:eye-bold"></iconify-icon>
                        </a>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 3rem; color: #7f8c8d;">
                    <iconify-icon icon="solar:inbox-line-broken" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></iconify-icon>
                    <p style="margin: 0; font-size: 1rem; font-weight: 600;">No orders found</p>
                    <p style="margin: 0.5rem 0 0 0; font-size: 0.875rem;">Try adjusting your filters</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
