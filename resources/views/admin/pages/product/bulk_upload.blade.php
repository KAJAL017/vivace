@php
    if (isset($categories)) {
        $id = $categories->id;
        $name = $categories->name;
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
                            <form id="bulkUploadForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data"
                                method="POST" action="/upload-excel">
                                @csrf
                                <div class="col-md-12">
                                    <label for="bulkUploadFile" class="form-label">Upload Excel File</label>
                                    <input type="file" name="excel_file" class="form-control" id="bulkUploadFile"
                                        required accept=".xlsx, .xls, .csv">
                                    <div class="invalid-feedback">
                                        Please upload a valid Excel file.
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-between">
                                    <button class="btn btn-dark" type="submit">Upload Now</button>
                                    <a href="{{ url('public/demo_bulk_product_upload.xlsx') }}" class="btn btn-secondary">
                                        <i class="fa fa-download"></i> Download Excel Template
                                    </a>
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
    $('#bulkUploadForm').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "{{ route('product.uploadExcel') }}",
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
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
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
