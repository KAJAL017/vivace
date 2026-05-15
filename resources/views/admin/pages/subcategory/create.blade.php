@php
    if (isset($sub_categories)) {
        $id = $sub_categories->id;
        $name = $sub_categories->name;
        $image = $sub_categories->image;
        $category_id = $sub_categories->category_id;
        $show_in_top_bar = $sub_categories->show_in_top_bar;
        $update = true;
    } else {
        $id = '';
        $name = '';
        $category_id = '';
        $image = '';
        $show_in_top_bar = 0;
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', $update ? 'Edit Subcategory' : 'Create Subcategory')
@section('topbar-text', $update ? 'Edit Subcategory' : 'Create Subcategory')

@section('admin-css')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Corporate Subcategory Form */
    .subcategory-form-container {
        padding: 2rem 0;
    }
    
    .subcategory-form-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .form-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        padding: 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .form-header-content h4 {
        color: white;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .form-header-content h4 iconify-icon {
        margin-right: 0.75rem;
        font-size: 2rem;
    }
    
    .form-header-content p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 0.9375rem;
    }
    
    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }
    
    .form-body {
        padding: 2.5rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.125rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
    }
    
    .section-title iconify-icon {
        margin-right: 0.5rem;
        color: #e74c3c;
        font-size: 1.5rem;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9375rem;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-label .required {
        color: #e74c3c;
        margin-left: 0.25rem;
    }
    
    .form-label .hint {
        color: #7f8c8d;
        font-weight: 400;
        font-size: 0.875rem;
        margin-left: 0.5rem;
    }
    
    .form-control {
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 0.9375rem;
        color: #495057;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    .form-control::placeholder {
        color: #adb5bd;
    }
    
    /* Select2 Custom Styling */
    .select2-container--default .select2-selection--single {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        height: 48px;
        padding: 0.5rem;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 32px;
        color: #495057;
    }
    
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 46px;
    }
    
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.15);
    }
    
    /* Image Upload */
    .image-upload-wrapper {
        position: relative;
    }
    
    .image-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f8f9fa;
    }
    
    .image-upload-area:hover {
        border-color: #2c3e50;
        background: #e9ecef;
    }
    
    .image-upload-area.has-image {
        border-style: solid;
        border-color: #27ae60;
        background: #f0f9f4;
    }
    
    .upload-icon {
        font-size: 3rem;
        color: #7f8c8d;
        margin-bottom: 1rem;
    }
    
    .upload-text {
        color: #495057;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .upload-hint {
        color: #7f8c8d;
        font-size: 0.875rem;
    }
    
    .image-preview {
        margin-top: 1rem;
        display: none;
    }
    
    .image-preview.show {
        display: block;
    }
    
    .preview-image {
        max-width: 300px;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.5rem;
        background: white;
    }
    
    .current-image {
        margin-top: 1rem;
    }
    
    .current-image-label {
        font-size: 0.875rem;
        color: #7f8c8d;
        margin-bottom: 0.5rem;
    }
    
    /* Checkbox Styling */
    .custom-checkbox-wrapper {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        transition: all 0.3s ease;
    }
    
    .custom-checkbox-wrapper:hover {
        background: #e9ecef;
        border-color: #2c3e50;
    }
    
    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
    }
    
    .custom-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #e74c3c;
    }
    
    .custom-checkbox label {
        margin: 0;
        cursor: pointer;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9375rem;
    }
    
    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 2px solid #e9ecef;
        justify-content: flex-end;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    }
    
    .btn-cancel {
        background: transparent;
        border: 2px solid #6c757d;
        color: #6c757d;
        padding: 0.875rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-cancel:hover {
        background: #6c757d;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-submit,
        .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-xxl subcategory-form-container">
    <div class="subcategory-form-card">
        <!-- Form Header -->
        <div class="form-header">
            <div class="form-header-content">
                <h4>
                    <iconify-icon icon="{{ $update ? 'solar:pen-bold-duotone' : 'solar:add-circle-bold-duotone' }}"></iconify-icon>
                    {{ $update ? 'Edit Subcategory' : 'Create New Subcategory' }}
                </h4>
                <p>{{ $update ? 'Update subcategory information and image' : 'Add a new subcategory to your store' }}</p>
            </div>
            <a href="{{ route('subcategories.index') }}" class="btn-back">
                <iconify-icon icon="solar:alt-arrow-left-bold"></iconify-icon>
                Back to List
            </a>
        </div>
        
        <!-- Form Body -->
        <div class="form-body">
            <form id="subcategoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                
                <!-- Basic Information -->
                <div class="form-section">
                    <h5 class="section-title">
                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                        Basic Information
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Subcategory Name
                                    <span class="required">*</span>
                                </label>
                                <input type="text" name="name" class="form-control" 
                                       placeholder="Enter subcategory name" 
                                       value="{{ $name }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    Parent Category
                                    <span class="required">*</span>
                                </label>
                                <select name="category" class="form-control" id="categorySelect" required>
                                    <option value="">Select Category</option>
                                    @php
                                        $categories = DB::table('categories')->where('is_deleted', 0)->orderBy('name')->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Subcategory Image -->
                <div class="form-section">
                    <h5 class="section-title">
                        <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
                        Subcategory Image
                    </h5>
                    
                    <div class="form-group">
                        <label class="form-label">
                            Upload Image
                            <span class="hint">(Recommended: 242 x 281 pixels)</span>
                        </label>
                        
                        <div class="image-upload-wrapper">
                            <label for="imageInput" class="image-upload-area" id="uploadArea">
                                <iconify-icon icon="solar:gallery-add-bold-duotone" class="upload-icon"></iconify-icon>
                                <div class="upload-text">Click to upload subcategory image</div>
                                <div class="upload-hint">PNG, JPG, WEBP up to 2MB</div>
                            </label>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                            
                            <div class="image-preview" id="imagePreview">
                                <img src="" alt="Preview" class="preview-image" id="previewImg">
                            </div>
                            
                            @if($update && $image)
                            <div class="current-image">
                                <div class="current-image-label">Current Image:</div>
                                <img src="{{ url($image) }}" alt="{{ $name }}" class="preview-image">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Display Settings -->
                <div class="form-section">
                    <h5 class="section-title">
                        <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                        Display Settings
                    </h5>
                    
                    <div class="form-group">
                        <div class="custom-checkbox-wrapper">
                            <div class="custom-checkbox">
                                <input type="checkbox" name="show_in_top_bar" value="1" id="showInTopBar" 
                                       {{ $show_in_top_bar == 1 ? 'checked' : '' }}>
                                <label for="showInTopBar">
                                    Show this subcategory in the top navigation bar
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('subcategories.index') }}" class="btn-cancel">
                        <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                        Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <iconify-icon icon="{{ $update ? 'solar:check-circle-bold' : 'solar:add-circle-bold' }}"></iconify-icon>
                        {{ $update ? 'Update Subcategory' : 'Create Subcategory' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#categorySelect').select2({
            placeholder: 'Select Category',
            allowClear: true
        });
        
        // Image preview
        $('#imageInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                    $('#imagePreview').addClass('show');
                    $('#uploadArea').addClass('has-image');
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Form submission
        $('#subcategoryForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            // Show loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we save the subcategory',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('subcategories.store') }}",
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
                            window.location.href = "{{ route('subcategories.index') }}";
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += value[0] + '\n';
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
                            text: 'An unexpected error occurred. Please try again.',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
