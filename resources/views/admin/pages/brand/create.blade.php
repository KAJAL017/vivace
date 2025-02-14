@php
    if (isset($brands)) {
        $id = $brands->id;
        $name = $brands->name;
        $update = true;
    } else {
        $id = '';
        $name = '';
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
                                    <label for="validationCustom01" class="form-label">Brand Name</label>
                                    <input type="text" name="name" class="form-control" id="validationCustom01"
                                        required placeholder="Enter Brand Name" value="{{ $name }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom02" class="form-label">Brand Logo &nbsp;&nbsp;(177 x 33)</label>
                                    <input type="file" name="image" class="form-control" id="validationCustom02"
                                        >
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary" type="submit">{{ $update == true ? 'Update' : 'Submit' }}</button>
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
                    url: "{{ route('brand.store') }}",
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
                                window.location.href = "{{ route('brand.index') }}";
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
