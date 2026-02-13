@extends('admin.main.app')
@section('admin-title', 'Settings')
@section('admin-content')
<div class="container-xxl">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Payment Gateway Settings</h4>
                </div>
                <div class="card-body">
                    <form id="settingsForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="mb-3">Razorpay Configuration</h5>
                                
                                <div class="mb-3">
                                    <label for="razorpay_key_id" class="form-label">Razorpay Key ID</label>
                                    <input type="text" class="form-control" id="razorpay_key_id" name="razorpay_key_id" 
                                           value="{{ $settings->razorpay_key_id ?? '' }}" placeholder="Enter Razorpay Key ID" required>
                                </div>

                                <div class="mb-3">
                                    <label for="razorpay_key_secret" class="form-label">Razorpay Key Secret</label>
                                    <input type="password" class="form-control" id="razorpay_key_secret" name="razorpay_key_secret" 
                                           value="{{ $settings->razorpay_key_secret ?? '' }}" placeholder="Enter Razorpay Key Secret" required>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="razorpay_enabled" name="razorpay_enabled" 
                                               {{ isset($settings->razorpay_enabled) && $settings->razorpay_enabled == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="razorpay_enabled">Enable Razorpay</label>
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Save Settings</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('admin-js')
<script>
$(document).ready(function() {
    $('#settingsForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '{{ route("admin.settings.update") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    Swal.fire('Success!', response.message, 'success');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Error updating settings. Please try again.', 'error');
            }
        });
    });
});
</script>
@endsection
@endsection
