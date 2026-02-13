@extends('website.main.app')
@section('title', 'Checkout')
@section('website.content')
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
        .error-message {
            display: block;
            font-size: 12px;
            margin-top: 5px;
            color: #dc3545;
        }
        .form-control.error {
            border-color: #dc3545;
        }
    </style>
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
                                <h4>Shipping Address</h4><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#add-address" title="add product" tabindex="0">+ Add New Address</a>
                            </div>
                            <div class="row">
                                @foreach ($shipping_addresses as $key => $address)
                                    <div class="col-xxl-4">
                                        <label for="address-shipping-{{ $key }}">
                                            <span class="delivery-address-box">
                                                <span class="form-check">
                                                    <input class="custom-radio" id="address-shipping-{{ $key }}"
                                                        value="{{ $address->id }}" type="radio" name="shipping_address"
                                                        {{ $loop->first ? 'checked="checked"' : '' }}>
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
                                    <input type="radio" name="billing_option" class="billing_option"
                                        value="same_as_shipping" style="margin-right: 10px;" checked>
                                    Same as shipping address
                                </label>
                                <label style="display: block; padding: 10px; cursor: pointer;">
                                    <input type="radio" name="billing_option" class="billing_option"
                                        value="different_address" style="margin-right: 10px;">
                                    Use a different billing address
                                </label>
                            </div>
                        </div>

                        <div class="address-option" id="billing-address" style="display: none;">
                            <div class="address-title">
                                <h4>Billing Address </h4><a href="#" data-bs-toggle="modal"
                                    data-bs-target="#add-address" title="add product" tabindex="0">+ Add New Address</a>
                            </div>
                            <div class="row gy-3">
                                @foreach ($billing_addresses as $key => $address)
                                    <div class="col-xxl-4">
                                        <label for="address-billing-{{ $key }}">
                                            <span class="delivery-address-box">
                                                <span class="form-check">
                                                    <input class="custom-radio" id="address-billing-{{ $key }}"
                                                        value="{{ $address->id }}" type="radio" name="billing_address"
                                                        {{ $loop->first ? 'checked="checked"' : '' }}>
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

                        <div class="payment-options">
                            <h4 class="mb-3">Payment Method</h4>
                            <div class="row gy-3">
                                <div class="col-sm-6">
                                    <div class="payment-box"> <input class="custom-radio me-2" id="cod"
                                            type="radio" checked="checked" name="payment_method" value="Cod"> <label
                                            for="cod">Cash on Delivery</label> </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="payment-box"> <input class="custom-radio me-2" id="online"
                                            type="radio" name="payment_method" value="Online"> <label
                                            for="online">Online Payment</label> </div>
                                </div>
                            </div>
                        </div>
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
                                </ul>
                            </div>

                            <div class="total">
                                <h6>Total :</h6>
                                <h6>₹{{ number_format($subtotal, 2) }}</h6>
                                <input type="hidden" value="{{ $subtotal }}" id="total_price">
                            </div>

                            <div class="order-button">
                                <button class="btn btn_black sm w-100 rounded" id="placeOrderBtn">Place Order</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    
    <!-- Add Address Modal -->
    <div class="reviews-modal modal theme-modal fade" id="add-address" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Add New Address</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="addAddressForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="name" id="name"
                                        placeholder="Enter your name">
                                    <span class="text-danger error-message" id="name_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="john.smith@example.com">
                                    <span class="text-danger error-message" id="email_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="phone" id="phone"
                                        placeholder="Enter your Number" maxlength="10">
                                    <span class="text-danger error-message" id="phone_error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="address" id="address" cols="30" rows="5"
                                        placeholder="Write your Address..."></textarea>
                                    <span class="text-danger error-message" id="address_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="pincode" id="pincode"
                                        placeholder="Enter your Pincode" maxlength="6">
                                    <span class="text-danger error-message" id="pincode_error"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="city" id="city"
                                        placeholder="Enter your City">
                                    <span class="text-danger error-message" id="city_error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="state" id="state"
                                        placeholder="Enter your State">
                                    <span class="text-danger error-message" id="state_error"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address Type <span class="text-danger">*</span></label>
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
                                    <span class="text-danger error-message" id="address_type_error"></span>
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit" id="submitAddress">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('website.js')
    <script>
        // Toggle billing address visibility
        document.querySelectorAll('.billing_option').forEach(function(radio) {
            radio.addEventListener('change', function() {
                const billingAddress = document.getElementById('billing-address');
                if (this.value === 'different_address') {
                    billingAddress.style.display = 'block';
                } else {
                    billingAddress.style.display = 'none';
                }
            });
        });

        // Add Address Form Submission
        document.getElementById('addAddressForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(function(el) {
                el.textContent = '';
            });
            document.querySelectorAll('.form-control').forEach(function(el) {
                el.classList.remove('error');
            });
            
            const formData = new FormData(this);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch('{{ route("user.address.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                return response.json().then(data => {
                    return {
                        status: response.status,
                        ok: response.ok,
                        data: data
                    };
                });
            })
            .then(result => {
                if (result.ok && result.data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('add-address'));
                    modal.hide();
                    document.getElementById('addAddressForm').reset();
                    location.reload();
                } else if (result.data.errors) {
                    // Display validation errors below each input
                    Object.keys(result.data.errors).forEach(function(key) {
                        const errorElement = document.getElementById(key + '_error');
                        const inputElement = document.getElementById(key);
                        if (errorElement) {
                            errorElement.textContent = result.data.errors[key][0];
                        }
                        if (inputElement) {
                            inputElement.classList.add('error');
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Place Order Button
        document.getElementById('placeOrderBtn').addEventListener('click', function(e) {
            e.preventDefault();
            
            // Disable button to prevent double submission
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Processing...';
            
            // Get billing option
            const billingOption = document.querySelector('input[name="billing_option"]:checked').value;
            let billingAddressId = null;
            
            if (billingOption === 'different_address') {
                const billingAddressRadio = document.querySelector('input[name="billing_address"]:checked');
                if (!billingAddressRadio) {
                    btn.disabled = false;
                    btn.textContent = 'Place Order';
                    return;
                }
                billingAddressId = billingAddressRadio.value;
            } else {
                const shippingAddressRadio = document.querySelector('input[name="shipping_address"]:checked');
                if (!shippingAddressRadio) {
                    btn.disabled = false;
                    btn.textContent = 'Place Order';
                    return;
                }
                billingAddressId = shippingAddressRadio.value;
            }
            
            // Get shipping address
            const shippingAddressRadio = document.querySelector('input[name="shipping_address"]:checked');
            if (!shippingAddressRadio) {
                btn.disabled = false;
                btn.textContent = 'Place Order';
                return;
            }
            
            // Get payment method
            const paymentMethodRadio = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethodRadio) {
                btn.disabled = false;
                btn.textContent = 'Place Order';
                return;
            }
            
            // Collect cart items
            const cartItems = [];
            document.querySelectorAll('.cart-listing ul li').forEach(function(item) {
                const productId = item.getAttribute('data-product-id');
                const quantity = item.getAttribute('data-quantity');
                const price = item.getAttribute('data-price');
                const color = item.getAttribute('data-color');
                const size = item.getAttribute('data-size');
                
                if (productId && quantity && price) {
                    cartItems.push({
                        product_id: productId,
                        quantity: quantity,
                        price: price,
                        color: color,
                        size: size
                    });
                }
            });
            
            if (cartItems.length === 0) {
                btn.disabled = false;
                btn.textContent = 'Place Order';
                return;
            }
            
            // Prepare form data
            const formData = {
                total_price: document.getElementById('total_price').value,
                billing_option: billingOption,
                billing_address_id: billingAddressId,
                payment_method: paymentMethodRadio.value,
                shipping_address_id: shippingAddressRadio.value,
                cart_items: cartItems
            };
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Process order based on payment method
            if (paymentMethodRadio.value === 'Online') {
                // Razorpay payment
                fetch('{{ route("razorpay.payment.initiate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Initialize Razorpay
                        const options = {
                            key: data.razorpay_key,
                            amount: data.amount,
                            currency: data.currency,
                            name: data.name,
                            description: data.description,
                            handler: function (response) {
                                // Verify payment
                                fetch('{{ route("razorpay.payment.verify") }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        razorpay_payment_id: response.razorpay_payment_id
                                    })
                                })
                                .then(res => res.json())
                                .then(result => {
                                    if (result.success) {
                                        window.location.href = result.redirect_url;
                                    } else {
                                        btn.disabled = false;
                                        btn.textContent = 'Place Order';
                                        console.error('Verification failed:', result);
                                    }
                                })
                                .catch(error => {
                                    btn.disabled = false;
                                    btn.textContent = 'Place Order';
                                    console.error('Verification Error:', error);
                                });
                            },
                            modal: {
                                ondismiss: function() {
                                    btn.disabled = false;
                                    btn.textContent = 'Place Order';
                                }
                            },
                            theme: {
                                color: '#000000'
                            }
                        };
                        const rzp = new Razorpay(options);
                        rzp.on('payment.failed', function (response){
                            btn.disabled = false;
                            btn.textContent = 'Place Order';
                            console.error('Payment failed:', response.error);
                        });
                        rzp.open();
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Place Order';
                        console.error('Initiate failed:', data);
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.textContent = 'Place Order';
                    console.error('Error:', error);
                });
            } else {
                // COD order
                fetch('{{ route("store.order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect_url;
                    } else {
                        btn.disabled = false;
                        btn.textContent = 'Place Order';
                        console.error('Order failed:', data);
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.textContent = 'Place Order';
                    console.error('Error:', error);
                });
            }
        });
    </script>
@endsection
