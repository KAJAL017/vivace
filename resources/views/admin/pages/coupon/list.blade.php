@extends('admin.main.app')
@section('admin-title', 'Coupons')
@section('topbar-text', 'Coupon Management')

@section('admin-css')
<style>
    /* Corporate Coupon List */
    .coupon-container {
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
    
    .filter-select,
    .filter-input {
        padding: 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9375rem;
        color: #495057;
        transition: all 0.3s ease;
        background: white;
    }
    
    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    /* Coupon Card */
    .coupon-card {
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
    
    .btn-add {
        background: #27ae60;
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .btn-add:hover {
        background: #229954;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Table Styles */
    .table-container {
        padding: 0;
        overflow-x: auto;
    }
    
    .coupon-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .coupon-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .coupon-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .coupon-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .coupon-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .coupon-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .coupon-code-cell {
        display: flex;
        align-items: center;
    }
    
    .coupon-code-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.875rem;
        letter-spacing: 1px;
        font-family: 'Courier New', monospace;
    }
    
    .discount-value {
        font-weight: 700;
        color: #27ae60;
        font-size: 1.125rem;
    }
    
    .date-range {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .date-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.875rem;
        color: #495057;
    }
    
    .date-icon {
        color: #3498db;
        font-size: 1rem;
    }
    
    .date-separator {
        color: #7f8c8d;
        font-weight: 700;
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
    
    .badge-percentage { background: #e3f2fd; color: #1976d2; }
    .badge-fixed { background: #fff3e0; color: #f57c00; }
    .badge-active { background: #e8f5e9; color: #388e3c; }
    .badge-inactive { background: #ffebee; color: #d32f2f; }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .btn-edit {
        background: #3498db;
        color: white;
    }
    
    .btn-edit:hover {
        background: #2980b9;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background: #e74c3c;
        color: white;
    }
    
    .btn-delete:hover {
        background: #c0392b;
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
        
        .coupon-table {
            font-size: 0.875rem;
        }
        
        .coupon-table thead th,
        .coupon-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .date-range {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }
</style>
@endsection

@section('admin-content')

<div class="container-fluid coupon-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card blue">
                <h3 class="stat-value">{{ $total_coupons }}</h3>
                <p class="stat-label">Total Coupons</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card green">
                <h3 class="stat-value">{{ $active_coupons }}</h3>
                <p class="stat-label">Active Coupons</p>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card purple">
                <h3 class="stat-value">{{ $percentage_coupons }}</h3>
                <p class="stat-label">Percentage Coupons</p>
            </div>
        </div>
    </div>
    
    <!-- Coupon Table Card with Filters -->
    <div class="coupon-card">
        <div class="card-header-custom">
            <h4>All Coupons (<span id="totalCount">{{ $coupons->total() }}</span> items)</h4>
            <a href="{{ route('coupon.create') }}" class="btn-add">+ Add Coupon</a>
        </div>
        
        <!-- Filter Section Inside Card -->
        <div style="padding: 1.5rem; background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
            <div class="filter-header">
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 1rem; margin: 0;">🔍 Filter Coupons</h5>
                <button type="button" class="btn-clear-filters" id="clearFilters">Clear All</button>
            </div>
            <form id="filterForm">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Search</label>
                        <input type="text" name="search" class="filter-input" placeholder="Search by coupon code..." id="searchInput">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Type</label>
                        <select name="type" class="filter-select" id="typeFilter">
                            <option value="">All Types</option>
                            <option value="1">Percentage</option>
                            <option value="0">Fixed</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Table Container -->
        <div id="couponTableContainer">
            @include('admin.pages.coupon.partials.coupon-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.coupon.partials.pagination')
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
    // AJAX Filter Function
    function applyFilters(url = null) {
        const formData = $('#filterForm').serialize();
        const requestUrl = url || "{{ route('coupon.index') }}";
        
        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: formData,
            beforeSend: function() {
                $('#couponTableContainer').html('<div style="padding: 3rem; text-align: center;"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading coupons...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#couponTableContainer').html(response.html);
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
                    text: 'Failed to load coupons',
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
    
    // Filter Change Events
    $('#statusFilter, #typeFilter').on('change', function() {
        applyFilters();
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
            scrollTop: $('.coupon-card').offset().top - 100
        }, 500);
    });
    
    // Delete Coupon
    $(document).ready(function () {
        // Set CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var deleteUrl = "{{ route('coupon.destroy', ['id' => ':id']) }}";

        $(document).on('click', '.delete-btn', function () {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var url = deleteUrl.replace(':id', id);

            Swal.fire({
                title: "Delete Coupon?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function (response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Coupon deleted successfully",
                                icon: "success",
                                confirmButtonColor: '#27ae60',
                                timer: 2000
                            }).then(() => {
                                applyFilters(); // Reload with current filters
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                title: "Error!",
                                text: "Failed to delete coupon",
                                icon: "error",
                                confirmButtonColor: '#e74c3c'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
