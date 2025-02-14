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
@section('admin-title', 'Create Category')
@section('admin-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <form id="categoryForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Collection Name</label>
                                    <input type="text" name="collection_name" class="form-control"
                                        id="validationCustom01" required placeholder="Enter Category Name"
                                        value="{{ $name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom02" class="form-label">Collection Image</label>
                                    <input type="file" name="collection_image" class="form-control"
                                        id="validationCustom02" required>

                                    <div class="d-flex justify-content-center align-items-center mt-3">
                                        <img src="{{ path() }}/uploads/{{ $image_path }}" alt="" width="100px" alt="dd">
                                    </div>
                                </div>
                                @php
                                    $categories = DB::table('sub_categories')
                                        ->where(['is_deleted' => 0])
                                        ->get();
                                @endphp
                                <div class="col-lg-12">
                                    <label for="product-categories" class="form-label">Collection Category</label>
                                    <select class="form-control" id="product-categories" name="sub_category" data-choices
                                        data-choices-groups data-placeholder="Select Categories">
                                        <option value="">Choose a category</option>
                                        @foreach ($categories as $category)
                                            <option {{ $sub_category_id == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary"
                                        type="submit">{{ $update == true ? 'Update' : 'Submit' }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
@endsection
@section('admin-js')
    <script>
        $(document).ready(function() {
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
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(function() {
                                window.location.href =
                                    "{{ route('collections.index') }}";
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
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An unexpected error occurred.',
                            });
                        }
                    }
                });
            });
        });
    </script>

@endsection
