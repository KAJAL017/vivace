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
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row">
                <div class="col-xxl-9 col-lg-8">
                    <div class="left-sidebar-checkout sticky">
                        <!-- Shipping Address Form -->
                        <div class="address-option">
                            <div class="address-title">
                                <h4>Shipping Address</h4>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_name" name="shipping_name" placeholder="Enter your full name" value="{{ $lastAddress->name ?? '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" placeholder="Enter your phone number" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $lastAddress->phone ?? '' }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="shipping_address" name="shipping_address" rows="2" placeholder="Enter your complete address">{{ $lastAddress->address ?? '' }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Pincode <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_pincode" name="shipping_pincode" placeholder="Enter pincode" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{ $lastAddress->pincode ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_city" name="shipping_city" placeholder="Enter city" value="{{ $lastAddress->city ?? '' }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="shipping_state" name="shipping_state" placeholder="Enter state" value="{{ $lastAddress->state ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <div class="payment-options">
                            <h4 class="mb-3">Payment Method</h4>
                            <div class="row gy-3">
                                @php
                                    $settings = DB::table('settings')->first();
                                    $codEnabled = $settings && $settings->cod_enabled == 1;
                                    $razorpayEnabled = $settings && $settings->razorpay_enabled == 1;
                                @endphp

                                @if($codEnabled)
                                <div class="col-sm-6">
                                    <div class="payment-box">
                                        <input class="custom-radio me-2" id="cod" type="radio"
                                               {{ !$razorpayEnabled ? 'checked="checked"' : '' }}
                                               name="payment_method" value="Cod">
                                        <label for="cod">Cash on Delivery</label>
                                    </div>
                                </div>
                                @else
                                <div class="col-sm-6">
                                    <div class="payment-box disabled" style="opacity: 0.5; cursor: not-allowed;">
                                        <input class="custom-radio me-2" id="cod" type="radio"
                                               name="payment_method" value="Cod" disabled>
                                        <label for="cod" style="cursor: not-allowed;">Cash on Delivery (Not Available)</label>
                                    </div>
                                </div>
                                @endif

                                @if($razorpayEnabled)
                                <div class="col-sm-6">
                                    <div class="payment-box">
                                        <input class="custom-radio me-2" id="online" type="radio"
                                               {{ $razorpayEnabled && !$codEnabled ? 'checked="checked"' : '' }}
                                               name="payment_method" value="Online">
                                        <label for="online">Razorpay</label>
                                    </div>
                                </div>
                                @else
                                <div class="col-sm-6">
                                    <div class="payment-box disabled" style="opacity: 0.5; cursor: not-allowed;">
                                        <input class="custom-radio me-2" id="online" type="radio"
                                               name="payment_method" value="Online" disabled>
                                        <label for="online" style="cursor: not-allowed;">Razorpay (Not Available)</label>
                                    </div>
                                </div>
                                @endif
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
                                @php
                                    // Default shipping charge is 0 until user enters city
                                    $shippingCharge = 0;

                                    // Calculate GST (5%)
                                    $gstAmount = ($subtotal * 5) / 100;

                                    // Calculate total
                                    $total = $subtotal + $gstAmount + $shippingCharge;
                                @endphp
                                <ul>
                                    <li>
                                        <p>Subtotal</p>
                                        <span id="subtotal-amount">₹{{ number_format($subtotal, 2) }}</span>
                                    </li>
                                    <li>
                                        <p>GST (5%)</p>
                                        <span id="gst-amount">₹{{ number_format($gstAmount, 2) }}</span>
                                    </li>
                                    <li>
                                        <p>Shipping Charge</p>
                                        <span id="shipping-amount">₹{{ number_format($shippingCharge, 2) }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="total">
                                <h6>Total :</h6>
                                <h6 id="total-amount">₹{{ number_format($total, 2) }}</h6>
                                <input type="hidden" value="{{ $total }}" id="total_price">
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
@endsection
@section('website.js')
    <script>
        // Function to validate address fields
        function validateAddressFields(prefix) {
            let isValid = true;
            const requiredFields = ['name', 'phone', 'address', 'pincode', 'city', 'state'];

            requiredFields.forEach(field => {
                const input = document.getElementById(prefix + '_' + field);
                if (input && input.value.trim() === '') {
                    input.classList.add('border-danger');
                    isValid = false;
                } else if (input) {
                    input.classList.remove('border-danger');
                }
            });

            return isValid;
        }

        // Function to update shipping charge based on city input
        function updateShippingCharge() {
            const cityInput = document.getElementById('shipping_city');
            if (!cityInput || !cityInput.value.trim()) return;

            const city = cityInput.value.trim().toLowerCase();
            console.log('City:', city);

            // Calculate shipping charge
            let shippingCharge = 0;
            if (city !== 'srinagar') {
                shippingCharge = 150;
            }

            // Get subtotal
            const subtotalText = document.getElementById('subtotal-amount').textContent.replace('₹', '').replace(',', '');
            const subtotal = parseFloat(subtotalText);

            // Calculate GST (5%)
            const gstAmount = (subtotal * 5) / 100;

            // Calculate total
            const total = subtotal + gstAmount + shippingCharge;

            // Update UI
            document.getElementById('shipping-amount').textContent = '₹' + shippingCharge.toFixed(2);
            document.getElementById('gst-amount').textContent = '₹' + gstAmount.toFixed(2);
            document.getElementById('total-amount').textContent = '₹' + total.toFixed(2);
            document.getElementById('total_price').value = total.toFixed(2);
        }

        // Add event listener to shipping city input
        document.getElementById('shipping_city').addEventListener('input', updateShippingCharge);

        // Fetch last address when phone number is entered (10 digits)
        document.getElementById('shipping_phone').addEventListener('input', function() {
            const phone = this.value.trim();
            
            // When phone number is 10 digits, fetch last address
            if (phone.length === 10) {
                fetch('{{ route("get.last.address.by.phone") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ phone: phone })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.address) {
                        // Fill all fields with last address
                        document.getElementById('shipping_name').value = data.address.name || '';
                        document.getElementById('shipping_address').value = data.address.address || '';
                        document.getElementById('shipping_pincode').value = data.address.pincode || '';
                        document.getElementById('shipping_city').value = data.address.city || '';
                        document.getElementById('shipping_state').value = data.address.state || '';
                        
                        // Trigger shipping charge calculation
                        updateShippingCharge();
                        
                        // Show success message
                        console.log('Previous address loaded successfully!');
                    }
                })
                .catch(error => {
                    console.error('Error fetching address:', error);
                });
            }
        });

        // Calculate shipping charge on page load if city is already filled
        document.addEventListener('DOMContentLoaded', function() {
            const cityInput = document.getElementById('shipping_city');
            if (cityInput && cityInput.value.trim() !== '') {
                updateShippingCharge();
            }
        });

        // Place Order Button
        document.getElementById('placeOrderBtn').addEventListener('click', function(e) {
            e.preventDefault();

            // Disable button to prevent double submission
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Processing...';

            // Validate shipping address
            if (!validateAddressFields('shipping')) {
                btn.disabled = false;
                btn.textContent = 'Place Order';
                Swal.fire('Error', 'Please fill all required shipping address fields', 'error');
                return;
            }

            // Get shipping address data (used for both shipping and billing)
            const shippingData = {
                name: document.getElementById('shipping_name').value.trim(),
                phone: document.getElementById('shipping_phone').value.trim(),
                address: document.getElementById('shipping_address').value.trim(),
                pincode: document.getElementById('shipping_pincode').value.trim(),
                city: document.getElementById('shipping_city').value.trim(),
                state: document.getElementById('shipping_state').value.trim()
            };

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
                shipping_address: shippingData,
                payment_method: paymentMethodRadio.value,
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
