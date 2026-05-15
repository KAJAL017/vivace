@extends('admin.main.app')
@section('admin-title', 'Contact Queries')
@section('topbar-text', 'Contact Management')

@section('admin-css')
<style>
    /* Corporate Contact Queries List */
    .contacts-container {
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
    
    /* Contacts Card */
    .contacts-card {
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
    
    .contacts-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .contacts-table thead {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
    }
    
    .contacts-table thead th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .contacts-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }
    
    .contacts-table tbody tr:hover {
        background: #f8f9fa;
    }
    
    .contacts-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .contact-name,
    .contact-email,
    .contact-phone,
    .contact-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .name-icon {
        color: #9b59b6;
        font-size: 1.125rem;
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
        color: #e74c3c;
        font-size: 1.125rem;
    }
    
    .contact-subject {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .btn-view-details {
        background: #3498db;
        color: white;
        border: none;
        padding: 0.5rem;
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
    
    .btn-view-details:hover {
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
        padding: 2rem;
    }
    
    .query-details {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .detail-label {
        font-weight: 700;
        color: #2c3e50;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .detail-value {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        color: #495057;
        font-size: 0.9375rem;
    }
    
    .detail-value.message {
        line-height: 1.8;
        min-height: 100px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .pagination-container {
            flex-direction: column;
            text-align: center;
        }
        
        .contacts-table {
            font-size: 0.875rem;
        }
        
        .contacts-table thead th,
        .contacts-table tbody td {
            padding: 0.75rem 0.5rem;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid contacts-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-6 col-md-6">
            <div class="stat-card blue">
                <h3 class="stat-value">{{ $total_queries }}</h3>
                <p class="stat-label">Total Queries</p>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="stat-card">
                <h3 class="stat-value">{{ $contacts->total() }}</h3>
                <p class="stat-label">Showing Results</p>
            </div>
        </div>
    </div>
    
    <!-- Contacts Table Card with Filters -->
    <div class="contacts-card">
        <div class="card-header-custom">
            <h4>Contact Queries (<span id="totalCount">{{ $contacts->total() }}</span> queries)</h4>
        </div>
        
        <!-- Filter Section Inside Card -->
        <div style="padding: 1.5rem; background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
            <div class="filter-header">
                <h5 style="color: #2c3e50; font-weight: 600; font-size: 1rem; margin: 0;">🔍 Search Queries</h5>
                <button type="button" class="btn-clear-filters" id="clearFilters">Clear Search</button>
            </div>
            <form id="filterForm">
                <div class="filter-group">
                    <label class="filter-label">Search by Name, Email, Phone or Subject</label>
                    <input type="text" name="search" class="filter-input" placeholder="Type to search..." id="searchInput">
                </div>
            </form>
        </div>
        
        <!-- Table Container -->
        <div id="contactsTableContainer">
            @include('admin.pages.partials.contacts-table')
        </div>
        
        <!-- Pagination Container -->
        <div id="paginationContainer">
            @include('admin.pages.partials.contacts-pagination')
        </div>
    </div>
</div>

<!-- Query Details Modal -->
<div class="modal fade" id="queryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Query Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="query-details">
                    <div class="detail-item">
                        <div class="detail-label">Name</div>
                        <div class="detail-value" id="queryName"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value" id="queryEmail"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value" id="queryPhone"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Subject</div>
                        <div class="detail-value" id="querySubject"></div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Message</div>
                        <div class="detail-value message" id="queryMessage"></div>
                    </div>
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
        const requestUrl = url || "{{ route('admin.contact') }}";
        
        $.ajax({
            url: requestUrl,
            method: 'GET',
            data: formData,
            beforeSend: function() {
                $('#contactsTableContainer').html('<div style="padding: 3rem; text-align: center;"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading queries...</p></div>');
            },
            success: function(response) {
                if (response.success) {
                    $('#contactsTableContainer').html(response.html);
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
                    text: 'Failed to load queries',
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
            scrollTop: $('.contacts-card').offset().top - 100
        }, 500);
    });
    
    // View Full Message
    $(document).on('click', '.btn-view-details', function() {
        const name = $(this).data('name');
        const email = $(this).data('email');
        const phone = $(this).data('phone');
        const subject = $(this).data('subject');
        const message = $(this).data('message');
        
        $('#queryName').text(name);
        $('#queryEmail').text(email);
        $('#queryPhone').text(phone);
        $('#querySubject').text(subject);
        $('#queryMessage').text(message);
        
        $('#queryModal').modal('show');
    });
</script>
@endsection
