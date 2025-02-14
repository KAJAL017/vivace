@extends('admin.main.app')
@section('admin-title', 'Create Product')
@section('topbar-text', 'Create Product')
@section('admin-css')


    <!-- Select2 JS -->

    <style>
        #color-input {
            width: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <div class="container-xxl">
        <form id="productForm" enctype="multipart/form-data">
            <div class="row">
                <div class="col-xl-12 col-lg-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_name" class="form-label">Product Name</label>
                                        <input type="text" id="product_name" class="form-control"
                                            placeholder="Items Name" name="product_name">
                                    </div>
                                </div>
                                @php
                                    $categories = DB::table('categories')
                                        ->where(['is_deleted' => 0])
                                        ->get();
                                @endphp
                                <div class="col-lg-4">
                                    <label for="product-categories" class="form-label">Product Categories</label>
                                    <select class="form-control" id="product-categories" name="category" data-choices
                                        data-choices-groups data-placeholder="Select Categories">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-lg-4">
                                    <label for="product-subcategories" class="form-label">Product Subcategories</label>
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

                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product_url" class="form-label">Product Identifier URL</label>
                                        <input type="text" id="product_url" class="form-control" name="product_url"
                                            placeholder="Product Slug" disabled>
                                    </div>
                                </div>

                                <!--<div class="col-lg-4">-->
                                <!--    <div class="mb-3">-->
                                <!--        <label for="product-brand" class="form-label">Collections</label>-->
                                <!--        <input type='text' class='form-control' placeholder>-->
                                <!--    </div>-->
                                <!--</div>-->

                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="product-brand" class="form-label">Brand</label>
                                        <select class="form-control" id="product-categories" data-choices
                                            data-choices-groups data-placeholder="Select Categories" name="brand">
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
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Additional Information</h4>
                        </div>
                        @php
                            $tags = DB::table('tags')
                                ->where(['is_deleted' => 0])
                                ->get();
                        @endphp
                        <div class="card-body">
                            <div class="row ">
                                <div class="col-lg-6 mt-3">
                                    <label for="product-stock" class="form-label">Tag</label>
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
                                <div class="col-lg-6 mt-3">
                                    <label for="product-collection" class="form-label">Collections</label>
                                    <select class="form-control" id="product-collection" name="collection" data-choices
                                        data-choices-groups data-placeholder="Select Collection">
                                        <option value="">Choose a category</option>
                                        @foreach ($collections as $collection)
                                            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <label for="product-yt-link" class="form-label">Youtube Link</label>
                                    <input type="text" name="yt_link" placeholder="Enter Your Youtube Link"
                                        class="form-control" id="product-yt-link">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product Descriptions</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mt-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <div id="short_description" style="height: 300px"></div>
                                    </div>


                                </div>
                                <div class="col-lg-6">
                                    <div class="mt-3">
                                        <label for="description" class="form-label">Description</label>
                                        <div id="description" style="height: 300px"></div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" id="featured" name="featured"
                                            value="1">
                                        <label class="form-check-label" for="featured">Featured</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" id="discounted"
                                            name="discounted" value="1">
                                        <label class="form-check-label" for="discounted">Discounted</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" id="newarrival"
                                            name="newarrival" value="1">
                                        <label class="form-check-label" for="newarrival">New Arrival</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" id="bestseller"
                                            name="bestseller" value="1">
                                        <label class="form-check-label" for="bestseller">Best Seller</label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check form-checkbox-success mb-2">
                                        <input type="checkbox" class="form-check-input" id="special"
                                            name="special" value="1">
                                        <label class="form-check-label" for="bestseller">Special Product</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Product Multimedia</div>
                        <div class="card-body">
                            <div class="row">
                                {{-- <div class="col-lg-6">
                                    <label for="first_image" class="form-label">First Image</label>
                                    <input type="file" id="first_image" class="form-control" name="first_image">
                                </div>
                                <div class="col-lg-6">
                                    <label for="second_image" class="form-label">Second Image</label>
                                    <input type="file" id="second_image" class="form-control" name="second_image">
                                </div> --}}
                                <div class="col-lg-12">
                                    <label for="second_image" class="form-label">Images</label>
                                    <input type="file" id="second_image" class="form-control" name="product_images[]"
                                        multiple>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Inventory Information</h4>
                        </div>

                        <div class="card-body">
                            <div id="form-rows">
                                <div class="row form-row">
                                    <div class="col-lg-4">
                                        <label for="mrp" class="form-label">MRP</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="mrp" class="form-control"
                                                placeholder="Enter Here" name="mrp[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="price" class="form-label">Price</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="price" class="form-control"
                                                placeholder="Enter Here" name="price[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
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
                                    <div class="col-lg-3">
                                        <label for="qty" class="form-label">Qty</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="qty" class="form-control"
                                                placeholder="Enter Here" name="qty[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <label for="attr_image" class="form-label">Images</label>
                                        <div class="input-group mb-3">
                                            <input type="file" id="attr_image" class="form-control"
                                                name="attr_image[]">
                                        </div>
                                    </div>
                                    <div class="col-lg-1">
                                        <div class="input-group mt-3">
                                            <button class="btn btn-primary add-row" type="button">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="p-3 bg-light mb-3 rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-outline-secondary w-100">Create Product</button>

                            </div>
                            <div class="col-lg-2">
                                <button type="reset" class="btn btn-primary w-100">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('admin-js')
<script>
    var quill = new Quill('#short_description', {
        theme: 'snow',
        modules: {
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
    var quill = new Quill('#description', {
        theme: 'snow',
        modules: {
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
                <div class="row form-row">
                    <hr style="border: 0; height: 2px; background: linear-gradient( #808080, #ffff); margin: 20px 0;">
                    <div class="col-lg-4">
                        <label for="mrp" class="form-label">MRP</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Enter Here" name="mrp[]">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Enter Here" name="price[]">
                        </div>
                    </div>
                    <div class="col-lg-4">
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
                    <div class="col-lg-3">
                        <label for="qty" class="form-label">Qty</label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Enter Here" name="qty[]">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <label for="attr_image" class="form-label">Images</label>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" name="attr_image[]">
                        </div>
                    </div>
                    <div class="col-lg-1">
                        <div class="input-group mt-3">
                            <button class="btn btn-danger remove-row" type="button">Remove</button>
                        </div>
                    </div>
                </div>`;
                $('#form-rows').append(newRow);
            });
            $(document).on('click', '.remove-row', function() {
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
