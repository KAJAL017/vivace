@extends('website.main.app')
@section('title','Login')
@section('website-css')
<style>
    .validation-error {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    .validation-error {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .form-control.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
    }
</style>
@endsection
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Login</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                            <li class=" active"> <a href="{{ route('login') }}">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0 login-bg-img">
        <div class="custom-container container login-page">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-6 d-none d-lg-block">
                    <div class="login-img"> <img class="img-fluid"
                            src="{{ path() }}/1.svg"
                            alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>Welcome To Vivace</h4>
                            <p style="color: #7f8c8d; font-size: 14px; margin-top: 10px;">Login with OTP sent to your email</p>
                        </div>
                        
                        <div class="login-box">
                            <!-- Step 1: Request OTP -->
                            <form class="row g-3" id="RequestOtpForm">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" id="otp_email" type="email" name="email" placeholder="Enter Your Email Address">
                                        <label for="otp_email">Enter Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="submit">Send OTP</button>
                                </div>
                            </form>
                            
                            <!-- Step 2: Verify OTP (Hidden initially) -->
                            <form class="row g-3" id="VerifyOtpForm" style="display: none;">
                                @csrf
                                <input type="hidden" id="verify_email" name="email">
                                <div class="col-12">
                                    <div class="alert alert-info" role="alert" style="font-size: 14px; display: flex; justify-content: space-between; align-items: center;">
                                        <span>📧 OTP sent to <strong id="sent_email"></strong></span>
                                        <button type="button" class="btn btn-sm btn-outline-primary" id="changeEmailBtn" style="font-size: 12px; padding: 2px 10px;">Change Email</button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" id="otp_code" type="text" name="otp" placeholder="Enter 6-digit OTP" maxlength="6" pattern="[0-9]{6}">
                                        <label for="otp_code">Enter 6-digit OTP</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="submit">Verify & Login</button>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="button" class="btn btn-link" id="resendOtpBtn" style="font-size: 14px;">Resend OTP</button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="other-log-in">
                            <h6>OR</h6>
                        </div>
                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                            <p>Don't have an account?</p><a href="{{ route('website.auth.register') }}">Sign Up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('website.js')
<script>
// Request OTP
$(document).on('submit', '#RequestOtpForm', function(e) {
    e.preventDefault();
    $('.validation-error').remove();

    let email = $('#otp_email').val();
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    $.ajax({
        url: "{{ route('login.otp.send') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            email: email
        },
        beforeSend: function() {
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...');
        },
        success: function(response) {
            submitBtn.prop('disabled', false);
            submitBtn.html(originalText);
            
            if (response.success) {
                $('#RequestOtpForm').hide();
                $('#VerifyOtpForm').show();
                $('#verify_email').val(email);
                $('#sent_email').text(email);
                
                // Show success message
                const alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Success!</strong> ' + response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#VerifyOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            } else {
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Error!</strong> ' + response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#RequestOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            }
        },
        error: function(xhr) {
            submitBtn.prop('disabled', false);
            submitBtn.html(originalText);
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                for (const [key, value] of Object.entries(errors)) {
                    const inputElement = $('#otp_email');
                    inputElement.after(`<div class="validation-error">${value}</div>`);
                }
            } else {
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Error!</strong> ' + (xhr.responseJSON?.message || 'An unexpected error occurred.') +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#RequestOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            }
        }
    });
});

// Verify OTP
$(document).on('submit', '#VerifyOtpForm', function(e) {
    e.preventDefault();
    $('.validation-error').remove();

    let email = $('#verify_email').val();
    let otp = $('#otp_code').val();
    let submitBtn = $(this).find('button[type="submit"]');
    let originalText = submitBtn.html();

    $.ajax({
        url: "{{ route('login.otp.verify') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            email: email,
            otp: otp
        },
        beforeSend: function() {
            submitBtn.prop('disabled', true);
            submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Verifying...');
        },
        success: function(response) {
            if (response.success) {
                submitBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Logging in...');
                window.location.href = response.redirect;
            } else {
                submitBtn.prop('disabled', false);
                submitBtn.html(originalText);
                
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Error!</strong> ' + response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#VerifyOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            }
        },
        error: function(xhr) {
            submitBtn.prop('disabled', false);
            submitBtn.html(originalText);
            
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                for (const [key, value] of Object.entries(errors)) {
                    const inputElement = $('#otp_code');
                    inputElement.after(`<div class="validation-error">${value}</div>`);
                }
            } else {
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Error!</strong> ' + (xhr.responseJSON?.message || 'Invalid OTP or OTP expired.') +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#VerifyOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            }
        }
    });
});

// Resend OTP
$(document).on('click', '#resendOtpBtn', function(e) {
    e.preventDefault();
    let email = $('#verify_email').val();
    let resendBtn = $(this);
    let originalText = resendBtn.html();

    $.ajax({
        url: "{{ route('login.otp.send') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            email: email
        },
        beforeSend: function() {
            resendBtn.prop('disabled', true);
            resendBtn.html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Resending...');
        },
        success: function(response) {
            resendBtn.prop('disabled', false);
            resendBtn.html(originalText);
            
            if (response.success) {
                $('#otp_code').val('');
                
                // Remove old alerts
                $('#VerifyOtpForm .alert-success, #VerifyOtpForm .alert-danger').remove();
                
                const alertDiv = $('<div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Success!</strong> OTP resent successfully!' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#VerifyOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            } else {
                const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                    '<strong>Error!</strong> ' + response.message +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                    '</div>');
                $('#VerifyOtpForm').prepend(alertDiv);
                setTimeout(() => alertDiv.fadeOut(), 5000);
            }
        },
        error: function(xhr) {
            resendBtn.prop('disabled', false);
            resendBtn.html(originalText);
            
            const alertDiv = $('<div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 15px;">' +
                '<strong>Error!</strong> Failed to resend OTP. Please try again.' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>');
            $('#VerifyOtpForm').prepend(alertDiv);
            setTimeout(() => alertDiv.fadeOut(), 5000);
        }
    });
});

// Change Email - Go back to request OTP form
$(document).on('click', '#changeEmailBtn', function(e) {
    e.preventDefault();
    
    // Clear OTP form
    $('#otp_code').val('');
    $('#verify_email').val('');
    
    // Remove any alerts
    $('.alert-success, .alert-danger').remove();
    $('.validation-error').remove();
    
    // Hide verify form and show request form
    $('#VerifyOtpForm').hide();
    $('#RequestOtpForm').show();
});
</script>
@endsection
