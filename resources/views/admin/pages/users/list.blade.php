@extends('admin.main.app')
@section('admin-title', 'Customers')
@section('topbar-text', 'Customer Management')

@section('admin-css')
<style>
    /* Corporate Users/Customers List */
    .users-container {
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
    }
    
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card.blue { border-left-color: #3498db; }
    .stat-card.green { border-left-color: #27ae60; }
    .stat-card.purple { border-left-color: #9b59b6; }
    
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
    
    /* Filter Section */
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
    
    /* Users Card */
    .users-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header-custom {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .card-header-custom h4 {
        color: white;
        margin: 0;
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    /* Table Styles */
    .table-container {
        padding: 0;
        overflow-x: auto;
    }
    
    .users-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .users-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .users-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .users-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .users-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .users-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .user-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9375rem;
    }
    
    .email-cell,
    .phone-cell,
    .date-cell {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .email-icon {
        color: #3498db;
        font-size: 1.125rem;
    }
    
    .phone-icon {
        color: #27ae60;
        font-size: 1.125rem;
    }
    
    .date-icon {
        color: #9b59b6;
        font-size: 1.125rem;
    }
    
    .badge-custom {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .badge-orders { background: #e3f2fd; color: #1976d2; }
    
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
    }
    
    .btn-view {
        background: #3498db;
        color: white;
    }
    
    .btn-view:hover {
        background: #2980b9;
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
        
        .users-table {
            font-size: 0.875rem;
        }
        
        .users-table thead th,
        .users-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            font-size: 0.75rem;
        }
    }
    
    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .modal-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border-radius: 16px 16px 0 0;
        padding: 1.5rem;
        border: none;
    }
    
    .modal-header .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
    }
    
    .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
    }
    
    .modal-header .btn-close:hover {
        opacity: 1;
    }
    
    .modal-body {
        padding: 0;
    }
    
    /* User Details Modal */
    .user-details-modal {
        padding: 2rem;
    }
    
    .user-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e9ecef;
        margin-bottom: 1.5rem;
    }
    
    .user-avatar-large {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.5rem;
        flex-shrink: 0;
    }
    
    .user-info-header {
        flex: 1;
    }
    
    .user-name-large {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 0.5rem 0;
    }
    
    .user-contact-info {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .contact-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #7f8c8d;
        font-size: 0.9375rem;
    }
    
    .contact-item iconify-icon {
        font-size: 1.125rem;
        color: #3498db;
    }
    
    .user-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }
    
    .stat-icon.blue { background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); }
    .stat-icon.green { background: linear-gradient(135deg, #27ae60 0%, #229954 100%); }
    .stat-icon.orange { background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); }
    
    .stat-content {
        flex: 1;
    }
    
    .stat-box .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }
    
    .stat-box .stat-label {
        font-size: 0.8125rem;
        color: #7f8c8d;
        margin: 0;
        text-transform: uppercase;
    }
    
    .section-box {
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .section-title iconify-icon {
        color: #e74c3c;
        font-size: 1.5rem;
    }
    
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .order-item {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .order-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    
    .order-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .order-id {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1rem;
    }
    
    .order-date {
        font-size: 0.8125rem;
        color: #7f8c8d;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .order-details {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
    }
    
    .order-amount {
        font-weight: 700;
        color: #27ae60;
        font-size: 1.125rem;
    }
    
    .order-status {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }
    
    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #cfe2ff; color: #084298; }
    .status-completed { background: #d1e7dd; color: #0f5132; }
    .status-cancelled { background: #f8d7da; color: #842029; }
    
    .addresses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .address-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
    }
    
    .address-type {
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9375rem;
    }
    
    .address-type iconify-icon {
        color: #e74c3c;
        font-size: 1.25rem;
    }
    
    .address-text {
        color: #7f8c8d;
        font-size: 0.875rem;
        line-height: 1.6;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #7f8c8d;
    }
    
    .empty-state iconify-icon {
        font-size: 3rem;
        display: block;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 0.9375rem;
    }
</style>
@endsection

@section('admin-content')

<div class="container-fluid users-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card blue">
                <h3 class="stat-value">{{ $total_users }}</h3>
                <p class="stat-label">Total Customers</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card green">
                <h3 class="stat-value">{{ $users_with_orders }}</h3>
                <p class="stat-label">Customers with Orders</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card purple">
                <h3 class="stat-value">{{ $total_orders }}</h3>
                <p class="stat-label">Total Orders</p>
            </div>
        </div>
    </div>
    
    <!-- Users Table Card with Filters -->
    <div class="users-card">
        <div class="card-header-custom">
            <h4>All Customers (<span id="totalCount">{{ $users->total() }}</span> registered)</h4>
        </div>
        
        <!-- Filter Section Inside Card -->
        <div style="padding: 1.5rem; background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
            <div class="filter-header">
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 1rem; margin: 0;">🔍 Search Customers</h5>
                <button type="button" class="btn-clear-filters" id="clearFilters">Clear Search</button>
            </div>
            <form id="filterForm">
                <div class="filter-group">
                    <label class="filter-label">Search by Name, Email or Phone</label>
                    <input type="text" name="search" class="filter-input" placeholder="Type to search..." id="searchInput">
                </div>
            </form>
        </div>
        
        <!-- Table Container -->
        <div id="usersTableContainer">
            @include('admin.pages.users.partials.users-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.users.partials.pagination')
        </div>
    </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="userDetailsContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading customer details...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
    // AJAX Filter Function
    function applyFilters(url = null) {
        const formData = $('#filterForm').serialize();
        const requestUrl = url || "{{ route('user.index') }}";
        
        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: formData,
            beforeSend: function() {
                $('#usersTableContainer').html('<div style="padding: 3rem; text-align: center;"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading customers...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#usersTableContainer').html(response.html);
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
                    text: 'Failed to load customers',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c'
                });
            }
        });
    }
    
    // Filter Form Submit
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });
    
    // Real-time Search (with debounce)
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            applyFilters();
        }, 500);
    });
    
    // Clear Filters
    $('#clearFilters').on('click', function() {
        $('#filterForm')[0].reset();
        applyFilters();
    });
    
    // Pagination Click Handler
    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        applyFilters(url);
        
        // Scroll to top of table
        $('html, body').animate({
            scrollTop: $('.users-card').offset().top - 100
        }, 500);
    });
    
    // View User Details
    $(document).on('click', '.btn-view', function() {
        const userId = $(this).closest('tr').data('id');
        const url = "{{ route('user.show', ':id') }}".replace(':id', userId);
        
        // Show modal
        $('#userDetailsModal').modal('show');
        
        // Reset content
        $('#userDetailsContent').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading customer details...</p></div>');
        
        // Load user details
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    $('#userDetailsContent').html(response.html);
                }
            },
            error: function() {
                $('#userDetailsContent').html('<div class="text-center py-5"><iconify-icon icon="solar:danger-circle-bold" style="font-size: 3rem; color: #e74c3c;"></iconify-icon><p class="mt-2 text-danger">Failed to load customer details</p></div>');
            }
        });
    });
</script>
@endsection
