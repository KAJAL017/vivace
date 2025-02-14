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
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            margin: 40px auto;
            transition: all 0.3s ease;
        }

        .form-container:hover {
            transform: scale(1.02);
        }

        h2 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            animation: fadeIn 1s ease-out;
        }

        .form-group {
            margin-bottom: 18px;
            animation: fadeIn 1s ease-out;
        }

        label {
            font-size: 15px;
            font-weight: 600;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            color: #555;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus,
        input[type="file"]:focus,
        textarea:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .form-footer {
            text-align: center;
        }

        .form-footer a {
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .form-footer a:hover {
            color: #388e3c;
        }

        .file-input-container {
            position: relative;
        }

        .file-input-container input[type="file"] {
            padding-left: 40px;
        }

        .file-input-container .fas {
            position: absolute;
            top: 12px;
            left: 12px;
            font-size: 18px;
            color: #4CAF50;
        }

        .file-label {
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
        <style>
            .hidden {
                display: none;
            }
        </style>

</head>

<body>
    <div class="form-container">
        <h2>Direct Order Form</h2>
        <form class="space-y-4" id="orderForm" enctype="multipart/form-data">
            <div class="form-group file-input-container">
                <label for="productScreenshot" class="file-label">Upload Product Screenshot</label>
                <input type="file" id="productScreenshot" name="productScreenshot[]"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required multiple >
                <span class="text-red-500 text-sm" id="productScreenshotError"></span> <!-- Error Message -->
            </div>
            <div class="form-group file-input-container">
                <label for="paymentScreenshot" class="file-label">Upload Payment Screenshot</label>
                <input type="file" id="paymentScreenshot" name="paymentScreenshot[]"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required multiple >
                <span class="text-red-500 text-sm" id="paymentScreenshotError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter your name"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required>
                <span class="text-red-500 text-sm" id="nameError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="mobile">Mobile No</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required pattern="^\d{10}$"
                    title="Mobile number must be exactly 10 digits">
                <span class="text-red-500 text-sm" id="mobileError"></span> <!-- Error Message -->
            </div>

            <div class="form-group">
                <label for="alternateMobile">Alternate Mobile No</label>
                <input type="tel" id="alternateMobile" name="alternateMobile"
                    placeholder="Enter alternate mobile number"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required pattern="^\d{10}$"
                    title="Mobile number must be exactly 10 digits" required>
                <span class="text-red-500 text-sm" id="alternateMobileError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="streetAddress">Street Address</label>
                <input type="text" id="streetAddress" name="streetAddress" placeholder="Enter your street address"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required>
                <span class="text-red-500 text-sm" id="streetAddressError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="colony">Colony/Mohalla</label>
                <input type="text" id="colony" name="colony" placeholder="Enter your colony or mohalla"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required>
                <span class="text-red-500 text-sm" id="colonyError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <input type="text" id="pincode" name="pincode" placeholder="Enter pincode"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required pattern="^\d{6}$"
                    title="Pincode must be exactly 6 digits">
                <span class="text-red-500 text-sm" id="pincodeError"></span> <!-- Error Message -->
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input type="text" id="city" name="city" placeholder="Enter your city"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required>
                <span class="text-red-500 text-sm" id="cityError"></span> <!-- Error Message -->
            </div>
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="Enter your state"
                    class="border-gray-300 rounded-lg p-2 focus:ring-green-500" required>
                <span class="text-red-500 text-sm" id="stateError"></span> <!-- Error Message -->
            </div>
            <div class="form-footer">
                <button type="submit" id="submitButton"
                    style="width: 100%; background-color: #4CAF50; color: white; padding: 14px; border-radius: 8px; font-size: 16px; cursor: pointer; border: none; transition: background-color 0.3s ease;">
                    Submit
                </button>
                <div id="spinner" class="hidden text-center mt-3">
                    <i class="fas fa-spinner fa-spin text-green-500 text-2xl"></i>
                </div>
            </div>

        </form>


    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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

        $('#orderForm').on('submit', function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    resetErrorMessages(); // Clear previous error messages

    // Show spinner and disable the submit button
    $('#spinner').removeClass('hidden');
    $('#submitButton').prop('disabled', true);

    // Check if the mobile number matches the 10 digits pattern
    var mobile = $('#mobile').val();
    if (!/^\d{10}$/.test(mobile)) {
        toastr.error('Mobile number must be exactly 10 digits');
        $('#spinner').addClass('hidden');
        $('#submitButton').prop('disabled', false);
        return;
    }

    $.ajax({
        url: '{{ route('store.manual.order') }}',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Hide spinner and enable the submit button
            $('#spinner').addClass('hidden');
            $('#submitButton').prop('disabled', false);

            if (response.success) {
                toastr.success(response.message);
                $('#orderForm')[0].reset();
            } else {
                toastr.error(response.message || 'Something went wrong.');
            }
        },
        error: function (xhr) {
            // Hide spinner and enable the submit button
            $('#spinner').addClass('hidden');
            $('#submitButton').prop('disabled', false);

            if (xhr.status === 422) { // Validation error
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    console.log(errors);
                    for (const field in errors) {
                        if (errors[field] && errors[field].length > 0) {
                            $('#' + field + 'Error').text(errors[field].join(', '));
                        }
                    }
                } else {
                    toastr.error('Validation error occurred, but no specific message was provided.');
                }
            } else {
                toastr.error('An unexpected error occurred. Please try again later.');
            }
        }
    });
});


        // Function to reset error messages
        function resetErrorMessages() {
            document.querySelectorAll('span[id$="Error"]').forEach(errorSpan => {
                errorSpan.textContent = '';
            });
        }

    </script>

</body>

</html>
