
@extends('admin.main.app')
@section('admin-title', 'Order Details')
@section('topbar-text', 'Order Details')

@section('admin-css')
<style>
    /* Corporate Order Details Design */
    .order-details-container {
        padding: 2rem 0;
    }
    
    /* Order Header Card */
    .order-header-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .order-header-top {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.5rem;
        color: white;
    }
    
    .order-id-badge {
        font-size: 1.5rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .order-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .status-latest { background: #fff3cd; color: #856404; }
    .status-ongoing { background: #cfe2ff; color: #084298; }
    .status-delivered { background: #d1e7dd; color: #0f5132; }
    .status-cancelled { background: #f8d7da; color: #842029; }
    
    .order-date-text {
        font-size: 0.9375rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    
    /* Info Cards */
    .info-cards-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1.5rem;
        background: #f8f9fa;
    }
    
    .info-card-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        border-left: 4px solid #3498db;
    }
    
    .info-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .info-content h6 {
        font-size: 0.8125rem;
        color: #7f8c8d;
        font-weight: 600;
        text-transform: uppercase;
        margin: 0 0 0.25rem 0;
    }
    
    .info-content p {
        font-size: 0.9375rem;
        color: #2c3e50;
        font-weight: 600;
        margin: 0;
    }
    
    /* Products Card */
    .products-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .card-header-corporate {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.25rem 1.5rem;
        color: white;
    }
    
    .card-header-corporate h4 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
    }
    
    .products-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .products-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .products-table thead th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
    }
    
    .products-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .products-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
    }
    
    .product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-image {
        width: 70px;
        height: 70px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #f0f0f0;
    }
    
    .product-details h6 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0 0 0.5rem 0;
    }
    
    .product-meta {
        font-size: 0.8125rem;
        color: #7f8c8d;
        margin: 0.25rem 0;
    }
    
    .quantity-badge {
        background: #e9ecef;
        color: #2c3e50;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9375rem;
    }
    
    .price-text {
        font-weight: 700;
        color: #27ae60;
        font-size: 1rem;
    }
    
    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .summary-total {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .summary-total h5,
    .summary-total h4 {
        color: white;
        margin: 0;
    }
    
    .summary-total h5 {
        font-size: 1rem;
        font-weight: 600;
    }
    
    .summary-total h4 {
        font-size: 1.5rem;
        font-weight: 700;
    }
    
    /* Details Card */
    .details-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }
    
    .details-body {
        padding: 1.5rem;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        font-size: 0.875rem;
        color: #7f8c8d;
        font-weight: 500;
    }
    
    .detail-value {
        font-size: 0.9375rem;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .payment-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
    }
    
    .badge-paid { background: #d1e7dd; color: #0f5132; }
    .badge-cod { background: #fff3cd; color: #856404; }
    
    /* Customer Card */
    .customer-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 1rem;
    }
    
    .customer-avatar {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        object-fit: cover;
        border: 3px solid #e9ecef;
    }
    
    .customer-info h5 {
        font-size: 1rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0 0 0.25rem 0;
    }
    
    .customer-info a {
        font-size: 0.875rem;
        color: #3498db;
        text-decoration: none;
    }
    
    .customer-info a:hover {
        text-decoration: underline;
    }
    
    .address-section {
        margin-top: 1.5rem;
    }
    
    .address-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #2c3e50;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .address-content {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 3px solid #3498db;
    }
    
    .address-content p {
        font-size: 0.875rem;
        color: #495057;
        margin: 0.25rem 0;
        line-height: 1.6;
    }
    
    /* Action Button */
    .btn-action-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-action-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .info-cards-row {
            grid-template-columns: 1fr;
        }
        
        .products-table {
            font-size: 0.875rem;
        }
        
        .product-image {
            width: 50px;
            height: 50px;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid order-details-container">
    <div class="row">
        <!-- Left Column - Order Details -->
        <div class="col-xl-9 col-lg-8">
            
            <!-- Order Header -->
            <div class="order-header-card">
                <div class="order-header-top">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                        <div>
                            <div class="order-id-badge">
                                <iconify-icon icon="solar:tag-bold"></iconify-icon>
                                #{{ $order->custom_order_id }}
                            </div>
                            <p class="order-date-text mb-0">
                                <iconify-icon icon="solar:calendar-bold"></iconify-icon>
                                Order Date: {{ $order->date }}
                            </p>
                        </div>
                        <div>
                            @if($order->is_deliverd == 1)
                                <span class="order-status-badge status-delivered">
                                    <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                    Delivered
                                </span>
                            @elseif($order->is_cancel == 1)
                                <span class="order-status-badge status-cancelled">
                                    <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                                    Cancelled
                                </span>
                            @elseif($order->is_confirm == 1)
                                <span class="order-status-badge status-ongoing">
                                    <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
                                    Ongoing
                                </span>
                            @else
                                <span class="order-status-badge status-latest">
                                    <iconify-icon icon="solar:star-bold"></iconify-icon>
                                    Latest
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Info Cards -->
                <div class="info-cards-row">
                    <div class="info-card-item">
                        <div class="info-icon">
                            <iconify-icon icon="solar:calendar-bold"></iconify-icon>
                        </div>
                        <div class="info-content">
                            <h6>Order Date</h6>
                            <p>{{ $order->date }}</p>
                        </div>
                    </div>
                    <div class="info-card-item">
                        <div class="info-icon">
                            <iconify-icon icon="solar:clipboard-text-bold"></iconify-icon>
                        </div>
                        <div class="info-content">
                            <h6>Reference</h6>
                            <p>#{{ $order->custom_order_id }}</p>
                        </div>
                    </div>
                    <div class="info-card-item">
                        <div class="info-icon">
                            <iconify-icon icon="solar:wallet-bold"></iconify-icon>
                        </div>
                        <div class="info-content">
                            <h6>Payment Method</h6>
                            <p>{{ ucfirst($order->payment_method ?? 'N/A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Table -->
            <div class="products-card">
                <div class="card-header-corporate">
                    <h4>
                        <iconify-icon icon="solar:bag-bold"></iconify-icon>
                        Order Items
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="products-table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_items as $item)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        <img src="{{ path() }}/{{ Product_first_image($item->product_id) }}" 
                                             alt="{{ $item->product_name }}" 
                                             class="product-image">
                                        <div class="product-details">
                                            <h6>{{ $item->product_name }}</h6>
                                            <p class="product-meta">
                                                <iconify-icon icon="solar:ruler-bold"></iconify-icon>
                                                Size: {{ getSizeData($item->size_id) }}
                                            </p>
                                            <p class="product-meta">
                                                <iconify-icon icon="solar:palette-bold"></iconify-icon>
                                                Color: {{ getColorData($item->color_id) }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="quantity-badge">{{ $item->quantity }}</span>
                                </td>
                                <td>
                                    <span class="price-text">₹{{ number_format($item->price, 2) }}</span>
                                </td>
                                <td>
                                    <span class="price-text">₹{{ number_format($item->price * $item->quantity, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
        
        <!-- Right Column - Summary & Customer Details -->
        <div class="col-xl-3 col-lg-4">
            
            <!-- Order Summary -->
            <div class="summary-card">
                <div class="card-header-corporate">
                    <h4>
                        <iconify-icon icon="solar:calculator-bold"></iconify-icon>
                        Order Summary
                    </h4>
                </div>
                <div class="summary-total">
                    <h5>Total Amount</h5>
                    <h4>₹{{ number_format($order->total_amount, 2) }}</h4>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div class="details-card">
                <div class="card-header-corporate">
                    <h4>
                        <iconify-icon icon="solar:card-bold"></iconify-icon>
                        Payment Details
                    </h4>
                </div>
                <div class="details-body">
                    <div class="detail-row">
                        <span class="detail-label">Payment Method</span>
                        <span class="detail-value">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                    </div>
                    @if($order->payment_id)
                    <div class="detail-row">
                        <span class="detail-label">Payment ID</span>
                        <span class="detail-value" style="font-family: 'Courier New', monospace; font-size: 0.8125rem;">{{ $order->payment_id }}</span>
                    </div>
                    @endif
                    <div class="detail-row">
                        <span class="detail-label">Status</span>
                        @if($order->payment_id)
                            <span class="payment-badge badge-paid">Paid</span>
                        @else
                            <span class="payment-badge badge-cod">Cash on Delivery</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Customer Details -->
            <div class="details-card">
                <div class="card-header-corporate">
                    <h4>
                        <iconify-icon icon="solar:user-bold"></iconify-icon>
                        Customer Details
                    </h4>
                </div>
                <div class="details-body">
                    <div class="customer-header">
                        <img src="{{ getUser($order->user_id)->image ? path() . '/' . getUser($order->user_id)->image : path() . '/default.png' }}" 
                             alt="Customer" 
                             class="customer-avatar">
                        <div class="customer-info">
                            <h5>{{ getUser($order->user_id)->name ?? 'N/A' }}</h5>
                            <a href="mailto:{{ getUser($order->user_id)->email ?? '' }}">
                                {{ getUser($order->user_id)->email ?? 'N/A' }}
                            </a>
                            <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem; color: #7f8c8d;">
                                <iconify-icon icon="solar:phone-bold"></iconify-icon>
                                {{ getUser($order->user_id)->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Shipping Address -->
                    <div class="address-section">
                        <div class="address-title">
                            <iconify-icon icon="solar:map-point-bold"></iconify-icon>
                            Shipping Address
                        </div>
                        <div class="address-content">
                            <p><strong>{{ getAddressData($order->shipping_address_id)->name ?? 'N/A' }}</strong></p>
                            <p>{{ getAddressData($order->shipping_address_id)->address ?? 'N/A' }}</p>
                            <p>{{ getAddressData($order->shipping_address_id)->city ?? 'N/A' }}, {{ getAddressData($order->shipping_address_id)->state ?? 'N/A' }} - {{ getAddressData($order->shipping_address_id)->pincode ?? 'N/A' }}</p>
                            <p>
                                <iconify-icon icon="solar:phone-bold"></iconify-icon>
                                {{ getAddressData($order->shipping_address_id)->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    <!-- Billing Address -->
                    <div class="address-section">
                        <div class="address-title">
                            <iconify-icon icon="solar:bill-list-bold"></iconify-icon>
                            Billing Address
                        </div>
                        <div class="address-content">
                            <p><strong>{{ getAddressData($order->billing_address_id)->name ?? 'N/A' }}</strong></p>
                            <p>{{ getAddressData($order->billing_address_id)->address ?? 'N/A' }}</p>
                            <p>{{ getAddressData($order->billing_address_id)->city ?? 'N/A' }}, {{ getAddressData($order->billing_address_id)->state ?? 'N/A' }} - {{ getAddressData($order->billing_address_id)->pincode ?? 'N/A' }}</p>
                            <p>
                                <iconify-icon icon="solar:phone-bold"></iconify-icon>
                                {{ getAddressData($order->billing_address_id)->phone ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    
                    @if ($order->is_confirm == 0 && $order->is_cancel == 0)
                    <div class="address-section">
                        <button id="pushToShiprocket" class="btn-action-primary">
                            <iconify-icon icon="solar:rocket-bold"></iconify-icon>
                            Push to ShipRocket
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
    $('#pushToShiprocket').click(function() {
        const orderId = {{ $order->id }};
        
        Swal.fire({
            title: 'Push to ShipRocket?',
            text: 'This will send the order to ShipRocket for shipping.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Yes, Push it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('admin.pushToShiprocket') }}',
                    type: 'POST',
                    data: {
                        order_id: orderId,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Pushing order to ShipRocket',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        if (data.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: 'Order pushed to ShipRocket successfully.',
                                icon: 'success',
                                confirmButtonColor: '#27ae60'
                            }).then(() => {
                                window.location.href = '{{ route('orders.index') }}';
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to push order to ShipRocket.',
                                icon: 'error',
                                confirmButtonColor: '#e74c3c'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while pushing the order.',
                            icon: 'error',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
