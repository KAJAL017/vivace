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
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="razorpay_key_secret" name="razorpay_key_secret"
                                               value="{{ $settings->razorpay_key_secret ?? '' }}" placeholder="Enter Razorpay Key Secret" required>
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none" style="padding: 0.375rem 0.75rem;" onclick="togglePassword('razorpay_key_secret', 'razorpayKeySecretIcon')">
                                            <i id="razorpayKeySecretIcon" class="ri-eye-off-line"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="razorpay_enabled" name="razorpay_enabled" 
                                               {{ isset($settings->razorpay_enabled) && $settings->razorpay_enabled == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="razorpay_enabled">Enable Razorpay</label>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Cash on Delivery (COD)</h5>
                                
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="cod_enabled" name="cod_enabled"
                                               {{ isset($settings->cod_enabled) && $settings->cod_enabled == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cod_enabled">Enable Cash on Delivery</label>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">Google Analytics</h5>

                                <div class="mb-3">
                                    <label for="google_analytics_id" class="form-label">Google Analytics Measurement ID</label>
                                    <input type="text" class="form-control" id="google_analytics_id" name="google_analytics_id"
                                           value="{{ $settings->google_analytics_id ?? '' }}" placeholder="G-XXXXXXXXXX">
                                    <small class="text-muted">Format: G-XXXXXXXXXX or UA-XXXXXXXX-X</small>
                                </div>

                                <div class="mb-3">
                                    <label for="google_analytics_api_key" class="form-label">Google Analytics API Key (Optional)</label>
                                    <input type="text" class="form-control" id="google_analytics_api_key" name="google_analytics_api_key"
                                           value="{{ $settings->google_analytics_api_key ?? '' }}" placeholder="For advanced analytics dashboard">
                                </div>

                                <hr class="my-4">

                                <h5 class="mb-3">ImageKit Configuration</h5>

                                <div class="mb-3">
                                    <label for="imagekit_public_key" class="form-label">ImageKit Public Key</label>
                                    <input type="text" class="form-control" id="imagekit_public_key" name="imagekit_public_key"
                                           value="{{ $settings->imagekit_public_key ?? '' }}" placeholder="Enter ImageKit Public Key">
                                    <small class="text-muted">Get your public key from ImageKit dashboard</small>
                                </div>

                                <div class="mb-3">
                                    <label for="imagekit_private_key" class="form-label">ImageKit Private Key</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="imagekit_private_key" name="imagekit_private_key"
                                               value="{{ $settings->imagekit_private_key ?? '' }}" placeholder="Enter ImageKit Private Key">
                                        <button type="button" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none" style="padding: 0.375rem 0.75rem;" onclick="togglePassword('imagekit_private_key', 'imagekitPrivateKeyIcon')">
                                            <i id="imagekitPrivateKeyIcon" class="ri-eye-off-line"></i>
                                        </button>
                                    </div>
                                    <small class="text-muted">Keep this key secure and never share it publicly</small>
                                </div>

                                <div class="mb-3">
                                    <label for="imagekit_url_endpoint" class="form-label">ImageKit URL Endpoint</label>
                                    <input type="text" class="form-control" id="imagekit_url_endpoint" name="imagekit_url_endpoint"
                                           value="{{ $settings->imagekit_url_endpoint ?? '' }}" placeholder="https://ik.imagekit.io/your_imagekit_id">
                                    <small class="text-muted">Format: https://ik.imagekit.io/your_imagekit_id</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="imagekit_enabled" name="imagekit_enabled"
                                               {{ isset($settings->imagekit_enabled) && $settings->imagekit_enabled == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="imagekit_enabled">Enable ImageKit</label>
                                    </div>
                                    <small class="text-muted">Enable to use ImageKit for image optimization and delivery</small>
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
function togglePassword(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("ri-eye-off-line");
        icon.classList.add("ri-eye-line");
    } else {
        input.type = "password";
        icon.classList.remove("ri-eye-line");
        icon.classList.add("ri-eye-off-line");
    }
}

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
