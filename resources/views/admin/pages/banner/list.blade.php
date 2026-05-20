@extends('admin.main.app')
@section('admin-title', 'Banners')
@section('topbar-text', 'Banner Management')

@section('admin-css')
<style>
    /* Corporate Banner Management */
    .banner-container {
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
    
    /* Banner Card */
    .banner-card {
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
    
    /* Banner Grid */
    .banner-grid {
        padding: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }
    
    .banner-item {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
    }
    
    .banner-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        border-color: #2c3e50;
    }
    
    .banner-image-container {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .banner-item:hover .banner-image {
        transform: scale(1.05);
    }
    
    .banner-index {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.875rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .banner-info {
        padding: 1.25rem;
    }
    
    .banner-url {
        color: #7f8c8d;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        word-break: break-all;
    }
    
    .banner-url iconify-icon {
        color: #3498db;
        font-size: 1.125rem;
        flex-shrink: 0;
    }
    
    .banner-actions {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
    }
    
    .btn-action {
        flex: 1;
        padding: 0.625rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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
    
    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #7f8c8d;
    }
    
    .empty-state iconify-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        display: block;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }
    
    .empty-state p {
        margin: 0;
        font-size: 0.9375rem;
    }
    
    /* Toggle Switch */
    .toggle-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .toggle-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.3em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #27ae60;
        border-color: #27ae60;
    }
    .status-badge {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 20px;
    }
    .status-badge.active   { background: #d4edda; color: #155724; }
    .status-badge.inactive { background: #f8d7da; color: #721c24; }
    .banner-item.is-inactive { opacity: 0.55; }

    @media (max-width: 768px) {
        .banner-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
            gap: 1.5rem;
        }
        .banner-image-container {
            height: 180px;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid banner-container">
    
    <!-- Stats Cards -->
    <div class="row stats-row g-3">
        <div class="col-xl-6 col-md-6">
            <div class="stat-card blue">
                <h3 class="stat-value">{{ count($banners) }}</h3>
                <p class="stat-label">Total Banners</p>
            </div>
        </div>
        <div class="col-xl-6 col-md-6">
            <div class="stat-card">
                <h3 class="stat-value">{{ $banners->where('is_active', 1)->count() }}</h3>
                <p class="stat-label">Active Banners</p>
            </div>
        </div>
    </div>
    
    <!-- Banner Card -->
    <div class="banner-card">
        <div class="card-header-custom">
            <h4>All Banners ({{ count($banners) }} items)</h4>
            <a href="{{ route('banner.create') }}" class="btn-add">+ Add Banner</a>
        </div>
        
        @if(count($banners) > 0)
            <div class="banner-grid">
                @foreach ($banners as $key => $banner)
                <div class="banner-item {{ $banner->is_active ? '' : 'is-inactive' }}" data-id="{{ $banner->id }}">
                    <div class="banner-image-container">
                        @php
                            // Desktop preview ya original ImageKit URL ya local
                            $imageUrl = !empty($banner->imagekit_url_desktop)
                                ? $banner->imagekit_url_desktop
                                : (!empty($banner->imagekit_url)
                                    ? $banner->imagekit_url
                                    : url('uploads/' . $banner->banner));
                        @endphp
                        <img src="{{ $imageUrl }}" alt="Banner {{ $key + 1 }}" class="banner-image">
                        @if($banner->index_number)
                            <div class="banner-index">
                                <iconify-icon icon="solar:sort-bold"></iconify-icon>
                                Order: {{ $banner->index_number }}
                            </div>
                        @endif
                        @if($banner->uploaded_to_imagekit)
                            <div style="position:absolute;top:10px;right:10px;background:#27ae60;color:white;padding:3px 8px;border-radius:5px;font-size:11px;font-weight:700;box-shadow:0 2px 6px rgba(0,0,0,0.2);">
                                ☁ ImageKit · WebP
                            </div>
                        @endif
                    </div>
                    <div class="banner-info">
                        {{-- Active / Inactive Toggle --}}
                        <div class="toggle-wrap">
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input toggle-active-btn"
                                       type="checkbox"
                                       role="switch"
                                       id="toggle_{{ $banner->id }}"
                                       {{ $banner->is_active ? 'checked' : '' }}>
                            </div>
                            <span class="status-badge {{ $banner->is_active ? 'active' : 'inactive' }}" id="badge_{{ $banner->id }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        @if($banner->url)
                            <div class="banner-url">
                                <iconify-icon icon="solar:link-bold"></iconify-icon>
                                <span>{{ Str::limit($banner->url, 40) }}</span>
                            </div>
                        @endif
                        <div class="banner-actions">
                            <a href="{{ route('banner.edit', $banner->id) }}" class="btn-action btn-edit">
                                <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                Edit
                            </a>
                            <button class="btn-action btn-delete delete-btn">
                                <iconify-icon icon="solar:trash-bin-minimalistic-bold"></iconify-icon>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <iconify-icon icon="solar:gallery-broken"></iconify-icon>
                <h3>No Banners Found</h3>
                <p>Start by adding your first banner to showcase on your website</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        var deleteUrl      = "{{ route('banner.destroy', ['id' => ':id']) }}";
        var toggleUrl      = "{{ route('banner.toggle.active') }}";

        // ── Toggle Active / Inactive ──────────────────────────────────────
        $(document).on('change', '.toggle-active-btn', function() {
            var checkbox  = $(this);
            var item      = checkbox.closest('.banner-item');
            var id        = item.data('id');
            var badge     = $('#badge_' + id);

            $.ajax({
                url:    toggleUrl,
                method: 'POST',
                data:   { id: id },
                success: function(res) {
                    if (res.success) {
                        if (res.is_active) {
                            badge.text('Active').removeClass('inactive').addClass('active');
                            item.removeClass('is-inactive');
                            checkbox.prop('checked', true);
                        } else {
                            badge.text('Inactive').removeClass('active').addClass('inactive');
                            item.addClass('is-inactive');
                            checkbox.prop('checked', false);
                        }
                    }
                },
                error: function() {
                    // Revert toggle on error
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Could not update status.', confirmButtonColor: '#e74c3c' });
                }
            });
        });

        // ── Delete ────────────────────────────────────────────────────────
        $(document).on('click', '.delete-btn', function() {
            var item = $(this).closest('.banner-item');
            var id   = item.data('id');
            var url  = deleteUrl.replace(':id', id);

            Swal.fire({
                title: "Delete Banner?",
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
                                text: "Banner deleted successfully",
                                icon: "success",
                                confirmButtonColor: '#27ae60',
                                timer: 2000
                            }).then(() => {
                                item.fadeOut(300, function() {
                                    $(this).remove();
                                    if ($('.banner-item').length === 0) location.reload();
                                });
                            });
                        },
                        error: function() {
                            Swal.fire({ title: "Error!", text: "Failed to delete banner", icon: "error", confirmButtonColor: '#e74c3c' });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
