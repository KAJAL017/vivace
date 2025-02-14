@extends('website.main.app')
@section('website-content')
@section('website-css')
    <style>
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px;
            /* Adjust this based on icon size */
        }

        .password-container .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            /* Icon color */
        }

        .password-container .toggle-password:hover {
            color: #333;
            /* Icon hover color */
        }
    </style>
@endsection
<!-- Page Title/Header Start -->
<div class="page-title-section section" data-bg-image="assets/images/bg/page-title-1.webp">
    <div class="container">
        <div class="row">
            <div class="col">

                <div class="page-title">
                    <h1 class="title">My Account</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">My Account</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page Title/Header End -->

<!-- My Account Section Start -->
<div class="section section-padding">
    <div class="container">
        <div class="row learts-mb-n30">

            <!-- My Account Tab List Start -->
            <div class="col-lg-4 col-12 learts-mb-30">
                <div class="myaccount-tab-list nav">

                    {{-- <a href="#orders" data-bs-toggle="tab">Orders <i class="far fa-file-alt"></i></a> --}}
                    {{-- <a href="#download" data-bs-toggle="tab">Download Invoice <i class="far fa-arrow-to-bottom"></i></a> --}}
                    <a href="#address" data-bs-toggle="tab">Your Address <i class="far fa-map-marker-alt"></i></a>
                    <a href="#account-info" data-bs-toggle="tab">Account Details <i class="fa fa-user"
                            aria-hidden="true"></i></a>
                    <a href="{{ route('logout') }}">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                </div>
            </div>
            <!-- My Account Tab List End -->

            <!-- My Account Tab Content Start -->
            <div class="col-lg-12 col-12 learts-mb-30">
                <div class="tab-content">
                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade  " id="orders">
                        <div class="myaccount-content order">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order-ID</th>
                                            <th>Date / Time</th>
                                            <th>Order Status</th>
                                            <th>Total</th>
                                            <th style="color: crimson;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>#VC-000001</td>
                                            <td>22/Aug/2024, 10 : 00 am</td>
                                            <td> <span class="btn-danger pt-1 pb-1 ps-3 pe-3 rounded-pill">Not
                                                    Confirmed</span></td>
                                            <td>₹ 3000</td>
                                            <td><a href="#" title="view Order"> <i class="fa fa-eye"
                                                        style="font-size:30px"></i></a> <span
                                                    style="font-size: 23px; color: grey;">|</span>
                                                <a href="#" title="Track Order"> <i
                                                        class="fas fa-shipping-fast" style="font-size:20px"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>#VC-000002</td>
                                            <td>22/Aug/2024, 10 : 00 am</td>
                                            <td> <span
                                                    class="btn-warning pt-1 pb-1 ps-3 pe-3 rounded-pill text-light">Confirmed</span>
                                            </td>
                                            <td>₹ 3000</td>
                                            <td><a href="#" title="view Order"> <i class="fa fa-eye"
                                                        style="font-size:30px"></i></a> <span
                                                    style="font-size: 23px; color: grey;">|</span>
                                                <a href="#" title="Track Order"> <i
                                                        class="fas fa-shipping-fast" style="font-size:20px"></i></a>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>#VC-000003</td>
                                            <td>22/Aug/2024, 10 : 00 am</td>
                                            <td> <span
                                                    class="btn-success pt-1 pb-1 ps-3 pe-3 rounded-pill">Delieverd</span>
                                            </td>
                                            <td>₹ 3000</td>
                                            <td><a href="#" title="view Order"> <i class="fa fa-eye"
                                                        style="font-size:30px"></i></a> <span
                                                    style="font-size: 23px; color: grey;">|</span>
                                                <a href="#" title="Track Order"> <i
                                                        class="fas fa-shipping-fast" style="font-size:20px"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade" id="download">
                        <div class="myaccount-content download">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Date Of Purchase</th>
                                            <th>Download Invoice</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Haven - Free Real Estate PSD Template</td>
                                            <td>22/Aug/2024</td>
                                            <td style="color: crimson;"><a href="#"><i class="fa fa-download"
                                                        aria-hidden="true"></i> Download File</a></td>
                                        </tr>
                                        <tr>
                                            <td>HasTech - Profolio Business Template</td>
                                            <td>22/Aug/2024</td>
                                            <td style="color: crimson;"><a href="#"><i class="fa fa-download"
                                                        aria-hidden="true"></i> Download File</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->
                    @php
                        $user_id = Session::get('user_id');
                        $user = DB::table('users')->where('id', $user_id)->first();
                    @endphp

                    <div class="tab-pane fade active show" id="address">
                        <div class="myaccount-content address">
                            <p>The following addresses will be used on the checkout page by default.</p>
                            <div class="row learts-mb-n30">
                                <div class="col-md-8 col-12 learts-mb-30" style="padding: 20px;">
                                    <h4 class="title d-flex justify-content-between align-items-center"
                                        style="font-size: 18px; font-weight: 600; color: #333;">
                                        Billing Address
                                        <a href="#" class="edit-link text-primary"
                                            style="font-size: 14px; text-decoration: none; color: #007bff; font-weight: 600; transition: color 0.3s ease;">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </h4>
                                    <div class="billing-address-box"
                                        style="padding: 20px; border: 1px solid #e0e0e0; border-radius: 8px; background-color: #f9f9f9; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin-top: 10px;">
                                        <address style="font-size: 16px; line-height: 1.6; color: #333;">
                                            <p style="margin-bottom: 10px;"><strong
                                                    style="font-weight: bold; color: #007bff;">{{ $user->street_address }}</strong>
                                            </p>
                                            <p style="margin-bottom: 10px;"><strong
                                                    style="font-weight: bold; color: #007bff;">{{ $user->landmark }}</strong>
                                            </p>
                                            <p style="margin-bottom: 10px;">{{ $user->district }} - {{ $user->pincode }}
                                                <br>
                                                {{ $user->state }}, {{ $user->country }}
                                            </p>
                                            <p style="margin-bottom: 10px;">Mobile: <span
                                                    style="font-size: 14px; color: #555;">+91
                                                    {{ $user->mobile_no }}</span></p>
                                        </address>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!-- Single Tab Content End -->

                    <!-- Single Tab Content Start -->
                    <div class="tab-pane fade" id="account-info">
                        <div class="myaccount-content account-details">
                            <div class="account-details-form">
                                <form action="#">
                                    <div class="row learts-mb-n30">
                                        <div class="col-md-6 learts-mb-30">
                                            <label for="display-name">Display Name <abbr
                                                    class="required">*</abbr></label>
                                            <input type="text" id="display-name" value="{{ $user->name }}">
                                            <p>This will be how your name will be displayed in the account section and
                                                in reviews</p>
                                        </div>
                                        <div class="col-md-6 learts-mb-30">
                                            <label for="email">Email Id <abbr class="required">*</abbr></label>
                                            <input type="email" id="email" value="{{ $user->email }}">
                                        </div>
                                        <div class="col-12 learts-mb-30 learts-mt-30">
                                            <fieldset>
                                                <legend>Password change</legend>
                                                <div class="row learts-mb-n30">
                                                    <div class="col-12 learts-mb-30">
                                                        <label for="current-pwd">Current password</label>
                                                        <input type="password" id="current-pwd"
                                                            value="{{ $user->password }}">
                                                    </div>
                                                    <div class="col-12 learts-mb-30">
                                                        <label for="new-pwd">New password</label>
                                                        <input type="password" id="new-pwd">
                                                    </div>
                                                    <div class="col-12 learts-mb-30">
                                                        <label for="confirm-pwd">Confirm new password</label>
                                                        <input type="password" id="confirm-pwd">
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class="col-12 learts-mb-30">
                                            <button class="btn btn-dark btn-outline-hover-dark">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- Single Tab Content End -->

                </div>
            </div> <!-- My Account Tab Content End -->
        </div>
    </div>
</div>

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAddressModalLabel">Edit Billing Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm">
                    <div class="mb-3">
                        <label for="pincode" class="form-label">Pincode</label>
                        <input type="text" class="form-control" id="pincode" name="pincode" required
                            placeholder="Enter Pincode" value="{{ $user->pincode ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="districtPincode" class="form-label">District </label>
                        <input type="text" class="form-control" id="districtPincode" name="districtPincode"
                            required placeholder="Enter District" value="{{ $user->district ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="stateCountry" class="form-label">State</label>
                        <input type="text" class="form-control" id="stateCountry" name="stateCountry" required
                            placeholder="Enter State" value="{{ $user->state ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" required
                            placeholder="Enter Country" value="{{ $user->state ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="landmark" class="form-label">Landmark (optional)</label>
                        <input type="text" class="form-control" id="landmark" name="landmark" required
                            placeholder="Enter Landmark" value="{{ $user->landmark ?? '' }}">
                    </div>

                    <div class="mb-3">
                        <label for="streetAddress" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="streetAddress" name="streetAddress" required
                            placeholder="Enter Street Address" value="{{ $user->street_address ?? '' }}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveAddressBtn">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- My Account Section End -->
@endsection
@section('website-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener for the save address button
        document.getElementById('saveAddressBtn').addEventListener('click', function(event) {
            event.preventDefault();

            // Get the form data
            let formData = new FormData(document.getElementById('editAddressForm'));

            // Send the form data via AJAX
            fetch("{{ route('update.billing.address') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}", // Add CSRF token for security
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close the modal if the address was updated successfully
                        $('#editAddressModal').modal('hide');
                        // Optionally show a success message
                        alert('Billing address updated successfully!');
                    } else {
                        // Show an error message if update fails
                        alert('Failed to update address. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error updating address:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>


<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('registerPassword');
        const currentType = passwordInput.getAttribute('type');

        // Toggle the type attribute
        if (currentType === 'password') {
            passwordInput.setAttribute('type', 'text');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
        } else {
            passwordInput.setAttribute('type', 'password');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
        }
    });
</script>

<script>
    function validateMobileNo() {
        const mobileInput = document.getElementById('mobile_no');
        const value = mobileInput.value;
        const numericValue = value.replace(/\D/g, '');
        mobileInput.value = numericValue;
        if (numericValue.length > 10) {
            mobileInput.value = numericValue.slice(0, 10);
        }
    }
</script>

<script>
    $('#LoginFORM').on('submit', function(e) {
        e.preventDefault();

        var mobile_no = $('#mobile_no').val();
        var password = $('#registerPassword').val();
        var rememberMe = $('#rememberMe').is(':checked');

        $.ajax({
            url: '{{ route('login.process') }}',
            method: 'POST',
            data: {
                mobile_no: mobile_no,
                password: password,
                remember: rememberMe,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        window.location.href =
                            '{{ route('website.home') }}';
                    });

                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: xhr.responseJSON.message
                });
            }
        });
    });
</script>
<script>
    document.querySelector('.edit-link').addEventListener('click', function(e) {
        e.preventDefault();


        // Show the modal
        const editModal = new bootstrap.Modal(document.getElementById('editAddressModal'));
        editModal.show();
    });

    document.getElementById('saveAddressBtn').addEventListener('click', function() {
        // Collect updated data
        const updatedAddress = {
            streetAddress: document.getElementById('streetAddress').value,
            districtPincode: document.getElementById('districtPincode').value,
            stateCountry: document.getElementById('stateCountry').value,
            mobileNumber: document.getElementById('mobileNumber').value,
        };

        // Handle the updated data (e.g., send it to the server via AJAX)
        console.log(updatedAddress);

        // Close the modal after saving
        const editModal = bootstrap.Modal.getInstance(document.getElementById('editAddressModal'));
        editModal.hide();
    });
</script>
@endsection
