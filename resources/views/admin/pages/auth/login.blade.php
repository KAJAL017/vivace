<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>Sign In || Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ admin_assets() }}/assets/images/favicon.ico">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ admin_assets() }}/assets/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/config.js"></script>
</head>

<body class="h-100">
    <div class="d-flex flex-column h-100 p-3">
        <div class="d-flex flex-column flex-grow-1">
            <div class="row h-100">
                <div class="col-xxl-7">
                    <div class="row justify-content-center h-100">
                        <div class="col-lg-6 py-lg-5">
                            <div class="d-flex flex-column h-100 justify-content-center">
                                <div class="auth-logo mb-4">
                                      <img src='{{ path() }}/vivaceLogo (1).png' width="300px"/>
                                </div>

                                <h2 class="fw-bold fs-24">Sign In</h2>

                                <p class="text-muted mt-1 mb-4">Enter your email address and password to access admin
                                    panel.</p>

                                <div class="mb-5">
                                    <form id="loginForm">
                                        <div class="mb-3">
                                            <label class="form-label" for="example-email">Email</label>
                                            <input type="email" id="example-email" name="email" class="form-control"
                                                placeholder="Enter your email" required value="{{ Cookie::get('email', '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="example-password">Password</label>
                                            <input type="password" id="example-password" name="password" class="form-control"
                                                placeholder="Enter your password" required value="{{ Cookie::get('password', '') }}">
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin" name="remember" {{ Cookie::get('email') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="mb-1 text-center d-grid">
                                            <button class="btn btn-soft-primary" type="submit">Sign In</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-5 d-none d-xxl-flex">
                    <div class="card h-100 mb-0 overflow-hidden">
                        <div class="d-flex flex-column h-100">
                            <img src="{{ admin_assets() }}/assets/images/small/img-10.jpg" alt=""
                                class="w-100 h-100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/vendor.js"></script>

    <!-- App Javascript (Require in all Page) -->
    <script src="{{ admin_assets() }}/assets/js/app.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#loginForm').on('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route('admin.login.process') }}',
                    type: 'POST',
                    data: {
                        email: $('#example-email').val(),
                        password: $('#example-password').val(),
                        remember: $('#checkbox-signin').is(':checked'),
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Logged in successfully!',
                                text: response.message,
                                confirmButtonText: 'OK',
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href ='{{ route('admin.dashboard') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Login failed',
                                text: response.message
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred',
                            text: xhr.responseJSON.message || 'Something went wrong, please try again.'
                        });
                    }
                });
            });
        });
    </script>


</body>

</html>
