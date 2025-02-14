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
                        </div>
                        <div class="login-box">
                            <form class="row g-3" id="LoginForm">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" id="email" type="email" name="email" placeholder="Enter Your Email Address">
                                        <label for="email">Enter Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" id="password" type="password" name="password" placeholder="Enter Your Password">
                                        <label for="password">Enter Your Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div>
                                            <input class="custom-checkbox me-2" id="remember" type="checkbox" name="remember">
                                            <label for="remember">Remember me</label>
                                        </div>
                                        <a href="{{ route('forget.password') }}">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn login btn_black sm" type="submit">Log In</button>
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
    $(document).on('submit', '#LoginForm', function(e) {
        e.preventDefault();

        // Clear previous validation error messages
        $('.validation-error').remove();

        let email = $('#email').val();
        let password = $('#password').val();
        let remember = $('#remember').is(':checked');
        let firstErrorElement = null; // To track the first error field for focus

        $.ajax({
            url: "{{ route('login.process') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                email: email,
                password: password,
                remember: remember
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success', response.message, 'success').then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;

                    for (const [key, value] of Object.entries(errors)) {
                        const inputElement = $(`#${key}`);
                        inputElement.after(`<div class="validation-error" style="color: red; font-size: 0.875rem; margin-top: 5px;">${value}</div>`);

                        // Set focus to the first input field with an error
                        if (!firstErrorElement) {
                            firstErrorElement = inputElement;
                        }
                    }

                    // Focus the first invalid input field
                    if (firstErrorElement) {
                        firstErrorElement.focus();
                    }
                } else {
                    Swal.fire('Error', 'An unexpected error occurred.', 'error');
                }
            }
        });
    });
</script>

@endsection
