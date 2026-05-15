@extends('admin.main.app')
@section('admin-title', 'Colors')
@section('topbar-text', 'Color Management')

@section('admin-css')
<style>
    /* Corporate Color List */
    .color-container {
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
    .filter-section {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .filter-header h5 {
        color: #2c3e50;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        font-size: 1.125rem;
    }
    
    .filter-header h5 iconify-icon {
        margin-right: 0.5rem;
        color: #e74c3c;
        font-size: 1.5rem;
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
        grid-template-columns: 1fr;
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
    
    /* Color Card */
    .color-card {
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
        font-weight: 700;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
    }
    
    .card-header-custom h4 iconify-icon {
        margin-right: 0.75rem;
        font-size: 1.75rem;
    }
    
    .btn-add-color {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    }
    
    .btn-add-color:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        color: white;
    }
    
    /* Table Styling */
    .table-container {
        padding: 2rem;
    }
    
    .corporate-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.75rem;
    }
    
    .corporate-table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        color: #2c3e50;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.875rem;
        padding: 1rem 1.5rem;
        border: none;
        letter-spacing: 0.5px;
    }
    
    .corporate-table thead th:first-child {
        border-radius: 10px 0 0 10px;
    }
    
    .corporate-table thead th:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    .corporate-table tbody tr {
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .corporate-table tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .corporate-table tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        border: none;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .corporate-table tbody td:first-child {
        border-radius: 10px 0 0 10px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .corporate-table tbody td:last-child {
        border-radius: 0 10px 10px 0;
    }
    
    .color-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
    }
    
    .hex-code {
        font-family: 'Courier New', monospace;
        background: #f8f9fa;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        color: #495057;
        font-size: 0.875rem;
    }
    
    .color-preview {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Action Buttons */
    .btn-action {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
    }
    
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(39, 174, 96, 0.4);
        background: linear-gradient(135deg, #229954 0%, #27ae60 100%);
        color: white;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        color: white;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state iconify-icon {
        font-size: 5rem;
        color: #bdc3c7;
        margin-bottom: 1rem;
    }
    
    .empty-state h3 {
        color: #7f8c8d;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        color: #95a5a6;
    }
    
    /* Pagination Styling */
    .pagination-container {
        padding: 2rem 0 1rem 0;
        border-top: 2px solid #f1f3f5;
        margin-top: 2rem;
    }
    
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .pagination-list {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 0.5rem;
    }
    
    .page-item {
        display: inline-block;
    }
    
    .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0.5rem 0.75rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        color: #495057;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        background: white;
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border-color: #2c3e50;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(44, 62, 80, 0.2);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border-color: #e74c3c;
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
    }
    
    .page-item.disabled .page-link {
        background: #f8f9fa;
        color: #adb5bd;
        border-color: #e9ecef;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .pagination-info {
        color: #6c757d;
        font-size: 0.9375rem;
        font-weight: 500;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-header-custom {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .table-container {
            padding: 1rem;
            overflow-x: auto;
        }
        
        .corporate-table {
            min-width: 700px;
        }
        
        .pagination-wrapper {
            flex-direction: column;
            text-align: center;
        }
        
        .pagination-list {
            justify-content: center;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-xxl color-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-4 col-md-6">
            <div class="stat-card">
                @php
                    $totalColors = DB::table('colors')->where('is_deleted', 0)->count();
                @endphp
                <div class="stat-value">{{ $totalColors }}</div>
                <div class="stat-label">Total Colors</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card blue">
                @php
                    $activeColors = DB::table('colors')
                        ->where('is_deleted', 0)
                        ->whereExists(function($query) {
                            $query->select(DB::raw(1))
                                  ->from('product_attributes')
                                  ->whereColumn('product_attributes.color_id', 'colors.id');
                        })
                        ->count();
                @endphp
                <div class="stat-value">{{ $activeColors }}</div>
                <div class="stat-label">Active Colors</div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="stat-card green">
                @php
                    $totalProducts = DB::table('product_attributes')
                        ->distinct('product_id')
                        ->count('product_id');
                @endphp
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Products with Colors</div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <h5>
                <iconify-icon icon="solar:filter-bold-duotone"></iconify-icon>
                Filters
            </h5>
            <button type="button" class="btn-clear-filters" id="clearFilters">
                <iconify-icon icon="solar:restart-bold" class="me-1"></iconify-icon>
                Clear Filters
            </button>
        </div>
        
        <form id="filterForm" method="GET" action="{{ route('color.index') }}">
            <div class="filter-row">
                <div class="filter-group">
                    <label class="filter-label">Search Color</label>
                    <input type="text" name="search" class="filter-input" placeholder="Search by color name..." 
                           value="{{ request('search') }}" id="searchInput">
                </div>
            </div>
        </form>
    </div>
    
    <!-- Color Table Card -->
    <div class="color-card">
        <div class="card-header-custom">
            <h4>
                <iconify-icon icon="solar:palette-bold-duotone"></iconify-icon>
                All Colors
            </h4>
            <a href="{{ route('color.create') }}" class="btn btn-add-color">
                <iconify-icon icon="solar:add-circle-bold" class="me-2"></iconify-icon>
                Add Color
            </a>
        </div>
        
        <div class="table-container" id="colorTableContainer">
            @include('admin.pages.colors.partials.color-table')
            
            <!-- Pagination -->
            @include('admin.pages.colors.partials.pagination')
        </div>
    </div>
    
</div>
@endsection

@section('admin-js')
<script>
    var deleteUrl = "{{ route('color.destroy', ['id' => ':id']) }}";
    
    $(document).ready(function() {
        // Function to load colors with AJAX
        function loadColors(page = 1) {
            let search = $('#searchInput').val();
            
            $.ajax({
                url: "{{ route('color.index') }}",
                type: 'GET',
                data: {
                    search: search,
                    page: page
                },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    // Update table and pagination
                    $('#colorTableContainer').html(response.table + response.pagination);
                    
                    // Re-bind delete buttons
                    bindDeleteButtons();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load colors',
                        confirmButtonColor: '#e74c3c'
                    });
                }
            });
        }
        
        // Search with debounce
        let searchTimeout;
        $('#searchInput').on('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadColors(1);
            }, 500);
        });
        
        // Clear filters
        $('#clearFilters').on('click', function() {
            $('#searchInput').val('');
            loadColors(1);
        });
        
        // Pagination clicks - using event delegation
        $(document).on('click', '.pagination-list .page-link', function(e) {
            e.preventDefault();
            let page = $(this).data('page');
            if (page && !$(this).parent().hasClass('disabled') && !$(this).parent().hasClass('active')) {
                loadColors(page);
            }
        });
        
        // Bind delete buttons
        function bindDeleteButtons() {
            $('.delete-btn').off('click').on('click', function() {
                var row = $(this).closest('tr');
                var id = row.data('id');
                var url = deleteUrl.replace(':id', id);

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to recover this color!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: response.message || "Color has been deleted.",
                                    icon: "success",
                                    confirmButtonColor: '#2c3e50'
                                }).then(() => {
                                    // Get current page or default to 1
                                    let currentPage = $('.pagination-list .page-item.active .page-link').data('page') || 1;
                                    loadColors(currentPage);
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "An error occurred while deleting the color.",
                                    icon: "error",
                                    confirmButtonColor: '#e74c3c'
                                });
                            }
                        });
                    }
                });
            });
        }
        
        // Initial bind
        bindDeleteButtons();
    });
</script>
@endsection
