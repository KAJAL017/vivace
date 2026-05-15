@extends('admin.main.app')
@section('admin-title', 'Manual Orders')
@section('topbar-text', 'Manual Order Management')

@section('admin-css')
<style>
    /* Corporate Manual Orders Management */
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
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid orders-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card blue" data-status="">
                <h3 class="stat-value">{{ $total_orders }}</h3>
                <p class="stat-label">Total Orders</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card orange" data-status="pending">
                <h3 class="stat-value">{{ $pending_orders }}</h3>
                <p class="stat-label">Pending</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" data-status="ongoing">
                <h3 class="stat-value">{{ $ongoing_orders }}</h3>
                <p class="stat-label">Ongoing</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stat-card green" data-status="shipped">
                <h3 class="stat-value">{{ $shipped_orders }}</h3>
                <p class="stat-label">Shipped</p>
            </div>
        </div>
    </div>
    
    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" data-status="">
            <iconify-icon icon="solar:list-bold"></iconify-icon>
            All Orders
        </button>
        <button class="filter-tab" data-status="pending">
            <iconify-icon icon="solar:star-bold"></iconify-icon>
            Pending
        </button>
        <button class="filter-tab" data-status="ongoing">
            <iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
            Ongoing
        </button>
        <button class="filter-tab" data-status="shipped">
            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
            Shipped
        </button>
    </div>
    
    <!-- Orders Table Card -->
    <div class="orders-card">
        <div class="card-header-custom">
            <h4>Manual Orders List (<span id="totalCount">{{ $orders->total() }}</span> orders)</h4>
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
                        <input type="text" name="search" class="filter-input" placeholder="Order ID, Name, Mobile..." id="searchInput">
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
            @include('admin.pages.orders.partials.manual-orders-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.orders.partials.manual-pagination')
        </div>
    </div>
</div>

<!-- Address Modal -->
<div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                <h5 class="modal-title" style="color: white;" id="addressModalLabel">Order Address</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="modalName"></span></p>
                <p><strong>Mobile:</strong> <span id="modalMobile"></span></p>
                <p><strong>Alternate Mobile:</strong> <span id="modalAltMobile"></span></p>
                <p><strong>Street Address:</strong> <span id="modalStreet"></span></p>
                <p><strong>Colony:</strong> <span id="modalColony"></span></p>
                <p><strong>Pincode:</strong> <span id="modalPincode"></span></p>
                <p><strong>City:</strong> <span id="modalCity"></span></p>
                <p><strong>State:</strong> <span id="modalState"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                <h5 class="modal-title" style="color: white;" id="imageModalLabel">Images</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carouselImages"></div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                <h5 class="modal-title" style="color: white;" id="trackingModalLabel">Update Tracking Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="trackingForm">
                    <input type="hidden" id="order_id">
                    <div class="mb-3">
                        <label for="tracking_id" class="form-label">Tracking ID</label>
                        <input type="text" class="form-control" id="tracking_id" placeholder="Enter Tracking ID" required>
                    </div>
                    <div class="mb-3">
                        <label for="tracking_link" class="form-label">Tracking Link</label>
                        <input type="url" class="form-control" id="tracking_link" placeholder="Enter Tracking Link" required>
                    </div>
                    <div class="mb-3">
                        <label for="tracking_slip" class="form-label">Upload Tracking Slip (Optional)</label>
                        <input type="file" class="form-control" id="tracking_slip">
                        <div id="tracking_slip_preview"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="background: #2c3e50; border-color: #2c3e50;">Submit</button>
                    </div>
                </form>
            </div>
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
        const requestUrl = url || "{{ route('manual.orders.index') }}";
        
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
    
    // View Address Modal
    $(document).on('click', '.view-address-btn', function() {
        $('#modalName').text($(this).data('name'));
        $('#modalMobile').text($(this).data('mobile'));
        $('#modalAltMobile').text($(this).data('alt-mobile'));
        $('#modalStreet').text($(this).data('street'));
        $('#modalColony').text($(this).data('colony'));
        $('#modalPincode').text($(this).data('pincode'));
        $('#modalCity').text($(this).data('city'));
        $('#modalState').text($(this).data('state'));
    });
    
    // View Images Modal
    $(document).on('click', '.view-images', function() {
        const images = $(this).data('images').split(',');
        const title = $(this).data('title');
        
        $('#imageModalLabel').text(title);
        $('#carouselImages').empty();
        
        images.forEach((image, index) => {
            $('#carouselImages').append(`
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${image}" class="d-block w-100" alt="${title}">
                </div>
            `);
        });
        
        $('#imageModal').modal('show');
    });
    
    // Tracking Modal - Update
    $(document).on('click', '.update-tracking-btn', function() {
        let orderId = $(this).data('id');
        $('#order_id').val(orderId);
        
        $.ajax({
            url: "{{ route('order.tracking.view') }}",
            type: "GET",
            data: { order_id: orderId },
            success: function(response) {
                if (response.success) {
                    $('#tracking_id').val(response.data.tracking_id || '');
                    $('#tracking_link').val(response.data.tracking_link || '');
                    
                    if (response.data.tracking_slip) {
                        $('#tracking_slip_preview').html(
                            `<a href="${response.data.tracking_slip}" target="_blank" class="btn btn-success btn-sm mt-2">View Existing Slip</a>`
                        );
                    } else {
                        $('#tracking_slip_preview').html('');
                    }
                } else {
                    $('#tracking_id').val('');
                    $('#tracking_link').val('');
                    $('#tracking_slip_preview').html('');
                }
                
                $('#trackingModal').modal('show');
            }
        });
    });
    
    // Tracking Form Submit
    $('#trackingForm').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        
        let formData = new FormData();
        formData.append('order_id', $('#order_id').val());
        formData.append('tracking_id', $('#tracking_id').val());
        formData.append('tracking_link', $('#tracking_link').val());
        if ($('#tracking_slip')[0].files[0]) {
            formData.append('tracking_slip', $('#tracking_slip')[0].files[0]);
        }
        
        $.ajax({
            url: "{{ route('order.tracking.store') }}",
            type: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#trackingModal').modal('hide');
                Swal.fire({
                    title: 'Success!',
                    text: response.success,
                    icon: 'success',
                    confirmButtonColor: '#27ae60'
                });
                $('#trackingForm')[0].reset();
                applyFilters();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $('#' + field).after('<span class="text-danger error-message">' + messages[0] + '</span>');
                    });
                } else {
                    Swal.fire('Error!', 'Something went wrong!', 'error');
                }
            }
        });
    });
    
    // Proceed Button
    $(document).on('click', '.proceed-btn', function(e) {
        e.preventDefault();
        let orderId = $(this).closest('tr').data('id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "You want to proceed with this order!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#e74c3c",
            confirmButtonText: "Yes, Proceed!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('manual.update.proceed.status') }}",
                    type: "POST",
                    data: {
                        order_id: orderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire({
                                title: "Updated!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#27ae60"
                            }).then(() => {
                                applyFilters();
                            });
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                });
            }
        });
    });
    
    // Push to ShipRocket
    $(document).on('click', '.push-order', function(e) {
        e.preventDefault();
        let orderId = $(this).data('id');
        
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to push this order to Shiprocket?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3498db',
            cancelButtonColor: '#e74c3c',
            confirmButtonText: 'Yes, push it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('maual-order-push-to-shiprocket') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        order_id: orderId
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Pushing...',
                            text: 'Please wait while we process the order.',
                            icon: 'info',
                            allowOutsideClick: false,
                            showConfirmButton: false
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#27ae60'
                            }).then(() => {
                                applyFilters();
                            });
                        } else {
                            Swal.fire('Failed!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong. Please try again later.', 'error');
                    }
                });
            }
        });
    });
    
    // Push to Manual Ship
    $(document).on('click', '.confirm-manual', function(e) {
        e.preventDefault();
        let orderId = $(this).data('id');
        
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to mark this order as Shipped?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#27ae60",
            cancelButtonColor: "#e74c3c",
            confirmButtonText: "Yes, Confirm!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('manual.update.confirm.status') }}",
                    type: "POST",
                    data: {
                        order_id: orderId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire({
                                title: "Updated!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#27ae60"
                            }).then(() => {
                                applyFilters();
                            });
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    }
                });
            }
        });
    });
    
    // Delete Button
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        var id = row.data('id');
        var url = "{{ route('manual.order.destroy', ['id' => ':id']) }}".replace(':id', id);
        
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to recover this record!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#e74c3c",
            cancelButtonColor: "#95a5a6",
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.success || response.message,
                            icon: "success",
                            confirmButtonColor: "#27ae60"
                        }).then(() => {
                            applyFilters();
                        });
                    },
                    error: function() {
                        Swal.fire("Error", "An error occurred while deleting the record.", "error");
                    }
                });
            }
        });
    });
</script>
@endsection
