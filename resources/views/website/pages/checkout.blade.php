@extends('website.main.app')
@section('title', 'Checkout')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Check Out</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                            <li class=""> <a href="#">Check Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
        $userId = session('user_id');
        $billing_addresses = DB::table('addresses')
            ->where(['user_id' => $userId])
            ->where(['address_type' => 1])
            ->where(['is_deleted' => 0])
            ->get();
        $shipping_addresses = DB::table('addresses')
            ->where(['user_id' => $userId])
            ->where(['address_type' => 2])
            ->where(['is_deleted' => 0])
            ->get();
    @endphp
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="left-sidebar-checkout sticky">
                        <div class="address-option">
                            <div class="address-title">
                                <h4>Shipping Address</h4><a href="#" data-bs-toggle="modal" data-bs-target="#add-address" title="add product" tabindex="0">+ Add New Address</a>
                            </div>
                            <div class="row">
                                @foreach ($shipping_addresses as $key => $address)
                                    <div class="col-xxl-4">
                                        <label for="address-shipping-{{ $key }}">
                                            <span class="delivery-address-box">
                                                <span class="form-check">
                                                    <input class="custom-radio" id="address-shipping-{{ $key }}" value="{{ $address->id }}" type="radio" name="shipping_address" {{ $loop->first ? 'checked="checked"' : '' }}>
                                                </span>
                                                <span class="address-detail">
                                                    <span class="address">
                                                        <span class="address-title">{{ $address->name }}</span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Address:</span>
                                                            {{ $address->address }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Pin Code:</span>
                                                            {{ $address->pincode }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Phone:</span> {{ $address->phone }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">City:</span> {{ $address->city }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">State:</span> {{ $address->state }}
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <div style="border: 1px solid #ccc; border-radius: 5px; padding: 10px;">
                                <label style="display: block; padding: 10px; cursor: pointer;">
                                    <input type="radio" name="billing_option" class="billing_option" value="same_as_shipping" style="margin-right: 10px;" checked onclick="toggleBillingAddress(false)">
                                    Same as shipping address
                                </label>
                                <label style="display: block; padding: 10px; cursor: pointer;">
                                    <input type="radio" name="billing_option" class="billing_option" value="different_address" style="margin-right: 10px;" onclick="toggleBillingAddress(true)">
                                    Use a different billing address
                                </label>
                            </div>
                        </div>

                        <div class="address-option" id="billing-address" style="display: none;">
                            <div class="address-title">
                                <h4>Billing Address </h4><a href="#" data-bs-toggle="modal" data-bs-target="#add-address" title="add product" tabindex="0">+ Add New Address</a>
                            </div>
                            <div class="row gy-3">
                                @foreach ($billing_addresses as $key => $address)
                                    <div class="col-xxl-4">
                                        <label for="address-billing-{{ $key }}">
                                            <span class="delivery-address-box">
                                                <span class="form-check">
                                                    <input class="custom-radio" id="address-billing-{{ $key }}" value="{{ $address->id }}" type="radio" name="billing_address" {{ $loop->first ? 'checked="checked"' : '' }}>
                                                </span>
                                                <span class="address-detail">
                                                    <span class="address">
                                                        <span class="address-title">{{ $address->name }}</span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Address:</span>
                                                            {{ $address->address }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Pin Code:</span>
                                                            {{ $address->pincode }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">Phone:</span> {{ $address->phone }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">City:</span> {{ $address->city }}
                                                        </span>
                                                    </span>
                                                    <span class="address">
                                                        <span class="address-home">
                                                            <span class="address-tag">State:</span> {{ $address->state }}
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="payment-options">
                            <h4 class="mb-3">Payment Method</h4>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <div class="payment-box"> <input class="custom-radio me-2" id="cod" type="radio"
                                            checked="checked" name="radio" value="Cod"> <label
                                            for="cod">Cod</label> </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"> <input class="custom-radio me-2" id="online"
                                            type="radio" name="radio" value="Online"> <label
                                            for="online">Online</label> </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                @php
                $CartData = CartProductData();
                $subtotal = 0;
            @endphp

            <div class="col-xxl-3 col-lg-4">
                <div class="right-sidebar-checkout">
                    <h4>Checkout</h4>
                    <div class="cart-listing">
                        <ul>

                            @foreach ($CartData as $product)
                                @php
                                    $quantity = $product['cart_item']['quantity'];
                                    $price = $product['product']['price'];
                                    $itemTotal = $quantity * $price;
                                    $subtotal += $itemTotal;
                                @endphp

                                <li data-product-id="{{ $product['product']['id'] }}"
                                    data-quantity="{{ $product['cart_item']['quantity'] }}"
                                    data-color="{{ $product['cart_item']['color_id'] }}"
                                    data-size="{{ $product['cart_item']['size_id'] }}"
                                    data-price="{{ $product['product']['price'] }}">
                                    <img src="{{ $product['product']['image'] }}" alt="" width="50">
                                    <div>
                                        <h6>{{ $product['product']['name'] }}</h6>
                                        <span>{{ ucfirst(strtolower(getColorData($product['cart_item']['color_id']))) }}</span>
                                    </div>
                                    <p>₹{{ number_format($itemTotal, 2) }}</p>
                                </li>
                            @endforeach
                        </ul>

                        <div class="summary-total">
                            <ul>
                                <li>
                                    <p>Subtotal</p>
                                    <span>₹{{ number_format($subtotal, 2) }}</span>
                                </li>

                                {{-- Removed shipping calculation --}}
                            </ul>
                        </div>

                        <div class="total">
                            <h6>Total :</h6>
                            <h6>₹{{ number_format($subtotal, 2) }}</h6>
                            <input type="hidden" value="{{ $subtotal }}" id="total_price">
                        </div>

                        {{-- <div class="order-button">
                            <a class="btn btn_black sm w-100 rounded" href="{{ route('order.placed') }}">Place
                                Order</a>
                        </div> --}}
                    </div>
                </div>
            </div>

            </div>
        </div>
    </section>
    <!-- Modal Structure -->
    <div class="reviews-modal modal theme-modal fade" id="add-address" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Address Profile</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="userForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" id="name"
                                        placeholder="Enter your name.">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="john.smith@example.com">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" type="number" name="phone" id="phone"
                                        placeholder="Enter your Number.">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="5"
                                        placeholder="Write your Address..."></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Pincode</label>
                                    <input class="form-control" type="text" name="pincode" id="pincode"
                                        placeholder="Enter your Pincode">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <input class="form-control" type="text" name="city" id="city"
                                        placeholder="Enter your City">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">State</label>
                                    <input class="form-control" type="text" name="state" id="state"
                                        placeholder="Enter your State">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="billing_address" value="1" checked>
                                        <label class="form-check-label" for="billing_address">Billing Address</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="shipping_address" value="2">
                                        <label class="form-check-label" for="shipping_address">Shipping Address</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('website.js')
    <!-- AJAX Script -->
    <script>
        $(document).on('click', '#submitAddress', function(e) {
            e.preventDefault();

            // Client-side form validation
            let form = $('#addAddressForm')[0];
            if (form.checkValidity() === false) {
                form.classList.add('was-validated');
                return;
            }

            let formData = $('#addAddressForm').serialize();

            $.ajax({
                url: "{{ route('user.update.address') }}", // Laravel route
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#address-modal1').modal('hide');
                        $('#addAddressForm')[0].reset();
                        form.classList.remove('was-validated');
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('Something went wrong!');
                    }
                }
            });
        });
    </script>
    <script>
       $(document).on('click', '.order-button .btn', function(e) {
    e.preventDefault();

    // Clear previous error messages
    $('.invalid-feedback').text('');
    $('.form-control').removeClass('is-invalid');

    // Check the selected billing option
    let billingOption = $('input[name="billing_option"]:checked').val();
    let billingAddressId = null;

    if (billingOption === 'different_address') {
        billingAddressId = $('input[name="billing_address"]:checked').val();
        if (!billingAddressId) {
            Swal.fire('Error', 'Please select a different billing address.', 'error');
            return;
        }
    } else {
        billingAddressId = $('input[name="shipping_address"]:checked').val();
    }

    let formData = {
        _token: $('meta[name="csrf-token"]').attr('content'),
        total_price: $('#total_price').val(),
        billing_option: billingOption,
        billing_address_id: billingAddressId,
        payment_method: $('input[name="radio"]:checked').val(),
        shipping_address_id: $('input[name="shipping_address"]:checked').val(),
        cart_items: [],
    };

    // Collect cart items
    $('.cart-listing ul li').each(function() {
        let productId = $(this).data('product-id');
        let quantity = $(this).data('quantity');
        let price = $(this).data('price');
        let color = $(this).data('color');
        let size = $(this).data('size');
        if (productId && quantity && price) {
            formData.cart_items.push({
                product_id: productId,
                quantity: quantity,
                price: price,
                color: color,
                size: size
            });
        }
    });

    if (formData.cart_items.length === 0) {
        Swal.fire('Error', 'No items in your cart.', 'error');
        return;
    }

    // Process the order submission based on the payment method
    if (formData.payment_method === 'Online') {
        // Trigger PhonePe payment
        $.ajax({
            url: '{{ route('phonepe.payment.initiate') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Payment failed. Please try again.', 'error');
            },
        });
    } else {
        $.ajax({
            url: '{{ route('store.order') }}',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    window.location.href = response.redirect_url;
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr) {
                // If validation errors are returned from Laravel
                let errors = xhr.responseJSON.errors;

                // Loop through each error and display it next to the corresponding input field
                $.each(errors, function(field, message) {
                    let inputField = $('#' + field);
                    inputField.addClass('is-invalid');
                    inputField.siblings('.invalid-feedback').text(message[0]);
                });

                Swal.fire('Error', 'Please check the form for validation errors.', 'error');
            },
        });
    }
});

    </script>
    <script>
        $(document).ready(function() {
            $('#userForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('user.address.store') }}", // Replace with your Laravel route
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            window.location.reload(); // Reload the page after success
                        }
                    },
                    error: function(xhr) {
                        // Handle validation errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;

                            // Clear previous error messages
                            $('.form-control').removeClass('is-invalid');
                            $('.invalid-feedback').remove();

                            // Show validation errors next to the relevant inputs
                            $.each(errors, function(field, messages) {
                                let inputField = $('#' + field);
                                inputField.addClass(
                                    'is-invalid'
                                ); // Add 'is-invalid' class to show error styling

                                // Show the error message
                                inputField.after('<div class="invalid-feedback">' +
                                    messages.join('<br>') + '</div>');
                            });

                            // Optionally, show a toastr error message
                            toastr.error("Please fix the highlighted errors.");
                        } else {
                            // If the error doesn't have validation errors, show a general error message
                            toastr.error("An unexpected error occurred.");
                        }
                    }
                });
            });
        });
    </script>
    <script>
        function toggleBillingAddress(show) {
            document.getElementById('billing-address').style.display = show ? 'block' : 'none';
        }
    </script>

@endsection
