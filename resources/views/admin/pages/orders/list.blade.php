@extends('admin.main.app')
@section('admin-title', 'Orders')
@section('topbar-text', 'Order Management')

@section('admin-css')
<style>
    /* Corporate Orders Management */
    .orders-container {
        padding: 2rem 0;
    }
    
    /* Stats Cards */
    .stats-row {
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border-left: 4px solid #e74c3c;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card.blue { border-left-color: #3498db; }
    .stat-card.orange { border-left-color: #f39c12; }
    .stat-card.green { border-left-color: #27ae60; }
    .stat-card.red { border-left-color: #e74c3c; }
    
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
        margin-top: 0.5rem;
    }
    
    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }
    
    .filter-tab {
        background: white;
        border: 2px solid #e9ecef;
        color: #7f8c8d;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-tab:hover {
        border-color: #2c3e50;
        color: #2c3e50;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-color: #2c3e50;
        color: white;
    }
    
    /* Orders Card */
    .orders-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.5rem;
    }
    
    .card-header-custom h4 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    /* Filter Section */
    .filter-section {
        padding: 1.5rem;
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .btn-clear-filters {
        background: transparent;
        border: 2px solid #e74c3c;
        color: #e74c3c;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-clear-filters:hover {
        background: #e74c3c;
        color: white;
    }
    
    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    
    .filter-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-input {
        padding: 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9375rem;
        color: #495057;
        transition: all 0.3s ease;
        background: white;
    }
    
    .filter-input:focus {
        outline: none;
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    /* Table Styles */
    .table-container {
        padding: 0;
        overflow-x: auto;
    }
    
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .orders-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .orders-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .orders-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .orders-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .orders-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .order-id-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .order-icon {
        color: #3498db;
        font-size: 1.125rem;
    }
    
    .order-id-text {
        font-weight: 700;
        color: #2c3e50;
        font-family: 'Courier New', monospace;
    }
    
    .customer-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
        flex-shrink: 0;
    }
    
    .customer-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .customer-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9375rem;
    }
    
    .customer-email {
        font-size: 0.8125rem;
        color: #7f8c8d;
    }
    
    .contact-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .contact-icon {
        color: #27ae60;
        font-size: 1.125rem;
    }
    
    .date-cell {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .date-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .date-icon {
        color: #e74c3c;
        font-size: 1.125rem;
    }
    
    .date-text {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
    }
    
    .time-text {
        font-size: 0.75rem;
        color: #95a5a6;
        margin-left: 1.625rem;
    }
    
    .amount-text {
        font-weight: 700;
        color: #27ae60;
        font-size: 1.125rem;
    }
    
    .badge-status {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .badge-latest { background: #fff3cd; color: #856404; }
    .badge-ongoing { background: #cfe2ff; color: #084298; }
    .badge-delivered { background: #d1e7dd; color: #0f5132; }
    .badge-cancelled { background: #f8d7da; color: #842029; }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-action {
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        font-size: 1.125rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        text-decoration: none;
    }
    
    .btn-view {
        background: #3498db;
        color: white;
    }
    
    .btn-view:hover {
        background: #2980b9;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Pagination */
    .pagination-container {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 2px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .pagination-info {
        color: #7f8c8d;
        font-size: 0.9375rem;
        font-weight: 500;
    }
    
    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
        margin: 0;
        padding: 0;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .pagination li {
        margin: 0;
    }
    
    .pagination a,
    .pagination span {
        padding: 0.625rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        color: #2c3e50;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        display: inline-block;
        min-width: 45px;
        text-align: center;
    }
    
    .pagination a:hover {
        background: #f8f9fa;
        border-color: #2c3e50;
        transform: translateY(-2px);
    }
    
    .pagination .active span {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-color: #2c3e50;
        color: white;
    }
    
    .pagination .disabled span,
    .pagination .disabled a {
        opacity: 0.4;
        cursor: not-allowed;
        border-color: #e9ecef;
        color: #adb5bd;
        pointer-events: none;
    }
    
    .pagination .dots {
        border: none;
        padding: 0.625rem 0.5rem;
        color: #7f8c8d;
        font-weight: 700;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            text-align: center;
        }
        
        .orders-table {
            font-size: 0.875rem;
        }
        
        .orders-table thead th,
        .orders-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .customer-avatar {
            width: 35px;
            height: 35px;
            font-size: 0.7rem;
        }
        
        .filter-tabs {
            overflow-x: auto;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid orders-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl col-md-4 col-6">
            <div class="stat-card blue" data-status="">
                <h3 class="stat-value">{{ $total_orders }}</h3>
                <p class="stat-label">Total Orders</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-6">
            <div class="stat-card orange" data-status="latest">
                <h3 class="stat-value">{{ $latest_orders }}</h3>
                <p class="stat-label">Latest</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-6">
            <div class="stat-card" data-status="ongoing">
                <h3 class="stat-value">{{ $ongoing_orders }}</h3>
                <p class="stat-label">Ongoing</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-6">
            <div class="stat-card red" data-status="cancelled">
                <h3 class="stat-value">{{ $cancelled_orders }}</h3>
                <p class="stat-label">Cancelled</p>
            </div>
        </div>
        <div class="col-xl col-md-4 col-6">
            <div class="stat-card green" data-status="delivered">
                <h3 class="stat-value">{{ $delivered_orders }}</h3>
                <p class="stat-label">Delivered</p>
            </div>
        </div>
    </div>
    
    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-status="">
            <iconify-icon icon="solar:list-bold"></iconify-icon>
            All Orders
        </button>
        <button class="filter-tab" data-status="latest">
            <iconify-icon icon="solar:star-bold"></iconify-icon>
            Latest
        </button>
        <button class="filter-tab" data-status="ongoing">
            <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
            Ongoing
        </button>
        <button class="filter-tab" data-status="cancelled">
            <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
            Cancelled
        </button>
        <button class="filter-tab" data-status="delivered">
            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
            Delivered
        </button>
    </div>
    
    <!-- Orders Table Card -->
    <div class="orders-card">
        <div class="card-header-custom">
            <h4>Orders List (<span id="totalCount">{{ $orders->total() }}</span> orders)</h4>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 1rem; margin: 0;">🔍 Search & Filter</h5>
                <button type="button" class="btn-clear-filters" id="clearFilters">Clear All</button>
            </div>
            <form id="filterForm">
                <input type="hidden" name="status" id="statusFilter" value="">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Search</label>
                        <input type="text" name="search" class="filter-input" placeholder="Order ID, Name, Email..." id="searchInput">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Start Date</label>
                        <input type="date" name="start_date" class="filter-input" id="startDate">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">End Date</label>
                        <input type="date" name="end_date" class="filter-input" id="endDate">
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Table Container -->
        <div id="ordersTableContainer">
            @include('admin.pages.orders.partials.orders-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.orders.partials.pagination')
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
    let currentStatus = '';
    
    // AJAX Filter Function
    function applyFilters(url = null) {
        const formData = $('#filterForm').serialize();
        const requestUrl = url || "{{ route('orders.index') }}";
        
        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: formData,
            beforeSend: function() {
                $('#ordersTableContainer').html('<div style="padding: 3rem; text-align: center;"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading orders...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#ordersTableContainer').html(response.html);
                    $('#paginationContainer').html(response.pagination);
                    
                    // Update total count
                    const match = response.pagination.match(/of (\d+) results/);
                    if (match) {
                        $('#totalCount').text(match[1]);
                    }
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to load orders',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c'
                });
            }
        });
    }
    
    // Filter Tab Click
    $('.filter-tab').on('click', function() {
        $('.filter-tab').removeClass('active');
        $(this).addClass('active');
        currentStatus = $(this).data('status');
        $('#statusFilter').val(currentStatus);
        applyFilters();
    });
    
    // Stat Card Click
    $('.stat-card').on('click', function() {
        const status = $(this).data('status');
        $('.filter-tab').removeClass('active');
        $('.filter-tab[data-status="' + status + '"]').addClass('active');
        currentStatus = status;
        $('#statusFilter').val(currentStatus);
        applyFilters();
    });
    
    // Real-time Search
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            applyFilters();
        }, 500);
    });
    
    // Date Filter Change
    $('#startDate, #endDate').on('change', function() {
        applyFilters();
    });
    
    // Clear Filters
    $('#clearFilters').on('click', function() {
        $('#filterForm')[0].reset();
        $('#statusFilter').val('');
        currentStatus = '';
        $('.filter-tab').removeClass('active');
        $('.filter-tab[data-status=""]').addClass('active');
        applyFilters();
    });
    
    // Pagination Click
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        applyFilters(url);
        
        $('html, body').animate({
            scrollTop: $('.orders-card').offset().top - 100
        }, 500);
    });
</script>
@endsection
