<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Order Form</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hidden {
            display: none;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h2>Direct Order Form</h2>
            </div>
            <div class="card-body">
                <form id="orderForm" enctype="multipart/form-data" style='display:none'>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="productScreenshot" class="form-label">Upload Product Screenshot</label>
                            <input type="file" id="productScreenshot" name="productScreenshot[]" class="form-control"
                                required multiple>
                            <div class="text-danger small" id="productScreenshotError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="paymentScreenshot" class="form-label">Upload Payment Screenshot</label>
                            <input type="file" id="paymentScreenshot" name="paymentScreenshot[]" class="form-control"
                                required multiple>
                            <div class="text-danger small" id="paymentScreenshotError"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                placeholder="Enter your name" required>
                            <div class="text-danger small" id="nameError"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mobile" class="form-label">Mobile No</label>
                            <input type="tel" id="mobile" name="mobile" class="form-control"
                                placeholder="Enter your mobile number" required pattern="^\d{10}$"
                                title="Mobile number must be exactly 10 digits">
                            <div class="text-danger small" id="mobileError"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="Enter your Email" required>
                            <div class="text-danger small" id="emailError"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="alternateMobile" class="form-label">Alternate Mobile No</label>
                            <input type="tel" id="alternateMobile" name="alternateMobile" class="form-control"
                                placeholder="Enter alternate mobile number" required pattern="^\d{10}$"
                                title="Mobile number must be exactly 10 digits">
                            <div class="text-danger small" id="alternateMobileError"></div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="streetAddress" class="form-label">Street Address</label>
                            <input type="text" id="streetAddress" name="streetAddress" class="form-control"
                                placeholder="Enter your street address" required>
                            <div class="text-danger small" id="streetAddressError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="colony" class="form-label">Colony/Mohalla</label>
                            <input type="text" id="colony" name="colony" class="form-control"
                                placeholder="Enter your colony or mohalla" required>
                            <div class="text-danger small" id="colonyError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" id="pincode" name="pincode" class="form-control"
                                placeholder="Enter pincode" required pattern="^\d{6}$"
                                title="Pincode must be exactly 6 digits">
                            <div class="text-danger small" id="pincodeError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" id="city" name="city" class="form-control"
                                placeholder="Enter your city" required>
                            <div class="text-danger small" id="cityError"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" id="state" name="state" class="form-control"
                                placeholder="Enter your state" required>
                            <div class="text-danger small" id="stateError"></div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" id="submitButton" class="btn btn-dark w-100"> Submit </button>
                        <div id="successMessage" class="alert alert-success mt-3 d-none"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const form = document.getElementById('orderForm');
            const submitButton = document.getElementById('submitButton');
            let isValid = true;

            form.querySelectorAll('input').forEach(input => {
                if (input.required && !input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = '#FF0000';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });

            submitButton.disabled = !isValid;
        }

        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', validateForm);
        });
    </script>
<script>
    $('#orderForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        resetErrorMessages();

        $('#submitButton').html('<i class="fas fa-spinner fa-spin"></i> Please wait...').prop('disabled', true);
        $('#thankYouMessage').fadeOut(); // पहले का थैंक यू मैसेज छुपाएँ

        $.ajax({
            url: '{{ route('store.manual.order') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#submitButton').html('Submit').prop('disabled', false);
                if (response.success) {
                    $('#orderForm')[0].reset();
                    Swal.fire({
                        title: "🎉 Thank You!",
                        html: `
                            <div style="font-size:18px; line-height:1.6; text-align:center;">
                                <p>✅ Your order has been placed successfully!</p>
                                 <p><b>Order ID:</b> <span style="color:#d9534f;">${response.order_id}</span></p>
                                <p>We have received your details and will process your order soon.</p>
                                <p>For any queries, contact us at <b style="color:#0275d8;">contact@vivacecollections.com</b>.</p>
                            </div>`,
                        icon: "success",
                        confirmButtonText: "OK",
                        allowOutsideClick: false
                    });
                } else {
                    toastr.error(response.message || 'Something went wrong.');
                }
            },
            error: function(xhr) {
                $('#submitButton').html('Submit').prop('disabled', false);
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    if (errors) {
                        for (const field in errors) {
                            if (errors[field].length > 0) {
                                $('#' + field + 'Error').text(errors[field].join(', '));
                            }
                        }
                    } else {
                        toastr.error('Validation error occurred.');
                    }
                } else {
                    toastr.error('An unexpected error occurred.');
                }
            }
        });
    });

    function resetErrorMessages() {
        $('small[id$="Error"]').text('');
    }

    document.addEventListener("DOMContentLoaded", function() {
        showWelcomeMessage();
    });


</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        showWelcomeMessage();
    });

    function showWelcomeMessage() {
        Swal.fire({
            title: "<h2 style='color:grey; font-weight:bold;'> Welcome to Vivace Collection </h2>",
            html: `
                <div style="text-align:center; font-size:18px; line-height:1.6;">
                    <p> Your one-stop destination for elegant and trendy collections! </p>
                    <p>Explore the best designs and shop with confidence.</p>
                    <p>🛍️ Happy Shopping! 🛍️</p>
                </div>`,
            icon: "success",
            confirmButtonText: "Submit Details",
            allowOutsideClick: false,
            width: 600,
        }).then((result) => {
            if (result.isConfirmed) {
                $('#orderForm').fadeIn();
            }
        });
    }
</script>


</body>

</html>
