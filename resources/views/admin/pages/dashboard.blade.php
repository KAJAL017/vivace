@extends('admin.main.app')
@section('admin-title', 'Dashboard')
@section('topbar-text', 'Dashboard Overview')

@section('admin-css')
<style>
    /* Dashboard Custom Styles */
    .stat-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.1) 0%, rgba(192, 57, 43, 0.1) 100%);
        color: #e74c3c;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #7f8c8d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-change {
        font-size: 0.8125rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .stat-change.positive {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60;
    }

    .stat-change.negative {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .chart-card {
        border-radius: 16px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .chart-card .card-header {
        background: transparent;
        border-bottom: 2px solid #f8f9fa;
        padding: 1.5rem;
    }

    .chart-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 350px;
        width: 100%;
    }

    .chart-container-small {
        position: relative;
        height: 300px;
        width: 100%;
    }

    .quick-action-btn {
        border-radius: 12px;
        padding: 1rem;
        border: 2px solid #e0e0e0;
        background: white;
        transition: all 0.3s ease;
        text-align: center;
        display: block;
        text-decoration: none;
    }

    .quick-action-btn:hover {
        border-color: #e74c3c;
        background: rgba(231, 76, 60, 0.05);
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.2);
    }

    .quick-action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.5rem;
    }

    .recent-activity {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        padding: 1rem;
        border-left: 3px solid #e74c3c;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .activity-time {
        font-size: 0.75rem;
        color: #95a5a6;
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid">
    
    <!-- Welcome Section -->
    <div class="row mb-4" style="margin-top: 2rem;">
        <div class="col-12">
            <div class="card stat-card" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="text-white mb-2">Welcome back, Admin! 👋</h2>
                            <p class="text-white-50 mb-0">Here's what's happening with your store today.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <p class="text-white-50 mb-0">Today's Date</p>
                            <h4 class="text-white mb-0">{{ date('d M, Y') }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon">
                            <iconify-icon icon="solar:dollar-bold-duotone"></iconify-icon>
                        </div>
                        <span class="stat-change positive">
                            <i class="bx bx-trending-up"></i> +12.5%
                        </span>
                    </div>
                    <h3 class="stat-value">₹{{ number_format($total_revenue ?? 0, 0) }}</h3>
                    <p class="stat-label mb-0">Total Revenue</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon">
                            <iconify-icon icon="solar:bag-smile-bold-duotone"></iconify-icon>
                        </div>
                        <span class="stat-change positive">
                            <i class="bx bx-trending-up"></i> +8.2%
                        </span>
                    </div>
                    <h3 class="stat-value">{{ $total_orders ?? 0 }}</h3>
                    <p class="stat-label mb-0">Total Orders</p>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <a href="{{ route('user.index') }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon">
                                <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
                            </div>
                            <span class="stat-change positive">
                                <i class="bx bx-trending-up"></i> +15.3%
                            </span>
                        </div>
                        <h3 class="stat-value">{{ $users }}</h3>
                        <p class="stat-label mb-0">Total Customers</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card">
                <div class="card-body p-4">
                    <a href="{{ route('product.index') }}" class="text-decoration-none">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="stat-icon">
                                <iconify-icon icon="solar:t-shirt-bold-duotone"></iconify-icon>
                            </div>
                            <span class="stat-change positive">
                                <i class="bx bx-trending-up"></i> +5.7%
                            </span>
                        </div>
                        <h3 class="stat-value">{{ $products }}</h3>
                        <p class="stat-label mb-0">Total Products</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="row g-3 mb-4">
        <!-- Brands -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('brand.index') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:star-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $brands }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Brands</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('DeliveredOrder') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $completed_orders ?? 0 }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Completed</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Ongoing Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('OngoingOrder') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:refresh-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $ongoing_orders ?? 0 }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Ongoing</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Cancelled Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('CancelOrder') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:close-circle-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $cancelled_orders ?? 0 }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Cancelled</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('latestOrder') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:clock-circle-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $pending_orders ?? 0 }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Pending</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Manual Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card stat-card">
                <div class="card-body p-3">
                    <a href="{{ route('ManualOrder') }}" class="text-decoration-none">
                        <div class="stat-icon mb-2" style="width: 50px; height: 50px; font-size: 1.5rem;">
                            <iconify-icon icon="solar:document-add-bold-duotone"></iconify-icon>
                        </div>
                        <h4 class="stat-value" style="font-size: 1.5rem;">{{ $manual_orders ?? 0 }}</h4>
                        <p class="stat-label mb-0" style="font-size: 0.75rem;">Manual</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Sales Chart -->
        <div class="col-xl-8">
            <div class="card chart-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="chart-card-title">Sales Overview</h5>
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary active sales-period-btn" data-period="week">Week</button>
                            <button class="btn btn-outline-secondary sales-period-btn" data-period="month">Month</button>
                            <button class="btn btn-outline-secondary sales-period-btn" data-period="year">Year</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Chart -->
        <div class="col-xl-4">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="chart-card-title">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container-small">
                        <canvas id="orderStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="row g-3 mb-4">
        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="chart-card-title">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('product.create') }}" class="quick-action-btn">
                                <div class="quick-action-icon">
                                    <iconify-icon icon="solar:add-circle-bold"></iconify-icon>
                                </div>
                                <p class="mb-0 fw-semibold">Add Product</p>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('latestOrder') }}" class="quick-action-btn">
                                <div class="quick-action-icon">
                                    <iconify-icon icon="solar:bag-bold"></iconify-icon>
                                </div>
                                <p class="mb-0 fw-semibold">View Orders</p>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('user.index') }}" class="quick-action-btn">
                                <div class="quick-action-icon">
                                    <iconify-icon icon="solar:users-group-rounded-bold"></iconify-icon>
                                </div>
                                <p class="mb-0 fw-semibold">Customers</p>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.settings') }}" class="quick-action-btn">
                                <div class="quick-action-icon">
                                    <iconify-icon icon="solar:settings-bold"></iconify-icon>
                                </div>
                                <p class="mb-0 fw-semibold">Settings</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-8">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="chart-card-title">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <div class="recent-activity">
                        @forelse($recent_orders as $order)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p class="mb-1 fw-semibold">New order received #{{ $order->custom_order_id ?? $order->id }}</p>
                                    <p class="mb-0 text-muted small">Customer: {{ $order->customer_name ?? 'N/A' }}</p>
                                </div>
                                <span class="activity-time">Order #{{ $order->id }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="activity-item">
                            <div class="text-center text-muted">
                                <p class="mb-0">No recent activity</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products & Categories -->
    <div class="row g-3">
        <!-- Top Selling Products -->
        <div class="col-xl-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="chart-card-title">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container-small">
                        <canvas id="topProductsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Category -->
        <div class="col-xl-6">
            <div class="card chart-card">
                <div class="card-header">
                    <h5 class="chart-card-title">Revenue by Category</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container-small">
                        <canvas id="categoryRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('admin-js')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Global variables
    let salesChart = null;
    
    // Prepare data from backend
    const orderStatusData = {
        completed: {{ $completed_orders ?? 0 }},
        ongoing: {{ $ongoing_orders ?? 0 }},
        cancelled: {{ $cancelled_orders ?? 0 }},
        pending: {{ $pending_orders ?? 0 }}
    };

    const topProductsData = @json($top_products ?? []);
    
    // Sales data from backend
    const weeklySalesData = @json($weekly_sales ?? []);
    const monthlySalesData = @json($monthly_sales ?? []);
    const yearlySalesData = @json($yearly_sales ?? []);
    
    // Prepare sales chart data
    function prepareSalesData(data, limit) {
        const labels = [];
        const values = [];
        
        if (!data || data.length === 0) {
            return { 
                labels: ['No Data'], 
                values: [0] 
            };
        }
        
        data.slice(0, limit).reverse().forEach((order, index) => {
            labels.push('Order #' + order.id);
            values.push(parseFloat(order.total_amount) || 0);
        });
        
        return { labels, values };
    }
    
    // Function to update sales chart
    function updateSalesChart(period) {
        console.log('Updating chart for period:', period);
        
        let newData;
        if (period === 'week') {
            newData = prepareSalesData(weeklySalesData, 7);
        } else if (period === 'month') {
            newData = prepareSalesData(monthlySalesData, 30);
        } else if (period === 'year') {
            newData = prepareSalesData(yearlySalesData, 365);
        }
        
        console.log('New data prepared:', newData);
        
        if (salesChart) {
            salesChart.data.labels = newData.labels;
            salesChart.data.datasets[0].data = newData.values;
            salesChart.update();
            console.log('Chart updated successfully');
        }
    }
    
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing charts...');
        
        // Initial data (weekly)
        let currentSalesData = prepareSalesData(weeklySalesData, 7);
        
        // Sales Overview Chart
        const salesCtx = document.getElementById('salesChart');
        if (!salesCtx) {
            console.error('Sales chart canvas not found!');
            return;
        }
        
        salesChart = new Chart(salesCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: currentSalesData.labels,
                datasets: [{
                    label: 'Sales (₹)',
                    data: currentSalesData.values,
                    borderColor: '#e74c3c',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Amount: ₹' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₹' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
        
        console.log('Sales chart created successfully');
        
        // Button click handlers with direct event binding
        const periodButtons = document.querySelectorAll('.sales-period-btn');
        console.log('Found period buttons:', periodButtons.length);
        
        periodButtons.forEach((btn, index) => {
            console.log('Attaching listener to button', index, 'with period:', btn.dataset.period);
            
            btn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const period = this.dataset.period;
                console.log('Button clicked! Period:', period);
                
                // Remove active class from all buttons
                periodButtons.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                // Update chart
                updateSalesChart(period);
                
                return false;
            };
        });

        // Order Status Chart
        const orderStatusCtx = document.getElementById('orderStatusChart');
        if (orderStatusCtx) {
            new Chart(orderStatusCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Completed', 'Ongoing', 'Cancelled', 'Pending'],
                    datasets: [{
                        data: [
                            orderStatusData.completed,
                            orderStatusData.ongoing,
                            orderStatusData.cancelled,
                            orderStatusData.pending
                        ],
                        backgroundColor: ['#27ae60', '#3498db', '#e74c3c', '#f39c12'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Top Products Chart
        const topProductsCtx = document.getElementById('topProductsChart');
        if (topProductsCtx) {
            const productLabels = topProductsData.map(p => p.name || 'Unknown');
            const productData = topProductsData.map(p => parseInt(p.total_sold) || 0);
            
            new Chart(topProductsCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: productLabels.length > 0 ? productLabels : ['No Data'],
                    datasets: [{
                        label: 'Units Sold',
                        data: productData.length > 0 ? productData : [0],
                        backgroundColor: '#e74c3c',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Category Revenue Chart
        const categoryRevenueCtx = document.getElementById('categoryRevenueChart');
        if (categoryRevenueCtx) {
            new Chart(categoryRevenueCtx.getContext('2d'), {
                type: 'polarArea',
                data: {
                    labels: ['Men', 'Women', 'Kids', 'Accessories', 'Footwear'],
                    datasets: [{
                        data: [45000, 52000, 28000, 18000, 35000],
                        backgroundColor: [
                            'rgba(231, 76, 60, 0.7)',
                            'rgba(52, 152, 219, 0.7)',
                            'rgba(46, 204, 113, 0.7)',
                            'rgba(241, 196, 15, 0.7)',
                            'rgba(155, 89, 182, 0.7)'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
        
        console.log('All charts initialized successfully');
    });
</script>

{{-- Google Analytics Dashboard --}}
@php
    $settings = DB::table('settings')->first();
    $ga_id = $settings->google_analytics_id ?? '';
    $ga_api_key = $settings->google_analytics_api_key ?? '';
@endphp

@if($ga_id)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="fa-brands fa-google me-2"></i> Google Analytics
                </h4>
                <a href="https://analytics.google.com" target="_blank" class="btn btn-sm btn-primary">
                    Open Analytics <i class="ri-external-link-line"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-3">
                    <strong>Measurement ID:</strong> {{ $ga_id }}
                    @if($ga_api_key)
                    <span class="ms-3"><strong>API Key:</strong> Configured</span>
                    @else
                    <span class="ms-3 text-muted">API Key: Not configured (basic tracking only)</span>
                    @endif
                </div>

                <div class="row g-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-users fa-2x mb-2"></i>
                                <h5>Real-Time Users</h5>
                                <p class="mb-0" id="ga-realtime-users">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-eye fa-2x mb-2"></i>
                                <h5>Page Views (Today)</h5>
                                <p class="mb-0" id="ga-pageviews">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-clock fa-2x mb-2"></i>
                                <h5>Avg. Session Duration</h5>
                                <p class="mb-0" id="ga-duration">Loading...</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <i class="fa-solid fa-percent fa-2x mb-2"></i>
                                <h5>Bounce Rate</h5>
                                <p class="mb-0" id="ga-bounce">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Top Pages</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="ga-top-pages">
                                        <thead>
                                            <tr>
                                                <th>Page</th>
                                                <th>Views</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="2" class="text-center">Loading...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Top Sources</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="ga-top-sources">
                                        <thead>
                                            <tr>
                                                <th>Source</th>
                                                <th>Users</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="2" class="text-center">Loading...</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <p class="text-muted">
                        <i class="fa-solid fa-circle-info me-1"></i>
                        For detailed analytics, please visit
                        <a href="https://analytics.google.com" target="_blank">Google Analytics Dashboard</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.ga-card-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // For basic tracking without API, show setup instructions
    const gaId = '{{ $ga_id }}';
    console.log('Google Analytics ID: ' + gaId);

    // Simulated data for demonstration (replace with actual API call in production)
    setTimeout(function() {
        document.getElementById('ga-realtime-users').textContent = 'View in GA';
        document.getElementById('ga-pageviews').textContent = 'View in GA';
        document.getElementById('ga-duration').textContent = 'View in GA';
        document.getElementById('ga-bounce').textContent = 'View in GA';
    }, 1000);
});
</script>
@else
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="fa-brands fa-google me-2"></i> Google Analytics
                </h4>
            </div>
            <div class="card-body text-center py-5">
                <i class="fa-brands fa-google fa-4x text-muted mb-3"></i>
                <h5>Google Analytics Not Configured</h5>
                <p class="text-muted mb-4">Add your Google Analytics Measurement ID in Settings to track your website analytics.</p>
                <a href="{{ route('admin.settings') }}" class="btn btn-primary">
                    <i class="ri-settings-3-line me-1"></i> Go to Settings
                </a>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
