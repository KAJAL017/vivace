@extends('website.main.app')
@section('website.content')
    <section class="section-b-space pt-0 login-bg-img">
        <div class="custom-container container login-page">
            <div class="row align-items-center">
                <div class="col-xxl-7 col-6 d-none d-lg-block">
                    <div class="login-img"> <img class="img-fluid" src="{{ path() }}/1.svg" alt=""></div>
                </div>
                <div class="col-xxl-4 col-lg-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h4>Welcome To Vivace Collections;</h4>
                            <p>Forgot your password</p>
                        </div>
                        <div class="login-box">
                            <form class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input class="form-control" id="floatingInputValue" type="email"
                                            placeholder="name@example.com">
                                        <label for="floatingInputValue">Enter Your Email</label>
                                    </div>
                                </div>
                                <div class="col-12"> <a class="btn login btn_black sm">Send Email </a></div>
                            </form>
                        </div>
                        <div class="other-log-in"></div>
                        <div class="sign-up-box"> <a class="text-decoration-underline" href="{{ route('login') }}">Back To
                                Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('website.js')
    <script>
        $(document).ready(function() {
            $('.btn.login').on('click', function(e) {
                e.preventDefault();

                const email = $('#floatingInputValue').val();

                $.ajax({
                    url: '{{ route('send-reset-password-email') }}',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                             $('#floatingInputValue').val('');
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection
