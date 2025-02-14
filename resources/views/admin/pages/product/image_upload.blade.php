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
@section('admin-title', 'Upload Imgae Upload')
@section('admin-css')
@endsection
@section('admin-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <form action="{{ route('images.upload.process') }}" method="post" class="dropzone" id="imageDropzone">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $data }}">
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
    Dropzone.options.imageDropzone = {
        maxFiles: 4,
        maxFilesize: 2,
        acceptedFiles: 'image/*',
        addRemoveLinks: true,
        init: function() {
            this.on("success", function(file, response) {
                console.log(response);
            });
            this.on("error", function(file, response) {
                console.log(response);
            });
        }
    };
</script>
@endsection
