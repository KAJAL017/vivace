@php
    if (isset($banners)) {
        $id = $banners->id;
        $banner = $banners->banner;
        $url = $banners->url;
        $index_number = $banners->index_number;
        $update = true;
    } else {
        $id = '';
        $banner_text = '';
        $banner = '';
        $url = '';
        $index_number = '';
        $update = false;
    }
@endphp

@extends('admin.main.app')
@section('admin-title', 'Create Banner')
@section('admin-content')
    <div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4> {{ $update == true ? 'Edit' : 'Add'}} Banner</h4>
        </div>
    </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <form id="categoryForm" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <div class="col-md-12">
                                    <label for="banner" class="form-label">Banner</label>
                                    <input type="file" name="banner" class="form-control" id="banner"  >

                                </div>
                                <div class="col-md-12">
                                    <label for="url" class="form-label">Url</label>
                                    <input type="text" name="url" class="form-control" id="url"  placeholder="Enter Banner Url" value="{{ $url ?? '' }}">

                                </div>
                                <div class="col-md-12">
                                    <label for="url" class="form-label">Index</label>
                                    <input type="number" name="index" class="form-control" id="index"  placeholder="Enter Banner Index Number" value="{{ $index_number ?? '' }}">

                                </div>
                                <img src="{{ url('public/uploads') }}/{{ $banner }}" alt="" width="100%" class="mt-5">
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
                    url: "{{ route('banner.store') }}",
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
                                window.location.href = "{{ route('banner.index') }}";
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
