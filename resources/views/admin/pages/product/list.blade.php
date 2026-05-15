@extends('admin.main.app')
@section('admin-title', 'Products')
@section('topbar-text', 'Product Management')

@section('admin-css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Corporate Product List */
    .product-container {
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
    .stat-card.orange { border-left-color: #f39c12; }
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
    
    /* Filter Section */
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    
    /* Custom Select2 Styling */
    .select2-container--default .select2-selection--single {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        height: auto;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #495057;
        line-height: 1.5;
        padding: 0;
        font-size: 0.9375rem;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100%;
        right: 10px;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        color: #6c757d;
    }
    
    .select2-dropdown {
        border: 2px solid #2c3e50;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background: #f8f9fa;
        color: #2c3e50;
        font-weight: 600;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        padding: 0.5rem;
        font-size: 0.9375rem;
    }
    
    .select2-container--default .select2-search--dropdown .select2-search__field:focus {
        border-color: #2c3e50;
        outline: none;
    }
    
    .select2-results__option {
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    /* Product Card */
    .product-card {
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
    
    .product-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .product-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .product-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .product-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .product-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .product-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .product-image-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .product-thumb {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }
    
    .product-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9375rem;
    }
    
    .badge-custom {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-category { background: #e3f2fd; color: #1976d2; }
    .badge-subcategory { background: #f3e5f5; color: #7b1fa2; }
    .badge-brand { background: #fff3e0; color: #f57c00; }
    .badge-collection { background: #e8f5e9; color: #388e3c; }
    
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
        display: inline-block;
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
        
        .pagination-info {
            font-size: 0.8125rem;
        }
        
        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
            min-width: 40px;
        }
        
        .pagination {
            gap: 0.375rem;
        }
        
        .product-table {
            font-size: 0.875rem;
        }
        
        .product-table thead th,
        .product-table tbody td {
            padding: 0.75rem 0.5rem;
        }
        
        .product-thumb {
            width: 50px;
            height: 50px;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid product-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card blue">
                <h3 class="stat-value">{{ $total_products }}</h3>
                <p class="stat-label">Total Products</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card green">
                <h3 class="stat-value">{{ $active_products }}</h3>
                <p class="stat-label">Active Products</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card orange">
                <h3 class="stat-value">{{ $out_of_stock }}</h3>
                <p class="stat-label">Out of Stock</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card red">
                <h3 class="stat-value">{{ $categories_count }}</h3>
                <p class="stat-label">Categories</p>
            </div>
        </div>
    </div>
    
    <!-- Product Table Card with Filters -->
    <div class="product-card">
        <div class="card-header-custom">
            <h4>All Products (<span id="totalCount">{{ $products->total() }}</span> items)</h4>
            <a href="{{ route('product.create') }}" class="btn-add">+ Add Product</a>
        </div>
        
        <!-- Filter Section Inside Card -->
        <div style="padding: 1.5rem; background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
            <div class="filter-header" style="margin-bottom: 1rem;">
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 1rem; margin: 0;">🔍 Filter Products</h5>
                <button type="button" class="btn-clear-filters" id="clearFilters">Clear All</button>
            </div>
            <form id="filterForm">
                <div class="filter-row">
                    <div class="filter-group">
                        <label class="filter-label">Search By</label>
                        <select name="search_type" class="filter-select" id="searchType">
                            <option value="name">Product Name</option>
                            <option value="sku">SKU</option>
                            <option value="category">Category</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Search</label>
                        <input type="text" name="search" class="filter-input" placeholder="Search products..." id="searchInput">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Category</label>
                        <select name="category" class="filter-select" id="categoryFilter">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Brand</label>
                        <select name="brand" class="filter-select" id="brandFilter">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Collection</label>
                        <select name="collection" class="filter-select" id="collectionFilter">
                            <option value="">All Collections</option>
                            @foreach($collections as $collection)
                                <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Table Container -->
        <div id="productTableContainer">
            @include('admin.pages.product.partials.product-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.product.partials.pagination')
        </div>
    </div>
</div>

<!-- Stock Update Modal -->
<div class="modal fade" id="stockModal" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; border-radius: 12px 12px 0 0;">
                <h5 class="modal-title" id="stockModalLabel">
                    <iconify-icon icon="solar:box-bold"></iconify-icon>
                    Update Stock Quantity
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div id="stockModalContent"></div>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #f0f0f0; padding: 1rem 1.5rem;">
                <button type="button" class="btn" style="background: #95a5a6; color: white; padding: 0.625rem 1.5rem; border-radius: 8px; font-weight: 600;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); color: white; padding: 0.625rem 1.5rem; border-radius: 8px; font-weight: 600;" onclick="updateAllStock()">
                    <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                    Update Stock
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Initialize Select2
    $(document).ready(function() {
        // Initialize Select2 on filter dropdowns
        $('#searchType').select2({
            placeholder: 'Select search type',
            minimumResultsForSearch: -1, // Hide search box
            width: '100%'
        });
        
        $('#categoryFilter').select2({
            placeholder: 'All Categories',
            allowClear: true,
            width: '100%'
        });
        
        $('#brandFilter').select2({
            placeholder: 'All Brands',
            allowClear: true,
            width: '100%'
        });
        
        $('#collectionFilter').select2({
            placeholder: 'All Collections',
            allowClear: true,
            width: '100%'
        });
        
        // Update search input placeholder based on search type
        $('#searchType').on('change', function() {
            const searchType = $(this).val();
            let placeholder = 'Search products...';
            
            if (searchType === 'name') {
                placeholder = 'Search by product name...';
            } else if (searchType === 'sku') {
                placeholder = 'Search by SKU...';
            } else if (searchType === 'category') {
                placeholder = 'Search by category name...';
            }
            
            $('#searchInput').attr('placeholder', placeholder);
        });
    });
    
    // AJAX Filter Function
    function applyFilters(url = null) {
        const formData = $('#filterForm').serialize();
        const requestUrl = url || "{{ route('product.index') }}";
        
        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: formData,
            beforeSend: function() {
                $('#productTableContainer').html('<div style="padding: 3rem; text-align: center;"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading products...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#productTableContainer').html(response.html);
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
                    text: 'Failed to load products',
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
    $('#categoryFilter, #brandFilter, #collectionFilter').on('change', function() {
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
            scrollTop: $('.product-card').offset().top - 100
        }, 500);
    });
    
    // Delete Product
    var deleteUrl = "{{ route('product.destroy', ['id' => ':id']) }}";
    
    $(document).on('click', '.delete-btn', function() {
        var row = $(this).closest('tr');
        var id = row.data('id');
        var url = deleteUrl.replace(':id', id);

        Swal.fire({
            title: "Delete Product?",
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
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Product deleted successfully",
                            icon: "success",
                            confirmButtonColor: '#27ae60',
                            timer: 2000
                        }).then(() => {
                            applyFilters(); // Reload with current filters
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to delete product",
                            icon: "error",
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                });
            }
        });
    });
    
    // Stock Modal Functions
    let currentProductId = null;
    
    function showStockModal(productId, productName, attributes) {
        currentProductId = productId;
        
        let html = `
            <h6 style="color: #2c3e50; font-weight: 600; margin-bottom: 1rem;">Product: ${productName}</h6>
            <div style="max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa; position: sticky; top: 0;">
                        <tr>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #2c3e50; border-bottom: 2px solid #e9ecef;">Size</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #2c3e50; border-bottom: 2px solid #e9ecef;">Color</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #2c3e50; border-bottom: 2px solid #e9ecef;">Current Qty</th>
                            <th style="padding: 0.75rem; text-align: left; font-size: 0.875rem; color: #2c3e50; border-bottom: 2px solid #e9ecef;">New Qty</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        attributes.forEach(attr => {
            html += `
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 0.75rem; font-size: 0.9375rem;">${attr.size_name || 'N/A'}</td>
                    <td style="padding: 0.75rem; font-size: 0.9375rem;">${attr.color_name || 'N/A'}</td>
                    <td style="padding: 0.75rem; font-size: 0.9375rem; font-weight: 600; color: ${attr.qty <= 0 ? '#e74c3c' : (attr.qty <= 10 ? '#f39c12' : '#27ae60')}">${attr.qty}</td>
                    <td style="padding: 0.75rem;">
                        <input type="number" 
                               class="form-control stock-input" 
                               data-attr-id="${attr.id}" 
                               value="${attr.qty}" 
                               min="0"
                               style="width: 100px; padding: 0.5rem; border: 2px solid #e9ecef; border-radius: 6px; font-size: 0.9375rem;">
                    </td>
                </tr>
            `;
        });
        
        html += `
                    </tbody>
                </table>
            </div>
        `;
        
        $('#stockModalContent').html(html);
        $('#stockModal').modal('show');
    }
    
    function updateAllStock() {
        const updates = [];
        $('.stock-input').each(function() {
            updates.push({
                id: $(this).data('attr-id'),
                qty: $(this).val()
            });
        });
        
        $.ajax({
            url: "{{ route('product.update.stock') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                updates: updates
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait while we update the stock',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Stock updated successfully',
                        icon: 'success',
                        confirmButtonColor: '#27ae60',
                        timer: 2000
                    }).then(() => {
                        $('#stockModal').modal('hide');
                        applyFilters(); // Reload table
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message || 'Failed to update stock',
                        icon: 'error',
                        confirmButtonColor: '#e74c3c'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update stock',
                    icon: 'error',
                    confirmButtonColor: '#e74c3c'
                });
            }
        });
    }
</script>
@endsection
