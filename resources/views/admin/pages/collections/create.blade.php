@php
    if (isset($collections)) {
        $id = $collections->id;
        $name = $collections->name;
        $sub_category_id = $collections->sub_category_id;
        $image_path = $collections->image_path;
        $update = true;
    } else {
        $id = '';
        $name = '';
        $sub_category_id = '';
        $image_path = '';
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', $update ? 'Edit Collection' : 'Create Collection')
@section('topbar-text', $update ? 'Edit Collection' : 'Create Collection')

@section('admin-css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Corporate Collection Create Page */
    .collection-create-container {
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
    
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
    }
    
    /* File Input Styling */
    input[type="file"] {
        padding: 0.875rem 1rem;
    }
    
    input[type="file"]::file-selector-button {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        margin-right: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
        transform: translateY(-2px);
    }
    
    /* Image Preview */
    .image-preview {
        margin-top: 1.5rem;
        text-align: center;
    }
    
    .image-preview img {
        max-width: 200px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 3px solid #e9ecef;
    }
    
    .image-preview-label {
        display: block;
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }
    
    /* Custom Select2 Styling */
    .select2-container--default .select2-selection--single {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        height: auto;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default.select2-container--open .select2-selection--single {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.15);
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
        top: 0;
    }
    
    .select2-dropdown {
        border: 2px solid #e74c3c;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(231, 76, 60, 0.2);
        margin-top: 4px;
    }
    
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }
    
    .select2-container--default .select2-results__option[aria-selected=true] {
        background: #f8f9fa;
        color: #e74c3c;
        font-weight: 600;
    }
    
    .select2-container {
        width: 100% !important;
    }
    
    /* Action Buttons */
    .action-buttons {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .btn-create {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        border: none;
        color: white;
        padding: 0.875rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
        letter-spacing: 0.5px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(44, 62, 80, 0.4);
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
    }
    
    .btn-create iconify-icon {
        vertical-align: middle;
        font-size: 1.25rem;
    }
    
    .btn-reset {
        background: white;
        border: 2px solid #dee2e6;
        color: #6c757d;
        padding: 0.875rem 2.5rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-reset:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
        color: #495057;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-reset iconify-icon {
        vertical-align: middle;
        font-size: 1.25rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }
        
        .section-card .card-body {
            padding: 1.5rem 1rem;
        }
        
        .action-buttons {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-xxl collection-create-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>
                    <iconify-icon icon="{{ $update ? 'solar:pen-bold-duotone' : 'solar:add-square-bold-duotone' }}" class="me-2"></iconify-icon>
                    {{ $update ? 'Edit Collection' : 'Create New Collection' }}
                </h2>
                <p>{{ $update ? 'Update collection details and settings' : 'Fill in the details below to add a new collection' }}</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('collections.index') }}" class="btn btn-light">
                    <iconify-icon icon="solar:arrow-left-bold" class="me-2"></iconify-icon>
                    Back to Collections
                </a>
            </div>
        </div>
    </div>
    
    <form id="categoryForm" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                
                <!-- Collection Information -->
                <div class="card section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                            Collection Information
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="mb-0">
                                    <label for="collection_name" class="form-label">Collection Name</label>
                                    <input type="text" name="collection_name" class="form-control"
                                        id="collection_name" required placeholder="Enter collection name"
                                        value="{{ $name }}">
                                </div>
                            </div>
                            
                            @php
                                $categories = DB::table('sub_categories')
                                    ->where(['is_deleted' => 0])
                                    ->get();
                            @endphp
                            
                            <div class="col-lg-6">
                                <label for="product-categories" class="form-label">Subcategory</label>
                                <select class="form-control" id="product-categories" name="sub_category" required>
                                    <option value="">Choose a subcategory</option>
                                    @foreach ($categories as $category)
                                        <option {{ $sub_category_id == $category->id ? 'selected' : '' }}
                                            value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Collection Image -->
                <div class="card section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
                            Collection Image
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="collection_image" class="form-label">Upload Image</label>
                                <input type="file" name="collection_image" class="form-control"
                                    id="collection_image" {{ $update ? '' : 'required' }} accept="image/*">
                                <small class="text-muted mt-2 d-block">Recommended size: 800x800px. Formats: JPG, PNG, WEBP</small>
                                
                                @if($update && $image_path)
                                <div class="image-preview">
                                    <span class="image-preview-label">Current Image</span>
                                    <img src="{{ path() }}/uploads/{{ $image_path }}" alt="Collection Image" id="current-image">
                                </div>
                                @endif
                                
                                <div class="image-preview" id="new-image-preview" style="display: none;">
                                    <span class="image-preview-label">New Image Preview</span>
                                    <img src="" alt="Preview" id="preview-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="action-buttons mb-4">
                    <div class="row justify-content-end g-3">
                        <div class="col-lg-2 col-md-4">
                            <button type="reset" class="btn btn-reset w-100">
                                <iconify-icon icon="solar:restart-bold" class="me-2"></iconify-icon>
                                Reset
                            </button>
                        </div>
                        <div class="col-lg-2 col-md-4">
                            <button type="submit" class="btn btn-create w-100">
                                <iconify-icon icon="solar:check-circle-bold" class="me-2"></iconify-icon>
                                {{ $update ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('admin-js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#product-categories').select2({
            placeholder: 'Choose a subcategory',
            allowClear: true
        });
        
        // Image preview
        $('#collection_image').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result);
                    $('#new-image-preview').show();
                    $('#current-image').parent().hide();
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Form submission
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('collections.store') }}",
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
                            confirmButtonColor: '#2c3e50',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = "{{ route('collections.index') }}";
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += value + '\n';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMessages,
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
