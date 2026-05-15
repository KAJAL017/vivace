@php
    if (isset($colors)) {
        $id = $colors->id;
        $name = $colors->name;
        $hex_code = $colors->hex_code;
        $update = true;
    } else {
        $id = '';
        $name = '';
        $hex_code = '';
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', $update ? 'Edit Color' : 'Create Color')
@section('topbar-text', $update ? 'Edit Color' : 'Create Color')

@section('admin-css')
<style>
    /* Corporate Color Form */
    .color-form-container {
        padding: 2rem 0;
    }
    
    .color-form-card {
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
    
    /* Color Picker Wrapper */
    .color-picker-wrapper {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .color-input-group {
        flex: 1;
    }
    
    .color-preview-box {
        width: 80px;
        height: 50px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    input[type="color"] {
        width: 80px;
        height: 50px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    input[type="color"]:hover {
        border-color: #2c3e50;
        transform: scale(1.05);
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
        
        .color-picker-wrapper {
            flex-direction: column;
            align-items: stretch;
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
<div class="container-xxl color-form-container">
    <div class="color-form-card">
        <!-- Form Header -->
        <div class="form-header">
            <div class="form-header-content">
                <h4>
                    <iconify-icon icon="{{ $update ? 'solar:pen-bold-duotone' : 'solar:add-circle-bold-duotone' }}"></iconify-icon>
                    {{ $update ? 'Edit Color' : 'Create New Color' }}
                </h4>
                <p>{{ $update ? 'Update color information' : 'Add a new color to your store' }}</p>
            </div>
            <a href="{{ route('color.index') }}" class="btn-back">
                <iconify-icon icon="solar:alt-arrow-left-bold"></iconify-icon>
                Back to List
            </a>
        </div>
        
        <!-- Form Body -->
        <div class="form-body">
            <form id="colorForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                
                <!-- Color Information -->
                <div class="form-section">
                    <h5 class="section-title">
                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                        Color Information
                    </h5>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">
                                    Color Name
                                    <span class="required">*</span>
                                    <span class="hint">(e.g., Red, Blue, Black, White)</span>
                                </label>
                                <input type="text" name="name" class="form-control" 
                                       placeholder="Enter color name" 
                                       value="{{ $name }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">
                                    Hex Code
                                    <span class="required">*</span>
                                    <span class="hint">(e.g., #FF0000, #0000FF)</span>
                                </label>
                                <div class="color-picker-wrapper">
                                    <div class="color-input-group">
                                        <input type="text" name="hex_code" id="hexInput" class="form-control" 
                                               placeholder="Enter hex code (e.g., #FF0000)" 
                                               value="{{ $hex_code }}" required>
                                    </div>
                                    <input type="color" id="colorPicker" value="{{ $hex_code ?: '#000000' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('color.index') }}" class="btn-cancel">
                        <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                        Cancel
                    </a>
                    <button type="submit" class="btn-submit">
                        <iconify-icon icon="{{ $update ? 'solar:check-circle-bold' : 'solar:add-circle-bold' }}"></iconify-icon>
                        {{ $update ? 'Update Color' : 'Create Color' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('admin-js')
<script>
    $(document).ready(function() {
        // Sync color picker with hex input
        $('#colorPicker').on('input', function() {
            $('#hexInput').val($(this).val().toUpperCase());
        });
        
        // Sync hex input with color picker
        $('#hexInput').on('input', function() {
            let hex = $(this).val();
            if (/^#[0-9A-F]{6}$/i.test(hex)) {
                $('#colorPicker').val(hex);
            }
        });
        
        // Form submission
        $('#colorForm').on('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            
            // Show loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we save the color',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('color.store') }}",
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
                            window.location.href = "{{ route('color.index') }}";
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
