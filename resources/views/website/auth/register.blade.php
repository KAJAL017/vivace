@extends('website.main.app')
@section('title','Sign Up')
@section('website.content')
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
<section class="section-b-space pt-0">
    <div class="heading-banner">
        <div class="custom-container container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h4>Sign Up</h4>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb float-end">
                        <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                        <li class=" active"> <a href="{{ route('website.auth.register') }}">Register</a></li>
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
                <div class="login-img"> <img class="img-fluid" src="{{ path() }}/logo.svg" alt=""></div>
            </div>
            <div class="col-xxl-4 col-lg-6 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h4>Welcome To Vivace</h4>
                        <p>Create New Account</p>
                    </div>
                    <div class="login-box">
                        <form class="row g-3" id="RegisterData">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" id="floatingInputValue" name="name" type="text"
                                        placeholder="Full Name">
                                    <label for="floatingInputValue">Enter Your Name</label>
                                </div>
                                <span id="nameError" class="validation-error"></span>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" id="floatingInputNumber" name="phone" type="text"
                                        placeholder="Enter Your Phone Number">
                                    <label for="floatingInputNumber">Enter Your Phone Number</label>
                                </div>
                                <span id="phoneError" class="validation-error"></span>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" id="floatingInputValue1" name="email" type="email"
                                        placeholder="name@example.com">
                                    <label for="floatingInputValue1">Enter Your Email</label>
                                </div>
                                <span id="emailError" class="validation-error"></span>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input class="form-control" id="floatingInputValue2" name="password" type="password"
                                        placeholder="Password">
                                    <label for="floatingInputValue2">Enter Your Password</label>
                                </div>
                                <span id="passwordError" class="validation-error"></span>
                            </div>
                            <div class="col-12">
                                <div class="forgot-box">
                                    <div>
                                        <input class="custom-checkbox me-2" id="category1" name="terms"
                                            type="checkbox">
                                        <label for="category1">I agree with <span><a
                                                    href="{{ route('terms') }}">Terms</a> </span>and <span><a
                                                    href="{{ route('privacy-Policy') }}">Privacy</a></span></label>
                                    </div>
                                </div>
                                <span id="termsError" class="validation-error"></span>
                            </div>
                            <div class="col-12">
                                <button class="btn login btn_black sm" type="submit">Sign Up</button>
                            </div>
                        </form>
                    </div>
                    <div class="other-log-in">
                        <h6>OR</h6>
                    </div>
                    <div class="other-log-in"></div>
                    <div class="sign-up-box">
                        <p>Already have an account?</p><a href="{{ route('login') }}">Log In </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('website.js')
<script>
    $(document).on('submit', '#RegisterData', function(e) {
        e.preventDefault();

        let formData = {
            name: $('#floatingInputValue').val(),
            phone: $('#floatingInputNumber').val(),
            email: $('#floatingInputValue1').val(),
            password: $('#floatingInputValue2').val(),
            terms: $('#category1').is(':checked') ? 1 : 0,
        };

        $('.validation-error').text('');
        $('.form-control').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('signup.store') }}",
            type: "POST",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Reset the form before redirecting
                    $('#RegisterData')[0].reset();

                    // Redirect to the URL passed in the response
                    window.location.href = "{{ route('website.home') }}";  // Use Blade directive to inject the route
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        $(`#${key}Error`).text(value[0]); // Show error below input
                        $(`[name="${key}"]`).addClass('is-invalid'); // Highlight invalid input
                    }
                }
            }
        });
    });
</script>
@endsection
