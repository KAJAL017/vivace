
@php
use Carbon\Carbon;
    if (isset($coupons)) {
        $id = $coupons->id;
        $coupon_code = $coupons->coupon_code;
        $coupon_type = $coupons->coupon_type;
        $discount_value = $coupons->discount_value;
        $start_date = Carbon::createFromFormat('d-m-Y', $coupons->start_date)->format('Y-m-d');
        $end_date = Carbon::createFromFormat('d-m-Y', $coupons->end_date)->format('Y-m-d');
        $status = $coupons->status;
        $update = true;
    } else {
        $id = "";
        $coupon_code = "";
        $coupon_type = "";
        $discount_value = "";
        $start_date = "";
        $end_date = "";
        $status = "";
        $update = false;
    }
@endphp


@extends('admin.main.app')
@section('admin-content')
@section('admin-title', 'Create Coupon')
@section('admin-css')
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table/css/vendors/datatable-extension.css">
    <link rel="stylesheet" type="text/css" href="{{ admin_assets() }}/table.css">
@endsection

@section('admin-content')
    <div class="container-xxl">
        <div class="card">
            <div class="card-body">
                <h4>Add Coupon</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <form id="categoryForm" class="g-3 needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $id }}" name="id">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Coupon Status</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="1" name="status"
                                                id="status" value="Active" {{ $status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="0" name="status"
                                            id="InActive" value="InActive" {{ $status == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="InActive">Inactive</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Date Schedule</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="start-date" class="form-label text-dark">Start Date</label>
                                <input type="text" id="start-date" class="form-control flatpickr-input active"
                                    placeholder="dd-mm-yyyy" readonly="readonly" name="start_date" value="{{ $start_date }}">
                            </div>

                            <div class="mb-3">
                                <label for="end-date" class="form-label text-dark">End Date</label>
                                <input type="text" id="end-date" class="form-control flatpickr-input active"
                                    placeholder="dd-mm-yyyy" readonly="readonly" name="end_date" value="{{ $end_date }}">
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Coupon Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="coupons-code" class="form-label">Coupons Code</label>
                                    <input type="text" id="coupons-code" name="coupon_code" value="{{ $coupon_code }}" class="form-control"
                                        placeholder="Enter Code">
                                </div>
                            </div>
                        </div>

                        <h4 class="card-title mb-3 mt-2">Coupons Types</h4>
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="coupon_type" value="1"
                                        id="percentage" {{ $coupon_type == 1 ? 'checked' : ''}} >
                                    <label class="form-check-label" for="percentage">Percentage</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="2" name="coupon_type"
                                        id="fixedamount" {{ $coupon_type == 2 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="fixedamount">Fixed Amount</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="discount-value" class="form-label">Discount Value</label>
                                    <input type="text" id="discount-value" name="discount_value" class="form-control" placeholder="Enter Value" value="{{ $discount_value }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-primary"> {{ $update == true ? 'Update' : 'Create' }} Coupon</button>
                    </div>

                </div>

            </div>
            </form>
        </div>
    </div>

@endsection

@section('admin-js')
    <script src="{{ admin_assets() }}/assets/js/pages/coupons-add.js"></script>
    <script>
        $(document).ready(function() {
            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('coupon.store') }}", // Make sure this route exists and is correct
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
                                    "{{ route('coupon.index') }}"; // Adjust redirect URL
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Handle validation errors
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            $.each(errors, function(key, value) {
                                errorMessages += value +
                                    '<br>'; // Use <br> for line breaks
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessages, // Use 'html' instead of 'text' to render HTML
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
