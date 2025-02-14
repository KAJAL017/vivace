@php
    $user = getUserData();
@endphp
@php
    $userId = session('user_id');
    $addresses = DB::table('addresses')
        ->where(['user_id' => $userId])
        ->where(['is_deleted' => 0])
        ->get();
@endphp
@extends('website.main.app')
@section('title','Dashboard')
@section('website.content')
    <section class="section-b-space pt-0">
        <div class="heading-banner">
            <div class="custom-container container">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="col-sm-6">
                        <ul class="breadcrumb float-end">
                            <li class="breadcrumb-item"> <a href="{{ route('website.home') }}">Home / </a></li>
                            <li class=" active"> <a href="#">Dahboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-b-space pt-0">
        <div class="custom-container container user-dashboard-section">
            <div class="row">
                <div class="col-xl-3 col-lg-4">
                    <div class="left-dashboard-show">
                        <button class="btn btn_black sm rounded bg-primary">Show Menu</button>
                    </div>
                    <div class="dashboard-left-sidebar sticky">
                        <div class="profile-box">
                            <div class="profile-bg-img"></div>
                            <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
                            <div class="profile-contain">
                                <div class="profile-image"> <img class="img-fluid" src="../assets/images/user/12.jpg"
                                        alt=""></div>
                                <div class="profile-name">
                                    <h4>{{ $user->name ?? '' }}</h4>
                                    <h6>{{ $user->email ?? '' }}</h6>
                                    {{-- <span data-bs-toggle="modal" data-bs-target="#edit-box"
                                        title="Quick View" tabindex="0">Edit Profile</span> --}}
                                </div>
                            </div>
                        </div>
                        <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            <li>
                                <button class="nav-link active" id="dashboard-tab" data-bs-toggle="pill"
                                    data-bs-target="#dashboard" role="tab" aria-controls="dashboard"
                                    aria-selected="true"><i class="iconsax" data-icon="home-1"></i> Dashboard</button>
                            </li>
                            <li>
                                <button class="nav-link" id="order-tab" data-bs-toggle="pill" data-bs-target="#order"
                                    role="tab" aria-controls="order" aria-selected="false"><i class="iconsax"
                                        data-icon="receipt-square"></i> Order</button>
                            </li>
                            <li>
                                <button class="nav-link" id="address-tab" data-bs-toggle="pill" data-bs-target="#address"
                                    role="tab" aria-controls="address" aria-selected="false"><i class="iconsax"
                                        data-icon="cue-cards"></i>Address</button>
                            </li>

                        </ul>
                        <div class="logout-button"> <a class="btn btn_black sm" data-bs-toggle="modal"
                                data-bs-target="#Confirmation-modal" title="Quick View" tabindex="0"><i
                                    class="iconsax me-1" data-icon="logout-1"></i> Logout </a></div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="dashboard" role="tabpanel"
                            aria-labelledby="dashboard-tab">
                            <div class="dashboard-right-box">
                                <div class="my-dashboard-tab">

                                    <div class="profile-about">
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="sidebar-title">
                                                    <div class="loader-line"></div>
                                                    <h5>Profile Information</h5>
                                                </div>
                                                <ul class="profile-information">
                                                    <li>
                                                        <h6>Name :</h6>
                                                        <p>{{ $user->name ?? '' }}</p>
                                                    </li>
                                                    <li>
                                                        <h6>Phone:</h6>
                                                        <p>{{ $user->phone ?? '' }}</p>
                                                    </li>
                                                    {{-- <li>
                                                        <h6>Address:</h6>
                                                        <p>{{ $user->address ?? '' }}</p>
                                                    </li> --}}
                                                </ul>
                                                {{-- <div class="sidebar-title">
                                                    <div class="loader-line"></div>
                                                    <h5>Login Details</h5>
                                                </div>
                                                <ul class="profile-information mb-0">
                                                    <li>
                                                        <h6>Email :</h6>
                                                        <p> {{ $user->email ?? '' }} <span data-bs-toggle="modal"
                                                                data-bs-target="#edit-email" title="Quick View"
                                                                tabindex="0">Edit</span></p>
                                                    </li>
                                                    <li>
                                                        <h6>Password :</h6>
                                                        <p>●●●●●●<span data-bs-toggle="modal"
                                                                data-bs-target="#edit-password" title="Quick View"
                                                                tabindex="0">Edit</span></p>
                                                    </li>
                                                </ul> --}}
                                            </div>
                                            <div class="col-xl-5">
                                                <div class="profile-image d-none d-xl-block"> <img class="img-fluid"
                                                        src="../assets/images/other-img/dashboard.png" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="tab-pane fade" id="wishlist" role="tabpanel" aria-labelledby="wishlist-tab">
                            <div class="dashboard-right-box">
                                <div class="wishlist-box ratio1_3">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>Wishlist</h4>
                                    </div>
                                    <div class="row-cols-md-3 row-cols-2 grid-section view-option row gy-4 g-xl-4">
                                        <div class="col">
                                            <div class="product-box-3 product-wishlist">
                                                <div class="img-wrapper">
                                                    <div class="label-block"><a
                                                            class="label-2 wishlist-icon delete-button"
                                                            href="javascript:void(0)" title="Add to Wishlist"
                                                            tabindex="0"><i class="iconsax" data-icon="trash"
                                                                aria-hidden="true"></i></a></div>
                                                    <div class="product-image"><a class="pro-first" href="#"> <img
                                                                class="bg-img"
                                                                src="../assets/images/product/product-3/1.jpg"
                                                                alt="product"></a><a class="pro-sec" href="#">
                                                            <img class="bg-img"
                                                                src="../assets/images/product/product-3/20.jpg"
                                                                alt="product"></a></div>
                                                    <div class="cart-info-icon"> <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#addtocart" title="Add to cart"
                                                            tabindex="0"><i class="iconsax" data-icon="basket-2"
                                                                aria-hidden="true"> </i></a><a href="compare.html"
                                                            title="Compare" tabindex="0"><i class="iconsax"
                                                                data-icon="arrow-up-down" aria-hidden="true"></i></a><a
                                                            href="#" data-bs-toggle="modal"
                                                            data-bs-target="#quick-view" title="Quick View"
                                                            tabindex="0"><i class="iconsax" data-icon="eye"
                                                                aria-hidden="true"></i></a></div>
                                                    <div class="countdown">
                                                        <ul class="clockdiv1">
                                                            <li>
                                                                <div class="timer">
                                                                    <div class="days"></div>
                                                                </div><span class="title">Days</span>
                                                            </li>
                                                            <li class="dot"> <span>:</span></li>
                                                            <li>
                                                                <div class="timer">
                                                                    <div class="hours"></div>
                                                                </div><span class="title">Hours</span>
                                                            </li>
                                                            <li class="dot"> <span>:</span></li>
                                                            <li>
                                                                <div class="timer">
                                                                    <div class="minutes"></div>
                                                                </div><span class="title">Min</span>
                                                            </li>
                                                            <li class="dot"> <span>:</span></li>
                                                            <li>
                                                                <div class="timer">
                                                                    <div class="seconds"></div>
                                                                </div><span class="title">Sec</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-detail">
                                                    <ul class="rating">
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star"></i></li>
                                                        <li><i class="fa-solid fa-star-half-stroke"></i></li>
                                                        <li><i class="fa-regular fa-star"></i></li>
                                                        <li>4.3</li>
                                                    </ul><a href="#">
                                                        <h6>Greciilooks Women's Stylish Top</h6>
                                                    </a>
                                                    <p>$100.00
                                                        <del>$140.00</del><span>-20%</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <div class="dashboard-right-box">
                                <div class="order">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>My Orders History</h4>
                                    </div>
                                    @php

                                        $orders = DB::table('orders')
                                            ->where('user_id', $userId)
                                            ->orderBy('id', 'DESC') // Corrected usage of orderBy
                                            ->get();

                                        $orders = $orders->map(function ($order) {
                                            $order->items = DB::table('order_items')
                                                ->where('order_id', $order->id)
                                                ->get();
                                            return $order;
                                        });

                                    @endphp
                                    <div class="row gy-4">
                                        @foreach ($orders as $order)
                                            <div class="col-12">
                                                <div class="order-box">
                                                    <div
                                                        class="order-container d-flex justify-content-between align-items-center">
                                                        <div class="order-icon">
                                                            <i class="iconsax" data-icon="box"></i>
                                                            @if ($order->is_cancel)
                                                            <div class="couplet"><i class="fa-solid fa-xmark"></i></div>
                                                        @elseif ($order->is_deliverd == 1)
                                                        <div class="couplet"><i class="fa-solid fa-check"></i></div>
                                                        @elseif ($order->is_confirm == 1)
                                                        <div class="couplet"><i class="fa-solid fa-timeline"></i></div>
                                                        @else
                                                        <div class="couplet"><i class="fa-solid fa-timeline"></i></div>
                                                        @endif


                                                        </div>
                                                        <div class="order-detail">
                                                            <h5>
                                                                @if ($order->is_cancel)
                                                                    Canceled
                                                                @elseif ($order->is_deliverd == 1)
                                                                    Delivered
                                                                @elseif ($order->is_confirm == 1)
                                                                    Ongoing
                                                                @else
                                                                    Pending
                                                                @endif
                                                            </h5>

                                                            <p>on
                                                                {{ $order->date }}
                                                            </p>
                                                        </div>
                                                        @if (!$order->is_deliverd == 1 && !$order->is_confirm == 1 && !$order->is_cancel )
                                                        <div class="cancel-button">
                                                            <button class="btn btn-danger btn-sm cancel-order" data-id="{{ $order->id }}">Cancel</button>
                                                        </div>
                                                    @endif

                                                    </div>

                                                    @foreach ($order->items as $item)
                                                        <div class="product-order-detail">
                                                            <div class="product-box">
                                                                <a
                                                                    href="{{ route('view.product', [get_product_data($item->product_id)->slug]) }}">
                                                                    <img src="{{ path() }}/{{ Product_first_image($item->product_id) }}"
                                                                        alt="Product Image">
                                                                </a>
                                                                <div class="order-wrap">
                                                                    <h5>Product Name:
                                                                        {{ get_product_data($item->product_id)->name }}
                                                                    </h5> <!-- Replace with actual product name -->
                                                                    <ul>
                                                                        <li>
                                                                            <p>Order ID:</p>
                                                                            <span>{{ $order->custom_order_id }}</span>
                                                                        </li>
                                                                        <p>Quantity: {{ $item->quantity }}</p>
                                                                        <li>
                                                                            <p>Price:</p><span>₹{{ $item->price }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <p>Size:</p>
                                                                            <span>{{ getSizeData($item->size_id) }}</span>
                                                                        </li>
                                                                        <li>
                                                                            <p>Color:</p>
                                                                            <span>{{ getColorData($item->color_id) }}</span>
                                                                        </li>

                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    {{-- <div class="return-box">
                                                        <div class="review-box">
                                                            <ul class="rating">
                                                                <li>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star"></i>
                                                                    <i class="fa-solid fa-star-half-stroke"></i>
                                                                    <i class="fa-regular fa-star"></i>
                                                                </li>
                                                            </ul>
                                                            <span data-bs-toggle="modal" data-bs-target="#Reviews-modal" title="Quick View" tabindex="0">Write Review</span>
                                                        </div>
                                                        <h6>* Exchange/Return window closed on {{ \Carbon\Carbon::parse($order->date)->addDays(15)->format('d M Y') }}</h6>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                            <div class="dashboard-right-box">
                                <div class="address-tab">
                                    <div class="sidebar-title">
                                        <div class="loader-line"></div>
                                        <h4>My Address Details</h4>
                                    </div>


                                    <div class="row gy-3">
                                        @if ($addresses->isEmpty())
                                            <div class="col-xxl-12 col-md-12"
                                                style="text-align: center; padding: 20px; background-color: #f8d7da; color: #721c24; border-radius: 5px; font-size: 16px;">
                                                <h5>No addresses available. Please add an address.</h5>
                                            </div>
                                        @else
                                            @foreach ($addresses as $key => $addressdata)
                                                <div class="col-xxl-4 col-md-6" id="address-{{ $addressdata->id }}">
                                                    <div class="address-option">
                                                        <label for="address-billing-{{ $key }}">
                                                            <span class="delivery-address-box">
                                                                <span class="address-detail">
                                                                    <span class="address">
                                                                        <span
                                                                            class="address-title">{{ $addressdata->name }}</span>
                                                                    </span>
                                                                    <span class="address">
                                                                        <span class="address-home">
                                                                            <span class="address-tag">Address:</span>
                                                                            {{ $addressdata->address }}
                                                                        </span>
                                                                    </span>
                                                                    <span class="address">
                                                                        <span class="address-home">
                                                                            <span class="address-tag">City:</span>
                                                                            {{ $addressdata->city }}
                                                                        </span>
                                                                    </span>
                                                                    <span class="address">
                                                                        <span class="address-home">
                                                                            <span class="address-tag">State:</span>
                                                                            {{ $addressdata->state }}
                                                                        </span>
                                                                    </span>
                                                                    <span class="address">
                                                                        <span class="address-home">
                                                                            <span class="address-tag">Pin Code:</span>
                                                                            {{ $addressdata->pincode }}
                                                                        </span>
                                                                    </span>
                                                                    <span class="address">
                                                                        <span class="address-home">
                                                                            <span class="address-tag">Phone:</span>
                                                                            {{ $addressdata->phone }}
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </span>
                                                            <span class="buttons">
                                                                <a class="btn btn_black sm edit-address" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#edit-address"
                                                                    data-id="{{ $addressdata->id }}"
                                                                    data-name="{{ $addressdata->name }}"
                                                                    data-email="{{ $addressdata->email }}"
                                                                    data-phone="{{ $addressdata->phone }}"
                                                                    data-address="{{ $addressdata->address }}"
                                                                    data-pincode="{{ $addressdata->pincode }}"
                                                                    data-city="{{ $addressdata->city }}"
                                                                    data-state="{{ $addressdata->state }}"
                                                                    data-address_type="{{ $addressdata->address_type }}"
                                                                    title="Edit Address" tabindex="0">Edit</a>

                                                                <a class="btn btn_outline sm delete-address"
                                                                    href="#" data-id="{{ $addressdata->id }}"
                                                                    title="Delete Address" tabindex="0">Delete</a>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>

                                    <button class="btn add-address" data-bs-toggle="modal" data-bs-target="#add-address"
                                        title="Quick View" tabindex="0">+ Add
                                        Address</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal theme-modal fade confirmation-modal" id="Confirmation-modal" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body"> <img class="img-fluid"
                        src="{{ website_assets() }}/assets/images/gif/question.gif" alt="">
                    <h4>Confirmation</h4>
                    <p>Are you sure you want to proceed?</p>
                    <div class="submit-button">
                        <button class="btn" type="submit" data-bs-dismiss="modal" aria-label="Close">No</button><a
                            class="btn" href="{{ route('logout') }}">Yes</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    {{-- Edit Address Modal --}}
    <div class="reviews-modal modal theme-modal fade" id="edit-address" tabindex="-1" role="dialog"
        aria-modal="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Edit Address</h4>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <form id="edit-address-form">
                        @csrf
                        <input type="hidden" name="id" id="edit-id">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name" id="edit-name"
                                        placeholder="Enter your name.">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email address</label>
                                    <input class="form-control" type="email" name="email" id="edit-email"
                                        placeholder="john.smith@example.com">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control" type="number" name="phone" id="edit-phone"
                                        placeholder="Enter your Number.">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control edit_custom_address" name="address" id="edit-address" cols="30" rows="5"
                                        placeholder="Write your Address..."></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Pincode</label>
                                    <input class="form-control" type="text" name="pincode" id="edit-pincode"
                                        placeholder="Enter your Pincode">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">City</label>
                                    <input class="form-control" type="text" name="city" id="edit-city"
                                        placeholder="Enter your City">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">State</label>
                                    <input class="form-control" type="text" name="state" id="edit-state"
                                        placeholder="Enter your State">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Address Type</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="billing_address" value="1">
                                        <label class="form-check-label" for="billing_address">Billing Address</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="address_type"
                                            id="shipping_address" value="2">
                                        <label class="form-check-label" for="shipping_address">Shipping Address</label>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-submit" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('website.js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const savedTab = localStorage.getItem('activeTab');
            if (savedTab) {
                const triggerEl = document.querySelector(`[data-bs-target="${savedTab}"]`);
                if (triggerEl) {
                    new bootstrap.Tab(triggerEl).show();
                }
            }
            const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const tabTarget = this.getAttribute('data-bs-target');
                    localStorage.setItem('activeTab', tabTarget);
                });
            });
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
        $(document).ready(function() {
            // When the Edit button is clicked
            $('.edit-address').on('click', function() {
                // Get the data attributes
                var id = $(this).data('id');
                var name = $(this).data('name');
                var email = $(this).data('email');
                var phone = $(this).data('phone');
                var address = $(this).data('address');
                var pincode = $(this).data('pincode');
                var city = $(this).data('city');
                var state = $(this).data('state');
                var address_type = $(this).data('address_type');


                // Set the values in the modal
                $('#edit-id').val(id);
                $('#edit-name').val(name);
                $('#edit-email').val(email);
                $('#edit-phone').val(phone);
                $('#edit-pincode').val(pincode);
                $('#edit-city').val(city);
                $('#edit-state').val(state);
                $('.edit_custom_address').val(address);

                $('input[name="address_type"][value="' + address_type + '"]').prop('checked', true);
            });

            // Handle the form submission for updating the address
            $('#edit-address-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('user.address.update') }}', // Update this with your actual route
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            window.location.reload(); // Reload page to reflect changes
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error('Error occurred while updating the address.');
                    }
                });
            });
        });
    </script>
    <script>
        // Handling the delete functionality with SweetAlert2 and AJAX
        $(document).on('click', '.delete-address', function(e) {
            e.preventDefault();

            // Get the address ID from data-id attribute
            var addressId = $(this).data('id');

            // Show SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you really want to delete this address?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Generate URL using the route name
                    var url = '{{ route('address.delete', ':id') }}';
                    url = url.replace(':id', addressId); // Replace :id with the actual address ID

                    // AJAX request to delete the address
                    $.ajax({
                        url: url, // Use the generated URL
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content') // CSRF token
                        },
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                Swal.fire('Deleted!', 'The address has been deleted.',
                                    'success');

                                // Remove the address from the DOM
                                $('#address-' + addressId).remove();
                            } else {
                                // Show error message
                                Swal.fire('Error!', 'Something went wrong. Please try again.',
                                    'error');
                            }
                        },
                        error: function() {
                            // Handle error
                            Swal.fire('Error!', 'Something went wrong. Please try again.',
                                'error');
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.cancel-order', function(e) {
    e.preventDefault();

    var orderId = $(this).data('id');

    // Show SweetAlert2 confirmation dialog
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to cancel this order?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, cancel it!',
        cancelButtonText: 'No, keep it',
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to update the order status to canceled
            $.ajax({
                url: '{{ route('user.order.updateCancelStatus', ':orderId') }}'.replace(':orderId', orderId),
                method: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        Swal.fire('Cancelled!', 'The order has been cancelled.', 'success');

                        // Optionally, reload the page
                        location.reload();
                    } else {
                        Swal.fire('Error!', 'Failed to cancel the order. Please try again.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                }
            });
        }
    });
});

    </script>
@endsection
