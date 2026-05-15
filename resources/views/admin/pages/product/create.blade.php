@extends('admin.main.app')
@section('admin-title', 'Create Product')
@section('topbar-text', 'Create Product')
@section('admin-css')
<style>
    /* Corporate Product Create Page Styles */
    .product-create-container {
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
    
    .section-card .card-header h4 i,
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
    
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #dee2e6;
        border-radius: 6px;
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
    
    .form-check-label {
        font-weight: 500;
        color: #495057;
        margin-left: 0.5rem;
        cursor: pointer;
    }
    
    .checkbox-group {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        border: 2px dashed #dee2e6;
    }
    
    .checkbox-group .form-check {
        margin-bottom: 0;
    }
    
    .inventory-row {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 2px solid #e9ecef;
        position: relative;
    }
    
    .inventory-row:hover {
        border-color: #e74c3c;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.1);
    }
    
    .inventory-row-divider {
        border: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #e74c3c, transparent);
        margin: 1.5rem 0;
    }
    
    .btn-add-row {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }
    
    .btn-add-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(39, 174, 96, 0.4);
        background: linear-gradient(135deg, #229954 0%, #27ae60 100%);
    }
    
    .btn-remove-row {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    }
    
    .btn-remove-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);
    }
    
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
    
    /* Quill Editor Styling */
    .ql-container {
        border-radius: 0 0 10px 10px;
        border: 2px solid #e9ecef;
        border-top: none;
    }
    
    .ql-toolbar {
        border-radius: 10px 10px 0 0;
        border: 2px solid #e9ecef;
        background: #f8f9fa;
    }
    
    .ql-editor {
        min-height: 250px;
        font-size: 0.9375rem;
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
    
    #color-input {
        width: 150px;
        padding: 10px;
        border: 2px solid #e9ecef;
        border-radius: 10px;
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
@php
    $colors = DB::table('colors')
        ->where(['is_deleted' => 0])
        ->orderBy('id', 'DESC')
        ->get();
    $sizes = DB::table('sizes')
        ->where(['is_deleted' => 0])
        ->orderBy('id', 'DESC')
        ->get();
@endphp


@section('admin-content')
    <div class="container-xxl product-create-container">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2>
                        <iconify-icon icon="solar:add-square-bold-duotone" class="me-2"></iconify-icon>
                        Create New Product
                    </h2>
                    <p>Fill in the details below to add a new product to your inventory</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('product.index') }}" class="btn btn-light">
                        <iconify-icon icon="solar:arrow-left-bold" class="me-2"></iconify-icon>
                        Back to Products
                    </a>
                </div>
            </div>
        </div>
        
        <form id="productForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    
                    <!-- Product Information -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                                Product Information
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" id="product_name" class="form-control"
                                            placeholder="Enter product name" name="product_name">
                                    </div>
                                </div>
                                @php
                                    $categories = DB::table('categories')
                                        ->where(['is_deleted' => 0])
                                        ->get();
                                @endphp
                                <div class="col-lg-4">
                                    <label for="product-categories" class="form-label">Product Category</label>
                                    <select class="form-control" id="product-categories" name="category" data-choices
                                        data-choices-groups data-placeholder="Select Categories">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="product-subcategories" class="form-label">Subcategory</label>
                                    <select class="form-control select2" id="product-subcategories" name="subcategory">
                                        <option value="">Select Subcategory</option>
                                    </select>
                                </div>
                            </div>

                            @php
                                $brands = DB::table('brands')
                                    ->where(['is_deleted' => 0])
                                    ->get();
                            @endphp

                            <div class="row g-4 mt-2">
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label for="product_url" class="form-label">Product URL Slug</label>
                                        <input type="text" id="product_url" class="form-control" name="product_url"
                                            placeholder="auto-generated-slug" disabled>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label for="product_sku" class="form-label">SKU (Stock Keeping Unit)</label>
                                        <input type="text" id="product_sku" class="form-control" name="sku"
                                            placeholder="Enter SKU (e.g., PROD-001)">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-0">
                                        <label for="product-brand" class="form-label">Brand</label>
                                        <select class="form-control" id="product-categories" data-choices
                                            data-choices-groups data-placeholder="Select Brand" name="brand">
                                            <option value="">Choose a brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" id="gender" data-choices data-choices-groups
                                        data-placeholder="Select Gender" name="gender">
                                        <option value="" selected disabled>Select Gender</option>
                                        <option value="Men">Men</option>
                                        <option value="Women">Women</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:tag-bold-duotone"></iconify-icon>
                                Additional Information
                            </h4>
                        </div>
                        @php
                            $tags = DB::table('tags')
                                ->where(['is_deleted' => 0])
                                ->get();
                        @endphp
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <label for="product-stock" class="form-label">Tags</label>
                                    <select class="form-control" id="choices-multiple-remove-button" data-choices
                                        data-choices-removeItem name="tags[]" multiple style="z-index: 999 !important">
                                        @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @php
                                    $sizes = DB::table('sizes')
                                        ->where(['is_deleted' => 0])
                                        ->get();
                                @endphp

                                @php
                                    $collections = DB::table('collections')
                                        ->where(['is_deleted' => 0])
                                        ->get();
                                @endphp
                                <div class="col-lg-6">
                                    <label for="product-collection" class="form-label">Collections</label>
                                    <select class="form-control" id="product-collection" name="collection" data-choices
                                        data-choices-groups data-placeholder="Select Collection">
                                        <option value="">Choose a collection</option>
                                        @foreach ($collections as $collection)
                                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="product-yt-link" class="form-label">Youtube Video Link</label>
                                    <input type="text" name="yt_link" placeholder="https://youtube.com/watch?v=..."
                                        class="form-control" id="product-yt-link">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Product Descriptions -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:text-bold-duotone"></iconify-icon>
                                Product Descriptions
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="mb-0">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <div id="short_description" style="height: 300px"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-0">
                                        <label for="description" class="form-label">Full Description</label>
                                        <div id="description" style="height: 300px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Flags -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:flag-bold-duotone"></iconify-icon>
                                Product Flags & Features
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="checkbox-group">
                                <div class="row g-4">
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="featured" name="featured"
                                                value="1">
                                            <label class="form-check-label" for="featured">Featured</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="discounted"
                                                name="discounted" value="1">
                                            <label class="form-check-label" for="discounted">Discounted</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="newarrival"
                                                name="newarrival" value="1">
                                            <label class="form-check-label" for="newarrival">New Arrival</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="bestseller"
                                                name="bestseller" value="1">
                                            <label class="form-check-label" for="bestseller">Best Seller</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="special"
                                                name="special" value="1">
                                            <label class="form-check-label" for="special">Special</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Multimedia -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
                                Product Images
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="second_image" class="form-label">Product Images (Multiple)</label>
                                    <input type="file" id="second_image" class="form-control" name="product_images[]"
                                        multiple accept="image/*">
                                    <small class="text-muted mt-2 d-block">You can select multiple images. Recommended size: 800x800px</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inventory Information -->
                    <div class="card section-card">
                        <div class="card-header">
                            <h4>
                                <iconify-icon icon="solar:box-bold-duotone"></iconify-icon>
                                Inventory & Variants
                            </h4>
                        </div>
                        <div class="card-body">
                            <div id="form-rows">
                                <div class="row form-row inventory-row">
                                    <div class="col-lg-3">
                                        <label for="mrp" class="form-label">MRP (₹)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="mrp" class="form-control"
                                                placeholder="0.00" name="mrp[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="price" class="form-label">Selling Price (₹)</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="price" class="form-control"
                                                placeholder="0.00" name="price[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="size" class="form-label">Size</label>
                                        <select class="form-control" id="choices-multiple-remove-button" data-choices
                                            data-choices-removeItem name="size[]">
                                            <option value="" selected disabled>Select Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="color" class="form-label">Color</label>
                                        <select class="form-control" id="choices-multiple-remove-button" data-choices
                                            data-choices-removeItem name="color[]">
                                            <option value="" selected disabled>Select Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3 mt-3">
                                        <label for="qty" class="form-label">Quantity</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="qty" class="form-control"
                                                placeholder="0" name="qty[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-7 mt-3">
                                        <label for="attr_image" class="form-label">Variant Image</label>
                                        <div class="input-group mb-3">
                                            <input type="file" id="attr_image" class="form-control"
                                                name="attr_image[]" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 mt-3">
                                        <label class="form-label d-block">&nbsp;</label>
                                        <div class="input-group">
                                            <button class="btn btn-add-row add-row w-100" type="button">
                                                <iconify-icon icon="solar:add-circle-bold" class="me-2"></iconify-icon>
                                                Add Variant
                                            </button>
                                        </div>
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
                                    Save
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    var quill = new Quill('#short_description', {
        theme: 'snow',
        modules: {
            toolbar: {
                clipboard: {
                matchVisual: false
            },
                container: [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }, {
                        'align': []
                    }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean'] // remove formatting button
                ],
                handlers: {
                    'image': function() {
                        var fileInput = this.container.querySelector('input.ql-image[type=file]');
                        if (fileInput === null) {
                            fileInput = document.createElement('input');
                            fileInput.setAttribute('type', 'file');
                            fileInput.setAttribute('accept', 'image/*');
                            fileInput.classList.add('ql-image');
                            fileInput.addEventListener('change', function() {
                                var file = fileInput.files[0];
                                if (file) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        var range = quill.getSelection();
                                        quill.insertEmbed(range.index, 'image', e.target
                                            .result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                            this.container.appendChild(fileInput);
                        }
                        fileInput.click();
                    }
                }
            }
        }
    });
</script>
<script>
    var quill = new Quill('#description', {
        theme: 'snow',
        modules: {
            clipboard: {
                matchVisual: false
            },
            toolbar: {
                container: [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }, {
                        'align': []
                    }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean'] // remove formatting button
                ],
                handlers: {
                    'image': function() {
                        var fileInput = this.container.querySelector('input.ql-image[type=file]');
                        if (fileInput === null) {
                            fileInput = document.createElement('input');
                            fileInput.setAttribute('type', 'file');
                            fileInput.setAttribute('accept', 'image/*');
                            fileInput.classList.add('ql-image');
                            fileInput.addEventListener('change', function() {
                                var file = fileInput.files[0];
                                if (file) {
                                    var reader = new FileReader();
                                    reader.onload = function(e) {
                                        var range = quill.getSelection();
                                        quill.insertEmbed(range.index, 'image', e.target
                                            .result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                            this.container.appendChild(fileInput);
                        }
                        fileInput.click();
                    }
                }
            }
        }
    });
</script>


    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-row', function() {
                var newRow = `
                <hr class="inventory-row-divider">
                <div class="row form-row inventory-row">
                    <div class="col-lg-3">
                        <label for="mrp" class="form-label">MRP (₹)</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="0.00" name="mrp[]">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="price" class="form-label">Selling Price (₹)</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="0.00" name="price[]">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-control" data-choices data-choices-removeItem name="size[]">
                            <option value="" selected disabled>Select Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label for="color" class="form-label">Color</label>
                        <select class="form-control" data-choices data-choices-removeItem name="color[]">
                            <option value="" selected disabled>Select Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 mt-3">
                        <label for="qty" class="form-label">Quantity</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="0" name="qty[]">
                        </div>
                    </div>
                    <div class="col-lg-7 mt-3">
                        <label for="attr_image" class="form-label">Variant Image</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="attr_image[]" accept="image/*">
                        </div>
                    </div>
                    <div class="col-lg-2 mt-3">
                        <label class="form-label d-block">&nbsp;</label>
                        <div class="input-group">
                            <button class="btn btn-remove-row remove-row w-100" type="button">
                                <iconify-icon icon="solar:trash-bin-trash-bold" class="me-2"></iconify-icon>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>`;
                $('#form-rows').append(newRow);
            });
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-row').prev('hr').remove();
                $(this).closest('.form-row').remove();
            });
        });
    </script>

    <script>
        function generateSlug(value) {
            return value
                .toLowerCase()
                .replace(/ /g, '-') // Replace spaces with dashes
                .replace(/[^\w-]+/g, ''); // Remove special characters
        }

        const productNameInput = document.getElementById('product_name'); // Corrected ID
        const productUrlInput = document.getElementById('product_url');

        productNameInput.addEventListener('input', function() {
            const slug = generateSlug(productNameInput.value);
            productUrlInput.value = slug;
        });
    </script>

    <script>
        $('.btn-check').on('click', function() {
            $(this).prop('checked', !$(this).prop('checked'));
        });
    </script>
    <script>
        const pickr = Pickr.create({
            el: '#color-input',
            theme: 'classic',
            default: '#ff0000',
            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    input: true,
                    save: true
                }
            }
        });
        pickr.on('change', (color) => {
            const hexColor = color.toHEXA().toString();
            document.getElementById('color-input').value = hexColor;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                var short_description = quill.root.innerHTML;
                formData.append('short_description', short_description);
                var description = quill.root.innerHTML;
                formData.append('description', description);
                $.ajax({
                    url: "{{ route('product.store') }}",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('product.index') }}";
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = '<ul>';
                            $.each(errors, function(key, value) {
                                errorMessage += '<li>' + value[0] +
                                    '</li>';
                            });
                            errorMessage += '</ul>';
                            Swal.fire({
                                title: 'Validation Error',
                                html: errorMessage,
                                icon: 'error'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred. Please try again.',
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#product-subcategories').select2({
                placeholder: 'Select Subcategory',
                allowClear: true
            });
            $('#product-categories').on('change', function() {
                let categoryId = $(this).val();
                $('#product-subcategories').empty().append('<option>Loading...</option>').trigger('change');
                if (categoryId) {
                    $.ajax({
                        url: "{{ route('productsubcategories.get', ['categoryId' => '__CATEGORY_ID__']) }}"
                            .replace('__CATEGORY_ID__', categoryId),
                        type: 'GET',
                        success: function(response) {
                            $('#product-subcategories').empty();
                            if (response.length > 0) {
                                $('#product-subcategories').append(
                                    '<option value="">Select Subcategory</option>');
                                $.each(response, function(index, subcategory) {
                                    $('#product-subcategories').append(
                                        '<option value="' + subcategory.id + '">' +
                                        subcategory.name + '</option>');
                                });
                            } else {
                                $('#product-subcategories').append(
                                    '<option value="">No Subcategories Available</option>');
                            }
                            $('#product-subcategories').trigger('change');
                        },
                        error: function() {
                            $('#product-subcategories').empty().append(
                                '<option value="">Failed to load subcategories</option>');
                            $('#product-subcategories').trigger('change');
                        }
                    });
                } else {
                    $('#product-subcategories').empty().append(
                        '<option value="">Select Subcategory</option>');
                    $('#product-subcategories').trigger('change');
                }
            });
        });
    </script>
@endsection
