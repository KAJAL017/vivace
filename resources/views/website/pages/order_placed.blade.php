@extends('website.main.app')
@section('title','Order Placed')
@section('website.content')
    <section class="section-b-space py-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 px-0">
                    <div class="order-box-1"><img src="{{ website_assets() }}/assets/images/gif/success.gif" alt="">
                        <h4>Order Success</h4>
                        <p>Order Is Successfully Processsed And Your Order Is On The Way</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space">
        <div class="custom-container container order-success">
            <div class="row gy-4">
                <div class="col-xl-8">
                    <div class="order-items sticky">
                        <h4>Order Information</h4>
                        <p>Your order invoice has been sent to your registered email account. Please double-check your order details.</p>
                        <div class="order-table">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('order_success.order_items') as $item)
                                        <tr>
                                            <td>
                                                <div class="cart-box">
                                                    <a href="{{ route('view.product',[$item['slug']]) }}">
                                                        <img src="{{ Product_first_image($item['product_id']) }}" alt="">
                                                    </a>
                                                    <div>
                                                        <a href="{{ route('view.product',[$item['slug']]) }}">
                                                            <h5>{{ $item['name'] }}</h5>
                                                        </a>
                                                        {{-- <p>Size: <span></span></p> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>₹{{ number_format($item['price'], 2) }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>₹{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="summery-box">
                        <div class="sidebar-title">
                            <h4>Order Details</h4>
                        </div>
                        <div class="summery-content">
                            <ul>
                                <li>
                                    <p>Product total</p>
                                    <h6>₹{{ number_format(session('order_success.total_price'), 2) }}</h6>
                                </li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6>Total</h6>
                                <h5>₹{{ number_format(session('order_success.total_price'), 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="summery-footer">
                        <div class="sidebar-title">
                            <h4>Shipping Address</h4>
                        </div>
                        <ul>
                            @php
                                $shippingAddress = DB::table('addresses')->find(session('order_success.shipping_address_id'));
                            @endphp
                            @if($shippingAddress)
                                <li>
                                    <h6><strong>Name:</strong> {{ $shippingAddress->name }}</h6>
                                    <h6><strong>Address:</strong> {{ $shippingAddress->address }}</h6>
                                    <h6><strong>Pin Code:</strong> {{ $shippingAddress->pincode }}</h6>
                                    <h6><strong>Phone:</strong> {{ $shippingAddress->phone }}</h6>
                                    <h6><strong>City:</strong> {{ $shippingAddress->city }}</h6>
                                    <h6><strong>State:</strong> {{ $shippingAddress->state }}</h6>
                                </li>
                            @else
                                <li>No shipping address found.</li>
                            @endif
                        </ul>
                    </div>

                    <div class="summery-footer">
                        <div class="sidebar-title">
                            <h4>Payment Details</h4>
                        </div>
                        <ul>
                            <li>
                                <h6><strong>Payment Method:</strong> {{ session('order_success.payment_method', 'N/A') }}</h6>
                                @if(session('order_success.payment_id'))
                                    <h6><strong>Payment ID:</strong> {{ session('order_success.payment_id') }}</h6>
                                    <h6><strong>Status:</strong> <span style="color: green;">Paid</span></h6>
                                @else
                                    <h6><strong>Status:</strong> <span style="color: orange;">Cash on Delivery</span></h6>
                                @endif
                            </li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </section>

@endsection
