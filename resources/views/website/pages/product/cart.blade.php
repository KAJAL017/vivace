@extends('website.main.app')
@section('title','Cart')
<style>
    .quantity-input-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        width: fit-content;
        margin: auto;
    }

    .quantity-btn {
        background-color: #007bff;
        /* Primary color */
        color: #fff;
        border: none;
        padding: 10px 15px;
        font-size: 18px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .quantity-btn:hover {
        background-color: #0056b3;
    }

    .quantity-input {
        width: 60px;
        height: 40px;
        text-align: center;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s ease;
    }

    .quantity-input:focus {
        border-color: #007bff;
    }

    @media (max-width: 768px) {
        .quantity-btn {
            padding: 8px 12px;
            font-size: 16px;
        }

        .quantity-input {
            width: 50px;
            height: 35px;
            font-size: 14px;
        }
    }
</style>
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Cart</h4>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container">
            <div class="row g-4">
                {{-- <div class="col-12">
                    <div class="cart-countdown"><img src="{{ website_assets() }}/assets/images/gif/fire-2.gif"
                            alt="">
                        <h6>Please, hurry! Someone has placed an order on one of the items you have in the cart. We'll keep
                            it for you for<span id="countdown"></span>minutes.</h6>
                    </div>
                </div> --}}
                @php
                    $CartData = CartProductData();
                @endphp
                <div class="col-xxl-9 col-xl-8">
                    <div class="cart-table">
                        <div class="table-title">
                            <h5>Cart<span id="cartTitle"> ({{ count($CartData) }} Items)</span></h5>
                            <button id="clearAllButton">Clear All</button>
                        </div>

                        <div class="table-responsive theme-scrollbar">
                            <table class="table" id="cart-table">
                                <thead>
                                    <tr>
                                        <th>Product </th>
                                        <th>Price </th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                @php
                                    $totalPrice = 0;
                                    $gstRate = 5; // 5% GST
                                @endphp
                                <tbody>
                                    @foreach ($CartData as $product)
                                        @php
                                            $productTotal =
                                                $product['product']['price'] * $product['cart_item']['quantity'];
                                            $totalPrice += $productTotal;
                                        @endphp
                                        <tr data-cart-id="{{ $product['cart_item']['id'] }}">
                                            <td>
                                                <div class="cart-box"> <a
                                                        href="{{ route('view.product', $product['product']['slug']) }}">
                                                        <img src="{{ $product['product']['image'] }}" alt=""></a>
                                                    <div> <a href="#">
                                                            <h5>{{ $product['product']['name'] }}</h5>
                                                        </a>
                                                        <p>Color:
                                                            <span>{{ ucfirst(strtolower(getColorData($product['cart_item']['color_id']))) }}</span>
                                                        </p>

                                                        <p>Size:
                                                            <span>{{ ucfirst(strtolower(getSizeData($product['cart_item']['size_id']))) }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>₹{{ number_format($product['product']['price']) }}</td>
                                            <td>
                                                <div class="quantity-input-wrapper">
                                                    <button class="quantity-btn decrement">-</button>
                                                    <input type="number" class="quantity-input"
                                                        value="{{ $product['cart_item']['quantity'] }}" min="1" />
                                                    <button class="quantity-btn increment">+</button>
                                                </div>
                                            </td>
                                            <td>₹{{ number_format($product['product']['price'] * $product['cart_item']['quantity'], 2) }}
                                            </td>
                                            <td>
                                                <a class="deleteButton" href="javascript:void(0)"><i class="iconsax"
                                                        data-icon="trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="no-data" id="data-show"><img src="{{ website_assets() }}/assets/images/cart/1.gif"
                                alt="">
                            <h4>You have nothing in your shopping cart!</h4>
                            <p>Today is a great day to purchase the things you have been holding onto! or <span>Carry on
                                    Buying</span></p>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-4">
                    <div class="cart-items">
                        <div class="cart-body">
                            <h6>Price Details ({{ count($CartData) }} Items) </h6>
                            @php
                                $gstAmount = ($totalPrice * $gstRate) / 100;
                                $grandTotal = $totalPrice + $gstAmount;
                            @endphp
                            <ul>
                                <li>
                                    <p>Bag total </p><span id="bagTotal">₹{{ number_format($totalPrice, 2) }}</span>
                                </li>
                                <li>
                                    <p>GST ({{ $gstRate }}%) </p><span id="gstAmount">₹{{ number_format($gstAmount, 2) }}</span>
                                </li>
                                <li class="fw-bold border-top pt-2 mt-2">
                                    <p>Grand Total </p><span id="grandTotal">₹{{ number_format($grandTotal, 2) }}</span>
                                </li>
                                {{-- <li>
                                    <p>Coupon Discount </p><span class="Coupon">Apply Coupon </span>
                                </li>
                                <li>
                                    <p>Delivery </p><span>$50.00 </span>
                                </li> --}}
                            </ul>
                        </div>
                        {{-- <div class="cart-bottom">
                            <p><i class="iconsax me-1" data-icon="tag-2"></i>SPECIAL OFFER (-$1.49) </p>
                            <h6>Subtotal <span>$158.41 </span></h6><span>Taxes and shipping calculated at checkout</span>
                        </div> --}}
                        <div class="coupon-box">
                            {{-- <h6>Coupon</h6>
                            <ul>
                                <li> <span>
                                        <input type="text" placeholder="Apply Coupon"><i class="iconsax me-1"
                                            data-icon="tag-2"> </i></span>
                                    <button class="btn">Apply </button>
                                </li>
                            </ul> --}}
                        </div><a class="btn btn_black w-100 rounded sm" href="{{ route('check-out') }}">Check Out</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('website.js')
<script>
    $(document).on('click', '.quantity-btn', function () {
        let cartId = $(this).closest('tr').data('cart-id'); // Get cart ID from row
        let userId = "{{ session('user_id') ?? session('temporary_user_id') }}"; // Get user ID
        let quantityInput = $(this).siblings('.quantity-input');
        let quantity = parseInt(quantityInput.val());
        let priceCell = $(this).closest('tr').find('td:nth-child(2)'); // Price cell
        let totalCell = $(this).closest('tr').find('td:nth-child(4)'); // Total price cell

        // Adjust quantity based on button clicked
        if ($(this).hasClass('increment')) {
            quantity++;
        } else if ($(this).hasClass('decrement') && quantity > 1) {
            quantity--;
        }

        // Update quantity in the input field
        quantityInput.val(quantity); // Ensure the input's value is updated in the DOM

        // Make AJAX call to update the cart
        $.ajax({
            url: "{{ route('cart.update.quantity') }}",
            type: "POST",
            data: {
                cart_id: cartId,
                user_id: userId,
                quantity: quantity,
                _token: "{{ csrf_token() }}",
            },
            success: function (response) {
                if (response.success) {
                    // Update the total price dynamically in the DOM
                    let productPrice = parseFloat(priceCell.text().replace('₹', '').replace(',', ''));
                    let newTotal = productPrice * quantity;

                    // Update the total cell in the row
                    totalCell.text('₹' + newTotal.toFixed(2));

                    // Recalculate the bag total dynamically
                    let grandTotal = 0;
                    $('tbody tr').each(function () {
                        let rowTotal = parseFloat($(this).find('td:nth-child(4)').text().replace('₹', '').replace(',', ''));
                        grandTotal += rowTotal;
                    });

                    // Calculate GST (5%)
                    let gstAmount = (grandTotal * 5) / 100;
                    let finalTotal = grandTotal + gstAmount;

                    // Update the Bag Total, GST, and Grand Total dynamically
                    $('#bagTotal').text('₹' + grandTotal.toFixed(2));
                    $('#gstAmount').text('₹' + gstAmount.toFixed(2));
                    $('#grandTotal').text('₹' + finalTotal.toFixed(2));
                } else {
                    console.error(response.message);
                }
            },
            error: function (error) {
                console.error('Error:', error);
            },
        });
    });
</script>

<script>
    $(document).on('click', '#clearAllButton', function () {
        let userId = "{{ session('user_id') ?? session('temporary_user_id') }}"; // Get user ID

        // Confirmation alert before clearing the cart
        Swal.fire({
            title: 'Are you sure?',
            text: "This will remove all items from your cart.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, clear all!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make AJAX call to clear all items
                $.ajax({
                    url: "{{ route('cart.clear.all') }}",
                    type: "POST",
                    data: {
                        user_id: userId,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.success) {
                            // Remove all rows from the table
                            $('#cart-table tbody').empty();

                            // Update cart title and total price
                            $('#cartTitle').text(' (0 Items)');
                            $('#bagTotal').text('₹0.00');
                            $('#gstAmount').text('₹0.00');
                            $('#grandTotal').text('₹0.00');

                            // Show the "no data" message
                            $('#data-show').show();

                            // Success notification
                            Swal.fire(
                                'Cleared!',
                                'Your cart has been cleared.',
                                'success'
                            );
                        } else {
                            console.error(response.message);
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    },
                });
            }
        });
    });
</script>



@endsection
