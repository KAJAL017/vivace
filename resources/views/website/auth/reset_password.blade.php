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
                            <h4>Welcome To Vivace Collections</h4>
                            <p>Reset Your Password</p>
                        </div>
                        <div class="login-box">
                            <form id="passwordResetForm">
                                @csrf
                                <input type="hidden" name="token" value="{{ request('token') }}">
                                <input type="hidden" name="email" value="{{ request('email') }}">
                                <div class="col-12">
                                    <div class="form-floating position-relative">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter New Password" required>
                                        <label for="password">Enter New Password</label>
                                        <!-- Eye icon button -->
                                        <button type="button" id="togglePassword" class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-2">
                                            <i id="eyeIcon" class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="form-group position-relative">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Enter Confirm Password" class="form-control" required>
                                    <!-- Eye icon button -->
                                    <button type="button" id="toggleConfirmPassword" class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-2" style="margin-top: 13px">
                                        <i id="eyeIconConfirm" class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <button type="submit" class="btn login btn_black sm mt-3">Reset Password</button>
                            </form>
                        </div>
                        <div class="other-log-in"></div>
                        <div class="sign-up-box">
                             <a class="text-decoration-underline" href="{{ route('login') }}">Back To Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('website.js')
<script>
    $('#passwordResetForm').on('submit', function(e) {
        e.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: '{{ route('password.update') }}',
            method: 'POST',
            data: formData,
            success: function(data) {
                console.log(data);
                if (data.status === 'success') {
                    toastr.success(data.message);
                    window.location.href = '{{ route('login') }}';
                } else if (data.status === 'error') {
                    toastr.error(data.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        toastr.error(messages[0]);
                    });
                } else {
                    toastr.error('An error occurred while resetting the password.');
                }
            }
        });
    });
</script>


@endsection
