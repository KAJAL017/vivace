@extends('admin.main.app')
@section('admin-title', 'Products')
@section('topbar-text', 'Product Management')

@section('admin-css')
<style>
/* ===== PRODUCT LIST ===== */
.pl-wrap { padding: 24px; }

/* Stat cards */
.pl-stats {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media(max-width:991px){ .pl-stats{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:575px){ .pl-stats{ grid-template-columns: 1fr; } }

.pl-stat {
    border-radius: 14px;
    padding: 18px 20px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 3px 14px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.pl-stat:hover { transform: translateY(-3px); }
.pl-stat.s1 { background: linear-gradient(135deg,#6366f1,#818cf8); }
.pl-stat.s2 { background: linear-gradient(135deg,#10b981,#34d399); }
.pl-stat.s3 { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
.pl-stat.s4 { background: linear-gradient(135deg,#ef4444,#f87171); }

.pl-stat-icon {
    width: 48px; height: 48px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.pl-stat-val { font-size: 1.6rem; font-weight: 800; color: #fff; line-height: 1; }
.pl-stat-lbl { font-size: 0.72rem; color: rgba(255,255,255,0.85); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 3px; }

/* Main card */
.pl-card { background: #fff; border-radius: 16px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); overflow: hidden; }

/* Card header */
.pl-card-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 24px;
    background: #0f1117;
    border-bottom: 1px solid #1e2130;
}
.pl-card-title { color: #f1f5f9; font-size: 0.9rem; font-weight: 700; }
.pl-card-title span { color: #818cf8; }
.pl-btn-add {
    background: #6366f1; color: #fff;
    padding: 7px 16px; border-radius: 8px;
    text-decoration: none; font-size: 0.82rem; font-weight: 700;
    transition: background 0.2s;
}
.pl-btn-add:hover { background: #4f46e5; color: #fff; }

/* Filter bar */
.pl-filter {
    padding: 14px 24px;
    background: #f8fafc;
    border-bottom: 1px solid #e8ecf0;
    display: grid;
    grid-template-columns: 150px 1fr 1fr 1fr 1fr auto;
    gap: 10px;
    align-items: end;
}
@media(max-width:1199px){ .pl-filter{ grid-template-columns: repeat(3,1fr); } }
@media(max-width:767px) { .pl-filter{ grid-template-columns: 1fr 1fr; } }
@media(max-width:575px) { .pl-filter{ grid-template-columns: 1fr; } }

.pl-filter label { display: block; font-size: 0.68rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.pl-filter select, .pl-filter input {
    width: 100%; padding: 7px 10px;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: 0.83rem; color: #374151; background: #fff;
    transition: border-color 0.2s; outline: none;
}
.pl-filter select:focus, .pl-filter input:focus { border-color: #6366f1; }
.pl-btn-clear {
    padding: 7px 14px; background: none;
    border: 1.5px solid #e2e8f0; border-radius: 7px;
    font-size: 0.8rem; font-weight: 600; color: #64748b;
    cursor: pointer; white-space: nowrap; transition: all 0.2s; height: 36px;
}
.pl-btn-clear:hover { border-color: #ef4444; color: #ef4444; }

/* Table */
.product-table { width: 100%; border-collapse: collapse; }
.product-table thead th {
    background: #f8fafc; color: #64748b;
    font-size: 0.68rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.5px;
    padding: 10px 14px; border-bottom: 1px solid #e8ecf0;
    text-align: left; white-space: nowrap;
}
.product-table tbody td {
    padding: 11px 14px; font-size: 0.84rem; color: #374151;
    border-bottom: 1px solid #f1f5f9; vertical-align: middle;
}
.product-table tbody tr:hover td { background: #fafbfc; }
.product-table tbody tr:last-child td { border-bottom: none; }

.product-image-cell { display: flex; align-items: center; gap: 10px; }
.product-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; border: 1.5px solid #e2e8f0; flex-shrink: 0; }
.product-name { font-weight: 600; color: #1e293b; font-size: 0.84rem; }

.badge-custom { display: inline-block; padding: 3px 8px; border-radius: 5px; font-size: 0.7rem; font-weight: 700; }
.badge-category    { background: #ede9fe; color: #6d28d9; }
.badge-subcategory { background: #fce7f3; color: #be185d; }
.badge-brand       { background: #fef3c7; color: #b45309; }
.badge-collection  { background: #d1fae5; color: #065f46; }

.action-buttons { display: flex; gap: 5px; flex-wrap: wrap; }
.btn-action {
    padding: 5px 11px; border: none; border-radius: 6px;
    font-size: 0.76rem; font-weight: 700; cursor: pointer;
    text-decoration: none; display: inline-flex; align-items: center; gap: 4px;
    transition: all 0.2s;
}
.btn-edit   { background: #dbeafe; color: #1d4ed8; }
.btn-edit:hover   { background: #1d4ed8; color: #fff; }
.btn-delete { background: #fee2e2; color: #dc2626; }
.btn-delete:hover { background: #dc2626; color: #fff; }

/* Pagination */
.pagination-container {
    padding: 12px 24px;
    display: flex; justify-content: space-between; align-items: center;
    border-top: 1px solid #f1f5f9; flex-wrap: wrap; gap: 8px;
}
.pagination-info { font-size: 0.78rem; color: #94a3b8; font-weight: 500; }
.pagination { display: flex; gap: 4px; list-style: none; margin: 0; padding: 0; }
.pagination a, .pagination span {
    padding: 5px 10px; border: 1.5px solid #e2e8f0; border-radius: 6px;
    color: #374151; text-decoration: none; font-size: 0.8rem; font-weight: 600;
    display: inline-block; min-width: 34px; text-align: center; transition: all 0.2s;
}
.pagination a:hover { background: #6366f1; border-color: #6366f1; color: #fff; }
.pagination .active span { background: #6366f1; border-color: #6366f1; color: #fff; }
.pagination .disabled span, .pagination .disabled a { opacity: 0.4; pointer-events: none; }

/* Stock modal */
.stock-input { width: 90px; padding: 5px 8px; border: 1.5px solid #e2e8f0; border-radius: 6px; font-size: 0.85rem; }
.stock-input:focus { border-color: #6366f1; outline: none; }
</style>
@endsection

@section('admin-content')
<div class="pl-wrap">

    {{-- Stat Cards --}}
    <div class="pl-stats">
        <div class="pl-stat s1">
            <div class="pl-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </div>
            <div><div class="pl-stat-val">{{ $total_products }}</div><div class="pl-stat-lbl">Total Products</div></div>
        </div>
        <div class="pl-stat s2">
            <div class="pl-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div><div class="pl-stat-val">{{ $active_products }}</div><div class="pl-stat-lbl">Active</div></div>
        </div>
        <div class="pl-stat s3">
            <div class="pl-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div><div class="pl-stat-val">{{ $out_of_stock }}</div><div class="pl-stat-lbl">Out of Stock</div></div>
        </div>
        <div class="pl-stat s4">
            <div class="pl-stat-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M4 6h16M4 12h8m-8 6h16"/></svg>
            </div>
            <div><div class="pl-stat-val">{{ $categories_count }}</div><div class="pl-stat-lbl">Categories</div></div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="pl-card">

        {{-- Header --}}
        <div class="pl-card-head">
            <div class="pl-card-title">
                All Products &nbsp;<span>(<span id="totalCount">{{ $products->total() }}</span>)</span>
            </div>
            <div style="display:flex; gap:8px;">
                <a href="{{ route('product.bulk.form') }}" class="pl-btn-add" style="background:#10b981;">↑ Bulk Upload</a>
                <a href="{{ route('product.create') }}" class="pl-btn-add">+ Add Product</a>
            </div>
        </div>

        {{-- Filters --}}
        <form id="filterForm">
        <div class="pl-filter">
            <div>
                <label>Search By</label>
                <select name="search_type" id="searchType">
                    <option value="name">Product Name</option>
                    <option value="sku">SKU</option>
                    <option value="category">Category</option>
                </select>
            </div>
            <div>
                <label>Search</label>
                <input type="text" name="search" id="searchInput" placeholder="Search products...">
            </div>
            <div>
                <label>Category</label>
                <select name="category" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Brand</label>
                <select name="brand" id="brandFilter">
                    <option value="">All Brands</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Collection</label>
                <select name="collection" id="collectionFilter">
                    <option value="">All Collections</option>
                    @foreach($collections as $col)
                        <option value="{{ $col->id }}">{{ $col->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>&nbsp;</label>
                <button type="button" class="pl-btn-clear" id="clearFilters">✕ Clear</button>
            </div>
        </div>
        </form>

        {{-- Table --}}
        <div id="productTableContainer" style="overflow-x:auto;">
            @include('admin.pages.product.partials.product-table')
        </div>

        {{-- Pagination --}}
        <div id="paginationContainer">
            @include('admin.pages.product.partials.pagination')
        </div>

    </div>
</div>

{{-- Stock Modal --}}
<div class="modal fade" id="stockModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:14px; border:none; overflow:hidden;">
            <div class="modal-header" style="background:#0f1117; border-bottom:1px solid #1e2130;">
                <h5 class="modal-title" style="color:#f1f5f9; font-size:0.9rem; font-weight:700;">Update Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="filter:brightness(0) invert(1);"></button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <div id="stockModalContent"></div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:12px 20px;">
                <button type="button" class="btn" style="background:#f1f5f9;color:#374151;border-radius:8px;font-weight:600;padding:7px 18px;" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" style="background:#6366f1;color:#fff;border-radius:8px;font-weight:600;padding:7px 18px;" onclick="updateAllStock()">Update Stock</button>
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
        const requestUrl = url || "{{ route('product.index') }}";
        $.ajax({
            url: requestUrl, method: 'GET', data: formData,
            beforeSend: function() {
                $('#productTableContainer').html('<div style="padding:3rem;text-align:center;"><div class="spinner-border" style="color:#6366f1;" role="status"></div><p class="mt-2" style="color:#94a3b8;">Loading...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#productTableContainer').html(response.html);
                    $('#paginationContainer').html(response.pagination);
                    const match = response.pagination.match(/of (\d+) results/);
                    if (match) $('#totalCount').text(match[1]);
                }
            },
            error: function() { Swal.fire({ title:'Error!', text:'Failed to load products', icon:'error', confirmButtonColor:'#6366f1' }); }
        });
    }

    $('#filterForm').on('submit', function(e) { e.preventDefault(); applyFilters(); });

    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() { applyFilters(); }, 500);
    });

    $('#categoryFilter, #brandFilter, #collectionFilter, #searchType').on('change', function() { applyFilters(); });

    $('#clearFilters').on('click', function() { $('#filterForm')[0].reset(); applyFilters(); });

    $(document).on('click', '.pagination-link', function(e) {
        e.preventDefault();
        applyFilters($(this).attr('href'));
        $('html,body').animate({ scrollTop: $('.pl-card').offset().top - 80 }, 400);
    });

    // Delete
    var deleteUrl = "{{ route('product.destroy', ['id' => ':id']) }}";
    $(document).on('click', '.delete-btn', function() {
        var row = $(this).closest('tr');
        var id  = row.data('id');
        var url = deleteUrl.replace(':id', id);
        Swal.fire({ title:"Delete Product?", text:"This cannot be undone!", icon:"warning", showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#94a3b8', confirmButtonText:'Yes, Delete' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({ url:url, method:'DELETE',
                    success: function() { Swal.fire({ title:"Deleted!", icon:"success", timer:1500, showConfirmButton:false }).then(() => applyFilters()); },
                    error:   function() { Swal.fire({ title:"Error!", text:"Failed to delete", icon:"error" }); }
                });
            }
        });
    });

    // Bulk
    let selectedProducts = [];

    $(document).on('change', '#selectAll', function() {
        $('.product-checkbox').prop('checked', $(this).is(':checked'));
        updateSelectedProducts();
    });
    $(document).on('change', '.product-checkbox', function() {
        updateSelectedProducts();
        var total = $('.product-checkbox').length, checked = $('.product-checkbox:checked').length;
        $('#selectAll').prop('checked', total === checked);
    });
    function updateSelectedProducts() {
        selectedProducts = [];
        $('.product-checkbox:checked').each(function() { selectedProducts.push($(this).val()); });
        if (selectedProducts.length > 0) { $('#bulkActionsBar').css('display','flex'); $('#selectedCount').text(selectedProducts.length); }
        else { $('#bulkActionsBar').hide(); }
    }
    $(document).on('click', '#deselectAllBtn', function() { $('.product-checkbox, #selectAll').prop('checked', false); updateSelectedProducts(); });

    $(document).on('click', '#bulkDeleteBtn', function() {
        if (!selectedProducts.length) return;
        Swal.fire({ title:`Delete ${selectedProducts.length} Product(s)?`, text:"Cannot be undone!", icon:"warning", showCancelButton:true, confirmButtonColor:'#ef4444', confirmButtonText:'Yes, Delete All' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({ url:"{{ route('product.bulk.delete') }}", method:'POST',
                    data: { _token:"{{ csrf_token() }}", product_ids: selectedProducts },
                    beforeSend: function() { Swal.fire({ title:'Deleting...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() }); },
                    success: function(res) {
                        if (res.success) { Swal.fire({ title:"Deleted!", text:`${res.deleted_count} deleted`, icon:"success", timer:1500, showConfirmButton:false }).then(() => { selectedProducts=[]; $('#selectAll').prop('checked',false); applyFilters(); }); }
                        else { Swal.fire({ title:"Error!", text:res.message, icon:"error" }); }
                    }
                });
            }
        });
    });

    $(document).on('click', '#bulkOutOfStockBtn', function() {
        if (!selectedProducts.length) return;
        Swal.fire({ title:`Move ${selectedProducts.length} to Out of Stock?`, text:"Sets qty to 0", icon:"warning", showCancelButton:true, confirmButtonColor:'#f59e0b', confirmButtonText:'Yes, Move' })
        .then((r) => {
            if (r.isConfirmed) {
                $.ajax({ url:"{{ route('product.bulk.outofstock') }}", method:'POST',
                    data: { _token:"{{ csrf_token() }}", product_ids: selectedProducts },
                    beforeSend: function() { Swal.fire({ title:'Processing...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() }); },
                    success: function(res) {
                        if (res.success) { Swal.fire({ title:"Done!", text:`${res.updated_count} updated`, icon:"success", timer:1500, showConfirmButton:false }).then(() => { selectedProducts=[]; $('#selectAll').prop('checked',false); applyFilters(); }); }
                        else { Swal.fire({ title:"Error!", text:res.message, icon:"error" }); }
                    }
                });
            }
        });
    });

    // Stock Modal
    let currentProductId = null;
    function showStockModal(productId, productName, attributes) {
        currentProductId = productId;
        let html = `<p style="font-weight:700;color:#1e293b;margin-bottom:12px;">${productName}</p>
            <div style="max-height:380px;overflow-y:auto;">
            <table style="width:100%;border-collapse:collapse;">
            <thead><tr style="background:#f8fafc;">
                <th style="padding:8px 12px;font-size:0.72rem;color:#64748b;text-transform:uppercase;border-bottom:1px solid #e8ecf0;">Size</th>
                <th style="padding:8px 12px;font-size:0.72rem;color:#64748b;text-transform:uppercase;border-bottom:1px solid #e8ecf0;">Color</th>
                <th style="padding:8px 12px;font-size:0.72rem;color:#64748b;text-transform:uppercase;border-bottom:1px solid #e8ecf0;">Current</th>
                <th style="padding:8px 12px;font-size:0.72rem;color:#64748b;text-transform:uppercase;border-bottom:1px solid #e8ecf0;">New Qty</th>
            </tr></thead><tbody>`;
        attributes.forEach(attr => {
            const color = attr.qty <= 0 ? '#ef4444' : (attr.qty <= 10 ? '#f59e0b' : '#10b981');
            html += `<tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:9px 12px;font-size:0.84rem;">${attr.size_name||'N/A'}</td>
                <td style="padding:9px 12px;font-size:0.84rem;">${attr.color_name||'N/A'}</td>
                <td style="padding:9px 12px;font-size:0.84rem;font-weight:700;color:${color};">${attr.qty}</td>
                <td style="padding:9px 12px;"><input type="number" class="stock-input" data-attr-id="${attr.id}" value="${attr.qty}" min="0"></td>
            </tr>`;
        });
        html += `</tbody></table></div>`;
        $('#stockModalContent').html(html);
        $('#stockModal').modal('show');
    }

    function updateAllStock() {
        const updates = [];
        $('.stock-input').each(function() { updates.push({ id:$(this).data('attr-id'), qty:$(this).val() }); });
        $.ajax({ url:"{{ route('product.update.stock') }}", method:'POST',
            data: { _token:"{{ csrf_token() }}", updates:updates },
            beforeSend: function() { Swal.fire({ title:'Updating...', allowOutsideClick:false, didOpen:()=>Swal.showLoading() }); },
            success: function(res) {
                if (res.success) { Swal.fire({ title:'Updated!', icon:'success', timer:1500, showConfirmButton:false }).then(() => { $('#stockModal').modal('hide'); applyFilters(); }); }
                else { Swal.fire({ title:'Error!', text:res.message||'Failed', icon:'error' }); }
            },
            error: function() { Swal.fire({ title:'Error!', text:'Failed to update stock', icon:'error' }); }
        });
    }
</script>
@endsection
