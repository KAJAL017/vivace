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
@section('admin-title', $update ? 'Edit Coupon' : 'Create Coupon')
@section('topbar-text', $update ? 'Edit Coupon' : 'Create Coupon')

@section('admin-css')
<style>
    /* Corporate Coupon Form */
    .coupon-form-container {
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
    
    .form-check {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }
    
    .form-check:hover {
        border-color: #e74c3c;
        background: #fff5f5;
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
        font-weight: 600;
        color: #495057;
        cursor: pointer;
        margin-left: 0.5rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding: 1.5rem;
        background: #f8f9fa;
        border-top: 2px solid #e9ecef;
        border-radius: 0 0 16px 16px;
    }
    
    .btn-cancel {
        background: #95a5a6;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-cancel:hover {
        background: #7f8c8d;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
    }
    
    /* Date Input Styling */
    .flatpickr-input {
        background: white;
        cursor: pointer;
    }
    
    /* Radio Group Styling */
    .radio-group {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        
        .btn-cancel,
        .btn-submit {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection

@section('admin-content')
<div class="container-fluid coupon-form-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <h2>{{ $update ? '✏️ Edit Coupon' : '➕ Create New Coupon' }}</h2>
        <p>{{ $update ? 'Update coupon details and settings' : 'Fill in the details below to create a new discount coupon' }}</p>
    </div>
    
    <form id="categoryForm" class="g-3 needs-validation" novalidate enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $id }}" name="id">
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-5">
                
                <!-- Coupon Status -->
                <div class="section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:shield-check-bold"></iconify-icon>
                            Coupon Status
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="radio-group">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="1" name="status"
                                    id="status" {{ $status == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="0" name="status"
                                    id="InActive" {{ $status == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="InActive">Inactive</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Date Schedule -->
                <div class="section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:calendar-bold"></iconify-icon>
                            Date Schedule
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="start-date" class="form-label">Start Date</label>
                            <input type="text" id="start-date" class="form-control flatpickr-input active"
                                placeholder="Select start date" readonly="readonly" name="start_date" value="{{ $start_date }}">
                        </div>

                        <div class="mb-0">
                            <label for="end-date" class="form-label">End Date</label>
                            <input type="text" id="end-date" class="form-control flatpickr-input active"
                                placeholder="Select end date" readonly="readonly" name="end_date" value="{{ $end_date }}">
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Right Column -->
            <div class="col-lg-7">
                <div class="section-card">
                    <div class="card-header">
                        <h4>
                            <iconify-icon icon="solar:ticket-bold"></iconify-icon>
                            Coupon Information
                        </h4>
                    </div>
                    <div class="card-body">
                        <!-- Coupon Code -->
                        <div class="mb-4">
                            <label for="coupons-code" class="form-label">Coupon Code</label>
                            <input type="text" id="coupons-code" name="coupon_code" value="{{ $coupon_code }}" 
                                class="form-control" placeholder="Enter coupon code (e.g., SAVE20)">
                        </div>

                        <!-- Coupon Type -->
                        <div class="mb-4">
                            <label class="form-label">Coupon Type</label>
                            <div class="radio-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="coupon_type" value="1"
                                        id="percentage" {{ $coupon_type == 1 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="percentage">Percentage</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" value="2" name="coupon_type"
                                        id="fixedamount" {{ $coupon_type == 2 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="fixedamount">Fixed Amount</label>
                                </div>
                            </div>
                        </div>

                        <!-- Discount Value -->
                        <div class="mb-0">
                            <label for="discount-value" class="form-label">Discount Value</label>
                            <input type="text" id="discount-value" name="discount_value" class="form-control" 
                                placeholder="Enter discount value" value="{{ $discount_value }}">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('coupon.index') }}" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-submit">
                            {{ $update ? 'Update Coupon' : 'Create Coupon' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                url: "{{ route('coupon.store') }}",
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
                            confirmButtonColor: '#27ae60',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = "{{ route('coupon.index') }}";
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        $.each(errors, function(key, value) {
                            errorMessages += value + '<br>';
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            confirmButtonColor: '#e74c3c'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            confirmButtonColor: '#e74c3c'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
