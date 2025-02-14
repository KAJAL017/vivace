@php
    if (isset($sub_categories)) {
        $id = $sub_categories->id;
        $name = $sub_categories->name;
        $image = $sub_categories->image;
        $category_id = $sub_categories->category_id;
        $show_in_top_bar = $sub_categories->show_in_top_bar;
        $title = 'Edit Sub Category';
        $update = true;
    } else {
        $id = '';
        $name = '';
        $category_id = '';
        $image = '';
        $show_in_top_bar = '';
        $title = 'Create Sub Category';
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', $title)
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
                                    <label for="validationCustom01" class="form-label">Sub Category Name</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                        required placeholder="Enter Category Name" value="{{ $name }}">
                                </div>
                                @php
                                    $categories = DB::table('categories')
                                        ->where(['is_deleted' => 0])
                                        ->orderBy('id', 'DESC')
                                        ->get();
                                @endphp
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Categories</label>
                                    <select class="form-control" data-choices name="category" id="choices-single-default">
                                        @foreach ($categories as $category)
                                            <option {{ $category_id == $category->id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col-md-12">
                                    <label for="image" class="form-label">Subcategory Image &nbsp;&nbsp;(242 x
                                        281)</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                </div>
                                @if ($update == true)
                                    <div class="col-md-12 mt-2 d-flex justify-content-center align-items-center">
                                        <img src="{{ url(is_string($image) ? $image : 'path/to/default/image.jpg') }}" alt="">

                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" name="show_in_top_bar" value="1"
                                            type="checkbox" id="invalidCheck" @checked($show_in_top_bar == 1)>
                                        <label class="form-check-label" for="invalidCheck">
                                            Show In The Top Bar
                                        </label>
                                    </div>
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
                    url: "{{ route('subcategories.store') }}",
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
                                    "{{ route('subcategories.index') }}";
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors
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
