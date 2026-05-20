@php
    if (isset($banners)) {
        $id = $banners->id;
        $banner = $banners->banner;
        $url = $banners->url;
        $index_number = $banners->index_number;
        $update = true;
    } else {
        $id = '';
        $banner = '';
        $url = '';
        $index_number = '';
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', $update ? 'Edit Banner' : 'Create Banner')
@section('topbar-text', $update ? 'Edit Banner' : 'Create Banner')

@section('admin-css')
<style>
    /* Corporate Banner Form */
    .banner-form-container {
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 1.75rem;
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }
    
    .section-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border: none;
        overflow: hidden;
    }
    
    .section-card .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 3px solid #e74c3c;
        padding: 1.25rem 1.5rem;
        border-radius: 0;
    }
    
    .section-card .card-header h4 {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.125rem;
        margin: 0;
        display: flex;
        align-items: center;
    }
    
    .section-card .card-header h4 iconify-icon {
        margin-right: 0.75rem;
        color: #e74c3c;
        font-size: 1.5rem;
    }
    
    .section-card .card-body {
        padding: 2rem 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
    }
    
    /* Image Upload */
    .image-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f8f9fa;
    }
    
    .image-upload-area:hover {
        border-color: #e74c3c;
        background: #fff5f5;
    }
    
    .image-upload-area.has-image {
        border-style: solid;
        border-color: #27ae60;
        background: #f0fff4;
    }
    
    .upload-icon {
        font-size: 3rem;
        color: #95a5a6;
        margin-bottom: 1rem;
    }
    
    .image-upload-area.has-image .upload-icon {
        color: #27ae60;
    }
    
    .upload-text {
        color: #7f8c8d;
        font-size: 0.9375rem;
        margin-bottom: 0.5rem;
    }
    
    .upload-hint {
        color: #95a5a6;
        font-size: 0.8125rem;
    }
    
    .image-preview {
        margin-top: 1.5rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .image-preview img {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
        border-radius: 0 0 16px 16px;
    }
    
    .btn-cancel {
        background: #95a5a6;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-cancel:hover {
        background: #7f8c8d;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn-cancel,
        .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid banner-form-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <h2>{{ $update ? '✏️ Edit Banner' : '➕ Create New Banner' }}</h2>
        <p>{{ $update ? 'Update banner details and image' : 'Upload a banner image for your website homepage' }}</p>
    </div>
    
    <form id="categoryForm" class="g-3 needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        
        <div class="row">
            <div class="col-lg-12">
                
                <!-- Banner Upload -->
                <div class="section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:gallery-bold"></iconify-icon>
                            Banner Image
                        </h4>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Upload Banner</label>
                        <div class="image-upload-area {{ $banner ? 'has-image' : '' }}" onclick="document.getElementById('banner').click()">
                            <iconify-icon icon="solar:cloud-upload-bold" class="upload-icon"></iconify-icon>
                            <p class="upload-text">Click to upload banner image</p>
                            <p class="upload-hint">Recommended size: 1920x600px (JPG, PNG, WEBP)</p>
                        </div>
                        <input type="file" name="banner" class="form-control d-none" id="banner" accept="image/*">
                        
                        @if($banner)
                            <div class="image-preview" id="imagePreview">
                                @php
                                    // Use ImageKit URL if available, otherwise use local path
                                    $imageUrl = !empty($banners->imagekit_url) 
                                        ? $banners->imagekit_url 
                                        : upload_url($banner);
                                @endphp
                                <img src="{{ $imageUrl }}" alt="Current Banner" id="previewImage">
                            </div>
                        @else
                            <div class="image-preview d-none" id="imagePreview">
                                <img src="" alt="Banner Preview" id="previewImage">
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Banner Details -->
                <div class="section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:settings-bold"></iconify-icon>
                            Banner Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="url" class="form-label">Banner URL (Optional)</label>
                                <input type="text" name="url" class="form-control" id="url" placeholder="https://example.com/page" value="{{ $url }}">
                                <small class="text-muted">Link where users will be redirected when clicking the banner</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="index" class="form-label">Display Order</label>
                                <input type="number" name="index" class="form-control" id="index" placeholder="1" value="{{ $index_number }}" min="1">
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('banner.index') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-submit">
                            {{ $update ? 'Update Banner' : 'Create Banner' }}
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
</div>
@endsection

@section('admin-js')
<script>
    // Image Preview
    $('#banner').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#imagePreview').removeClass('d-none');
                $('.image-upload-area').addClass('has-image');
                $('.upload-text').text('Image selected: ' + file.name);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Form Submit
    $(document).ready(function() {
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('banner.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            confirmButtonColor: '#27ae60',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = "{{ route('banner.index') }}";
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += value + '<br>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            confirmButtonColor: '#e74c3c'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
